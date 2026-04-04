<?php
require_once __DIR__ . '/includes/config.php';

$file = $_GET['file'] ?? '';

// Prevent path traversal
if (empty($file) || strpos($file, '..') !== false) {
    die("Invalid file path.");
}

$filepath = realpath(UPLOAD_DIR . '/' . $file);

// Ensure the filepath is actually inside the UPLOAD_DIR
if ($filepath && file_exists($filepath) && strpos($filepath, realpath(UPLOAD_DIR)) === 0) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream'); // Forces direct download
    header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filepath));
    flush(); 
    readfile($filepath);
    exit;
}

die("File not found or has expired.");
