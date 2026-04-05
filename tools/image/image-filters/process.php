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
$filters = $_POST['filters'] ?? [];
$intensity = (int)($_POST['intensity'] ?? 50);

$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/image/image-filters/' . $sessionHash;
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

    // Apply Multiple Filters in sequence
    foreach ($filters as $filterType) {
        switch ($filterType) {
            case 'grayscale': 
                if ($intensity >= 50) {
                    imagefilter($srcImg, IMG_FILTER_GRAYSCALE);
                } else {
                    imagefilter($srcImg, IMG_FILTER_CONTRAST, -($intensity/2));
                }
                break;
            case 'sepia':     
                imagefilter($srcImg, IMG_FILTER_GRAYSCALE);
                $r = (int)(90 * ($intensity / 50));
                $g = (int)(60 * ($intensity / 50));
                $b = (int)(40 * ($intensity / 50));
                imagefilter($srcImg, IMG_FILTER_COLORIZE, $r, $g, $b);
                break;
            case 'invert':    
                if ($intensity > 50) imagefilter($srcImg, IMG_FILTER_NEGATE);
                break;
            case 'blur':
                $passes = (int)($intensity / 20); 
                for ($i = 0; $i < $passes; $i++) {
                    imagefilter($srcImg, IMG_FILTER_GAUSSIAN_BLUR);
                }
                break;
            case 'emboss':    
                imagefilter($srcImg, IMG_FILTER_EMBOSS);
                if ($intensity > 50) imagefilter($srcImg, IMG_FILTER_CONTRAST, ($intensity - 50));
                break;
            case 'pixelate':  
                $blockSize = (int)(2 + ($intensity / 10)); 
                imagefilter($srcImg, IMG_FILTER_PIXELATE, $blockSize, true);
                break;
        }
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $outputFileName = 'filtered_' . uniqid() . '.' . $ext;
    $outputPath = $outputDir . '/' . $outputFileName;

    switch ($mime) {
        case 'image/jpeg': imagejpeg($srcImg, $outputPath, 90); break;
        case 'image/png': imagepng($srcImg, $outputPath, 6); break;
        case 'image/webp': imagewebp($srcImg, $outputPath, 85); break;
    }

    imagedestroy($srcImg);
    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/uploads/image/image-filters/' . $sessionHash . '/' . $outputFileName
    ]);

} catch (Exception $e) {
    json_error('Filtering failed: ' . $e->getMessage());
}
