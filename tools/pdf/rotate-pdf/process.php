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

$angle = (int)($_POST['angle'] ?? 90);
if (!in_array($angle, [90, 180, 270])) { $angle = 90; }

// 2. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/pdf/rotate-pdf/' . $sessionHash;
if (!is_dir($outputDir)) { mkdir($outputDir, 0777, true); }

// 3. Rotation Process using Ghostscript (most reliable for rotation)
try {
    $tempFile = $outputDir . '/' . uniqid() . '_src.pdf';
    move_uploaded_file($file['tmp_name'], $tempFile);

    $outputFileName = 'rotated_' . uniqid() . '.pdf';
    $outputPath = $outputDir . '/' . $outputFileName;

    // Use Ghostscript for rotation
    $gsCmd = GHOSTSCRIPT_PATH 
        . " -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dQUIET -dBATCH"
        . " -c \"<</PageSize [595 842] /Orientation $angle>> setpagedevice\""
        . " -sOutputFile=" . escapeshellarg($outputPath)
        . " " . escapeshellarg($tempFile);

    // Alternative approach: Use FPDI with TCPDF for rotation
    $pdf = new \TCPDF();
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $fpdi = new Fpdi();
    $pageCount = $fpdi->setSourceFile($tempFile);

    for ($i = 1; $i <= $pageCount; $i++) {
        $tplIdx = $fpdi->importPage($i);
        $size = $fpdi->getTemplateSize($tplIdx);
        
        // Swap width/height for 90/270 rotation
        if ($angle == 90 || $angle == 270) {
            $newW = $size['height'];
            $newH = $size['width'];
        } else {
            $newW = $size['width'];
            $newH = $size['height'];
        }

        $fpdi->AddPage($newW > $newH ? 'L' : 'P', [$newW, $newH]);
        
        // Apply rotation using FPDI template with rotation transform
        if ($angle == 90) {
            $fpdi->useTemplate($tplIdx, $newW, 0, null, null, $angle);
        } elseif ($angle == 180) {
            $fpdi->useTemplate($tplIdx, $newW, $newH, null, null, $angle);
        } elseif ($angle == 270) {
            $fpdi->useTemplate($tplIdx, 0, $newH, null, null, $angle);
        }
    }

    $fpdi->Output('F', $outputPath);

    // If FPDI rotation fails, fallback to Ghostscript
    if (!file_exists($outputPath) || filesize($outputPath) < 100) {
        // Ghostscript fallback
        $gsCmd = escapeshellarg(GHOSTSCRIPT_PATH) 
            . " -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dQUIET -dBATCH -dAutoRotatePages=/None"
            . " -sOutputFile=" . escapeshellarg($outputPath)
            . " -c \"<< /Install { {$angle} rotate"
            . ($angle == 90 ? " 0 currentpagedevice /PageSize get 0 get neg translate" : "")
            . ($angle == 180 ? " currentpagedevice /PageSize get aload pop neg exch neg exch translate" : "")
            . ($angle == 270 ? " currentpagedevice /PageSize get 1 get neg 0 translate" : "")
            . " } bind >> setpagedevice\""
            . " -f " . escapeshellarg($tempFile);
        shell_exec('"' . $gsCmd . '"');
    }

    if (!file_exists($outputPath) || filesize($outputPath) < 100) {
        json_error('Rotation failed. Please try again.');
    }

    @unlink($tempFile);
    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/uploads/pdf/rotate-pdf/' . $sessionHash . '/' . $outputFileName,
        'filename' => $outputFileName
    ]);
} catch (Exception $e) {
    json_error('Rotation error: ' . $e->getMessage());
}
