<?php


abstract class BaseController {
    protected $request;
    public function setRequest($request) {
        $this->request = $request;
    }
    abstract public function index();

    protected function render($view, $data = []) {
        // Превращаем массив в переменные
        extract($data);
        
        $viewFile = __DIR__ . '/../views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo "View not found: $view";
        }
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }

    // Получение данных из POST
    protected function getFromPost($key = null) {
        if ($key === null) {
            return $_POST;
        }
        return isset($_POST[$key]) ? trim($_POST[$key]) : null;
    }
    
    // Получение данных из GET
    protected function getFromGet($key = null) {
        if ($key === null) {
            return $_GET;
        }
        return isset($_GET[$key]) ? trim($_GET[$key]) : null;
    }

    // CSRF токен (из request, установлен CsrfMiddleware)
    protected function getCsrfToken() {
        return $this->request->getAttribute('csrf_token');
    }
    
    // Flash сообщения (из request, установлен FlashMiddleware)
    protected function getFlash() {
        return $this->request->getAttribute('flash');
    }
    
    protected function setFlash($type, $message) {
        $flashMiddleware = new FlashMiddleware();
        $flashMiddleware->setFlash($this->request, $type, $message);
    }
}
?>