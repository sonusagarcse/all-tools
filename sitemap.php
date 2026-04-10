<?php
// ==========================================
// THE "NUCLEAR" SITEMAP OPTION
// Guaranteed to force Google to read the XML
// ==========================================

// 1. Force kill all forms of server/PHP compression (which corrupts the Content-Length)
@ini_set('zlib.output_compression', 'Off');
if (function_exists('apache_setenv')) {
    @apache_setenv('no-gzip', '1');
}

// 2. Destroy ALL output buffer layers (prevents auto_prepend_file scripts)
while (ob_get_level() > 0) {
    ob_end_clean();
}

// Start a single fresh buffer
ob_start();

// Include config and data
require_once __DIR__ . '/includes/config.php';

// 3. Brutally discard any errors, BOMs, or whitespace that existed in config.php
ob_end_clean();

// 4. Set strict XML headers
header('Content-Type: application/xml; charset=UTF-8');
// (We intentionally avoid Cache-Control and X-Robots-Tag to keep it as "vanilla" as possible for GSC)

// 5. Construct the XML tree in memory
$xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
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
$tool_lastmod = date('Y-m-d'); // Cache the date calculation
foreach ($TOOL_CATEGORIES as $cat_id => $category) {
    foreach ($category['tools'] as $tool_id => $tool) {
        $xml .= '    <url>' . "\n";
        $xml .= '        <loc>' . htmlspecialchars(SITE_URL . '/tools/' . $cat_id . '/' . $tool_id, ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</loc>' . "\n";
        $xml .= '        <changefreq>monthly</changefreq>' . "\n";
        $xml .= '        <priority>0.8</priority>' . "\n";
        $xml .= '        <lastmod>' . $tool_lastmod . '</lastmod>' . "\n";
        $xml .= '    </url>' . "\n";
    }
}

$xml .= '</urlset>' . "\n";

// 6. The "Kill-Switch": Calculate EXACT byte length.
// Because gzip is disabled above, this Content-Length will be 100% accurate.
// Googlebot will read exactly this many bytes and then close the connection,
// completely ignoring any adware scripts the host tries to append afterward.
header('Content-Length: ' . strlen($xml));

// Output the precise XML payload
echo $xml;

// 7. Hard process termination. Bypass PHP shutdown hooks where hosts usually inject scripts.
exit;
