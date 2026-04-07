<?php
require_once '../../../includes/config.php';
require_once '../../../includes/functions.php';
json_safe_start();

// 1. Validate Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf($_POST['csrf_token'] ?? '')) {
    json_error('Invalid request or security token expired.');
}

if (!rate_limit_check()) {
    json_error('Rate limit exceeded.');
}

if (empty($_FILES['file']['name'])) {
    json_error('No file uploaded.');
}

$file = $_FILES['file'];
$quality = (int)($_POST['quality'] ?? 75);

// 2. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/image/compress-image/' . $sessionHash;
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

// 3. Process Image
try {
    $info = getimagesize($file['tmp_name']);
    if (!$info) {
        json_error('Invalid image file.');
    }

    $mime = $info['mime'];
    $srcImg = null;

    switch ($mime) {
        case 'image/jpeg':
            $srcImg = imagecreatefromjpeg($file['tmp_name']);
            break;
        case 'image/png':
            $srcImg = imagecreatefrompng($file['tmp_name']);
            imagepalettetotruecolor($srcImg);
            imagealphablending($srcImg, true);
            imagesavealpha($srcImg, true);
            break;
        case 'image/webp':
            $srcImg = imagecreatefromwebp($file['tmp_name']);
            break;
        default:
            json_error('Unsupported image format: ' . $mime);
    }

    $outputFileName = 'BulkTools_' . rand(1000000, 9999999) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    $outputPath = $outputDir . '/' . $outputFileName;

    // Compress based on type
    switch ($mime) {
        case 'image/jpeg':
            imagejpeg($srcImg, $outputPath, $quality);
            break;
        case 'image/png':
            // PNG quality is 0-9 (high to low compression)
            $pngQuality = 9 - floor($quality / 10);
            imagepng($srcImg, $outputPath, $pngQuality);
            break;
        case 'image/webp':
            imagewebp($srcImg, $outputPath, $quality);
            break;
    }

    $originalSize = $file['size'];
    $compressedSize = filesize($outputPath);
    $savings = round((($originalSize - $compressedSize) / $originalSize) * 100);
    
    imagedestroy($srcImg);
    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/uploads/image/compress-image/' . $sessionHash . '/' . $outputFileName,
        'original_size_str' => format_bytes($originalSize),
        'compressed_size_str' => format_bytes($compressedSize),
        'savings_pct' => $savings
    ]);

} catch (Exception $e) {
    json_error('Compression failed: ' . $e->getMessage());
}
