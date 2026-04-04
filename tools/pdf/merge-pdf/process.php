<?php
require_once '../../../includes/config.php';
require_once '../../../includes/functions.php';
json_safe_start();

// Use libraries (Assumes composer install was run)
require_once '../../../vendor/autoload.php';

use setasign\Fpdi\Fpdi;

// 1. Validate Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf($_POST['csrf_token'] ?? '')) {
    json_error('Invalid request or security token expired.');
}

if (!rate_limit_check()) {
    json_error('Rate limit exceeded.');
}

if (empty($_FILES['files']['name'][0])) {
    json_error('No files uploaded.');
}

$files = $_FILES['files'];

// 2. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/pdf/merge-pdf/' . $sessionHash;
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

// 3. Merging Process
try {
    $pdf = new Fpdi();
    
    foreach ($files['tmp_name'] as $index => $tmpName) {
        if ($files['error'][$index] !== UPLOAD_ERR_OK) continue;
        
        $fileName = $files['name'][$index];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        if ($ext !== 'pdf') continue;

        $pageCount = $pdf->setSourceFile($tmpName);
        for ($i = 1; $i <= $pageCount; $i++) {
            $tplIdx = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($tplIdx);
            
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($tplIdx);
        }
    }

    $outputFileName = 'merged_' . uniqid() . '.pdf';
    $outputPath = $outputDir . '/' . $outputFileName;
    $pdf->Output('F', $outputPath);
    
    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/uploads/pdf/merge-pdf/' . $sessionHash . '/' . $outputFileName,
        'filename' => $outputFileName
    ]);

} catch (Exception $e) {
    json_error('Merging failed: ' . $e->getMessage());
}
