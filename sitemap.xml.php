<?php
require_once __DIR__ . '/includes/config.php';

// Handle clean URLs — redirect sitemap.xml to sitemap.php
// This file acts as a router for pretty URLs if not using .htaccess
header('Content-Type: application/xml; charset=UTF-8');
include __DIR__ . '/sitemap.php';
exit;
?>
