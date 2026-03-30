<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корзина покупок</title>
    <style>
        body { font-family: sans-serif; margin: 30px; line-height: 1.6; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        .total { font-size: 1.2em; font-weight: bold; text-align: right; }
        .btn { padding: 8px 15px; text-decoration: none; border-radius: 4px; color: white; display: inline-block; }
        .btn-remove { background-color: #dc3545; font-size: 0.9em; }
        .btn-clear { background-color: #6c757d; }
        .btn-back { background-color: #007bff; }
        .empty-msg { padding: 20px; background: #f8f9fa; border-radius: 5px; }
    </style>
</head>
<body>

    <h1>Ваша корзина</h1>

    <?php if (empty($items)): ?>
        <div class="empty-msg">
            <p>В корзине пока ничего нет.</p>
            <a href="/" class="btn btn-back">Вернуться в магазин</a>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Товар</th>
                    <th>Цена за ед.</th>
                    <th>Количество</th>
                    <th>Сумма</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $id => $data): ?>
                    <?php 
                        $product = $data['product'];
                        $qty = $data['quantity'];
                        $subtotal = $product->getPrice() * $qty;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($product->getTitle()) ?></td>
                        <td><?= number_format($product->getPrice(), 2) ?> руб.</td>
                        <td><?= $qty ?></td>
                        <td><?= number_format($subtotal, 2) ?> руб.</td>
                        <td>
                            <!-- Удаление конкретного товара по ID -->
                            <a href="/remove?id=<?= $product->getId() ?>" class="btn btn-remove">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total">
            Общая стоимость: <?= number_format($total, 2) ?> руб.
        </div>

        <hr>

        <div style="margin-top: 20px;">
            <a href="/clear" class="btn btn-clear">Очистить корзину</a>
            <a href="/" class="btn btn-back">Продолжить покупки</a>
        </div>
    <?php endif; ?>

</body>
</html>
