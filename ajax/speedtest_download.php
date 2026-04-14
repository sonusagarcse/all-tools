<?php
/**
 * Speed Test Download Stream Helper
 * Streams random data to measure download speed
 */

// Disable error reporting for raw stream
error_reporting(0);

// Set headers to prevent caching & compression
header('Content-Type: application/octet-stream');
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename="speedtest_data.bin"');
header('Content-Transfer-Encoding: binary');
header('Connection: close');

// CRITICAL: Disable all types of buffering
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

if (function_exists('apache_setenv')) {
    apache_setenv('no-gzip', '1');
}
ini_set('zlib.output_compression', 'Off');

// Stream 100MB of data in 1MB chunks for high-speed accuracy
$chunk_size = 1024 * 1024; // 1MB
$total_chunks = 100;

// Pre-generate a 1MB chunk of random data to reuse (faster than generating on each loop)
$random_data = openssl_random_pseudo_bytes($chunk_size);

for ($i = 0; $i < $total_chunks; $i++) {
    echo $random_data;
    flush(); // Push the data to the client immediately
    
    // Check if client is still connected
    if (connection_aborted()) {
        break;
    }
}
exit;
