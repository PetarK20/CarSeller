<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $car ? htmlspecialchars($car['make'] . ' ' . $car['model']) : 'Автомобил не е намерен'; ?></title>
    <!-- Зареждаме главния CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        /* СТИЛОВЕ ЗА ВЕРТИКАЛЕН ИЗГЛЕД С ГАЛЕРИЯ */

        html,
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #e2e8f0;
            min-height: 100vh;
        }

        body {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 40px 20px;
            box-sizing: border-box;
        }

        .main-card {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 40px;
        }

        .top-bar {
            padding: 15px 30px;
            background: white;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
        }

        .back-link {
            text-decoration: none;
            color: #64748b;
            font-weight: 500;
            display: flex;
            align-items: center;
            font-size: 0.95em;
            transition: color 0.2s;
        }

        .back-link span {
            margin-right: 8px;
            font-size: 1.2em;
        }

        .back-link:hover {
            color: #2563eb;
        }

        /* --- ГАЛЕРИЯ СЕКЦИЯ --- */
        .image-pane {
            width: 100%;
            /* Увеличена височина, за да побере голямата снимка комфортно */
            height: 500px;
            background-color: #0f172a;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .detail-main-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
            transition: opacity 0.3s ease;
        }

        /* Лента с миниатюри (Thumbnails) */
        .thumbnails-row {
            display: flex;
            gap: 10px;
            padding: 15px 30px;
            background: #1e293b;
            /* Тъмен фон за контраст */
            overflow-x: auto;
            /* Позволява скролване, ако снимките са много */
            justify-content: center;
        }

        .thumb-img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            cursor: pointer;
            border: 2px solid transparent;
            opacity: 0.7;
            transition: all 0.2s;
        }

        .thumb-img:hover,
        .thumb-img.active {
            border-color: #3b82f6;
            /* Синя рамка за активната снимка */
            opacity: 1;
            transform: scale(1.05);
        }

        .badge-overlay {
            position: absolute;
            top: 25px;
            right: 25px;
            background-color: #ef4444;
            color: white;
            padding: 10px 20px;
            font-weight: 800;
            border-radius: 6px;
            text-transform: uppercase;
            font-size: 1.1em;
            letter-spacing: 1px;
            border: 2px solid white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 5;
        }

        .info-pane {
            width: 100%;
            box-sizing: border-box;
            background: white;
            padding: 40px 50px;
            display: flex;
            flex-direction: column;
        }

        .header-section {
            margin-bottom: 30px;
            border-bottom: 2px solid #f8fafc;
            padding-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .car-title {
            margin: 0;
            font-size: 2.5em;
            color: #1e293b;
            line-height: 1.1;
            font-weight: 700;
        }

        .car-price {
            display: block;
            font-size: 2.2em;
            color: #2563eb;
            font-weight: 800;
        }

        .specs-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .spec-item {
            background: #f8fafc;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            text-align: center;
        }

        .spec-label {
            font-size: 0.75em;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .spec-value {
            font-weight: 700;
            color: #334155;
            font-size: 1.1em;
        }

        .content-block {
            margin-bottom: 40px;
        }

        .content-block h2 {
            font-size: 1.3em;
            color: #0f172a;
            margin-bottom: 15px;
            border-left: 5px solid #2563eb;
            padding-left: 15px;
            font-weight: 700;
        }

        .content-block p {
            line-height: 1.8;
            color: #475569;
            margin: 0;
            white-space: pre-line;
            font-size: 1.05em;
        }

        @media (max-width: 900px) {
            .specs-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .header-section {
                flex-direction: column;
                align-items: flex-start;
            }

            .car-price {
                margin-top: 10px;
            }

            .image-pane {
                height: 300px;
            }
        }

        .error-box {
            text-align: center;
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <?php if ($car): ?>
        <?php
        // ОБРАБОТКА НА СНИМКИТЕ
        // Разделяме стринга от базата по запетая и махаме празни места
        $images = array_filter(array_map('trim', explode(',', $car['image_url'])));

        // Ако няма снимки, слагаме placeholder
        if (empty($images)) {
            $images[] = 'images/placeholder.png';
        }

        // Първата снимка е "Главна"
        $mainImage = $images[0];
        ?>

        <div class="main-card">
            <div class="top-bar">
                <a href="index.php?url=public&page=1" onclick="history.back(); return false;" class="back-link">
                    <span>&#8592;</span> Обратно към списъка
                </a>
            </div>

            <!-- 1. ГЛАВНА СНИМКА -->
            <div class="image-pane">
                <?php if (isset($car['is_available']) && !$car['is_available']): ?>
                    <div class="badge-overlay">ПРОДАДЕН</div>
                <?php endif; ?>

                <img id="mainDisplayImage" class="detail-main-image"
                    src="<?= htmlspecialchars($mainImage); ?>"
                    alt="<?= htmlspecialchars($car['make']); ?>">
            </div>

            <!-- 2. ЛЕНТА С МИНИАТЮРИ (САМО АКО ИМА ПОВЕЧЕ ОТ 1 СНИМКА) -->
            <?php if (count($images) > 1): ?>
                <div class="thumbnails-row">
                    <?php foreach ($images as $index => $imgSrc): ?>
                        <img src="<?= htmlspecialchars($imgSrc); ?>"
                            class="thumb-img <?= $index === 0 ? 'active' : ''; ?>"
                            onclick="changeImage('<?= htmlspecialchars($imgSrc); ?>', this)"
                            alt="thumb">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- 3. ИНФОРМАЦИЯ -->
            <div class="info-pane">
                <div class="header-section">
                    <div class="title-group">
                        <h1 class="car-title"><?= htmlspecialchars($car['make'] . ' ' . $car['model']); ?></h1>
                    </div>
                    <div class="price-group">
                        <span class="car-price"><?= number_format($car['price'], 0, '.', ' '); ?> лв.</span>
                    </div>
                </div>

                <div class="specs-grid">
                    <div class="spec-item">
                        <span class="spec-label">Година</span>
                        <span class="spec-value"><?= htmlspecialchars($car['year']); ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Пробег</span>
                        <span class="spec-value"><?= number_format($car['mileage'] ?? 0, 0, '.', ' '); ?> км</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Гориво</span>
                        <span class="spec-value"><?= htmlspecialchars($car['engine_type']); ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Скорости</span>
                        <span class="spec-value"><?= htmlspecialchars($car['transmission_type'] ?? '-'); ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Градско</span>
                        <span class="spec-value"><?= htmlspecialchars($car['fuel_consumption_city']); ?> л.</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Извънградско</span>
                        <span class="spec-value"><?= htmlspecialchars($car['fuel_consumption_highway'] ?? '-'); ?> л.</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Цвят</span>
                        <span class="spec-value"><?= htmlspecialchars($car['color']); ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Наличност</span>
                        <span class="spec-value" style="color: <?= $car['is_available'] ? '#16a34a' : '#dc2626'; ?>">
                            <?= $car['is_available'] ? 'Наличен' : 'Продаден'; ?>
                        </span>
                    </div>
                </div>

                <div class="content-block">
                    <h2>Екстри и оборудване</h2>
                    <p><?= htmlspecialchars($car['extras'] ?: 'Няма въведени екстри.'); ?></p>
                </div>

                <div class="content-block">
                    <h2>Коментар</h2>
                    <p><?= htmlspecialchars($car['comments'] ?: 'Няма коментар.'); ?></p>
                </div>

                <div style="margin-top: 40px; border-top: 1px solid #f1f5f9; padding-top: 20px; text-align: center; color: #94a3b8; font-size: 0.9em;">
                    &copy; <?= date('Y'); ?> Автопарк
                </div>
            </div>
        </div>

        <!-- JS ЗА СМЯНА НА СНИМКИТЕ -->
        <script>
            function changeImage(src, element) {
                // Смяна на голямата снимка
                var mainImg = document.getElementById('mainDisplayImage');
                mainImg.style.opacity = 0; // Ефект на избледняване

                setTimeout(function() {
                    mainImg.src = src;
                    mainImg.style.opacity = 1;
                }, 200);

                // Смяна на активния клас на тъмбнейлите
                var thumbs = document.querySelectorAll('.thumb-img');
                thumbs.forEach(function(t) {
                    t.classList.remove('active');
                });
                element.classList.add('active');
            }
        </script>

    <?php else: ?>
        <div class="error-box">
            <h2>Автомобилът не е намерен</h2>
            <a href="index.php?url=public" class="back-link" style="justify-content: center;">Към началото</a>
        </div>
    <?php endif; ?>

</body>

</html>