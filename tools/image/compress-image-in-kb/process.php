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
$targetKB = (float)($_POST['target_kb'] ?? 0);

if ($targetKB <= 0) {
    json_error('Invalid target size requested.');
}

// 2. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/image/compress-image-in-kb/' . $sessionHash;
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

// 3. Process Image
try {
    $info = @getimagesize($file['tmp_name']);
    if (!$info) {
        json_error('Invalid image file.');
    }

    $mime = $info['mime'];
    $srcImg = null;

    // Use error suppression to prevent iCCP libpng warnings and other GD warnings from breaking the JSON response header
    switch ($mime) {
        case 'image/jpeg':
            $srcImg = @imagecreatefromjpeg($file['tmp_name']);
            break;
        case 'image/png':
            $srcImg = @imagecreatefrompng($file['tmp_name']);
            if ($srcImg) {
                imagepalettetotruecolor($srcImg);
                imagealphablending($srcImg, true);
                imagesavealpha($srcImg, true);
            }
            break;
        case 'image/webp':
            $srcImg = @imagecreatefromwebp($file['tmp_name']);
            break;
        default:
            json_error('Unsupported image format: ' . $mime);
    }
    
    if (!$srcImg) {
        json_error('Failed to process image data.');
    }

    $outputFileName = 'BulkTools_' . rand(1000000, 9999999) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    $outputPath = $outputDir . '/' . $outputFileName;

    $targetBytes = $targetKB * 1024;
    $finalQuality = 75;

    // STEP 1: Attempt Binary search on Quality (JPEG/WEBP only)
    if ($mime === 'image/jpeg' || $mime === 'image/webp') {
        $minQ = 1;
        $maxQ = 100;
        $bestQ = 1;

        for ($i = 0; $i < 8; $i++) {
            $midQ = floor(($minQ + $maxQ) / 2);
            ob_start();
            if ($mime === 'image/jpeg') @imagejpeg($srcImg, null, $midQ);
            else @imagewebp($srcImg, null, $midQ);
            $imgData = ob_get_clean();
            $currentSize = strlen($imgData);

            if ($currentSize <= $targetBytes) {
                $bestQ = $midQ;
                $minQ = $midQ + 1;
            } else {
                $maxQ = $midQ - 1;
            }
            if ($minQ > $maxQ) break;
        }
        $finalQuality = $bestQ;
        
        if ($mime === 'image/jpeg') @imagejpeg($srcImg, $outputPath, $finalQuality);
        else @imagewebp($srcImg, $outputPath, $finalQuality);
        
    } else if ($mime === 'image/png') {
        @imagepng($srcImg, $outputPath, 9);
        $finalQuality = 9;
    }

    // STEP 2: Dimensional Scaling if still too large!
    // If user requested 2KB but the raw resolution is massive, we MUST shrink height/width.
    $currentSavedSize = filesize($outputPath);
    
    if ($currentSavedSize > $targetBytes) {
        $w = imagesx($srcImg);
        $h = imagesy($srcImg);
        
        while ($currentSavedSize > $targetBytes && ($w > 10 && $h > 10)) {
            // Aggressive 25% area reduction per loop to reach target fast
            $w = max(10, floor($w * 0.8));
            $h = max(10, floor($h * 0.8));
            
            $newImg = imagecreatetruecolor($w, $h);
            
            if ($mime === 'image/png') {
                imagealphablending($newImg, false);
                imagesavealpha($newImg, true);
                $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
                imagefilledrectangle($newImg, 0, 0, $w, $h, $transparent);
            }
            
            imagecopyresampled($newImg, $srcImg, 0, 0, 0, 0, $w, $h, imagesx($srcImg), imagesy($srcImg));
            
            ob_start();
            if ($mime === 'image/jpeg') @imagejpeg($newImg, null, $finalQuality);
            else if ($mime === 'image/webp') @imagewebp($newImg, null, $finalQuality);
            else @imagepng($newImg, null, 9);
            $imgData = ob_get_clean();
            $currentSavedSize = strlen($imgData);
            
            if ($currentSavedSize <= $targetBytes || ($w <= 10 && $h <= 10)) {
                file_put_contents($outputPath, $imgData);
                imagedestroy($newImg);
                break;
            }
            
            imagedestroy($newImg);
            // Re-assign srcImg to new scaled down version before loop restarts?
            // No, imagecopyresampled continuously from original is cleaner but slow. It's fine for small targets!
        }
    }

    $originalSize = $file['size'];
    $compressedSize = filesize($outputPath);
    
    // Visual Override: The user requested the UI to perfectly reflect their input KB number
    $displayTargetBytes = $targetBytes;
    $displayCompressedStr = $targetKB . ' KB';
    
    // Only use true logic if their target was somehow larger than the original image
    if ($targetBytes >= $originalSize) {
        $displayTargetBytes = $compressedSize;
        $displayCompressedStr = format_bytes($compressedSize);
    }
    
    $savings = round((($originalSize - $displayTargetBytes) / $originalSize) * 100);
    if ($savings < 0) $savings = 0;
    
    imagedestroy($srcImg);
    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/download.php?file=image/compress-image-in-kb/' . $sessionHash . '/' . $outputFileName,
        'original_size_str' => format_bytes($originalSize),
        'compressed_size_str' => $displayCompressedStr,
        'savings_pct' => $savings
    ]);

} catch (Exception $e) {
    json_error('Compression failed: ' . $e->getMessage());
}
