<?php
class Application {
    private $router;
    private $middlewares = [];
    
    public function __construct(Router $router) {
        $this->router = $router;
    }
    
    public function addMiddleware($middleware) {
        $this->middlewares[] = $middleware;
    }
    
    public function run() {
        $request = new Request();
        
        $handler = function($req) {
            $this->router->run($req);
            return null;
        };
        
        foreach (array_reverse($this->middlewares) as $middleware) {
            $handler = function($req) use ($middleware, $handler) {
                return $middleware->handle($req, $handler);
            };
        }
        
        return $handler($request);
    }
}