<?php
    

    session_start();

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    echo '<h1>Регистрация</h1>';
    echo '<form method="POST" action="/">';
    echo "<input type='hidden' name='csrf_token' value='{$_SESSION['csrf_token']}'>";
    echo '<input type="text" name="username" placeholder="Имя пользователя" required>';
    echo '<input type="password" name="password" placeholder="Пароль" required>';
    echo '<button type="submit">Зарегистрироваться</button>';
    echo '</form>';

    $error = $_SESSION['error'] ?? '';
    $success = $_SESSION['success'] ?? '';
    
    unset($_SESSION['error']);
    unset($_SESSION['success']);

    if ($error) {
        echo $error;
    }
    elseif ($success) {
        echo $success;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $token =  $_POST['csrf_token']  ?? '';
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($token) || $token !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = 'нет токена или он просрочен';
            header('Location: /');
            exit;
        }

        if (empty($username) || strlen($username) <= 3){
            $_SESSION['error'] = 'Имя должно быть длиннее 3 символов';
            header('Location: /');
            exit;
        }
        $_SESSION['success'] = 'Все ок';
        header('Location: /');
    }
    
// $routes = [
//     '/' => function(): void {
//         echo '<h1>ГЛАВНАЯ</h1>';
//     },
//     '/shop' => function(): void {
//         echo '<h1>СТРАНИЦА МАГАЗИНА</h1>';
//     },
//     '/about' => function(): void {
//         echo '<h1>СТРАНИЦА ОБО МНЕ</h1>';   
//     },
//     '/auctions' => function(): void {
//         echo '<h1>СТРАНИЦА АУКЦИОНОВ</h1>';
//     }
// ];

// $request =$_SERVER['REQUEST_URI'];
// $request = parse_url($request, PHP_URL_PATH);

// if ($request != '/') {
//     $request = rtrim($request, '/');
// }

// if (isset($routes[$request])){
//     $routes[$request]();
//     }
// else {
//     http_response_code(404);
//     echo '404 error - not found';
// }
?>