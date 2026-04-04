<?php
require_once __DIR__ . '/includes/config.php';

echo "<h2>yt-dlp Debug Tester</h2>";

$yt_dlp_path = YT_DLP_PATH;
echo "<p><strong>Path:</strong> " . htmlspecialchars($yt_dlp_path) . "</p>";

if (!file_exists($yt_dlp_path)) {
    echo "<p style='color:red'>Error: yt-dlp file does not exist at the designated path.</p>";
    exit;
}

if (!is_executable($yt_dlp_path)) {
    echo "<p style='color:red'>Error: yt-dlp is not executable. Permissions needed (755).</p>";
    exit;
}

echo "<h3>Running yt-dlp --version</h3>";
// Add 2>&1 to capture stderr output (errors like "Permission denied" or "Python not found" or "noexec")
$command = escapeshellarg($yt_dlp_path) . " --version 2>&1";
$output = shell_exec($command);

echo "<pre style='background:#f4f4f4; padding:10px; border:1px solid #ccc; white-space:pre-wrap;'>";
if ($output === null || $output === '') {
    echo "NO OUTPUT. This usually means `shell_exec` is disabled in your PHP configuration (disable_functions).";
} else {
    echo htmlspecialchars($output);
}
echo "</pre>";

echo "<h3>Check for /tmp noexec issue</h3>";
echo "<p>If the error above mentions <strong>Permission denied</strong> or <strong>_MEI...</strong>, your server's /tmp directory is blocking executables.</p>";

// Let's try running it with a custom TMPDIR
$custom_tmp = __DIR__ . '/tmp';
if (!is_dir($custom_tmp)) mkdir($custom_tmp, 0777, true);

$command_fix = "export TMPDIR=" . escapeshellarg($custom_tmp) . " && " . escapeshellarg($yt_dlp_path) . " --version 2>&1";
$output_fix = shell_exec($command_fix);

echo "<h3>Running with fixed TMPDIR</h3>";
echo "Command: <code>$command_fix</code>";
echo "<pre style='background:#eef8ff; padding:10px; border:1px solid #bce8ff; white-space:pre-wrap;'>";
echo htmlspecialchars($output_fix);
echo "</pre>";
?>
