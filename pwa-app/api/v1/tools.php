<?php
// Tools API Endpoint
// Handles functionalities like compression, formatting, etc via REST

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
session_start();

require_once dirname(__DIR__) . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

$action = $_POST['action'] ?? '';

// 1. Image Compressor API (Stub)
if ($action === 'compress_image') {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Valid image upload required']);
        exit;
    }

    $targetSizeKb = (int)($_POST['target_size_kb'] ?? 100);
    
    // Stub: here we would process the image in PHP using GD or Imagick,
    // reducing quality or resizing until the file size is <= targetSizeKb.
    
    // Simulate processing time
    sleep(1);

    // Mock response
    echo json_encode([
        'success' => true,
        'message' => 'Image compressed successfully',
        'data' => [
            'original_size_kb' => round($_FILES['image']['size'] / 1024, 2),
            'compressed_size_kb' => $targetSizeKb * 0.95, // mock size
            'download_url' => '/api/v1/downloads.php?file=compressed_mock.jpg'
        ]
    ]);
    exit;
}

// 2. Transliteration API (Stub - handled offline but can be backend)
if ($action === 'transliterate') {
    $text = $_POST['text'] ?? '';
    if (empty($text)) {
         http_response_code(400);
         echo json_encode(['success' => false, 'message' => 'Text required']);
         exit;
    }
    
    echo json_encode([
        'success' => true,
        'data' => [
            'original' => $text,
            'result' => 'प्रतीकात्मक अनुवाद' // Symbolic mock transliteration
        ]
    ]);
    exit;
}

// Fallback
http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Invalid tool action']);
