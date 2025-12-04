<?php
// app/models/CarModel.php

class CarModel
{
    private $db;

    public function __construct()
    {
        $host = 'localhost';
        $db = 'autopark';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->db = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            die("DB Connection Error: " . $e->getMessage());
        }
    }

    public function getAllCars()
    {
        try {
            $stmt = $this->db->query('SELECT * FROM cars');
            $cars = $stmt->fetchAll();
            return ['cars' => $cars, 'diagnostic' => "Намерени: " . count($cars)];
        } catch (PDOException $e) {
            return ['cars' => [], 'diagnostic' => "Грешка: " . $e->getMessage()];
        }
    }

    public function getCarById($id)
    {
        try {
            $stmt = $this->db->prepare('SELECT * FROM cars WHERE id = :id');
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (\PDOException $e) {
            return false;
        }
    }

    // ТУК Е ОСНОВНАТА ПРОМЯНА - добавихме try-catch
    public function createCar($data)
    {
        $sql = "INSERT INTO cars (make, model, year, mileage, price, engine_type, transmission_type, fuel_consumption_city, fuel_consumption_highway, color, extras, comments, image_url, is_available) 
             VALUES (:make, :model, :year, :mileage, :price, :engine_type, :transmission_type, :fuel_consumption_city, :fuel_consumption_highway, :color, :extras, :comments, :image_url, :is_available)";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);
            return true;
        } catch (\PDOException $e) {
            // Това ще покаже грешката на екрана, за да разбереш какво става!
            echo "<div style='background:red; color:white; padding:20px;'>GRESHKA SQL: " . $e->getMessage() . "</div>";
            exit; // Спираме изпълнението, за да видиш грешката
        }
    }

    public function updateCar($data)
    {
        $sql = "UPDATE cars SET 
                     make = :make, 
                     model = :model, 
                     year = :year, 
                     mileage = :mileage, 
                     price = :price, 
                     engine_type = :engine_type, 
                     transmission_type = :transmission_type,
                     fuel_consumption_city = :fuel_consumption_city,
                     fuel_consumption_highway = :fuel_consumption_highway,
                     color = :color, 
                     extras = :extras, 
                     comments = :comments, 
                     image_url = :image_url,
                     is_available = :is_available
                   WHERE id = :id";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);
            return true;
        } catch (\PDOException $e) {
            echo "<div style='background:red; color:white; padding:20px;'>GRESHKA UPDATE: " . $e->getMessage() . "</div>";
            exit;
        }
    }

    public function deleteCar($id)
    {
        $stmt = $this->db->prepare('DELETE FROM cars WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}