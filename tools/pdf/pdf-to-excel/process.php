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

$mode = ($_POST['mode'] ?? 'lattice') === 'stream' ? 'stream' : 'lattice';

// 2. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/pdf/pdf-to-excel/' . $sessionHash;
if (!is_dir($outputDir)) { mkdir($outputDir, 0777, true); }

// 3. Extraction Process
try {
    $tempFile = $outputDir . '/' . uniqid() . '.pdf';
    move_uploaded_file($file['tmp_name'], $tempFile);

    $outputFileName = 'tables_' . uniqid() . '.csv';
    $outputPath = $outputDir . '/' . $outputFileName;

    // Check if tabula-java.jar exists
    if (!file_exists(TABULA_JAR_PATH)) {
        // Fallback: Use LibreOffice to convert PDF to XLSX if tabula isn't available
        $outputFileName = 'tables_' . uniqid() . '.xlsx';
        $outputPath = $outputDir . '/' . $outputFileName;
        
        $command = '"' . escapeshellarg(LIBREOFFICE_PATH) . " --headless --infilter=\"calc_pdf_import\" --convert-to xlsx --outdir " . escapeshellarg($outputDir) . " " . escapeshellarg($tempFile) . '"';
        shell_exec($command);
        
        // Find converted file 
        $xlsxFile = pathinfo($tempFile, PATHINFO_FILENAME) . '.xlsx';
        $xlsxPath = $outputDir . '/' . $xlsxFile;
        
        if (file_exists($xlsxPath)) {
            $outputFileName = $xlsxFile;
        } else {
            json_error('Table extraction failed. Neither Tabula nor LibreOffice could process this file.');
        }
    } else {
        // Use Tabula Java
        $tabulaFlag = $mode === 'stream' ? '-t' : '-l';
        $command = "java -jar " . escapeshellarg(TABULA_JAR_PATH) 
            . " " . $tabulaFlag
            . " -p all"
            . " -o " . escapeshellarg($outputPath)
            . " " . escapeshellarg($tempFile);
        
        shell_exec($command);

        if (!file_exists($outputPath) || filesize($outputPath) < 10) {
            json_error('No tables found in the PDF, or Java is not installed. Please ensure Java runtime is available.');
        }
    }

    @unlink($tempFile);
    mark_upload_attempt();

    json_response([
        'download_url' => SITE_URL . '/uploads/pdf/pdf-to-excel/' . $sessionHash . '/' . $outputFileName,
        'filename' => $outputFileName
    ]);
} catch (Exception $e) {
    json_error('Extraction error: ' . $e->getMessage());
}
