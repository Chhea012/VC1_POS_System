<?php
class Router {
    private $uri;
    private $method;
    private $routes = [];

    public function __construct() {
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function get($uri, $action) {
        $this->routes[$uri] = ['method' => 'GET', 'action' => $action];
    }

    public function post($uri, $action) {
        $this->routes[$uri] = ['method' => 'POST', 'action' => $action];
    }

    public function put($uri, $action) {
        $this->routes[$uri] = ['method' => 'PUT', 'action' => $action];
    }

    public function delete($uri, $action) {
        $this->routes[$uri] = ['method' => 'DELETE', 'action' => $action];
    }

    public function route() {
        foreach ($this->routes as $uri => $route) {
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([0-9]+)', trim($uri, '/'));
            if (preg_match("#^$pattern$#", trim($this->uri, '/'), $matches) && $route['method'] === $this->method) {
                array_shift($matches);
                $controllerClass = $route['action'][0];
                $function = $route['action'][1];
                $controller = new $controllerClass();
                $controller->$function(...$matches);
                exit;
            }
        }
        http_response_code(404);
        require_once 'Views/errors/404.php';
    }
}