<?php

define('DB_HOST', 'localhost');

// Si la variable d'environnement PHPUNIT_TEST=1, alors on prend la base de test
if (getenv('PHPUNIT_TEST') === '1') {
    define('DB_NAME', 'covoiturage_test'); //  base dédiée aux tests
} else {
    define('DB_NAME', 'covoiturage');      // base normale
}

define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');
