<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная страница — Магазин</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; margin: 20px; }
        .product-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px; }
        .btn-add { background: #28a745; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .btn-cart { background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>

    <h1>Список товаров</h1>

    <div class="product-list">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <h3><?= htmlspecialchars($product->getTitle()) ?></h3>
                    <p>Цена: <strong><?= number_format($product->getPrice(), 2, '.', ' ') ?> руб.</strong></p>
                    
                    <a href="/add?id=<?= $product->getId() ?>" class="btn-add">Добавить в корзину</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Товары не найдены.</p>
        <?php endif; ?>
    </div>

    <hr>
    
    <a href="/cart" class="btn-cart">Перейти в корзину</a>

</body>
</html>
