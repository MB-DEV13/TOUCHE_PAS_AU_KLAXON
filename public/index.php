<?php
// public/index.php

// Charger automatiquement les classes (PSR-4 simple)
spl_autoload_register(function ($class) {
    foreach (['app/Controllers/', 'app/Models/', 'app/Core/'] as $dir) {
        $file = __DIR__ . '/../' . $dir . $class . '.php';
        if (file_exists($file)) require_once $file;
    }
});

// ROUTEUR BASIQUE : toujours HomeController@index pour le test
require_once __DIR__ . '/../app/Controllers/HomeController.php';

$controller = new HomeController();
$controller->index();
