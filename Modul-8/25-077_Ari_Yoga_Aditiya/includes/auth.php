<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/helpers.php';

function current_user(): ?array
{
    return isset($_SESSION['user']) && is_array($_SESSION['user']) ? $_SESSION['user'] : null;
}

function sudahLogin(): bool
{
    return current_user() !== null;
}

function user_level(): int
{
    $user = current_user();

    return $user ? (int) $user['level'] : 0;
}

function user_nama(): string
{
    $user = current_user();

    return $user ? (string) $user['nama'] : '';
}

function wajibLogin(): void
{
    if (!sudahLogin()) {
        redirect('login');
    }
}

function wajibOwner(): void
{
    wajibLogin();

    if (user_level() !== 1) {
        http_response_code(403);
        require_once __DIR__ . '/../views/403.php';
        exit;
    }
}

function sudahLoginJanganKeLogin(): void
{
    if (sudahLogin()) {
        redirect('');
    }
}
