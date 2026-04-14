<?php
/**
 * Speed Test Upload Helper
 * Receives data to measure upload speed
 */

// Disable all error reporting for maximum efficiency
error_reporting(0);

// Basic CORS if needed (though on same domain here)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

// We just need to receive the data and confirm receipt.
// PHP automatically handles the input stream if we read from php://input
// or if it's a standard POST body.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the stream to actually "download" it into the server
    $handle = fopen('php://input', 'rb');
    while (!feof($handle)) {
        fread($handle, 8192);
        if (connection_aborted()) break;
    }
    fclose($handle);
    
    echo json_encode(['status' => 'success', 'received' => true]);
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['status' => 'error', 'message' => 'Only POST allowed']);
}
exit;
