<?php
$GetRoutes = [
    '/' => function() {
        echo '<h1>Главная страница</h1>';
        echo '<nav>';
        echo '<a href="/about">О нас</a> | ';
        echo '<a href="/shop">Магазин</a> | ';
        echo '<a href="/register">Регистрация</a>';
        echo '</nav>';
    },
    
    '/about' => function() {
        echo '<h1>О нас</h1>';
        echo '<p>Мы — лучший интернет-магазин!</p>';
        echo '<a href="/">На главную</a>';
    },
    
    '/shop' => function() use (&$products) {
        echo '<h1>Магазин</h1>';
        
        echo '<ul>';
        foreach ($products as $product) {
            echo "<li>$product</li>";
        }
        echo '</ul>';
        echo '<h3>Добавить товар:</h3>';
        echo '<form method="POST" action="/shop">';
        echo '<input type="text" name="name" placeholder="Название товара" required>';
        echo '<button type="submit">Создать товар</button>';
        echo '</form>';

        echo '<a href="/">На главную</a>';
    },
    
    '/register' => function() {
        echo '<h1>Регистрация</h1>';
        echo '<form method="POST" action="/register">';
        echo '<input type="text" name="username" placeholder="Имя пользователя" required>';
        echo '<br>';
        echo '<input type="password" name="password" placeholder="Пароль" required>';
        echo '<br>';
        echo '<input type="email" name="email" placeholder="Email" required>';
        echo '<br>';
        echo '<button type="submit">Зарегистрироваться</button>';
        echo '</form>';
        echo '<a href="/">На главную</a>';
    },
];

$PostRoutes = [
    '/register' => function() {
        echo '<h1>Результат регистрации</h1>';
        
        $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : 'Не указано';
        $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'Не указано';
        
        echo "<p>Спасибо за регистрацию, $username!</p>";
        echo "<p>Мы отправили письмо на $email</p>";
        echo '<a href="/">На главную</a>';
    },
    
    '/shop' => function() use (&$products, $productsFile) {
        echo '<h1>Корзина</h1>';
        echo 'Это результат POST запроса';
        if (isset($_POST['name'])) {
            $product = htmlspecialchars($_POST['name']);
            $products[] = $product;

            saveProducts($productsFile, $products);

            echo "<p>Товар '$product' добавлен в корзину!</p>";
        } else {
            echo '<p>Что-то пошло не так - товар не добавлен</p>';
        }

        echo '<a href="/shop">Вернуться в магазин</a>';
    },
];

$HttpMethod = $_SERVER['REQUEST_METHOD'];
$productsFile = __DIR__ . '/products.json';
$products = loadProducts($productsFile);

Route($HttpMethod, $GetRoutes, $PostRoutes);


function Route($HttpMethod, $GetRoutes, $PostRoutes) {
    $requestRoute =parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    switch ($HttpMethod) {
        case 'GET':
            isset($GetRoutes[$requestRoute]) 
            ? $GetRoutes[$requestRoute]() 
            : RenderPageNotFoundError();

            return;
        case 'POST':
            isset($PostRoutes[$requestRoute]) 
            ? $PostRoutes[$requestRoute]() 
            : RenderPageNotFoundError();

            return;
        default:
            RenderPageNotFoundError();
    }
};


function RenderPageNotFoundError() {
    echo '<h1>404 Error</h1>';
    echo '<br/>';
    echo '<h4>Page not found</h4>';
}
function loadProducts($file) {
    if (!file_exists($file)) {
        $defaultProducts = [];
        file_put_contents($file, json_encode($defaultProducts, JSON_PRETTY_PRINT));
        return $defaultProducts;
    }
    return json_decode(file_get_contents($file), true);
}

function saveProducts($file, $products) {
    file_put_contents($file, json_encode($products, JSON_PRETTY_PRINT));
}
?>