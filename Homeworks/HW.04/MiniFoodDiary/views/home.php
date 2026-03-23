<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .food-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; }
        .calories { color: #e67e22; font-weight: bold; }
        .btn { display: inline-block; padding: 5px 10px; margin: 5px; text-decoration: none; border-radius: 3px; }
        .btn-edit { background: #3498db; color: white; }
        .btn-create { background: #2ecc71; color: white; padding: 10px 15px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 3px; }
        .error { color: red; font-size: 0.9em; margin-top: 5px; }
        .success { background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $title ?></h1>
        
        <a href="/food/create" class="btn btn-create">+ Добавить блюдо</a>
        
        <?php if (empty($foods)): ?>
            <p>Пока нет блюд. Добавьте первое!</p>
        <?php else: ?>
            <?php foreach ($foods as $food): ?>
                <div class="food-card">
                    <h2><?= htmlspecialchars($food['title']) ?></h2>
                    <p><?= nl2br(htmlspecialchars($food['description'])) ?></p>
                    <p class="proteins">🔥 Белков: <?= $food['proteins'] ?> гр.</p>
                    <p class="fats">🔥 Жиров <?= $food['fats'] ?> гр.</p>
                    <p class="carbohydrates">🔥 Углеводов: <?= $food['carbohydrates'] ?> гр.</p>
                    <a href="/food/update?id=<?= $food['id'] ?>" class="btn btn-edit">Редактировать</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>