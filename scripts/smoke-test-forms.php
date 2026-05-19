#!/usr/bin/env php
<?php
/**
 * Smoke-test contact-handler and estimate.php (HTTP or CLI).
 *
 * Usage:
 *   php scripts/smoke-test-forms.php              # CLI (no server)
 *   php scripts/smoke-test-forms.php --cli        # same
 *   php scripts/smoke-test-forms.php http://127.0.0.1/dashandots
 *   php scripts/smoke-test-forms.php https://dashandots.com
 */
declare(strict_types=1);

$root = dirname(__DIR__);
$mode = 'http';
$base = 'http://127.0.0.1/dashandots';

foreach (array_slice($argv, 1) as $arg) {
    if ($arg === '--cli' || $arg === '--local') {
        $mode = 'cli';
    } elseif (!str_starts_with($arg, '-')) {
        $base = rtrim($arg, '/');
        $mode = 'http';
    }
}

if ($argc < 2) {
    $mode = 'cli';
}

$passed = 0;
$failed = 0;

function check(string $label, bool $ok, string $detail = ''): void
{
    global $passed, $failed;
    if ($ok) {
        $passed++;
        echo "  OK   {$label}\n";
    } else {
        $failed++;
        echo "  FAIL {$label}" . ($detail !== '' ? " — {$detail}" : '') . "\n";
    }
}

function http_json(string $url, string $method = 'GET', ?array $body = null): array
{
    $ch = curl_init($url);
    $headers = ['Content-Type: application/json', 'Accept: application/json'];
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => $method,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_CONNECTTIMEOUT => 10,
    ]);
    if ($body !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    }
    $raw = curl_exec($ch);
    $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    if (PHP_VERSION_ID < 80500) {
        curl_close($ch);
    }

    return [
        'code' => $code,
        'body' => is_string($raw) ? $raw : '',
        'json' => json_decode(is_string($raw) ? $raw : '', true),
        'error' => $err,
    ];
}

function http_head(string $url): array
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_NOBODY => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CONNECTTIMEOUT => 10,
    ]);
    $raw = curl_exec($ch);
    $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $location = '';
    if (is_string($raw) && preg_match('/^location:\s*(.+)$/im', $raw, $m)) {
        $location = trim($m[1]);
    }
    $err = curl_error($ch);
    if (PHP_VERSION_ID < 80500) {
        curl_close($ch);
    }

    return [
        'code' => $code,
        'location' => $location,
        'headers' => is_string($raw) ? $raw : '',
        'error' => $err,
    ];
}

/**
 * Run a PHP endpoint in-process (no Apache required).
 */
function cli_json(string $script, string $method = 'GET', ?array $body = null): array
{
    global $root;

    $prevMethod = $_SERVER['REQUEST_METHOD'] ?? null;
    $_SERVER['REQUEST_METHOD'] = $method;
    $prevDisplayErrors = ini_get('display_errors');
    ini_set('display_errors', '0');
    $previousHandler = set_error_handler(static function (int $severity, string $message): bool {
        $benign = str_contains($message, 'Cannot modify header information')
            || str_contains($message, 'Cannot set response code');

        return $benign;
    });

    $inputStream = null;
    if ($body !== null) {
        $json = json_encode($body);
        $inputStream = fopen('php://memory', 'r+');
        fwrite($inputStream, $json);
        rewind($inputStream);
        stream_wrapper_unregister('php');
        stream_wrapper_register('php', CliInputStream::class);
        CliInputStream::$data = $json;
    }

    ob_start();
    try {
        include $root . '/' . ltrim($script, '/');
    } catch (Throwable $e) {
        ob_end_clean();
        $_SERVER['REQUEST_METHOD'] = $prevMethod ?? 'GET';
        restore_error_handler();
        ini_set('display_errors', (string) $prevDisplayErrors);
        if ($inputStream) {
            stream_wrapper_restore('php');
        }

        return ['code' => 500, 'body' => $e->getMessage(), 'json' => null, 'error' => $e->getMessage()];
    }
    $bodyOut = ob_get_clean();

    if ($prevMethod !== null) {
        $_SERVER['REQUEST_METHOD'] = $prevMethod;
    } else {
        unset($_SERVER['REQUEST_METHOD']);
    }
    if ($inputStream) {
        stream_wrapper_restore('php');
        CliInputStream::$data = '';
    }
    restore_error_handler();
    ini_set('display_errors', (string) $prevDisplayErrors);

    $code = http_response_code();
    if ($code === false || $code === 0) {
        $code = 200;
    }

    return [
        'code' => $code,
        'body' => $bodyOut,
        'json' => json_decode($bodyOut, true),
        'error' => '',
    ];
}

final class CliInputStream
{
    public static string $data = '';
    public mixed $context;
    private int $pos = 0;

    public function stream_open(string $path, string $mode, int $options, ?string &$opened_path): bool
    {
        $this->pos = 0;

        return $path === 'php://input';
    }

    public function stream_read(int $count): string
    {
        $chunk = substr(self::$data, $this->pos, $count);
        $this->pos += strlen($chunk);

        return $chunk;
    }

    public function stream_eof(): bool
    {
        return $this->pos >= strlen(self::$data);
    }

    public function stream_stat(): array
    {
        return [];
    }
}

