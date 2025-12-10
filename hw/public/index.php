<?php
// public/index.php
session_start();
require_once '../app/models/CarModel.php';
require_once '../app/controllers/CarController.php';
require_once '../app/controllers/AdminController.php';


$url = $_GET['url'] ?? '';


$parts = explode('/', trim($url, '/'));


$route = ($parts[0] ? $parts[0] : 'public');

$action = $parts[1] ?? 'index';

$id = $parts[2] ?? null;

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
    
    $id ? $controller->$action($id) : $controller->$action();
    
} else {
    
    $controller->index();
    
}
