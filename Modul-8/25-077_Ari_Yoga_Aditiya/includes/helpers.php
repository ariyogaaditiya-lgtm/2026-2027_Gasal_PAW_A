<?php

require_once __DIR__ . '/../config/paths.php';

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function rupiah($value): string
{
    return 'Rp ' . number_format((float) $value, 2, ',', '.');
}

function tanggal($value, bool $withTime = true): string
{
    $value = (string) $value;

    if ($value === '' || $value === '0000-00-00 00:00:00') {
        return '-';
    }

    $timestamp = strtotime($value);
    if ($timestamp === false) {
        return e($value);
    }

    return date($withTime ? 'd M Y H:i' : 'd M Y', $timestamp);
}

function parse_date($value): ?string
{
    $value = (string) $value;
    $date = DateTime::createFromFormat('Y-m-d', $value);

    return ($date && $date->format('Y-m-d') === $value) ? $value : null;
}

function old(string $key, string $default = ''): string
{
    return e($_POST[$key] ?? $default);
}

function redirect(string $route = ''): void
{
    header('Location: ' . url($route));
    exit;
}

function build_update(PDO $conn, string $table, string $primaryKey, int $id, array $values): bool
{
    if (!$values) {
        return false;
    }

    $set = [];
    $params = [];

    foreach ($values as $column => $value) {
        $set[] = $column . ' = ?';
        $params[] = $value;
    }

    $params[] = $id;
    $sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $set) . ' WHERE ' . $primaryKey . ' = ?';

    return $conn->prepare($sql)->execute($params);
}

function level_label($level): string
{
    return (int) $level === 1 ? 'Owner' : 'Kasir';
}

function is_active(string $route, string $currentPath): string
{
    return $route === $currentPath ? ' active' : '';
}

function query_int(string $key): int
{
    return (int) ($_GET[$key] ?? 0);
}

function method_is(string $method): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === $method;
}
