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

if ($ext !== 'pdf') {
    json_error('Only PDF files are allowed.');
}

// 2. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/pdf/compress-pdf/' . $sessionHash;
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

// 3. Compression Levels (Ghostscript settings)
$levels = [
    'screen'  => '/screen',   // 72 dpi
    'ebook'   => '/ebook',    // 150 dpi
    'printer' => '/printer',  // 300 dpi
    'prepress'=> '/prepress', // 300 dpi (color preserving)
];

$level = $_POST['level'] ?? 'screen';
$gsSettings = $levels[$level] ?? '/screen';

// 4. Compression Process
try {
    $tempFile = $outputDir . '/' . uniqid() . '_src.pdf';
    move_uploaded_file($file['tmp_name'], $tempFile);

    $outputFileName = 'compressed_' . uniqid() . '.pdf';
    $outputPath = $outputDir . '/' . $outputFileName;

    // Ghostscript command
    // gswin64c.exe -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dNOPAUSE -dQUIET -dBATCH -sOutputFile=[output] [input]
    $gsCmd = escapeshellarg(GHOSTSCRIPT_PATH) . " -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=" . $gsSettings . " -dNOPAUSE -dQUIET -dBATCH -sOutputFile=" . escapeshellarg($outputPath) . " " . escapeshellarg($tempFile);
    
    shell_exec('"' . $gsCmd . '"');

    if (!file_exists($outputPath)) {
        json_error('Compression failed. Ensure Ghostscript is correctly configured on the server.');
    }

    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/uploads/pdf/compress-pdf/' . $sessionHash . '/' . $outputFileName,
        'filename' => $outputFileName
    ]);

} catch (Exception $e) {
    json_error('Compression error: ' . $e->getMessage());
}
