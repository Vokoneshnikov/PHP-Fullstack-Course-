<?php
include_once 'Product.php';
class Cart{
    // $items = ['id' => ['product' => Product, 'quantity' => int]]
    private array $items = [];
    public function __construct() {
        if (isset($_SESSION['cart'])) {
            $this->items = $_SESSION['cart'];
        }
    }
    private function saveToSession() {
        $_SESSION['cart'] = $this->items;
    }
    public function add(Product $product, int $quantity = 1) {
        $itemId = $product->getId();
        if (isset($this->items[$itemId])) {
            $this->items[$itemId]['quantity'] += $quantity;
        }
        else {
            $this->items[$itemId] = ['product' => $product, 'quantity' => $quantity];
        }
        $this->saveToSession();
    }
    public function remove(int $productId) {
        unset($this->items[$productId]);
        $this->saveToSession();
    }
    public function getItems() {
        return $this->items;
    }
    public function getTotal() {
        $total = 0;
        foreach($this->items as $item) {
            $total += $item['quantity'] * $item['product']->getPrice();
        }
        return $total;
    }
    public function clear() {
        $this->items = [];
        $this->saveToSession();
    }

}

?>