<?php
require_once '../../../includes/config.php';
require_once '../../../includes/functions.php';
json_safe_start();
require_once '../../../vendor/autoload.php';

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;

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
$passwordConfirm = $_POST['password_confirm'] ?? '';

if (strlen($password) < 4) { json_error('Password must be at least 4 characters.'); }
if ($password !== $passwordConfirm) { json_error('Passwords do not match.'); }

// 2. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/pdf/protect-pdf/' . $sessionHash;
if (!is_dir($outputDir)) { mkdir($outputDir, 0777, true); }

// 3. Protection Process using TCPDF + FPDI
try {
    $tempFile = $outputDir . '/' . uniqid() . '_src.pdf';
    move_uploaded_file($file['tmp_name'], $tempFile);

    $outputFileName = 'protected_' . uniqid() . '.pdf';
    $outputPath = $outputDir . '/' . $outputFileName;

    // Use TCPDF for encryption with FPDI for importing
    $pdf = new \TCPDF();
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    
    // Set password protection
    // SetProtection(array $permissions, string $user_pass, string $owner_pass, int $mode)
    $pdf->SetProtection(
        ['print', 'copy'],  // Allowed permissions
        $password,            // User password (to open)
        $password,            // Owner password
        0                     // 0 = RC4 40-bit, 1 = RC4 128-bit, 2 = AES 128-bit
    );

    // Import pages from source PDF using FPDI
    $fpdi = new Fpdi();
    $pageCount = $fpdi->setSourceFile($tempFile);
    
    // We need to use TCPDF directly since FPDI doesn't support encryption
    // Re-read pages and add to TCPDF
    for ($i = 1; $i <= $pageCount; $i++) {
        $tplIdx = $fpdi->importPage($i);
        $size = $fpdi->getTemplateSize($tplIdx);
        
        $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
        $fpdi->useTemplate($tplIdx);
    }

    // Since FPDI doesn't support encryption directly, use Ghostscript approach
    // First save without encryption
    $tempOutput = $outputDir . '/' . uniqid() . '_temp.pdf';
    $fpdi->Output('F', $tempOutput);

    // Then add encryption using Ghostscript
    $gsCmd = escapeshellarg(GHOSTSCRIPT_PATH) 
        . " -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dQUIET -dBATCH"
        . " -sOwnerPassword=" . escapeshellarg($password)
        . " -sUserPassword=" . escapeshellarg($password)
        . " -dEncryptionR=3 -dKeyLength=128"
        . " -dPermissions=-3904"  // Restrict permissions
        . " -sOutputFile=" . escapeshellarg($outputPath)
        . " " . escapeshellarg($tempOutput);
    
    shell_exec('"' . $gsCmd . '"');

    // Cleanup temp files
    @unlink($tempFile);
    @unlink($tempOutput);

    if (!file_exists($outputPath) || filesize($outputPath) < 100) {
        json_error('Protection failed. Ensure Ghostscript is correctly configured on the server.');
    }

    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/uploads/pdf/protect-pdf/' . $sessionHash . '/' . $outputFileName,
        'filename' => $outputFileName
    ]);
} catch (Exception $e) {
    json_error('Protection error: ' . $e->getMessage());
}
