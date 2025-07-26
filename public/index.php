<?php
// public/index.php

// Autoload PSR-4 simple
spl_autoload_register(function ($class) {
    foreach (['app/Controllers/', 'app/Models/', 'app/Core/'] as $dir) {
        $file = __DIR__ . '/../' . $dir . $class . '.php';
        if (file_exists($file)) require_once $file;
    }
});

// ROUTEUR
$uri = $_SERVER['REQUEST_URI'];

// ROUTES D'AUTH
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

} elseif (strpos($uri, '/trajet/creer') !== false) {
    $controller = new TrajetController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->creerTrajet();
    } else {
        $controller->formCreerTrajet();
    }

} elseif (preg_match('#/trajet/edit/(\d+)#', $uri, $matches)) {
    $controller = new TrajetController();
    $controller->editTrajet($matches[1]); // Méthode à implémenter

} elseif (preg_match('#/trajet/delete/(\d+)#', $uri, $matches)) {
    $controller = new TrajetController();
    $controller->deleteTrajet($matches[1]); // Méthode à implémenter

} else {
    $controller = new HomeController();
    $controller->index();
}

