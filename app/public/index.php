<?php 
declare(strict_types=1);
use Dotenv\Dotenv;
require __DIR__ . '/../vendor/autoload.php';

(new Core\App())->run();
$dotenv = Dotenv::createImmutable(__DIR__.'/../');

$dotenv->load();