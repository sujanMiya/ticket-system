<?php 
declare(strict_types=1);

function isLoggedIn(): bool {
    return isset($_SESSION['user']);
}

function currentUser(): ?array {
    return $_SESSION['user'] ?? null;
}

function requireAuth(): void {
    if (!isLoggedIn()) {
        header('Location: /login');
        exit;
    }
}
function json_response($data = null, $status = 200) {
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode($data);
    exit;
}

function generateCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCsrfToken(string $token): bool
{
    return isset($_SESSION['csrf_token']) && 
           hash_equals($_SESSION['csrf_token'], $token);
}