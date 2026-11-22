<?php

function base_dir(): string
{
    static $base = null;

    if ($base === null) {
        $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
        $dir = dirname($script);
        $parts = array_filter(explode('/', $dir), static fn($part) => $part !== '');
        $base = '/' . implode('/', array_map('rawurlencode', $parts));
        $base = rtrim($base, '/');
    }

    return $base;
}

function url(string $route = ''): string
{
    $route = ltrim($route, '/');

    return base_dir() . '/index.php' . ($route === '' ? '' : '/' . $route);
}

function asset_url(string $file = ''): string
{
    return base_dir() . '/assets/' . ltrim($file, '/');
}
