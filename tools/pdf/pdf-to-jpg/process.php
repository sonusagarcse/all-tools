<?php
require_once '../../../includes/config.php';
require_once '../../../includes/functions.php';
json_safe_start();

// Use libraries (Assumes composer install was run)
require_once '../../../vendor/autoload.php';

use Spatie\PdfToImage\Pdf;

// 1. Validate Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf($_POST['csrf_token'] ?? '')) {
    json_error('Invalid request or security token expired.');
}

if (!rate_limit_check()) {
    json_error('Rate limit exceeded. Please try again in an hour.');
}

// 2. Validate File
if (empty($_FILES['file']['name'])) {
    json_error('No file uploaded.');
}

$file = $_FILES['file'];
if ($file['size'] > MAX_FILE_SIZE) {
    json_error('File size exceeds 50MB limit.');
}

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if ($ext !== 'pdf') {
    json_error('Only PDF files are allowed.');
}

// 3. Setup Directories
$sessionHash = get_session_hash();
$jobId = uniqid();
$outputDir = UPLOAD_DIR . '/pdf/pdf-to-jpg/' . $sessionHash . '/' . $jobId;
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

// 4. Conversion Process using Ghostscript (more efficient and doesn't require Imagick)
try {
    $tempFile = $outputDir . '/source.pdf';
    move_uploaded_file($file['tmp_name'], $tempFile);

    $format = $_POST['format'] ?? 'jpg';
    $quality = (int)($_POST['quality'] ?? 90);
    $device = ($format === 'png') ? 'png16m' : 'jpeg';
    
    // Ghostscript command to convert all pages to images
    // -r150 is resolution, -dJPEGQ=X sets quality for jpeg
    $gsCmd = escapeshellarg(GHOSTSCRIPT_PATH) 
        . " -dNOPAUSE -dBATCH -sDEVICE=$device -r150 "
        . ($format === 'jpg' ? "-dJPEGQ=$quality " : "")
        . "-sOutputFile=" . escapeshellarg($outputDir . '/page-%d.' . $format)
        . " " . escapeshellarg($tempFile);

    exec('"' . $gsCmd . '" 2>&1', $output, $returnVar);

    if ($returnVar !== 0) {
        throw new Exception("Ghostscript conversion failed: " . implode("\n", $output));
    }

    // 5. ZIP the results
    $extractedFiles = glob($outputDir . '/page-*.' . $format);
    if (empty($extractedFiles)) {
        throw new Exception("No images were generated.");
    }

    $zipFileName = 'pdf_images_' . $jobId . '.zip';
    $zipPath = dirname($outputDir) . '/' . $zipFileName;
    
    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
        foreach ($extractedFiles as $imgFile) {
            $zip->addFile($imgFile, basename($imgFile));
        }
        $zip->close();
    } else {
        throw new Exception('Failed to create ZIP file.');
    }

    // Cleanup individual images
    foreach ($extractedFiles as $imgFile) { @unlink($imgFile); }
    @unlink($tempFile);

    mark_upload_attempt();

    // 6. Build Response
    $downloadUrl = SITE_URL . '/uploads/pdf/pdf-to-jpg/' . $sessionHash . '/' . $zipFileName;
    
    json_response([
        'download_url' => $downloadUrl,
        'filename' => $zipFileName
    ]);

} catch (Exception $e) {
    json_error('Error during conversion: ' . $e->getMessage());
}
