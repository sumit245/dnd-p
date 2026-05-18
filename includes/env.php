<?php
/**
 * Optional .env loader for non-secret site settings (verification tags, feature flags).
 */
declare(strict_types=1);

if (!function_exists('site_load_env')) {
    function site_load_env(): void
    {
        static $loaded = false;
        if ($loaded) {
            return;
        }

        $path = __DIR__ . '/../.env';
        if (!is_file($path)) {
            $loaded = true;
            return;
        }

        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }
            if (!str_contains($line, '=')) {
                continue;
            }
            [$key, $val] = array_map('trim', explode('=', $line, 2));
            if ($key !== '' && !array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $val;
            }
        }

        $loaded = true;
    }
}

if (!function_exists('site_env')) {
    function site_env(string $key, string $default = ''): string
    {
        site_load_env();
        $val = $_ENV[$key] ?? $default;

        return is_string($val) ? $val : $default;
    }
}

if (!function_exists('site_env_bool')) {
    function site_env_bool(string $key, bool $default = false): bool
    {
        $val = strtolower(trim(site_env($key, $default ? '1' : '0')));
        if (in_array($val, ['1', 'true', 'yes', 'on'], true)) {
            return true;
        }
        if (in_array($val, ['0', 'false', 'no', 'off', ''], true)) {
            return false;
        }

        return $default;
    }
}
