<?php
require_once '../../../includes/config.php';
require_once '../../../includes/functions.php';
json_safe_start();
require_once '../../../vendor/autoload.php';

use Spatie\PdfToImage\Pdf;

// 1. Validate Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf($_POST['csrf_token'] ?? '')) {
    json_error('Invalid request or security token expired.');
}
if (!rate_limit_check()) { json_error('Rate limit exceeded.'); }
if (empty($_FILES['file']['name'])) { json_error('No file uploaded.'); }

$file = $_FILES['file'];
if ($file['size'] > MAX_FILE_SIZE) { json_error('File size exceeds 50MB limit.'); }

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if ($ext !== 'pdf') { json_error('Only PDF files are allowed.'); }

// 2. Setup Directories
$sessionHash = get_session_hash();
$jobId = uniqid();
$outputDir = UPLOAD_DIR . '/pdf/pdf-to-png/' . $sessionHash . '/' . $jobId;
if (!is_dir($outputDir)) { mkdir($outputDir, 0777, true); }

// 3. Conversion Process
try {
    $tempFile = $outputDir . '/source.pdf';
    move_uploaded_file($file['tmp_name'], $tempFile);

    // Ghostscript command to convert all pages to PNG
    // png16m is 24-bit RGB, pngalpha is if transparency is needed
    $gsCmd = escapeshellarg(GHOSTSCRIPT_PATH) 
        . " -dNOPAUSE -dBATCH -sDEVICE=png16m -r150 "
        . "-sOutputFile=" . escapeshellarg($outputDir . '/page-%d.png')
        . " " . escapeshellarg($tempFile);

    exec('"' . $gsCmd . '" 2>&1', $output, $returnVar);

    if ($returnVar !== 0) {
        throw new Exception("Ghostscript conversion failed: " . implode("\n", $output));
    }

    // 4. ZIP the results
    $extractedFiles = glob($outputDir . '/page-*.png');
    if (empty($extractedFiles)) {
        throw new Exception("No images were generated.");
    }

    $zipFileName = 'pdf_png_' . $jobId . '.zip';
    $zipPath = dirname($outputDir) . '/' . $zipFileName;
    
    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
        foreach ($extractedFiles as $f) {
            $zip->addFile($f, basename($f));
        }
        $zip->close();
    } else {
        throw new Exception('Failed to create ZIP file.');
    }

    // Cleanup
    foreach ($extractedFiles as $f) { @unlink($f); }
    @unlink($tempFile);

    mark_upload_attempt();

    $downloadUrl = SITE_URL . '/uploads/pdf/pdf-to-png/' . $sessionHash . '/' . $zipFileName;
    
    json_response([
        'download_url' => $downloadUrl,
        'filename' => $zipFileName
    ]);
} catch (Exception $e) {
    json_error('Error during conversion: ' . $e->getMessage());
}
