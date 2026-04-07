<?php
require_once '../../../includes/config.php';
require_once '../../../includes/functions.php';
json_safe_start();

// 1. Validate Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf($_POST['csrf_token'] ?? '')) {
    json_error('Invalid request or security token expired.');
}
if (!rate_limit_check()) { json_error('Rate limit exceeded.'); }
if (empty($_FILES['file']['name'])) { json_error('No file uploaded.'); }

$file = $_FILES['file'];
$outputFormat = $_POST['output_format'] ?? 'jpg';
$quality = (int)($_POST['quality'] ?? 90);

if (!in_array($outputFormat, ['jpg', 'png', 'webp'])) { $outputFormat = 'jpg'; }

// 2. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/image/convert-image/' . $sessionHash;
if (!is_dir($outputDir)) { mkdir($outputDir, 0777, true); }

// 3. Conversion Process
try {
    $info = getimagesize($file['tmp_name']);
    if (!$info) { json_error('Invalid image file.'); }

    $mime = $info['mime'];
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
        case 'image/gif': $srcImg = imagecreatefromgif($file['tmp_name']); break;
        case 'image/bmp': $srcImg = imagecreatefrombmp($file['tmp_name']); break;
        default: json_error('Unsupported image format: ' . $mime);
    }

    $baseName = pathinfo($file['name'], PATHINFO_FILENAME);
    $outputFileName = 'BulkTools_' . rand(1000000, 9999999) . '.' . $outputFormat;
    $outputPath = $outputDir . '/' . $outputFileName;

    // Handle alpha for JPG (no transparency support)
    if ($outputFormat === 'jpg') {
        $w = imagesx($srcImg);
        $h = imagesy($srcImg);
        $bg = imagecreatetruecolor($w, $h);
        $white = imagecolorallocate($bg, 255, 255, 255);
        imagefilledrectangle($bg, 0, 0, $w, $h, $white);
        imagecopy($bg, $srcImg, 0, 0, 0, 0, $w, $h);
        imagedestroy($srcImg);
        $srcImg = $bg;
    }

    // Handle alpha for PNG/WebP
    if ($outputFormat === 'png' || $outputFormat === 'webp') {
        imagealphablending($srcImg, true);
        imagesavealpha($srcImg, true);
    }

    switch ($outputFormat) {
        case 'jpg': imagejpeg($srcImg, $outputPath, $quality); break;
        case 'png':
            $pngQuality = 9 - floor($quality / 10);
            imagepng($srcImg, $outputPath, max(0, min(9, $pngQuality)));
            break;
        case 'webp': imagewebp($srcImg, $outputPath, $quality); break;
    }

    imagedestroy($srcImg);
    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/uploads/image/convert-image/' . $sessionHash . '/' . $outputFileName,
        'filename' => $outputFileName
    ]);
} catch (Exception $e) {
    json_error('Conversion failed: ' . $e->getMessage());
}
