<?php
require_once '../../../includes/config.php';
require_once '../../../includes/functions.php';
json_safe_start();
require_once '../../../vendor/autoload.php';

use setasign\Fpdi\Fpdi;

// 1. Validate Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf($_POST['csrf_token'] ?? '')) {
    json_error('Invalid request or security token expired.');
}
if (!rate_limit_check()) { json_error('Rate limit exceeded.'); }
if (empty($_FILES['file']['name'])) { json_error('No file uploaded.'); }

$file = $_FILES['file'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if ($ext !== 'pdf') { json_error('Only PDF files are allowed.'); }

$watermarkText = trim($_POST['watermark_text'] ?? 'CONFIDENTIAL');
if (empty($watermarkText)) { json_error('Please enter watermark text.'); }

$fontSize = (int)($_POST['font_size'] ?? 50);
$opacity = (int)($_POST['opacity'] ?? 25);

// 2. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/pdf/watermark-pdf/' . $sessionHash;
if (!is_dir($outputDir)) { mkdir($outputDir, 0777, true); }

// 3. Watermark Process using TCPDF + FPDI
try {
    // First create watermark overlay PDF using TCPDF
    $watermarkPdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $watermarkPdf->setPrintHeader(false);
    $watermarkPdf->setPrintFooter(false);
    $watermarkPdf->AddPage();
    
    // Set transparency
    $watermarkPdf->SetAlpha($opacity / 100);
    $watermarkPdf->SetFont('helvetica', 'B', $fontSize);
    $watermarkPdf->SetTextColor(128, 128, 128);
    
    // Rotate text diagonally
    $watermarkPdf->StartTransform();
    $watermarkPdf->Rotate(45, 105, 148);
    $watermarkPdf->Text(30, 148, $watermarkText);
    $watermarkPdf->StopTransform();
    
    $watermarkPdf->SetAlpha(1);

    $watermarkTempFile = $outputDir . '/' . uniqid() . '_watermark.pdf';
    $watermarkPdf->Output($watermarkTempFile, 'F');

    // Now use FPDI to merge watermark with each page
    $fpdi = new Fpdi();
    $pageCount = $fpdi->setSourceFile($file['tmp_name']);

    // Also set watermark as source
    for ($i = 1; $i <= $pageCount; $i++) {
        $tplIdx = $fpdi->importPage($i);
        $size = $fpdi->getTemplateSize($tplIdx);
        
        $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
        $fpdi->useTemplate($tplIdx);
        
        // Overlay watermark
        $fpdi->setSourceFile($watermarkTempFile);
        $wmTpl = $fpdi->importPage(1);
        $fpdi->useTemplate($wmTpl, 0, 0, $size['width'], $size['height']);
        
        // Reset source file for next page
        if ($i < $pageCount) {
            $fpdi->setSourceFile($file['tmp_name']);
        }
    }

    $outputFileName = 'watermarked_' . uniqid() . '.pdf';
    $outputPath = $outputDir . '/' . $outputFileName;
    $fpdi->Output('F', $outputPath);

    @unlink($watermarkTempFile);
    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/uploads/pdf/watermark-pdf/' . $sessionHash . '/' . $outputFileName,
        'filename' => $outputFileName
    ]);
} catch (Exception $e) {
    json_error('Watermark error: ' . $e->getMessage());
}
