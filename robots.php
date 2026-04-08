<?php
// Serve robots.txt dynamically so SITE_URL is correct in any environment
require_once __DIR__ . '/includes/config.php';
header('Content-Type: text/plain');
?>
User-agent: *
Allow: /

# Block private directories
Disallow: /uploads/
Disallow: /includes/
Disallow: /vendor/
Disallow: /tmp/
Disallow: /assets/js/
Disallow: /cleanup.php
Disallow: /download.php

# Sitemap
Sitemap: <?php echo SITE_URL; ?>/sitemap.xml
