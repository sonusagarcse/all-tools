<?php
require_once '../../../includes/config.php';
require_once '../../../includes/functions.php';
json_safe_start();

// 1. Validate General Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf($_POST['csrf_token'] ?? '')) {
    json_error('Invalid request or security token expired.');
}

$action = $_POST['action'] ?? '';
$url = filter_var($_POST['url'] ?? '', FILTER_VALIDATE_URL);

if (!$url) {
    json_error('Please enter a valid URL.');
}

// 2. Setup Directories
$sessionHash = get_session_hash();
$outputDir = UPLOAD_DIR . '/downloader/' . $sessionHash;
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

// 3. Handle Actions
if ($action === 'fetch_info') {
    // Call yt-dlp to get metadata
    $command = YT_DLP_PATH . " --dump-json --no-playlist " . escapeshellarg($url);
    $output = shell_exec($command);
    
    if (!$output) {
        json_error('Failed to fetch video information. Ensure yt-dlp is installed.');
    }

    $data = json_decode($output, true);
    if (!$data) {
        json_error('Error parsing video metadata.');
    }

    // Filter relevant formats (only video+audio or audio only)
    $formats = [];
    foreach ($data['formats'] as $f) {
        if (isset($f['vcodec']) && $f['vcodec'] !== 'none' && isset($f['acodec']) && $f['acodec'] !== 'none') {
            $formats[] = [
                'format_id' => $f['format_id'],
                'ext' => $f['ext'],
                'quality' => $f['format_note'] ?? ($f['height'] . 'p'),
                'filesize_str' => isset($f['filesize']) ? format_bytes($f['filesize']) : 'N/A'
            ];
        }
    }

    // Sort by quality (highest first)
    usort($formats, function($a, $b) {
        return (int)$b['quality'] - (int)$a['quality'];
    });

    json_response([
        'title' => $data['title'],
        'thumbnail' => $data['thumbnail'],
        'duration_string' => gmdate("H:i:s", $data['duration']),
        'uploader' => $data['uploader'],
        'webpage_url' => $data['webpage_url'],
        'formats' => array_slice($formats, 0, 8) // Limit to top 8 formats
    ]);

} elseif ($action === 'download') {
    $formatId = $_POST['format_id'] ?? 'best';
    
    if (!rate_limit_check()) {
        json_error('Rate limit exceeded.');
    }

    $tempPrefix = 'video_' . uniqid();
    $outputPath = $outputDir . '/' . $tempPrefix . '.%(ext)s';

    // Call yt-dlp to download - Use manual quotes for $outputPath because escapeshellarg() on Windows replaces '%' with a space
    $command = escapeshellarg(YT_DLP_PATH) . " -f " . escapeshellarg($formatId) . " -o \"" . $outputPath . "\" " . escapeshellarg($url) . " 2>&1";
    shell_exec($command);

    // Find the actual file (since ext might vary)
    $files = glob($outputDir . '/' . $tempPrefix . '.*');
    
    if (empty($files)) {
        json_error('Failed to download the video.');
    }

    $actualFile = $files[0];
    $downloadUrl = SITE_URL . '/uploads/downloader/' . $sessionHash . '/' . basename($actualFile);
    
    mark_upload_attempt();

    json_response([
        'download_url' => $downloadUrl,
        'filename' => basename($actualFile)
    ]);
} else {
    json_error('Invalid action.');
}
