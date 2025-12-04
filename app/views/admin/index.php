<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Админ Панел</title>
    <!-- Зареждаме същия шрифт като в публичната част -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #f8fafc; margin: 0; padding: 0; color: #1e293b; }
        
        /* Header */
        .admin-header {
            background: white;
            padding: 15px 40px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand { font-size: 1.2em; font-weight: 700; color: #1e293b; }
        .user-nav a { color: #ef4444; text-decoration: none; font-weight: 500; margin-left: 20px; }
        .user-nav a.view-site { color: #2563eb; }

        /* Main Content */
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        h1 { margin: 0; font-size: 1.8em; }

        .btn-add {
            background-color: #2563eb;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
            transition: background 0.2s;
        }
        .btn-add:hover { background-color: #1d4ed8; }

        /* Alerts */
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-weight: 500;
        }
        .alert-success { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

        /* Table */
        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        table { width: 100%; border-collapse: collapse; }
        
        th {
            background-color: #f1f5f9;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75em;
            letter-spacing: 0.5px;
            padding: 15px 20px;
            text-align: left;
        }
        
        td {
            padding: 15px 20px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover { background-color: #f8fafc; }

        /* Thumbnails */
        .thumb {
            width: 60px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
            background-color: #e2e8f0;
            border: 1px solid #e2e8f0;
        }

        /* Status Badge */
        .status-badge {
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 0.75em;
            font-weight: 600;
        }
        .status-active { background-color: #dcfce7; color: #166534; }
        .status-sold { background-color: #fee2e2; color: #991b1b; }

        /* Actions */
        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.85em;
            font-weight: 500;
            margin-right: 5px;
            display: inline-block;
        }
        .edit-btn { background-color: #eff6ff; color: #1d4ed8; }
        .edit-btn:hover { background-color: #dbeafe; }
        
        .delete-btn { background-color: #fef2f2; color: #dc2626; }
        .delete-btn:hover { background-color: #fee2e2; }
    </style>
</head>
<body>

    <div class="admin-header">
        <div class="brand">Админ Панел</div>
        <div class="user-nav">
            <!-- Линк към публичната част (отваря се в нов таб) -->
            <a href="index.php?url=public" class="view-site" target="_blank">Преглед на сайта ↗</a>
            <a href="index.php?url=admin/logout">Изход</a>
        </div>
    </div>

    <div class="container">
        
        <!-- Съобщения за статус (при create/update/delete) -->
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'updated'): ?>
                <div class="alert alert-success">✅ Автомобилът беше обновен успешно!</div>
            <?php elseif ($_GET['status'] == 'created'): ?>
                <div class="alert alert-success">✅ Новият автомобил е добавен успешно!</div>
            <?php elseif ($_GET['status'] == 'deleted'): ?>
                <div class="alert alert-success">🗑️ Автомобилът беше изтрит.</div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="page-header">
            <h1>Управление на Автомобили</h1>
            <a href="index.php?url=admin/create" class="btn-add">+ Добави Нов</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th width="80">Снимка</th>
                        <th>Марка и Модел</th>
                        <th>Година</th>
                        <th>Цена</th>
                        <th>Пробег</th>
                        <th>Статус</th>
                        <th width="180">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($cars) && count($cars) > 0): ?>
                        <?php foreach ($cars as $car): 
                            // --- ЛОГИКА ЗА ТЪМБНЕЙЛ ---
                            // Разбиваме стринга, за да вземем само първата снимка
                            $images = preg_split('/[\s,]+/', $car['image_url'], -1, PREG_SPLIT_NO_EMPTY);
                            $thumb = !empty($images) ? $images[0] : 'images/placeholder.png';
                        ?>
                            <tr>
                                <td>
                                    <img src="<?= htmlspecialchars($thumb); ?>" class="thumb" alt="img">
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($car['make']); ?></strong><br>
                                    <span style="color:#64748b; font-size:0.9em;"><?= htmlspecialchars($car['model']); ?></span>
                                </td>
                                <td><?= htmlspecialchars($car['year']); ?></td>
                                <td style="font-weight:600;"><?= number_format($car['price'], 0, '.', ' '); ?> лв.</td>
                                <td style="color:#64748b;"><?= number_format($car['mileage'] ?? 0, 0, '.', ' '); ?> км</td>
                                <td>
                                    <?php if ($car['is_available']): ?>
                                        <span class="status-badge status-active">Наличен</span>
                                    <?php else: ?>
                                        <span class="status-badge status-sold">Продаден</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="index.php?url=admin/edit/<?= htmlspecialchars($car['id']); ?>" class="action-btn edit-btn">Редакция</a>
                                    
                                    <a href="index.php?url=admin/destroy/<?= htmlspecialchars($car['id']); ?>" 
                                       class="action-btn delete-btn"
                                       onclick="return confirm('Сигурни ли сте, че искате да изтриете този запис?');">
                                        Изтрий
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align:center; padding: 40px; color: #94a3b8;">
                                Няма намерени автомобили. Натиснете бутона "Добави Нов", за да създадете запис.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>