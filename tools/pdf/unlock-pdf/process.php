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

$password = $_POST['password'] ?? '';

// 2. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/pdf/unlock-pdf/' . $sessionHash;
if (!is_dir($outputDir)) { mkdir($outputDir, 0777, true); }

// 3. Unlock Process
try {
    $tempFile = $outputDir . '/' . uniqid() . '_src.pdf';
    move_uploaded_file($file['tmp_name'], $tempFile);

    $outputFileName = 'unlocked_' . uniqid() . '.pdf';
    $outputPath = $outputDir . '/' . $outputFileName;

    if (!empty($password)) {
        $gsCmd .= " -sPDFPassword=" . escapeshellarg($password);
    }
    
    $gsCmd = escapeshellarg(GHOSTSCRIPT_PATH) . " " . $gsCmd . " -sOutputFile=" . escapeshellarg($outputPath) . " " . escapeshellarg($tempFile);
    
    shell_exec('"' . $gsCmd . '"');

    if (!file_exists($outputPath) || filesize($outputPath) < 100) {
        json_error('Unlocking failed. The password may be incorrect, or Ghostscript is not configured.');
    }

    @unlink($tempFile);
    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/uploads/pdf/unlock-pdf/' . $sessionHash . '/' . $outputFileName,
        'filename' => $outputFileName
    ]);
} catch (Exception $e) {
    json_error('Unlock error: ' . $e->getMessage());
}
