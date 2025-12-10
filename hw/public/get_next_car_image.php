<?php
// public/get_next_car_image.php

$carImages = [
    'images/mercedes-benz-c220d-estate-2020.png',
    'images/volvo-xc90-t8-2020.png',
    'images/audi-a3-2024.png'
];

$currentIndex = isset($_GET['current_index']) ? (int)$_GET['current_index'] : -1;

$nextIndex = ($currentIndex + 1) % count($carImages);

header('Content-Type: application/json');
echo json_encode([
    'url' => $carImages[$nextIndex],
    'index' => $nextIndex
]);
exit; 
?>