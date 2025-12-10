<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Нашият Автопарк</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Добавяме Google Fonts за по-добър шрифт (Roboto) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        .header-content {
            /* ... (запазваме съществуващите стилове: position, z-index, display, flex-direction и т.н.) ... */

            /* НОВО: Преход за плавна анимация на текста */
            transition: opacity 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94),
                transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);

            /* НОВО: Начално състояние - скрит и леко отместен надолу */
            opacity: 0;
            transform: translateY(20px);
        }

        /* НОВ КЛАС: За да покажем и анимираме текста */
        .header-content.animate-in {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>


<body>

    <header class="main-header">

        <div class="background-rotator">
        </div>

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

    <div class="pagination-controls-wrapper">

        <?php if ($prevPageUrl): ?>
            <div class="button-wrapper-prev-page">
                <a href="<?= $prevPageUrl ?>" class="prev-page-button">
                    &lt;&lt; Предишна страница
                </a>
            </div>
        <?php endif; ?>

        <?php if ($nextPageUrl): ?>
            <div class="button-wrapper-next-page">
                <a href="<?= $nextPageUrl ?>" class="next-page-button">
                    Следваща страница &gt;&gt;
                </a>
            </div>
        <?php endif; ?>

    </div>

    <!-- Футър на страницата -->
    <footer class="main-footer">
        <p>&copy; <?= date('Y'); ?> Автопарк. Всички права запазени.</p>
    </footer>

</body>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const rotator = document.querySelector('.background-rotator');
            const headerContent = document.querySelector('.header-content'); // Взимаме елемента с текста
            const intervalTime = 7000;
            let currentImageIndex = -1;

            // НОВО: Първоначална анимация на текста при зареждане на страницата
            setTimeout(() => {
                headerContent.classList.add('animate-in');
            }, 100);

            // 1. Асинхронна функция за зареждане на следващата снимка
            function fetchNextImage() {
                // Първо скриваме текста, за да започне анимацията за изчезване
                headerContent.classList.remove('animate-in');

                const url = `get_next_car_image.php?current_index=${currentImageIndex}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        currentImageIndex = data.index;
                        transitionImage(data.url);
                    })
                    .catch(error => {
                        console.error('Грешка при зареждане на снимката:', error);
                        // В случай на грешка, пак показваме текста след кратко забавяне
                        setTimeout(() => {
                            headerContent.classList.add('animate-in');
                        }, 1000);
                    });
            }

            // 2. Логика за плавно преминаване към новата снимка
            function transitionImage(newImageUrl) {

                const newImage = document.createElement('img');
                newImage.src = newImageUrl;
                newImage.classList.add('rotator-image');

                newImage.onload = () => {

                    const activeImage = rotator.querySelector('img[style*="opacity: 1"]');

                    rotator.appendChild(newImage);

                    setTimeout(() => {
                        // Показваме новата снимка плавно (чрез CSS transition)
                        newImage.style.opacity = 1;

                        // НОВО: Анимираме текста да се появи отново
                        setTimeout(() => {
                            headerContent.classList.add('animate-in');
                        }, 1000); // Изчакваме снимката да се е сменила (1000ms < 1.5s преход)

                        // Скриваме старата снимка
                        if (activeImage) {
                            activeImage.style.opacity = 0;
                            setTimeout(() => {
                                rotator.removeChild(activeImage);
                            }, 2000);
                        }
                    }, 50);
                };
            }

            // 3. Стартираме ротатора
            fetchNextImage();
            setInterval(fetchNextImage, intervalTime);
        });
</script>

</html>