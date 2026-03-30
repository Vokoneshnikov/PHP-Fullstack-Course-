<?php
include_once 'Product.php';


$infoForProducts = [['id' => 1, 'title' => 'Кириешки', 'price' => 500000000.04322], ['id' => 2, 'title' => 'Пицца', 'price' =>30000.0], ['id' => 3, 'title' =>'Мороженое', 'price' =>10000.0]];

$products = [];

foreach($infoForProducts as $infoForProduct){
    $product = new Product(
        $infoForProduct['id'],
         $infoForProduct['title'],
          $infoForProduct['price']
          );
    $products[] = $product;
}

echo '<ul>';
foreach($products as $product) {
    echo '<li>' . $product->getTitle(), $product->getFormattedPrice(), '</li>';
}
echo '</ul>';



?>