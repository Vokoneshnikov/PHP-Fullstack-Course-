<?php

class Router {
    private $routes = [];


    public function get($path, $controller, $method){
        $this->routes['GET'][$path] =  ['controller' => $controller, 'method' => $method];
    }
    public function post($path, $controller, $method){
        $this->routes['POST'][$path] =  ['controller' => $controller, 'method' => $method];
    }

    public function run() {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($this->routes[$httpMethod][$path]) ) {
            $route = $this->routes[$httpMethod][$path];
            $controller = new $route['controller']();
            $method = $route['method'];
            $controller->$method();
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}

?>