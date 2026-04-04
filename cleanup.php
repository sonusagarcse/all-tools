<?php
/**
 * Cleanup script to remove temporary uploads older than 1 hour.
 * Run this via cron: 0 * * * * php /path/to/cleanup.php
 */

require_once __DIR__ . '/includes/config.php';

function delete_old_files($dir, $expiry_seconds) {
    if (!is_dir($dir)) return;

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    $now = time();
    $count = 0;

    foreach ($files as $fileinfo) {
        if ($fileinfo->getMTime() < ($now - $expiry_seconds)) {
            if ($fileinfo->isDir()) {
                @rmdir($fileinfo->getRealPath());
            } else {
                @unlink($fileinfo->getRealPath());
            }
            $count++;
        }
    }

    return $count;
}

$expiry = 3600; // 1 hour
$deletedCount = delete_old_files(UPLOAD_DIR, $expiry);

echo "Cleanup completed. Deleted $deletedCount items older than 1 hour.\n";
