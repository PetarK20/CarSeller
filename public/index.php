<?php
// public/index.php
session_start();

require_once '../app/models/CarModel.php';
require_once '../app/controllers/CarController.php';
require_once '../app/controllers/AdminController.php';


// Взима стойността на GET параметъра 'url' или празен низ.
$url = $_GET['url'] ?? '';

// Разделя URL-а по '/' на части, премахвайки водещия/крайния '/'.
$parts = explode('/', trim($url, '/'));


$route = ($parts[0] ? $parts[0] : 'public');

// Първата част е 'маршрут' (route), по подразбиране 'public'.
// print_r("Route: " . $route . "\n");
$action = $parts[1] ?? 'index';
// Втората част е 'действие' (action/метод), по подразбиране 'index'.
$id = $parts[2] ?? null;

// Третата част е 'идентификатор' (ID), по подразбиране null.

// Избор на контролер
switch ($route) {
    case 'admin':
        $controller = new AdminController(new CarModel());
        break;
    case 'public':
    default:
        $controller = new CarController();
        break;
}


if (method_exists($controller, $action)) {
    // Проверява дали методът ($action) съществува в избрания контролер.
    $id ? $controller->$action($id) : $controller->$action();
    // Ако има $id, извиква метода с $id като аргумент, иначе без аргументи.
} else {
    // Ако методът ($action) не съществува.
    $controller->index();
    // Извиква се методът 'index' като резервен вариант.
}

