<?php
require_once 'router.php';
require_once 'controllers/BaseController.php';
require_once 'controllers/FoodController.php';
$router = new Router();

$router->get('/food', 'FoodController', 'index');
$router->get('/food/create', 'FoodController', 'showCreateForm');
$router->get('/food/update', 'FoodController', 'showEditForm');

$router->post('/food/create', 'FoodController', 'create');
$router->post('/food/update', 'FoodController', 'update');

$router->run();
?>