<?php
// app/controllers/AdminController.php

class AdminController 
{
    private $carModel;

    public function __construct(CarModel $carModel)
    {
        $this->carModel = $carModel;
    }

    private function checkAccess()
    {
        if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
            // Зареждаме формата за вход, ако потребителят не е логнат
            require __DIR__ . '/../views/admin/login.php';
            exit; // Спираме скрипта тук, за да не се покаже админ панела
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';

            // ПАРОЛАТА Е ТУК: 'admin123'
            if ($password === 'admin123') { 
                $_SESSION['is_logged_in'] = true;
                header('Location: index.php?url=admin');
                exit;
            } else {
                $error = "Грешна парола!";
                require __DIR__ . '/../views/admin/login.php';
            }
        } else {
            // Ако просто отворим страницата
            require __DIR__ . '/../views/admin/login.php';
        }
    }

    public function logout()
    {
        session_destroy(); // Унищожава сесията
        header('Location: index.php'); // Връща към публичния сайт
        exit;
    }

    // ==========================================
    // 2. ОСНОВНИ ФУНКЦИИ (CRUD)
    // ==========================================

    public function index()
    {
        $this->checkAccess(); // Защита

        $data = $this->carModel->getAllCars();
        $cars = $data['cars'];
        
        require __DIR__ . '/../views/admin/index.php';
    }

    public function create()
    {
        $this->checkAccess(); // Защита
        require __DIR__ . '/../views/admin/create.php';
    }

    // Записване на нов автомобил
    public function store()
    {
        $this->checkAccess(); // Защита

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->collectPostData();

            if ($this->carModel->createCar($data)) {
                header('Location: index.php?url=admin&status=created');
                exit;
            } else {
                echo "Грешка при запис в базата.";
            }
        }
    }

    public function edit($id)
    {
        $this->checkAccess(); // Защита

        if (!$id) {
            header('Location: index.php?url=admin');
            exit;
        }

        $car = $this->carModel->getCarById($id);

        if (!$car) {
            echo "Автомобилът не е намерен.";
            return;
        }

        require __DIR__ . '/../views/admin/edit.php';
    }

    // Обновяване на съществуващ автомобил
    public function update()
    {
        $this->checkAccess(); // Защита

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->collectPostData();
            
            // Добавяме ID-то, което идва от скритото поле (hidden input)
            $data['id'] = (int)$_POST['id'];

            if ($this->carModel->updateCar($data)) {
                header('Location: index.php?url=admin&status=updated');
                exit;
            } else {
                echo "Грешка при редакция.";
            }
        }
    }

    public function destroy($id)
    {
        $this->checkAccess(); // Защита

        if ($id) {
            $this->carModel->deleteCar($id);
        }
        header('Location: index.php?url=admin&status=deleted');
        exit;
    }

    // ==========================================
    // 3. ПОМОЩНИ ФУНКЦИИ
    // ==========================================

    /**
     * Събира данните от $_POST формата в масив,
     * за да не пишем едно и също в store() и update().
     */
    private function collectPostData() {
        return [
            'make' => htmlspecialchars(trim($_POST['make'] ?? '')),
            'model' => htmlspecialchars(trim($_POST['model'] ?? '')),
            'year' => (int)($_POST['year'] ?? 0),
            'mileage' => (int)($_POST['mileage'] ?? 0), // ВАЖНО: Полето за пробег
            'price' => (float)($_POST['price'] ?? 0.00),
            'engine_type' => htmlspecialchars(trim($_POST['engine_type'] ?? '')),
            'transmission_type' => htmlspecialchars(trim($_POST['transmission_type'] ?? '')),
            'fuel_consumption_city' => (float)($_POST['fuel_consumption_city'] ?? 0.0),
            'fuel_consumption_highway' => (float)($_POST['fuel_consumption_highway'] ?? 0.0),
            'color' => htmlspecialchars(trim($_POST['color'] ?? '')),
            'extras' => htmlspecialchars(trim($_POST['extras'] ?? '')),
            'comments' => htmlspecialchars(trim($_POST['comments'] ?? '')),
            'image_url' => htmlspecialchars(trim($_POST['image_url'] ?? '')),
            // Чекбоксът връща 'on' или нищо. Превръщаме го в 1 или 0.
            'is_available' => isset($_POST['is_available']) ? 1 : 0,
        ];
    }
}