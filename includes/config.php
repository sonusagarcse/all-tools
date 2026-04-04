<?php
/**
 * ToolNest Config
 */

// Site Information
define('SITE_NAME', 'ToolNest');
define('SITE_TAGLINE', 'Every tool you need, one place.');
define('SITE_URL', 'http://localhost/tools'); // Change to your domain in production

// Include Autoloader & Fix Legacy Class Mapping
if (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    if (!class_exists('FPDF') && class_exists('\Fpdf\Fpdf')) {
        class_alias('\Fpdf\Fpdf', 'FPDF');
    }
}

// Paths
define('BASE_DIR', dirname(__DIR__));
define('UPLOAD_DIR', BASE_DIR . '/uploads');
define('LOG_DIR', BASE_DIR . '/logs');

// External Binary Paths (Configure based on your server)
define('GHOSTSCRIPT_PATH', 'C:\Program Files\gs\gs10.03.1\bin\gswin64c.exe'); // Path to Ghostscript
define('LIBREOFFICE_PATH', 'C:\Program Files\LibreOffice\program\soffice.exe');
define('YT_DLP_PATH', BASE_DIR . '/bin/yt-dlp.exe');
define('TABULA_JAR_PATH', BASE_DIR . '/bin/tabula-java.jar');

// Security Configurations
define('MAX_FILE_SIZE', 50 * 1024 * 1024); // 50MB
define('ALLOWED_EXTENSIONS', ['pdf', 'jpg', 'jpeg', 'png', 'webp', 'doc', 'docx', 'xls', 'xlsx']);

// Session & Rate Limiting
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
define('RATE_LIMIT_COUNT', 100); // Max uploads per window
define('RATE_LIMIT_WINDOW', 3600); // 1 hour window

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create upload directory if it doesn't exist
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}

// Global Category Map
$TOOL_CATEGORIES = [
    'pdf' => [
        'name' => 'PDF Tools',
        'icon' => 'file-pdf',
        'tools' => [
            'pdf-to-jpg' => ['name' => 'PDF to JPG', 'desc' => 'Convert PDF pages to JPG images.'],
            'jpg-to-pdf' => ['name' => 'JPG to PDF', 'desc' => 'Convert JPG images to PDF document.'],
            'compress-pdf' => ['name' => 'Compress PDF', 'desc' => 'Reduce PDF file size while keeping quality.'],
            'merge-pdf' => ['name' => 'Merge PDF', 'desc' => 'Combine multiple PDFs into one.'],
            'split-pdf' => ['name' => 'Split PDF', 'desc' => 'Separate pages from a PDF file.'],
            'pdf-to-word' => ['name' => 'PDF to Word', 'desc' => 'Convert PDF to editable Word document.'],
            'word-to-pdf' => ['name' => 'Word to PDF', 'desc' => 'Convert Word documents to PDF.'],
            'pdf-to-png' => ['name' => 'PDF to PNG', 'desc' => 'Convert PDF pages to PNG images.'],
            'rotate-pdf' => ['name' => 'Rotate PDF', 'desc' => 'Rotate PDF pages easily.'],
            'unlock-pdf' => ['name' => 'Unlock PDF', 'desc' => 'Remove password and glass from PDF.'],
            'protect-pdf' => ['name' => 'Protect PDF', 'desc' => 'Add password protection to your PDF.'],
            'pdf-to-excel' => ['name' => 'PDF to Excel', 'desc' => 'Convert PDF data to Excel tables.'],
            'watermark-pdf' => ['name' => 'Watermark PDF', 'desc' => 'Add text or image watermark to PDF.'],
        ]
    ],
    'downloader' => [
        'name' => 'Video Downloader',
        'icon' => 'video',
        'tools' => [
            'youtube-downloader' => ['name' => 'YouTube Downloader', 'desc' => 'Download YouTube videos and MP3.'],
            'instagram-downloader' => ['name' => 'Instagram Downloader', 'desc' => 'Download Instagram videos and reels.'],
            'facebook-downloader' => ['name' => 'Facebook Downloader', 'desc' => 'Download Facebook videos easily.'],
            'twitter-downloader' => ['name' => 'Twitter Downloader', 'desc' => 'Download Twitter/X videos.'],
            'tiktok-downloader' => ['name' => 'TikTok Downloader', 'desc' => 'Download TikTok videos without watermark.'],
        ]
    ],
    'image' => [
        'name' => 'Image Tools',
        'icon' => 'image',
        'tools' => [
            'compress-image' => ['name' => 'Compress Image', 'desc' => 'Reduce image size without quality loss.'],
            'resize-image' => ['name' => 'Resize Image', 'desc' => 'Resize images to custom dimensions.'],
            'convert-image' => ['name' => 'Convert Image', 'desc' => 'Convert images between JPG, PNG and WebP.'],
            'crop-image' => ['name' => 'Crop Image', 'desc' => 'Crop images to focus on what matters.'],
        ]
    ],
    'text' => [
        'name' => 'Text Tools',
        'icon' => 'font',
        'tools' => [
            'word-counter' => ['name' => 'Word Counter', 'desc' => 'Count words, characters and sentences.'],
            'case-converter' => ['name' => 'Case Converter', 'desc' => 'Convert text to UPPER, lower, Sentence case.'],
            'lorem-ipsum' => ['name' => 'Lorem Ipsum', 'desc' => 'Generate placeholder text for designs.'],
        ]
    ]
];
