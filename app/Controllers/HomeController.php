<?php
// app/Controllers/HomeController.php

require_once __DIR__ . '/../Models/TrajetModel.php';

class HomeController {
    public function index() {
        $trajets = TrajetModel::getTrajetsDisponibles();
        require __DIR__ . '/../Views/home.php';
    }
}
