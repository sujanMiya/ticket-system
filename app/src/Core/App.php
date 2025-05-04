<?php
namespace Core;
use Core\Database;
class App {
    private $router;
    protected static Database $db;
    // private $db;

    public function __construct() {

        $this->router = new Router();
        // $this->db = new Database(require __DIR__ . '/../../app/config/database.php');
    }

    public static function db(): Database {
        if (!isset(self::$db)) {
            // self::$db = new Database(require __DIR__ .'/../config/database.php');
            
            self::$db = new Database(require __DIR__ . '/../../app/config/database.php');
        }
        return self::$db;
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

    // public function db() {
    //     return $this->db;
    // }
}