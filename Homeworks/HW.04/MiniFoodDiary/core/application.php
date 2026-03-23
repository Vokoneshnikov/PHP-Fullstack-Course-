<?php
// core/Application.php

class Application {
    private $router;
    private $middlewares = [];
    
    public function __construct(Router $router) {
        $this->router = $router;
    }
    
    public function addMiddleware($middleware) {
        $this->middlewares[] = $middleware;
        return;
    }
    
    public function run() {
        $request = new Request();
        
        // Создаем цепочку middleware
        $handler = function(&$request) {
            $this->router->run();
            return null;
        };
        
        // Пропускаем через middleware в обратном порядке
        foreach (array_reverse($this->middlewares) as $middleware) {
            $handler = function($req) use ($middleware, $handler) {
                return $middleware->handle($req, $handler);
            };
        }
        
        return $handler($request);
    }
}