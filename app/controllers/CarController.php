<?php
// app/controllers/CarController.php

// 1. Сигурно зареждане на модела с абсолютен път
// Пътят е относителен спрямо CarController
require_once __DIR__ . '/../models/CarModel.php';

class CarController
{
    public function index()
    {
        // Създаваме инстанция на модела, който ще се свърже с БД
        $carModel = new CarModel();

        // Взимаме всички коли от базата данни, което връща 
        // асоциативен масив с ключове 'cars' и 'diagnostic'
        $cars_result = $carModel->getAllCars();

        // Извличаме само масива с автомобили, за да го обходи car_list.php
        $cars = $cars_result['cars'] ?? [];

        // 2. Зареждане на изгледа
        // Използваме __DIR__ за абсолютен път до изгледа:
        // __DIR__ (app/controllers) -> ../views/car_list.php
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

?>
