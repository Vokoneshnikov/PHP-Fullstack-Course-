<?php

require_once __DIR__ . '/../autoload.php';


use App\Routes;
use App\Router;

$routes = new Routes();

$router = new Router($routes);
$router->run();