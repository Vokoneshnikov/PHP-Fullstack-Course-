<?php
abstract class BaseController {
    protected $request;
    
    public function setRequest($request) {
        $this->request = $request;
    }
    
    abstract public function index();
    
    protected function render($view, $data = []) {
         error_log("=== render ===");
        error_log("View: " . $view);
        error_log("Data keys: " . implode(', ', array_keys($data)));


        extract($data, EXTR_OVERWRITE);

        error_log("csrfToken after extract: " . ($csrfToken ?? 'NULL'));

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
    
    protected function getFromPost($key = null) {
        if ($key === null) {
            return $this->request->post;
        }
        return $this->request->post[$key] ?? null;
    }
    
    protected function getFromGet($key = null) {
        if ($key === null) {
            return $this->request->get;
        }
        return $this->request->get[$key] ?? null;
    }
    
    // CSRF токен (из request, установлен CsrfMiddleware)
    protected function getCsrfToken() {
        if (!$this->request) {
            return null;
        }
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