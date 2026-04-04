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
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if ($ext !== 'pdf') { json_error('Only PDF files are allowed.'); }

// 2. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/pdf/pdf-to-word/' . $sessionHash;
if (!is_dir($outputDir)) { mkdir($outputDir, 0777, true); }

// 3. Conversion Process
try {
    $tempFile = $outputDir . '/' . uniqid() . '.pdf';
    move_uploaded_file($file['tmp_name'], $tempFile);

    // LibreOffice command to convert PDF to DOCX
    $command = '"' . escapeshellarg(LIBREOFFICE_PATH) . " --headless --infilter=\"writer_pdf_import\" --convert-to docx --outdir " . escapeshellarg($outputDir) . " " . escapeshellarg($tempFile) . '"';
    shell_exec($command);

    // Find converted file
    $docxFileName = pathinfo($tempFile, PATHINFO_FILENAME) . '.docx';
    $docxPath = $outputDir . '/' . $docxFileName;

    if (!file_exists($docxPath)) {
        json_error('Conversion failed. Ensure LibreOffice is correctly configured on the server.');
    }

    // Clean up source
    @unlink($tempFile);
    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/uploads/pdf/pdf-to-word/' . $sessionHash . '/' . $docxFileName,
        'filename' => $docxFileName
    ]);
} catch (Exception $e) {
    json_error('Conversion error: ' . $e->getMessage());
}
