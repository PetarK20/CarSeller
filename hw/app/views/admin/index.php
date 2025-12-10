<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Админ Панел</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        /* CSS променливи, които са в style.css (трябва да се дефинират или импортират тук) */
        :root {
            --primary-color: #2563eb; 
            --primary-hover: #1d4ed8; 
            --bg-color: #f8fafc; 
            --card-bg: #ffffff; 
            --text-dark: #1e293b; 
            --text-light: #64748b; 
            --accent-red: #ef4444; 
            --border-radius: 12px; 
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        body { font-family: 'Roboto', sans-serif; background-color: var(--bg-color); margin: 0; padding: 0; color: var(--text-dark); }
        
        /* Header */
        .admin-header {
            background: var(--card-bg);
            padding: 15px 40px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand { font-size: 1.2em; font-weight: 700; color: var(--text-dark); }
        .user-nav a { color: var(--accent-red); text-decoration: none; font-weight: 500; margin-left: 20px; }
        .user-nav a.view-site { color: var(--primary-color); }

        /* Main Content */
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        
        .controls-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .add-btn {
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
        }
        .add-btn:hover { background-color: var(--primary-hover); }
        .add-btn span { font-size: 1.5em; margin-right: 8px; }

        /* Table Styles */
        .table-wrapper {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            overflow-x: auto; /* Позволява хоризонтален скрол на малки екрани */
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95em;
        }

        th {
            text-align: left;
            padding: 15px;
            background-color: #f1f5f9; /* Светло сив фон на заглавията */
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }
        
        tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.8em;
            font-weight: 700;
        }

        .status-active {
            background-color: #ecfdf5; /* Light Green */
            color: #059669; /* Dark Green */
        }

        .status-sold {
            background-color: #fee2e2; /* Light Red */
            color: #ef4444; /* Dark Red */
        }

        /* Action Buttons */
        .action-btn {
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.9em;
            font-weight: 500;
            margin-right: 8px;
            transition: opacity 0.2s;
        }

        .edit-btn {
            background-color: #fcd34d; /* Amber */
            color: #78350f;
        }
        .edit-btn:hover { opacity: 0.8; }

        .delete-btn {
            background-color: #ef4444; /* Red */
            color: white;
            border: none;
        }
        .delete-btn:hover { opacity: 0.8; }
        
        /* Image Preview in Table */
        .car-thumb {
            width: 70px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            display: block;
        }

        /* НОВИ СТИЛОВЕ ЗА СОРТИРАНЕ И АЛЕРТ */
        th.sortable:after {
            content: '';
            display: inline-block;
            width: 0;
            height: 0;
            margin-left: 8px;
            vertical-align: middle;
            border-style: solid;
            border-width: 0 4px 6px 4px;
            border-color: #94a3b8 transparent transparent transparent;
            transition: transform 0.2s;
        }

        th.asc:after {
            transform: rotate(0deg);
            border-color: var(--primary-color) transparent transparent transparent;
        }

        th.desc:after {
            transform: rotate(180deg);
            border-color: var(--primary-color) transparent transparent transparent;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
            opacity: 1;
            transform: translateX(0);
        }
        .alert-success { 
            background-color: #d1fae5; 
            color: #065f46; 
            border: 1px solid #6ee7b7; 
        }
        .alert-error { 
            background-color: #fee2e2; 
            color: #991b1b; 
            border: 1px solid #fca5a5; 
        }

    </style>
</head>
<body>
    <div class="admin-header">
        <span class="brand">Администрация: Автопарк</span>
        <div class="user-nav">
            <a href="index.php?url=public" class="view-site">Към сайта</a>
            <a href="index.php?url=admin/logout">Изход</a>
        </div>
    </div>

    <div class="container">
        
        <div class="controls-bar">
            <h1>Управление на Автомобилите (<?= count($cars); ?>)</h1>
            <a href="index.php?url=admin/create" class="add-btn">
                <span>+</span> Добави Нов
            </a>
        </div>
        
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width: 80px;">Снимка</th>
                        <th class="sortable">Марка и Модел</th>
                        <th class="sortable" style="width: 80px;">Година</th>
                        <th class="sortable">Пробег (км)</th>
                        <th class="sortable">Цена (лв.)</th>
                        <th class="sortable" style="width: 100px;">Наличност</th>
                        <th style="width: 180px;">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($cars) && is_array($cars) && count($cars) > 0): ?>
                        <?php foreach ($cars as $car): ?>
                            <?php 
                                $mainImage = 'images/placeholder.png';
                                $images = array_filter(array_map('trim', explode(',', $car['image_url'] ?? '')));
                                if (!empty($images)) {
                                    $mainImage = $images[0];
                                }
                            ?>
                            <tr>
                                <td>
                                    <img src="<?= htmlspecialchars($mainImage); ?>" alt="Car thumbnail" class="car-thumb">
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($car['make']); ?></strong>
                                    <span><?= htmlspecialchars($car['model']); ?></span>
                                </td>
                                <td><?= htmlspecialchars($car['year']); ?></td>
                                <td><?= number_format($car['mileage'] ?? 0, 0, '', ' '); ?> км</td>
                                <td><?= number_format($car['price'], 0, '', ' '); ?> лв.</td>
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
                                       class="action-btn delete-btn">
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
    
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const table = document.querySelector('table');
        const tbody = table ? table.querySelector('tbody') : null;
        if (!tbody) return; // Спира, ако таблицата не съществува
        
        // =======================================================
        // 1. ФУНКЦИЯ ЗА СОРТИРАНЕ НА ТАБЛИЦАТА (Table Sorter)
        // =======================================================
        table.querySelectorAll('th.sortable').forEach(headerCell => {
            headerCell.style.cursor = 'pointer';
            headerCell.addEventListener('click', () => {
                const tableElement = headerCell.closest('table');
                const headerIndex = Array.prototype.indexOf.call(headerCell.parentNode.children, headerCell);
                const isAscending = headerCell.classList.contains('asc');

                // Премахване на класовете за сортиране от всички заглавия
                tableElement.querySelectorAll('th').forEach(th => {
                    th.classList.remove('asc', 'desc');
                });

                // Сортиране
                const sortedRows = Array.from(tbody.querySelectorAll('tr'));
                sortedRows.sort((a, b) => {
                    let aText = a.children[headerIndex].textContent.trim();
                    let bText = b.children[headerIndex].textContent.trim();
                    
                    // Специална обработка за числа (Цена, Година, Пробег)
                    if (headerCell.textContent.includes('Цена') || headerCell.textContent.includes('Пробег') || headerCell.textContent.includes('Година')) {
                        // Премахваме " лв.", " км" и интервалите за форматиране
                        const aValue = parseFloat(aText.replace(/ лв\.| км| /g, '')) || 0;
                        const bValue = parseFloat(bText.replace(/ лв\.| км| /g, '')) || 0;
                        return isAscending ? aValue - bValue : bValue - aValue;
                    }
                    
                    // Сортиране по наличност (дава приоритет на "Наличен")
                    if (headerCell.textContent.includes('Наличност')) {
                         const statusA = aText === 'Наличен' ? 1 : 0;
                         const statusB = bText === 'Наличен' ? 1 : 0;
                         return isAscending ? statusA - statusB : statusB - statusA;
                    }

                    // Сортиране по азбучен ред
                    return isAscending ? bText.localeCompare(aText) : aText.localeCompare(bText);
                });

                // Прилагане на новия ред
                sortedRows.forEach(row => tbody.appendChild(row));

                // Добавяне на класа за новото състояние на сортиране
                headerCell.classList.add(isAscending ? 'desc' : 'asc');
            });
        });

        // =======================================================
        // 2. AJAX ИЗТРИВАНЕ НА АВТОМОБИЛ
        // =======================================================
        tbody.addEventListener('click', (e) => {
            if (e.target.classList.contains('delete-btn')) {
                e.preventDefault();
                const deleteUrl = e.target.href;
                const row = e.target.closest('tr');
                // Извличаме името на колата от втората колона за потвърждение
                const carName = row.children[1].querySelector('strong').textContent + ' ' + row.children[1].querySelector('span').textContent;
                
                if (confirm(`Сигурни ли сте, че искате да изтриете ${carName}?`)) {
                    
                    // Изпращане на AJAX заявка. Предполагаме, че контролерът връща OK.
                    fetch(deleteUrl, {
                        method: 'GET' 
                    })
                    .then(response => {
                        if (response.ok) {
                             // Плавно скриване на реда
                            row.style.opacity = '0';
                            row.style.transform = 'translateX(-100%)';
                            setTimeout(() => {
                                row.remove();
                                showAdminAlert(`🗑️ Автомобилът "${carName}" беше изтрит успешно!`, 'success');
                            }, 500);
                        } else {
                            throw new Error('Грешка при изтриване');
                        }
                    })
                    .catch(error => {
                        console.error('AJAX Delete Error:', error);
                        showAdminAlert('❌ Възникна грешка при изтриването! Опитайте отново.', 'error');
                    });
                }
            }
        });

        // =======================================================
        // 3. ФУНКЦИЯ ЗА ПОКАЗВАНЕ НА АЛЕРТИ
        // =======================================================
        function showAdminAlert(message, type) {
            // Премахване на стари алерти
            document.querySelectorAll('.alert').forEach(a => a.remove());

            const alertDiv = document.createElement('div');
            alertDiv.classList.add('alert', `alert-${type}`);
            alertDiv.innerHTML = message;
            
            const container = document.querySelector('.container');
            container.prepend(alertDiv);
            
            // Плавно скриване след 5 секунди
            setTimeout(() => {
                alertDiv.style.opacity = '0';
                setTimeout(() => alertDiv.remove(), 500);
            }, 5000);
        }
    });
</script>

</body>
</html>