<?php
/**
 * BULKTOOLS PWA - Cloud Share Upload API
 * Handles image uploads and returns a unique shareable link.
 */

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

session_start();

// Pre-check for uploads directory
$uploadDir = dirname(dirname(dirname(__DIR__))) . '/uploads/shared/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

// Validate file existence
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'No image uploaded or upload error occurred.']);
    exit;
}

$file = $_FILES['image'];
$allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
$maxSize = 10 * 1024 * 1024; // 10MB limit for sharing

// 1. Validate Type
$fileType = mime_content_type($file['tmp_name']);
if (!in_array($fileType, $allowedTypes)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, WEBP, and GIF allowed.']);
    exit;
}

// 2. Validate Size
if ($file['size'] > $maxSize) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'File too large. Maximum size is 10MB.']);
    exit;
}

// 3. Generate Unique ID & Filename
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
if (empty($extension)) {
    $extension = explode('/', $fileType)[1];
}
$shareId = bin2hex(random_bytes(6)); // 12 character unique string
$filename = $shareId . '.' . $extension;
$targetPath = $uploadDir . $filename;

// 4. Move File
if (move_uploaded_file($file['tmp_name'], $targetPath)) {
    // Construct public share URL
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $baseUrl = $protocol . '://' . $host . dirname($_SERVER['SCRIPT_NAME']); // api/v1/
    
    // Go up 2 levels from api/v1 to root
    $projectRoot = $protocol . '://' . $host . str_replace('/pwa-app/api/v1', '', dirname($_SERVER['SCRIPT_NAME']));
    
    $shareLink = rtrim($projectRoot, '/') . '/shared.php?id=' . $shareId;

    echo json_encode([
        'success' => true,
        'message' => 'Image uploaded successfully.',
        'data' => [
            'id' => $shareId,
            'share_url' => $shareLink,
            'expiry' => 'Never (Demo)'
        ]
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save image on server.']);
}
