<?php
// ============================
// Error Handling Setup
// ============================

// Development mode: show errors
ini_set('display_errors', 1);              // Display errors on screen
ini_set('display_startup_errors', 1);      // Show startup errors
error_reporting(E_ALL);                    // Report all error levels

// Production mode (use when live):
// ini_set('display_errors', 0);           // Do not show errors to users
// ini_set('log_errors', 1);               // Log errors instead
// ini_set('error_log', __DIR__ . '/config/php_errors.log'); // Log file path

// ============================
// Session
// ============================
session_start(); // Start session handling

// ============================
// Autoload and Database
// ============================
require_once __DIR__ . '/config/Autoload.php';
require_once __DIR__ . '/config/Database.php';

// ============================
// Load Landing Page View
// ============================
$landingPage = __DIR__ . '/views/public/index.php';

// Check if file exists before including
if (file_exists($landingPage)) {
    include $landingPage; // Include landing page
} else {
    // Throw exception if file missing
    throw new Exception("View file not found: " . $landingPage);
}
?>
