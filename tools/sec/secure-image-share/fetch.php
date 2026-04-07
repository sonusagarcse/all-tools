<?php
require_once '../../../includes/config.php';

// Burn After Reading Endpoint
// Security: No json error wrapper, just standard HTTP responses so we can send raw binary data.

if (!isset($_GET['id']) || !preg_match('/^[0-9]{8}$/', $_GET['id'])) {
    http_response_code(400);
    die('Invalid or missing ID.');
}

$uuid = $_GET['id'];
$filePath = UPLOAD_DIR . '/sec/secure-image-share/' . $uuid . '.enc';

if (!file_exists($filePath)) {
    http_response_code(404);
    die('File not found. It may have already been viewed and permanently deleted, or it never existed.');
}

// Read the encrypted file into memory (Max 15MB, fits in memory easily)
$data = file_get_contents($filePath);

// BURN AFTER READING - Permanently delete the file from the server
unlink($filePath);

// Disable caching to ensure one-time view mechanics aren't thwarted by browsers
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: 0');

// Send generic octet stream, it's just encrypted bytes anyway.
header('Content-Type: application/octet-stream');
header('Content-Length: ' . strlen($data));

echo $data;
