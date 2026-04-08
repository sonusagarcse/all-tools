<?php
// Start a fresh buffer to catch any stray whitespace/errors from included files
ob_start();

require_once __DIR__ . '/includes/config.php';

// Discard anything that was outputted during the include phase (like BOMs or newlines)
// This ensures that the very first character sent is <?xml
ob_clean();

// Strictly set XML content type so Google recognizes it as a sitemap
header('Content-Type: application/xml; charset=UTF-8');

// Structure the XML safely
$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// Homepage
$xml .= '    <url>' . "\n";
$xml .= '        <loc>' . htmlspecialchars(SITE_URL, ENT_XML1 | ENT_QUOTES, 'UTF-8') . '/</loc>' . "\n";
$xml .= '        <changefreq>weekly</changefreq>' . "\n";
$xml .= '        <priority>1.0</priority>' . "\n";
$xml .= '        <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
$xml .= '    </url>' . "\n";

// Static pages
$static_pages = [
    '/about' => ['freq' => 'monthly', 'pri' => '0.7'],
    '/contact' => ['freq' => 'monthly', 'pri' => '0.6'],
    '/privacy-policy' => ['freq' => 'yearly', 'pri' => '0.4'],
    '/terms' => ['freq' => 'yearly', 'pri' => '0.4'],
];

foreach ($static_pages as $path => $meta) {
    $xml .= '    <url>' . "\n";
    $xml .= '        <loc>' . htmlspecialchars(SITE_URL . $path, ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</loc>' . "\n";
    $xml .= '        <changefreq>' . $meta['freq'] . '</changefreq>' . "\n";
    $xml .= '        <priority>' . $meta['pri'] . '</priority>' . "\n";
    $xml .= '    </url>' . "\n";
}

// Tool Pages
foreach ($TOOL_CATEGORIES as $cat_id => $category) {
    foreach ($category['tools'] as $tool_id => $tool) {
        $xml .= '    <url>' . "\n";
        $xml .= '        <loc>' . htmlspecialchars(SITE_URL . '/tools/' . $cat_id . '/' . $tool_id, ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</loc>' . "\n";
        $xml .= '        <changefreq>monthly</changefreq>' . "\n";
        $xml .= '        <priority>0.9</priority>' . "\n";
        $xml .= '        <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
        $xml .= '    </url>' . "\n";
    }
}

$xml .= '</urlset>' . "\n";

echo $xml;
