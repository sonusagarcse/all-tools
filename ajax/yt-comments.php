<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Securely store the API key server-side
$apiKey = 'AIzaSyARo4MQqizY_JCqKBzexa4MVOqycFhvaH4';

if (!isset($_GET['videoId']) || empty($_GET['videoId'])) {
    http_response_code(400);
    echo json_encode(['error' => ['message' => 'Video ID is required']]);
    exit;
}

$videoId = urlencode($_GET['videoId']);
$pageToken = isset($_GET['pageToken']) ? urlencode($_GET['pageToken']) : '';

$url = "https://www.googleapis.com/youtube/v3/commentThreads?part=snippet&videoId={$videoId}&key={$apiKey}&maxResults=100";
if ($pageToken) {
    $url .= "&pageToken={$pageToken}";
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // in case of local testing ssl issues

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    http_response_code(500);
    echo json_encode(['error' => ['message' => 'Server curl error: ' . curl_error($ch)]]);
    curl_close($ch);
    exit;
}
curl_close($ch);

http_response_code($httpcode);
echo $response;
