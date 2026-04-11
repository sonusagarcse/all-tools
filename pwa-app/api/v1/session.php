<?php
/**
 * PWA Session & CSRF Bridge
 * Provides the current CSRF token to the PWA app
 */

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

// Start the same session used by the main site
session_start();

require_once dirname(dirname(dirname(__DIR__))) . '/includes/config.php';
require_once dirname(dirname(dirname(__DIR__))) . '/includes/functions.php';

// Generate CSRF token if it doesn't exist
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

echo json_encode([
    'success' => true,
    'csrf_token' => $_SESSION['csrf_token'],
    'session_hash' => get_session_hash(),
    'online' => true // Server-side confirmation
]);
exit;
