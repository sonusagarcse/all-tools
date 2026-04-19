<?php
/**
 * TTS Audio Proxy
 * Fetches audio from Google Translate TTS engine (Public API)
 */

if (!isset($_GET['text']) || empty($_GET['text'])) {
    die("Error: No text provided.");
}

$text = substr(trim($_GET['text']), 0, 1000); // Sanity limit
$lang = isset($_GET['lang']) ? substr(trim($_GET['lang']), 0, 5) : 'en';

// Google Translate TTS Public Endpoint
// client=tw-ob is the standard for non-token based requests
$url = "https://translate.google.com/translate_tts?ie=UTF-8&q=" . urlencode($text) . "&tl=" . urlencode($lang) . "&total=1&idx=0&textlen=" . strlen($text) . "&client=tw-ob&prev=input";

// Stream the response directly to the output
header('Content-Type: audio/mpeg');
header('Content-Disposition: attachment; filename="tts-audio-' . date('Ymd-His') . '.mp3"');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false); // Stream directly to output
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');

if (!curl_exec($ch)) {
    header('HTTP/1.1 500 Internal Server Error');
    echo "Error fetching audio.";
}

curl_close($ch);
exit;
