<?php
// /config/Autoload.php

spl_autoload_register(function ($className) {
    // Directories to search (models + all controllers)
    $directories = [
        __DIR__ . '/../models/',
        __DIR__ . '/../controllers/user/',
        __DIR__ . '/../controllers/pengurus/',
        __DIR__ . '/../controllers/murid/',
        __DIR__ . '/../controllers/orangtua/',
        __DIR__ . '/../controllers/validasi/',
        __DIR__ . '/../controllers/pengumuman/',
    ];

    foreach ($directories as $directory) {
        $file = $directory . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
