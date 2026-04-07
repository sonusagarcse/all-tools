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
$cropX = max(0, (int)($_POST['crop_x'] ?? 0));
$cropY = max(0, (int)($_POST['crop_y'] ?? 0));
$cropW = max(1, (int)($_POST['crop_w'] ?? 500));
$cropH = max(1, (int)($_POST['crop_h'] ?? 500));

// 2. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/image/crop-image/' . $sessionHash;
if (!is_dir($outputDir)) { mkdir($outputDir, 0777, true); }

// 3. Cropping Process
try {
    $info = getimagesize($file['tmp_name']);
    if (!$info) { json_error('Invalid image file.'); }

    $mime = $info['mime'];
    $srcW = $info[0];
    $srcH = $info[1];

    // Validate crop bounds
    if ($cropX >= $srcW || $cropY >= $srcH) {
        json_error("Crop position is outside the image ($srcW x $srcH px).");
    }
    // Clamp crop size to image bounds
    $cropW = min($cropW, $srcW - $cropX);
    $cropH = min($cropH, $srcH - $cropY);

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

    $cropped = imagecrop($srcImg, ['x' => $cropX, 'y' => $cropY, 'width' => $cropW, 'height' => $cropH]);
    if ($cropped === false) { json_error('Cropping failed.'); }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $outputFileName = 'BulkTools_' . rand(1000000, 9999999) . '.' . $ext;
    $outputPath = $outputDir . '/' . $outputFileName;

    switch ($mime) {
        case 'image/jpeg': imagejpeg($cropped, $outputPath, 90); break;
        case 'image/png':
            imagesavealpha($cropped, true);
            imagepng($cropped, $outputPath);
            break;
        case 'image/webp': imagewebp($cropped, $outputPath, 90); break;
    }

    imagedestroy($srcImg);
    imagedestroy($cropped);
    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/uploads/image/crop-image/' . $sessionHash . '/' . $outputFileName,
        'filename' => $outputFileName
    ]);
} catch (Exception $e) {
    json_error('Cropping failed: ' . $e->getMessage());
}
