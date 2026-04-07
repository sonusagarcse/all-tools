<?php
require_once '../../../includes/config.php';
require_once '../../../includes/functions.php';
json_safe_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_error('Invalid request method.');
}

// Security: limit to 15MB since E2EE payload text (base64 in JSON) increases size compared to raw 10MB image
if (empty($_FILES['file']['name']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    json_error('Upload failed or no file provided.');
}
if ($_FILES['file']['size'] > (15 * 1024 * 1024)) {
    json_error('Encrypted payload exceeds 15MB size limit.');
}

// Note: we can't do any image validation (e.g. getimagesize()) because the file is encrypted with AES-GCM
// So we just store the binary blob as-is safely.

$outputDir = UPLOAD_DIR . '/sec/secure-image-share';
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

// Generate a unique 8-digit ID
$attempts = 0;
do {
    $uuid = (string)random_int(10000000, 99999999);
    $outputPath = $outputDir . '/' . $uuid . '.enc';
    $attempts++;
} while (file_exists($outputPath) && $attempts < 100);

if ($attempts >= 100) {
    json_error('Failed to generate a unique ID. Please try again.');
}

if (move_uploaded_file($_FILES['file']['tmp_name'], $outputPath)) {
    json_response([
        'id' => $uuid
    ]);
} else {
    json_error('Failed to save the encrypted file.');
}
