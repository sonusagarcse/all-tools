<?php
require_once '../../../includes/config.php';
require_once '../../../includes/functions.php';
json_safe_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf($_POST['csrf_token'] ?? '')) {
    json_error('Invalid request or security token expired.');
}

if (!rate_limit_check()) json_error('Rate limit exceeded.');
if (empty($_FILES['file']['name'])) json_error('No file uploaded.');

$file = $_FILES['file'];
$rotate = (int)($_POST['rotate'] ?? 0);
$flip = $_POST['flip'] ?? 'none';

$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/image/flip-rotate/' . $sessionHash;
if (!is_dir($outputDir)) mkdir($outputDir, 0777, true);

try {
    $info = getimagesize($file['tmp_name']);
    if (!$info) json_error('Invalid image file.');

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
        default: json_error('Unsupported image format.');
    }

    // 1. Rotate (Clockwise in UI, but imagerotate is CCW, so 360-X)
    if ($rotate !== 0) {
        $angle = 360 - $rotate;
        $srcImg = imagerotate($srcImg, $angle, 0);
        imagesavealpha($srcImg, true);
    }

    // 2. Flip
    if ($flip === 'horizontal') {
        imageflip($srcImg, IMG_FLIP_HORIZONTAL);
    } elseif ($flip === 'vertical') {
        imageflip($srcImg, IMG_FLIP_VERTICAL);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $outputFileName = 'transformed_' . uniqid() . '.' . $ext;
    $outputPath = $outputDir . '/' . $outputFileName;

    switch ($mime) {
        case 'image/jpeg': imagejpeg($srcImg, $outputPath, 90); break;
        case 'image/png': imagepng($srcImg, $outputPath, 6); break;
        case 'image/webp': imagewebp($srcImg, $outputPath, 85); break;
    }

    imagedestroy($srcImg);
    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/uploads/image/flip-rotate/' . $sessionHash . '/' . $outputFileName
    ]);

} catch (Exception $e) {
    json_error('Processing failed: ' . $e->getMessage());
}
