<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Нашият Автопарк</title>
    <!-- Връзка към CSS файла -->
    <link rel="stylesheet" href="css/style.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Заглавна част (Hero Section) -->
    <header class="main-header">
        <div class="header-content">
            <h1>Автомобили в наличност</h1>
            <p>Изберете вашия следващ автомобил от нашата селекция</p>
        </div>
    </header>

    <!-- Основен контейнер за картите -->
    <div class="card-wrapper">
        <?php 
        // Започваме цикъла, който обхожда всеки запис от базата
        foreach ($cars as $car): 
            // Проверка за наличност
            $isAvailable = $car['is_available'];
            $statusClass = $isAvailable ? '' : 'sold-out';

            // Разбиваме стринга по запетая, нов ред или интервал
            $images = preg_split('/[\s,]+/', $car['image_url'], -1, PREG_SPLIT_NO_EMPTY);
            // Взимаме първата, или слагаме placeholder ако няма нищо
            $mainImage = !empty($images) ? $images[0] : 'images/placeholder.png';
        ?>
        
        <!-- Карта за автомобил -->
        <div class="card <?= $statusClass ?>">
            
            <!-- Контейнер за снимката -->
            <div class="image-container">
                <!-- Етикет, ако колата е продадена -->
                <?php if (!$isAvailable): ?>
                    <span class="status-badge sold">ПРОДАДЕН</span>
                <?php endif; ?>
                
                <!-- Снимка на автомобила (използваме $mainImage) -->
                <img class="card-image" 
                     src="<?= htmlspecialchars($mainImage); ?>" 
                     alt="<?= htmlspecialchars($car['make'] . ' ' . $car['model']); ?>">
            </div>
            
            <!-- Съдържание на картата -->
            <div class="card-content">
                <div class="car-info-top">
                    <!-- Марка и Модел -->
                    <h3><?= htmlspecialchars($car['make']); ?> <span class="model-name"><?= htmlspecialchars($car['model']); ?></span></h3>
                    
                    <!-- Година и Трансмисия -->
                    <div class="meta-info">
                        <span class="year-badge"><?= htmlspecialchars($car['year']); ?></span>
                        <span class="transmission"><?= htmlspecialchars($car['transmission_type'] ?? 'N/A'); ?></span>
                    </div>
                </div>
                
                <!-- Спецификации -->
                <div class="car-specs">
                    <div class="spec-item">
                        <span class="label">Пробег</span>
                        <span class="value"><?= number_format($car['mileage'] ?? 0, 0, '', ' '); ?> км</span>
                    </div>
                    <div class="spec-item">
                        <span class="label">Гориво</span>
                        <span class="value"><?= htmlspecialchars($car['engine_type'] ?? '-'); ?></span>
                    </div>
                </div>

                <!-- Долна част с цена и бутон -->
                <div class="car-footer">
                    <div class="price-container">
                        <span class="price-label">Цена</span>
                        <span class="price"><?= number_format($car['price'], 0, '.', ' '); ?> лв.</span>
                    </div>
                    <a href="index.php?url=public/show/<?= htmlspecialchars($car['id']); ?>" class="btn-details">
                        Преглед
                    </a>
                </div>
            </div>

        </div>

        <?php 
        endforeach; 
        
        // Съобщение, ако няма автомобили
        if (empty($cars)) {
            echo "<div class='no-cars'>
                    <h3>В момента няма налични автомобили.</h3>
                    <p>Моля, проверете отново по-късно.</p>
                  </div>";
        }
        ?>
    </div> 

    <!-- Футър на страницата -->
    <footer class="main-footer">
        <p>&copy; <?= date('Y'); ?> Автопарк. Всички права запазени.</p>
    </footer>

</body>

</html>
