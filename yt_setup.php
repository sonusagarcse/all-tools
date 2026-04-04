<?php
/**
 * Auto-installer for yt-dlp (Linux Standalone)
 * Upload this file to your public_html or tools folder and open it in your browser.
 */

// Define path where yt-dlp should be saved
$bin_dir = __DIR__ . '/bin';
$yt_dlp_path = $bin_dir . '/yt-dlp';

echo "<h2>yt-dlp Auto Installer for Shared Hosting</h2>";

// Ensure bin directory exists
if (!is_dir($bin_dir)) {
    mkdir($bin_dir, 0755, true);
    echo "<p>Created bin directory.</p>";
}

echo "<p>Downloading the correct standalone Linux version of yt-dlp...</p>";

// The direct link to the single standalone binary
$url = "https://github.com/yt-dlp/yt-dlp/releases/latest/download/yt-dlp";

// Download the file
$ch = curl_init($url);
$fp = fopen($yt_dlp_path, "w");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);
fclose($fp);

if ($error) {
    echo "<p style='color:red;'>Download failed: $error</p>";
} else {
    // Make it executable
    chmod($yt_dlp_path, 0755);
    echo "<p style='color:green;'>✅ Successfully downloaded and installed yt-dlp!</p>";
    
    // Test the executable
    $version = shell_exec($yt_dlp_path . ' --version');
    if ($version) {
        echo "<p><strong>yt-dlp version:</strong> " . htmlspecialchars($version) . "</p>";
        echo "<p style='color:green;'>Everything is working perfectly! You can now use your video downloader.</p>";
    } else {
        echo "<p style='color:red;'>⚠️ Download succeeded, but could not retrieve version. Your server's <code>shell_exec</code> might be restricted, or the binary is not compatible.</p>";
    }
}

echo "<p><em>Note: Please delete this yt_setup.php file after successful installation for security.</em></p>";
?>
