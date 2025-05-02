<?php
namespace Core;

class Router {
    protected $routes = [];
    protected $params = [];

    public function add($method, $route, $controller) {
        $this->routes[$method][$route] = $controller;
    }

    protected function matchRoute($route, $uri) {
        $routeRegex = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z0-9-]+)', $route);
        $routeRegex = "@^" . $routeRegex . "$@i";

        if (preg_match($routeRegex, $uri, $matches)) {
            $this->params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            return true;
        }
        return false;
    }

    protected function callAction($controller, $action) {
        $controller = "App\\Controllers\\{$controller}";
        if (!method_exists($controller, $action)) {
            throw new \Exception("Method {$action} not found in {$controller}");
        }
        
        return (new $controller())->$action($this->params);
    }
    public function dispatch($uri, $method) {
        try {
            if (isset($this->routes[$method][$uri])) {
                return $this->callAction(...explode('@', $this->routes[$method][$uri]));
            }
    
            foreach ($this->routes[$method] as $route => $controller) {
                if ($this->matchRoute($route, $uri)) {
                    return $this->callAction(...explode('@', $controller));
                }
            }
    
            throw new \Exception("Route not found", 404);
        } catch (\Exception $e) {
            if ($this->isAjaxRequest()) {
                http_response_code($e->getCode());
                header('Content-Type: application/json');
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            }
            
            http_response_code($e->getCode());
            echo View::render('errors/404');
        }
    }
    
    protected function isAjaxRequest() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
}