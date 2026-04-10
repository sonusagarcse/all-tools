<?php
// Secure Backend Configuration for API
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');     // Assumed based on XAMPP default
define('DB_NAME', 'bulktools');

// Prevent direct access to API files entirely if not via explicit paths
if (basename($_SERVER['PHP_SELF']) == 'config.php') {
    die('Direct access forbidden.');
}

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    // Secure PDO settings
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    // In production, log instead of outputting error
    header('Content-Type: application/json', true, 500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}
