<?php
// public/index.php

// Charger automatiquement les classes (PSR-4 simple)
spl_autoload_register(function ($class) {
    foreach (['app/Controllers/', 'app/Models/', 'app/Core/'] as $dir) {
        $file = __DIR__ . '/../' . $dir . $class . '.php';
        if (file_exists($file)) require_once $file;
    }
});

// ROUTEUR
require_once __DIR__ . '/../app/Controllers/HomeController.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';

// Ajoute ici l'import du TrajetController :
require_once __DIR__ . '/../app/Controllers/TrajetController.php';

$uri = $_SERVER['REQUEST_URI'];

if (strpos($uri, '/login') !== false) {
    $controller = new AuthController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->login();
    } else {
        $controller->loginForm();
    }
} elseif (strpos($uri, '/logout') !== false) {
    $controller = new AuthController();
    $controller->logout();
} elseif (strpos($uri, '/trajets') !== false) {
    $controller = new TrajetController();
    $controller->mesTrajets();

} else {
    $controller = new HomeController();
    $controller->index();
}

