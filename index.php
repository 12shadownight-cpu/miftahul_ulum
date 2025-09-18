<?php
// Start session only if needed
session_start();

// Load autoloader & DB (so project is ready if needed later)
require_once __DIR__ . '/config/Autoload.php';
require_once __DIR__ . '/config/Database.php';

// Directly include the landing page view
include __DIR__ . '/views/public/index.php';
