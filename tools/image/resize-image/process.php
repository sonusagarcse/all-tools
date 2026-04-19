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
$newW = (float)($_POST['width'] ?? 800);
$newH = (float)($_POST['height'] ?? 600);
$unit = $_POST['unit'] ?? 'px';
$keepAspect = isset($_POST['aspect']);

// Convert to Pixels if needed (96 DPI standard)
if ($unit === 'cm') {
    $newW = round($newW * 37.7952755906);
    $newH = round($newH * 37.7952755906);
} elseif ($unit === 'm') {
    $newW = round($newW * 3779.52755906);
    $newH = round($newH * 3779.52755906);
} else {
    $newW = (int)$newW;
    $newH = (int)$newH;
}

// 2. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/image/resize-image/' . $sessionHash;
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

// 3. Resizing Process
try {
    $info = getimagesize($file['tmp_name']);
    if (!$info) json_error('Invalid image file.');

    $mime = $info['mime'];
    $srcW = $info[0];
    $srcH = $info[1];

    if ($keepAspect) {
        $ratio = min($newW / $srcW, $newH / $srcH);
        $newW = round($srcW * $ratio);
        $newH = round($srcH * $ratio);
    }

    $srcImg = null;
    switch ($mime) {
        case 'image/jpeg': $srcImg = imagecreatefromjpeg($file['tmp_name']); break;
        case 'image/png': 
            $srcImg = imagecreatefrompng($file['tmp_name']); 
            imagepalettetotruecolor($srcImg);
            imagealphablending($srcImg, true);
            imagesavealpha($srcImg, true);
            break;
        case 'image/webp': $srcImg = imagecreatefromwebp($file['tmp_name']); break;
        default: json_error('Unsupported format.');
    }

    $dstImg = imagecreatetruecolor($newW, $newH);

    // Alpha support
    if ($mime === 'image/png' || $mime === 'image/webp') {
        imagealphablending($dstImg, false);
        imagesavealpha($dstImg, true);
        $transparent = imagecolorallocatealpha($dstImg, 255, 255, 255, 127);
        imagefilledrectangle($dstImg, 0, 0, $newW, $newH, $transparent);
    }

    imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $newW, $newH, $srcW, $srcH);

    $outputFileName = 'BulkTools_' . rand(1000000, 9999999) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    $outputPath = $outputDir . '/' . $outputFileName;

    switch ($mime) {
        case 'image/jpeg': imagejpeg($dstImg, $outputPath, 90); break;
        case 'image/png': imagepng($dstImg, $outputPath); break;
        case 'image/webp': imagewebp($dstImg, $outputPath, 90); break;
    }

    imagedestroy($srcImg);
    imagedestroy($dstImg);
    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/uploads/image/resize-image/' . $sessionHash . '/' . $outputFileName,
        'filename' => $outputFileName
    ]);

} catch (Exception $e) {
    json_error('Resizing failed: ' . $e->getMessage());
}
