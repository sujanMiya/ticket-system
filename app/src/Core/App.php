<?php
namespace Core;

class App {
    private $router;
    private $db;

    public function __construct() {

        $this->router = new Router();
        $this->db = new Database(require __DIR__ . '/../../app/config/database.php');
    }

    public function run() {
        try {
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $method = $_SERVER['REQUEST_METHOD'];
    
            // Make router available to routes.php
            $router = $this->router;
            require __DIR__ . '/../../app/config/routes.php';
            
            echo $this->router->dispatch($uri, $method);
        } catch (\Exception $e) {
            http_response_code($e->getCode());
            echo View::render('errors/404');
        }
    }

    public function db() {
        return $this->db;
    }
}