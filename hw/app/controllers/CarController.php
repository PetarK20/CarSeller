<?php
// app/controllers/CarController.php


require_once __DIR__ . '/../models/CarModel.php';

class CarController
{
    public function index() 
    {
        // 1. Вземаме номера на страницата директно от URL параметрите
        // Ако 'page' не е зададен (т.е. index.php?url=public), използваме 1.
        $pageFromUrl = $_GET['page'] ?? 1;

        // 2. Гарантираме, че $currentPage е валидно положително число.
        $currentPage = max(1, (int)$pageFromUrl);

        $carModel = new CarModel();

        // 3. Извикваме модела с коректната страница
        $cars_result = $carModel->getNineCars($currentPage);
        $cars = is_array($cars_result) ? $cars_result : [];


        // 4. Изчисляване на общия брой страници
        $totalCars = $carModel->getTotalCarCount();
        $totalPages = ceil($totalCars / 9);

        // 5. Генериране на линк за СЛЕДВАЩА страница
        $nextPageUrl = null;
        $nextPage = $currentPage + 1;
        if ($nextPage <= $totalPages) {
            $nextPageUrl = "index.php?url=public&page=" . $nextPage;
        }

        // 6. Генериране на линк за ПРЕДИШНА страница
        $prevPageUrl = null;
        if ($currentPage > 1) {
            $prevPage = $currentPage - 1;
            $prevPageUrl = "index.php?url=public&page=" . $prevPage;
        }

        // 7. Зареждаме изгледа, като му предаваме всички променливи
        require_once __DIR__ . '/../views/car_list.php';
    }

    public function show($id)
    {
        $carModel = new CarModel();
        $car = $carModel->getCarById($id);

        if ($car) {
            require_once __DIR__ . '/../views/car_detail.php';
        } else {
            echo "<div class='diag-error'>Грешка: Автомобилът с ID " . htmlspecialchars($id) . " не беше намерен.</div>";
        }
    }
}
