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
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if (!in_array($ext, ['doc', 'docx'])) {
    json_error('Only Word documents (.doc, .docx) are allowed.');
}

// 2. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/pdf/word-to-pdf/' . $sessionHash;
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

// 3. Conversion Process
try {
    $tempFile = $outputDir . '/' . uniqid() . '.' . $ext;
    move_uploaded_file($file['tmp_name'], $tempFile);

    // LibreOffice command
    // soffice --headless --convert-to pdf --outdir [outputDir] [inputFile]
    $command = '"' . escapeshellarg(LIBREOFFICE_PATH) . " --headless --convert-to pdf --outdir " . escapeshellarg($outputDir) . " " . escapeshellarg($tempFile) . '"';
    
    $output = shell_exec($command);
    
    // Find converted file
    $pdfFileName = pathinfo($tempFile, PATHINFO_FILENAME) . '.pdf';
    $pdfPath = $outputDir . '/' . $pdfFileName;

    if (!file_exists($pdfPath)) {
        json_error('Conversion failed. Ensure LibreOffice is correctly configured on the server.');
    }

    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/uploads/pdf/word-to-pdf/' . $sessionHash . '/' . $pdfFileName,
        'filename' => $pdfFileName
    ]);

} catch (Exception $e) {
    json_error('Conversion error: ' . $e->getMessage());
}
