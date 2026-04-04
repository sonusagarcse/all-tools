<?php
require_once '../../../includes/config.php';
require_once '../../../includes/functions.php';
json_safe_start();

// Use FPDF library (Assumes composer install was run)
require_once '../../../vendor/autoload.php';

use Fpdf\Fpdf;

// 1. Validate Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf($_POST['csrf_token'] ?? '')) {
    json_error('Invalid request or security token expired.');
}

if (!rate_limit_check()) {
    json_error('Rate limit exceeded. Please try again in an hour.');
}

// 2. Validate Files
if (empty($_FILES['files']['name'][0])) {
    json_error('No files uploaded.');
}

$files = $_FILES['files'];
$totalSize = array_sum($files['size']);

if ($totalSize > MAX_FILE_SIZE) {
    json_error('Total file size exceeds 50MB limit.');
}

// 3. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/pdf/jpg-to-pdf/' . $sessionHash;
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

// 4. Initialize Process
try {
    $orientation = $_POST['orientation'] === 'L' ? 'L' : 'P';
    $pageSize = $_POST['page_size'] ?? 'A4';
    
    $pdf = new Fpdf($orientation, 'mm', $pageSize);
    
    foreach ($files['tmp_name'] as $index => $tmpName) {
        if ($files['error'][$index] !== UPLOAD_ERR_OK) continue;
        
        $fileName = $files['name'][$index];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        // Map common extensions to FPDF types
        $typeMap = [
            'jpg' => 'JPG',
            'jpeg' => 'JPG',
            'png' => 'PNG'
        ];

        if (!isset($typeMap[$ext])) {
            json_error('Only JPG, JPEG, and PNG files are allowed: ' . $fileName);
        }

        // Add page and image
        $pdf->AddPage();
        
        // Get image dimensions to fit page
        list($imgWidth, $imgHeight) = getimagesize($tmpName);
        
        // Calculate dimensions to fit A4/Letter
        $pageWidth = $pdf->GetPageWidth() - 20; // 10mm margin each side
        $pageHeight = $pdf->GetPageHeight() - 20;
        
        $ratio = min($pageWidth / $imgWidth, $pageHeight / $imgHeight);
        $newWidth = $imgWidth * $ratio;
        $newHeight = $imgHeight * $ratio;
        
        // Center image
        $x = ($pdf->GetPageWidth() - $newWidth) / 2;
        $y = ($pdf->GetPageHeight() - $newHeight) / 2;
        
        // Use $typeMap[$ext] to explicitly tell FPDF the file type
        $pdf->Image($tmpName, $x, $y, $newWidth, $newHeight, $typeMap[$ext]);
    }

    $outputFileName = 'converted_' . uniqid() . '.pdf';
    $outputPath = $outputDir . '/' . $outputFileName;
    $pdf->Output('F', $outputPath);
    
    mark_upload_attempt();

    // 5. Build Response
    $downloadUrl = SITE_URL . '/uploads/pdf/jpg-to-pdf/' . $sessionHash . '/' . $outputFileName;
    
    json_response([
        'download_url' => $downloadUrl,
        'filename' => $outputFileName
    ]);

} catch (Exception $e) {
    json_error('Error during conversion: ' . $e->getMessage());
}