function run_suite(callable $request): void
{
    $est = $request('estimate.php', 'POST', [
        'type' => 'Web App',
        'scale' => 'Medium',
        'features' => ['User auth'],
        'integrations' => [],
        'name' => 'Smoke Test',
        'email' => 'smoke-test@example.com',
        'company' => 'Dashandots QA',
    ]);
    check('estimate POST returns 200', $est['code'] === 200, 'HTTP ' . $est['code'] . ($est['error'] ? ' ' . $est['error'] : ''));
    check('estimate JSON has budgetMin', isset($est['json']['budgetMin']), $est['body']);
    check('estimate JSON has budgetStr', isset($est['json']['budgetStr']), $est['body']);
    check('estimate no budgetStrHtml', !isset($est['json']['budgetStrHtml']), 'legacy field should be removed');

    $hp = $request('estimate.php', 'POST', [
        'website' => 'http://spam.test',
        'name' => 'Bot',
        'email' => 'bot@spam.test',
    ]);
    check('estimate honeypot returns 200', $hp['code'] === 200, 'HTTP ' . $hp['code']);

    $get = $request('contact-handler.php', 'GET');
    check('contact GET returns 405', $get['code'] === 405, 'HTTP ' . $get['code']);

    $contactHp = $request('contact-handler.php', 'POST', [
        'name' => 'Bot',
        'email' => 'bot@spam.test',
        'message' => 'This honeypot message is long enough.',
        'website' => 'filled',
    ]);
    check('contact honeypot returns 200', $contactHp['code'] === 200, 'HTTP ' . $contactHp['code']);
    check('contact honeypot success flag', ($contactHp['json']['success'] ?? false) === true, $contactHp['body']);

    $bad = $request('contact-handler.php', 'POST', ['foo' => 'bar']);
    check('contact invalid returns 422', $bad['code'] === 422, 'HTTP ' . $bad['code']);
}

function run_live_url_suite(string $base): void
{
    $staticBlog = http_head($base . '/blog/future-of-custom-erp');
    check('static blog clean URL returns 200', $staticBlog['code'] === 200, 'HTTP ' . $staticBlog['code'] . ' ' . $staticBlog['location']);

    $staticBlog2 = http_head($base . '/blog/mobile-first-design-b2b');
    check('second static blog clean URL returns 200', $staticBlog2['code'] === 200, 'HTTP ' . $staticBlog2['code'] . ' ' . $staticBlog2['location']);

    $legacy = http_head($base . '/blog/future-of-custom-erp.html');
    check('legacy blog html redirects', in_array($legacy['code'], [301, 302], true), 'HTTP ' . $legacy['code']);
    check('legacy blog html avoids /dashandots/ on production', !str_contains($legacy['location'], '/dashandots/'), $legacy['location']);

    $sitemap = http_head($base . '/sitemap.php');
    check('sitemap returns 200', $sitemap['code'] === 200, 'HTTP ' . $sitemap['code']);

    $home = http_head($base . '/');
    check('X-Powered-By absent', stripos($home['headers'], 'x-powered-by:') === false, 'header still present');
}

if ($mode === 'cli') {
    $sock = stream_socket_server('tcp://127.0.0.1:0', $errno, $errstr);
    if (!$sock) {
        echo "Could not allocate local test port: {$errstr}\n";
        exit(1);
    }
    $name = stream_socket_get_name($sock, false);
    fclose($sock);
    $port = (int)substr(strrchr((string)$name, ':'), 1);

    $cmd = [PHP_BINARY, '-S', '127.0.0.1:' . $port, '-t', $root];
    $server = proc_open($cmd, [
        0 => ['pipe', 'r'],
        1 => ['file', '/dev/null', 'w'],
        2 => ['file', '/dev/null', 'w'],
    ], $pipes, $root);
    if (!is_resource($server)) {
        echo "Could not start local PHP test server.\n";
        exit(1);
    }

    $base = 'http://127.0.0.1:' . $port;
    $ready = false;
    for ($i = 0; $i < 20; $i++) {
        usleep(100000);
        if (http_json($base . '/estimate.php', 'GET')['code'] !== 0) {
            $ready = true;
            break;
        }
    }
    echo "Smoke test mode: CLI local server ({$base})\n\n";
    if (!$ready) {
        echo "  FAIL Local PHP test server did not start.\n";
        proc_terminate($server);
        proc_close($server);
        exit(1);
    }

    run_suite(static fn(string $script, string $method, ?array $body = null) => http_json($base . '/' . $script, $method, $body));
    proc_terminate($server);
    proc_close($server);
} else {
    echo "Smoke test mode: HTTP ({$base})\n\n";
    $probe = http_json($base . '/estimate.php', 'GET');
    if ($probe['code'] === 0) {
        echo "  WARN Server unreachable ({$probe['error']}). Start XAMPP or run: php scripts/smoke-test-forms.php --cli\n\n";
    }
    run_suite(static fn(string $script, string $method, ?array $body = null) => http_json($base . '/' . $script, $method, $body));
    if (preg_match('#^https?://dashandots\.com#', $base)) {
        run_live_url_suite($base);
    }
}

echo "\n{$passed} passed, {$failed} failed.\n";
exit($failed > 0 ? 1 : 0);
