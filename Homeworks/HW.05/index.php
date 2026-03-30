<?php
require_once 'Product.php';
require_once 'Cart.php';
require_once 'Router.php';
require_once 'CartController.php';
require_once 'Request.php';

$router = new Router();

// Регистрируем маршруты
$router->get('/', 'CartController', 'index');
$router->get('/add', 'CartController', 'add');
$router->get('/cart', 'CartController', 'show');
$router->get('/remove', 'CartController', 'remove');
$router->get('/clear', 'CartController', 'clear');

$request = new Request();

$router->run($request);
