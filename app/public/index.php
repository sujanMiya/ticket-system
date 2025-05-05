<?php 
declare(strict_types=1);
session_set_cookie_params([
    'lifetime' => 86400, // 1 day
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => true, // Only over HTTPS
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
(new Core\App())->run();
$dotenv = Dotenv::createImmutable(__DIR__.'/../');

$dotenv->load();