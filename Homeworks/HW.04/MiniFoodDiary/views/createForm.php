<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 30px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; box-sizing: border-box; }
        textarea { resize: vertical; font-family: Arial, sans-serif; }
        input:focus, textarea:focus { outline: none; border-color: #3498db; }
        .error { color: #e74c3c; font-size: 0.85em; margin-top: 5px; }
        .nutrients-row { display: flex; gap: 15px; }
        .nutrient-field { flex: 1; }
        .btn { display: inline-block; padding: 12px 24px; margin-top: 10px; cursor: pointer; font-size: 16px; border: none; border-radius: 5px; transition: all 0.3s; }
        .btn-submit { background: #3498db; color: white; }
        .btn-submit:hover { background: #2980b9; }
        .btn-cancel { background: #95a5a6; color: white; text-decoration: none; margin-left: 10px; padding: 12px 24px; display: inline-block; border-radius: 5px; }
        .btn-cancel:hover { background: #7f8c8d; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $title ?></h1>    
        <form method="POST" action="<?= $action ?>">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
            
            <div class="form-group">
                <label for="title">Название блюда *</label>
                <input type="text" id="title" name="title" 
                       value="<?= htmlspecialchars($food['title'] ?? '') ?>" 
                       placeholder="Например: Овсяная каша, Куриный суп..." required>
                <?php if (isset($errors['title'])): ?>
                    <?php foreach ($errors['title'] as $error): ?>
                        <div class="error"><?= $error ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="description">Описание *</label>
                <textarea id="description" name="description" rows="5" 
                          placeholder="Опишите рецепт, способ приготовления..." required><?= 
                    htmlspecialchars($food['description'] ?? '') 
                ?></textarea>
                <?php if (isset($errors['description'])): ?>
                    <?php foreach ($errors['description'] as $error): ?>
                        <div class="error"><?= $error ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <h3 style="color: #555; margin-bottom: 15px;">Пищевая ценность (на 100 г)</h3>
            
            <div class="nutrients-row">
                <div class="nutrient-field">
                    <label for="proteins">Белки (г) *</label>
                    <input type="number" step="0.1" id="proteins" name="proteins" 
                           value="<?= htmlspecialchars($food['proteins'] ?? '') ?>" 
                           placeholder="0.0" required>
                    <?php if (isset($errors['proteins'])): ?>
                        <?php foreach ($errors['proteins'] as $error): ?>
                            <div class="error"><?= $error ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <div class="nutrient-field">
                    <label for="fats">Жиры (г) *</label>
                    <input type="number" step="0.1" id="fats" name="fats" 
                           value="<?= htmlspecialchars($food['fats'] ?? '') ?>" 
                           placeholder="0.0" required>
                    <?php if (isset($errors['fats'])): ?>
                        <?php foreach ($errors['fats'] as $error): ?>
                            <div class="error"><?= $error ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <div class="nutrient-field">
                    <label for="carbohydrates">Углеводы (г) *</label>
                    <input type="number" step="0.1" id="carbohydrates" name="carbohydrates" 
                           value="<?= htmlspecialchars($food['carbohydrates'] ?? '') ?>" 
                           placeholder="0.0" required>
                    <?php if (isset($errors['carbohydrates'])): ?>
                        <?php foreach ($errors['carbohydrates'] as $error): ?>
                            <div class="error"><?= $error ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <button type="submit" class="btn btn-submit">Сохранить</button>
            <a href="/food" class="btn-cancel">Отмена</a>
        </form>
    </div>
</body>
</html>