<?php
/**
 * Shared security helpers — CSRF, rate limiting, session hardening, CORS.
 */

declare(strict_types=1);

if (!function_exists('admin_session_start')) {
    function admin_session_start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'secure'   => $secure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        session_start();
    }
}

if (!function_exists('csrf_ensure_token')) {
    function csrf_ensure_token(): void
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): void
    {
        csrf_ensure_token();
        echo '<input type="hidden" name="csrf_token" value="'
            . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8')
            . '">';
    }
}

if (!function_exists('csrf_verify')) {
    function csrf_verify(): bool
    {
        $submitted = $_POST['csrf_token'] ?? '';
        $expected  = $_SESSION['csrf_token'] ?? '';
        return is_string($submitted)
            && is_string($expected)
            && $expected !== ''
            && hash_equals($expected, $submitted);
    }
}

if (!function_exists('csrf_fail')) {
    function csrf_fail(): never
    {
        http_response_code(403);
        die('Invalid security token. Please refresh the page and try again.');
    }
}

if (!function_exists('contact_cors_origin')) {
    /**
     * Returns allowed Origin header value, or empty string if not permitted.
     */
    function contact_cors_origin(): string
    {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
        if ($origin === '') {
            return '';
        }

        $parsed = parse_url($origin);
        if (!is_array($parsed) || empty($parsed['host'])) {
            return '';
        }

        $scheme = strtolower((string)($parsed['scheme'] ?? ''));
        if ($scheme !== 'http' && $scheme !== 'https') {
            return '';
        }

        $host = strtolower($parsed['host']);

        if ($host === 'localhost' || $host === '127.0.0.1') {
            return $origin;
        }

        if (!defined('SITE_URL')) {
            return '';
        }

        $site = parse_url(SITE_URL);
        if (!is_array($site) || empty($site['host'])) {
            return '';
        }

        $siteHost = strtolower($site['host']);
        $allowed = [$siteHost];
        if (str_starts_with($siteHost, 'www.')) {
            $allowed[] = substr($siteHost, 4);
        } else {
            $allowed[] = 'www.' . $siteHost;
        }

        if (in_array($host, $allowed, true)) {
            return $origin;
        }

        return '';
    }
}

if (!function_exists('rate_limit_allow')) {
    /**
     * Simple file-based rate limit. Returns true if the request may proceed.
     */
    function rate_limit_allow(string $bucket, int $maxAttempts = 5, int $windowSeconds = 3600): bool
    {
        $dir = __DIR__ . '/../storage/rate_limits';
        if (!is_dir($dir) && !mkdir($dir, 0750, true) && !is_dir($dir)) {
            return true;
        }

        $ip  = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $key = hash('sha256', $bucket . '|' . $ip);
        $file = $dir . '/' . $key . '.json';
        $now  = time();

        $data = ['count' => 0, 'reset' => $now + $windowSeconds];
        if (is_file($file)) {
            $raw = file_get_contents($file);
            $decoded = json_decode($raw ?: '', true);
            if (is_array($decoded)) {
                $data = $decoded;
            }
        }

        if ($now > (int)($data['reset'] ?? 0)) {
            $data = ['count' => 0, 'reset' => $now + $windowSeconds];
        }

        if ((int)$data['count'] >= $maxAttempts) {
            return false;
        }

        $data['count'] = (int)$data['count'] + 1;
        file_put_contents($file, json_encode($data), LOCK_EX);

        return true;
    }
}
