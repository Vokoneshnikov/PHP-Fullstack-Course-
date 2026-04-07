<?php

class CartController {
    private $request;
    private $cart;
    private $products = [];

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $this->cart = new Cart();

        // Фейковая база товаров
        $this->products = [
            1 => new Product(1, "Телефон", 500),
            2 => new Product(2, "Лэптоп", 1200)
        ];
    }

    public function setRequest($request) {
        $this->request = $request;
    }

    public function index() {
        $products = $this->products;
        include 'views/index.php';
    }

    public function add() {
        $id = (int)($this->request->get['id'] ?? 0);
        if (isset($this->products[$id])) {
            $this->cart->add($this->products[$id]);
        }
        header('Location: /');
    }

    public function show() {
        $items = $this->cart->getItems();
        $total = $this->cart->getTotal();
        include 'views/cart.php';
    }

    public function remove() {
        $id = (int)($this->request->get['id'] ?? 0);
        $this->cart->remove($id);
        header('Location: /cart');
    }

    public function clear() {
        $this->cart->clear();
        header('Location: /cart');
    }
}
