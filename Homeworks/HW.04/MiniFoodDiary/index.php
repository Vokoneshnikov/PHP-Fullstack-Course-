<?php
// index.php

require_once 'core/Request.php';
require_once 'core/Router.php';
require_once 'core/Application.php';
require_once 'core/Validator.php';
require_once 'Middleware/IMiddleware.php';
require_once 'Middleware/SessionMiddleware.php';
require_once 'Middleware/FlashMiddleware.php';
require_once 'Middleware/CsrfMiddleware.php';
require_once 'controllers/BaseController.php';
require_once 'controllers/FoodController.php';
require_once 'models/FoodModel.php';

$router = new Router();

$router->get('/food', 'FoodController', 'index');
$router->get('/food/create', 'FoodController', 'showCreateForm');
$router->get('/food/edit', 'FoodController', 'showEditForm');
$router->post('/food/create', 'FoodController', 'create');
$router->post('/food/update', 'FoodController', 'update');

$app = new Application($router);
$app->addMiddleware(new SessionMiddleware());
$app->addMiddleware(new FlashMiddleware());
$app->addMiddleware(new CsrfMiddleware());

$app->run();