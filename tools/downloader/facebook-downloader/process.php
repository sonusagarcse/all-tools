<?php
require_once '../../../includes/config.php';
require_once '../../../includes/functions.php';
json_safe_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf($_POST['csrf_token'] ?? '')) { json_error('Invalid request or security token expired.'); }

$action = $_POST['action'] ?? '';
$url = filter_var($_POST['url'] ?? '', FILTER_VALIDATE_URL);
if (!$url) { json_error('Please enter a valid URL.'); }
if (strpos($url, 'facebook.com') === false && strpos($url, 'fb.watch') === false && strpos($url, 'fb.com') === false) { json_error('Please enter a valid Facebook URL.'); }

$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/downloader/' . $sessionHash;
if (!is_dir($outputDir)) { mkdir($outputDir, 0777, true); }

if ($action === 'fetch_info') {
    $command = YT_DLP_PATH . " --dump-json --no-playlist " . escapeshellarg($url);
    $output = shell_exec($command);
    if (!$output) { json_error('Failed to fetch video information. The video may be private.'); }
    $data = json_decode($output, true);
    if (!$data) { json_error('Error parsing video metadata.'); }

    $formats = [];
    foreach ($data['formats'] as $f) {
        if (isset($f['vcodec']) && $f['vcodec'] !== 'none') {
            $formats[] = ['format_id' => $f['format_id'], 'ext' => $f['ext'], 'quality' => $f['format_note'] ?? (isset($f['height']) ? $f['height'] . 'p' : 'unknown'), 'filesize_str' => isset($f['filesize']) ? format_bytes($f['filesize']) : 'N/A'];
        }
    }
    usort($formats, function($a, $b) { return (int)$b['quality'] - (int)$a['quality']; });

    json_response(['title' => $data['title'] ?? 'Facebook Video', 'thumbnail' => $data['thumbnail'] ?? '', 'duration_string' => isset($data['duration']) ? gmdate("H:i:s", $data['duration']) : '0:00', 'uploader' => $data['uploader'] ?? 'Unknown', 'webpage_url' => $data['webpage_url'] ?? $url, 'formats' => array_slice($formats, 0, 8)]);

} elseif ($action === 'download') {
    $formatId = $_POST['format_id'] ?? 'best';
    if (!rate_limit_check()) { json_error('Rate limit exceeded.'); }
    $tempPrefix = 'fb_' . uniqid();
    $outputPath = $outputDir . '/' . $tempPrefix . '.%(ext)s';
    $command = escapeshellarg(YT_DLP_PATH) . " -f " . escapeshellarg($formatId) . " -o \"" . $outputPath . "\" " . escapeshellarg($url) . " 2>&1";
    shell_exec($command);
    $files = glob($outputDir . '/' . $tempPrefix . '.*');
    if (empty($files)) { json_error('Failed to download the video.'); }
    $actualFile = end($files);
    mark_upload_attempt();
    json_response(['download_url' => SITE_URL . '/uploads/downloader/' . $sessionHash . '/' . basename($actualFile), 'filename' => basename($actualFile)]);
} else { json_error('Invalid action.'); }
