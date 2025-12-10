<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Редактиране на Автомобил</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #f8fafc; margin: 0; padding: 40px 20px; color: #1e293b; }
        
        .container { max-width: 900px; margin: 0 auto; }
        
        .header { display: flex; align-items: center; margin-bottom: 30px; }
        .back-btn { text-decoration: none; color: #64748b; margin-right: 20px; font-weight: 500; }
        .back-btn:hover { color: #2563eb; }
        h1 { margin: 0; font-size: 1.8em; }

        form { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 30px; }
        .full-width { grid-column: 1 / -1; }

        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; font-size: 0.9em; color: #475569; }
        
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 1em;
            box-sizing: border-box;
            font-family: inherit;
        }
        
        .form-group input:focus, .form-group textarea:focus {
            border-color: #2563eb;
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .section-title {
            grid-column: 1 / -1;
            font-size: 1.1em;
            font-weight: 700;
            color: #1e293b;
            margin-top: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f1f5f9;
        }

        .checkbox-group {
            display: flex; align-items: center; background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0;
        }
        .checkbox-group input { width: auto; margin-right: 10px; }
        .checkbox-group label { margin: 0; cursor: pointer; }

        button.save-btn {
            background-color: #ca8a04; /* Жълт/Оранжев за редакция */
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background 0.2s;
        }
        button.save-btn:hover { background-color: #a16207; }

        /* Стилове за галерията в админа */
        .admin-gallery-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .current-img-preview {
            width: 100px;
            height: 70px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ddd;
            padding: 2px;
            background: #fff;
        }
        .hint-text {
            font-size: 0.85em;
            color: #64748b;
            margin-top: 5px;
        }

        /* ... (съществуващи стилове) ... */
        
        /* Галерия превю */
        .admin-gallery-preview {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 15px;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #f8fafc;
        }
        .current-img-preview {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        /* Групиране на бутоните за по-добър изглед */
        .action-footer {
            display: flex;
            justify-content: flex-end; /* Бутоните да са вдясно */
            gap: 15px;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e2e8f0;
            grid-column: 1 / -1; /* Заема цялата ширина в grid-а */
        }

        button.save-btn, a.cancel-btn {
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            width: auto; 
            text-decoration: none; /* За cancel-btn */
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        button.save-btn {
            background-color: #22c55e; /* Използва зелен за "Редактирай" */
            color: white;
            border: none;
        }
        button.save-btn:hover { background-color: #16a34a; }

        a.cancel-btn {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }
        a.cancel-btn:hover { background-color: #e2e8f0; }

        .hint-text {
            font-size: 0.8em;
            color: #94a3b8;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <a href="index.php?url=admin" class="back-btn">← Назад</a>
        <h1>Редакция: <?= htmlspecialchars($car['make'] . ' ' . $car['model']); ?></h1>
    </div>

    <form action="index.php?url=admin/update" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($car['id']); ?>">

        <div class="form-grid">
            
            <div class="section-title">Основна информация</div>
            
            <div class="form-group">
                <label>Марка *</label>
                <input type="text" name="make" value="<?= htmlspecialchars($car['make']); ?>" required>
            </div>
            <div class="form-group">
                <label>Модел *</label>
                <input type="text" name="model" value="<?= htmlspecialchars($car['model']); ?>" required>
            </div>
            <div class="form-group">
                <label>Година</label>
                <input type="number" name="year" value="<?= htmlspecialchars($car['year']); ?>">
            </div>
            <div class="form-group">
                <label>Пробег (км)</label>
                <input type="number" name="mileage" value="<?= htmlspecialchars($car['mileage'] ?? 0); ?>">
            </div>
            <div class="form-group">
                <label>Цена (лв.)</label>
                <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($car['price']); ?>">
            </div>
            <div class="form-group">
                <label>Цвят</label>
                <input type="text" name="color" value="<?= htmlspecialchars($car['color']); ?>">
            </div>

            <div class="section-title">Технически характеристики</div>

            <div class="form-group">
                <label>Двигател</label>
                <input type="text" name="engine_type" value="<?= htmlspecialchars($car['engine_type']); ?>">
            </div>
            <div class="form-group">
                <label>Скоростна кутия</label>
                <input type="text" name="transmission_type" value="<?= htmlspecialchars($car['transmission_type'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Разход (Градско)</label>
                <input type="number" step="0.1" name="fuel_consumption_city" value="<?= htmlspecialchars($car['fuel_consumption_city'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Разход (Извънградско)</label>
                <input type="number" step="0.1" name="fuel_consumption_highway" value="<?= htmlspecialchars($car['fuel_consumption_highway'] ?? ''); ?>">
            </div>

            <div class="section-title full-width">Медия и Описание</div>

            <!-- ПРОМЯНА: Textarea за множество снимки -->
            <div class="form-group full-width">
                <label>Снимки (URL или път)</label>
                <textarea name="image_url" rows="3"><?= htmlspecialchars($car['image_url']); ?></textarea>
                <div class="hint-text">Можете да добавите няколко снимки, разделени със <b>запетая</b>. (напр: <code>images/car1.png, images/car2.png</code>)</div>
                
                <?php if (!empty($car['image_url'])): ?>
                    <div class="admin-gallery-preview">
                        <?php 
                            // Разделяме стринга на масив, за да покажем всички снимки
                            $img_list = array_filter(array_map('trim', explode(',', $car['image_url'])));
                            foreach($img_list as $img_src):
                        ?>
                            <img src="<?= htmlspecialchars($img_src); ?>" class="current-img-preview" alt="preview">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group full-width">
                <label>Екстри</label>
                <textarea name="extras" rows="4"><?= htmlspecialchars($car['extras']); ?></textarea>
            </div>

            <div class="form-group full-width">
                <label>Коментар</label>
                <textarea name="comments" rows="3"><?= htmlspecialchars($car['comments']); ?></textarea>
            </div>

            <div class="checkbox-group full-width">
                <input type="checkbox" id="avail" name="is_available" value="1" <?= (isset($car['is_available']) && $car['is_available']) ? 'checked' : ''; ?>>
                <label for="avail">Автомобилът е наличен за продажба</label>
            </div>

        </div>

        <div class="action-footer">
            <a href="index.php?url=admin" class="cancel-btn">Отказ</a>
            <button type="submit" class="save-btn">Запази Промените</button>
        </div>
    </form>
</div>

</body>
</html>