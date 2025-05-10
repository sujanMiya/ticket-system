<?php 

// 2. Configure session
session_set_cookie_params([
    'lifetime' => 86400,
    'path' => '/',
    'domain' => '',  // Empty is safer for local development
    'secure' => isset($_SERVER['HTTPS']), // Automatically set based on HTTPS
    'httponly' => true,
    'samesite' => 'Lax'  // Lax is more compatible than Strict
]);

// 3. Start session BEFORE any output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Rest of your index.php code
require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

(new Core\App())->run();