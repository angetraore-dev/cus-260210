<?php
// router.php
if (is_file(__DIR__ . '/public' . $_SERVER['REQUEST_URI'])) {
    return false; // Laisse PHP servir le fichier s'il existe physiquement
}

// Sinon, on envoie tout vers l'index de Symfony
require_once __DIR__ . '/public/index.php';
//php -S localhost:8000 -t public vendor/symfony/asset-mapper/infrastructure/php/router.php
//php -S localhost:8000 -t public router.php