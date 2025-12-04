<?php
// public/index.php
session_start();

// Начален PHP таг.
require_once '../app/models/CarModel.php';

// Включва файла с модела CarModel (работи с данните).
require_once '../app/controllers/CarController.php';

// Включва файла с контролера CarController (обработва публични заявки).
require_once '../app/controllers/AdminController.php';

// Включва файла с контролера AdminController (обработва административни заявки).

// --- ROUTER ---
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
// Коментар, указващ, че следва логиката за избор на контролер.
switch ($route) {
    // Започва проверка на стойността на $route.
    case 'admin':
        // Ако $route е 'admin'.

        $controller = new AdminController(new CarModel());


        // Създава се нов обект от класа AdminController.
        break;
    // Прекратява switch блока.
    case 'public':
        // Ако $route е 'public'.
    default:
        // Ако $route не е нито 'admin', нито 'public' (или е 'public').
        $controller = new CarController();
        // По подразбиране се създава нов обект от класа CarController.
        break;
        // Прекратява switch блока.
}

// Изпълняваме метода
// Коментар, указващ, че следва логиката за изпълнение на метода/действието.
if (method_exists($controller, $action)) {
    // Проверява дали методът ($action) съществува в избрания контролер.
    $id ? $controller->$action($id) : $controller->$action();
    // Ако има $id, извиква метода с $id като аргумент, иначе без аргументи.
} else {
    // Ако методът ($action) не съществува.
    $controller->index();
    // Извиква се методът 'index' като резервен вариант.
}
