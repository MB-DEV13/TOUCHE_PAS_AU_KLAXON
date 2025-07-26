<?php
// app/Controllers/HomeController.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Models/TrajetModel.php';

class HomeController {
    public function index() {
        $trajets = TrajetModel::getTrajetsDisponibles();
        require __DIR__ . '/../Views/home.php';
    }
}

