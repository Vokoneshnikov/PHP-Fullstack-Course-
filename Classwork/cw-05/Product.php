<?php

class Product{
    public function __construct(
        private int $id, 
        private string $title,
        private float $price
    ) {}

    public function getId() {
        return $this->id;
    }
    public function getTitle() {
        return $this->title; 
    }
    public function getPrice() {
        return  $this->price;
    }

    public function getFormattedPrice() : string {
        return number_format($this->price, 2, ".", " ") . " руб.";
    }
}

?>