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

// 2. Parse page ranges
$pagesInput = $_POST['pages'] ?? '1';
$requestedPages = [];
$parts = explode(',', $pagesInput);
foreach ($parts as $part) {
    $part = trim($part);
    if (strpos($part, '-') !== false) {
        list($start, $end) = explode('-', $part, 2);
        $start = (int)trim($start);
        $end = (int)trim($end);
        if ($start > 0 && $end >= $start) {
            for ($i = $start; $i <= $end; $i++) {
                $requestedPages[] = $i;
            }
        }
    } else {
        $p = (int)$part;
        if ($p > 0) $requestedPages[] = $p;
    }
}
$requestedPages = array_unique($requestedPages);
sort($requestedPages);

if (empty($requestedPages)) { json_error('Invalid page range. Use format like: 1-3, 5, 7-10'); }

// 3. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/pdf/split-pdf/' . $sessionHash;
if (!is_dir($outputDir)) { mkdir($outputDir, 0777, true); }

// 4. Split Process
try {
    $pdf = new Fpdi();
    $totalPages = $pdf->setSourceFile($file['tmp_name']);

    // Validate pages
    foreach ($requestedPages as $p) {
        if ($p > $totalPages) {
            json_error("Page $p doesn't exist. PDF has only $totalPages pages.");
        }
    }

    foreach ($requestedPages as $pageNo) {
        $tplIdx = $pdf->importPage($pageNo);
        $size = $pdf->getTemplateSize($tplIdx);
        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
        $pdf->useTemplate($tplIdx);
    }

    $outputFileName = 'split_' . uniqid() . '.pdf';
    $outputPath = $outputDir . '/' . $outputFileName;
    $pdf->Output('F', $outputPath);

    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/uploads/pdf/split-pdf/' . $sessionHash . '/' . $outputFileName,
        'filename' => $outputFileName
    ]);
} catch (Exception $e) {
    json_error('Splitting failed: ' . $e->getMessage());
}
