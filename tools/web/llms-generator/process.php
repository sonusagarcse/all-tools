<?php
require_once '../../../includes/config.php';
require_once '../../../includes/functions.php';

json_safe_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_error('Method not allowed');
}

$url = isset($_POST['url']) ? trim($_POST['url']) : '';
$csrf_token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';

if (!validate_csrf($csrf_token)) {
    json_error('Invalid security token');
}

if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
    json_error('Invalid website URL');
}

try {
    // Set user agent to avoid blocking
    $options = [
        'http' => [
            'method' => "GET",
            'header' => "User-Agent: BulkTools AI-Scanner/1.0 (https://bulktools.example.com)\r\n" .
                        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8\r\n"
        ]
    ];
    $context = stream_context_create($options);
    
    // Fetch HTML
    $html = @file_get_contents($url, false, $context);
    
    if ($html === false) {
        json_error('Could not fetch website content. Please check the URL and try again.');
    }

    // Parse HTML
    $doc = new DOMDocument();
    @$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    $xpath = new DOMXPath($doc);

    // Extract Metadata
    $title = $xpath->query('//title')->item(0);
    $title = $title ? trim($title->textContent) : parse_url($url, PHP_URL_HOST);

    $description = $xpath->query('//meta[@name="description"]/@content')->item(0);
    $description = $description ? trim($description->textContent) : '';

    if (empty($description)) {
        $ogDescription = $xpath->query('//meta[@property="og:description"]/@content')->item(0);
        $description = $ogDescription ? trim($ogDescription->textContent) : 'No description provided.';
    }

    // Extract H1 (Tagline)
    $h1 = $xpath->query('//h1')->item(0);
    $tagline = $h1 ? trim($h1->textContent) : $title;

    // Extract Links
    $links = [];
    $aTags = $xpath->query('//a[@href]');
    $host = parse_url($url, PHP_URL_HOST);

    foreach ($aTags as $a) {
        $href = $a->getAttribute('href');
        $text = trim($a->textContent);
        
        // Filter empty text or very long text
        if (empty($text) || strlen($text) > 50) continue;
        
        // Resolve relative URLs
        if (strpos($href, '/') === 0) {
            $href = rtrim($url, '/') . $href;
        } elseif (strpos($href, 'http') !== 0) {
            continue; // Skip fragments, tel:, mailto:, etc.
        }

        // Only include internal links to keep it concise
        $linkHost = parse_url($href, PHP_URL_HOST);
        if ($linkHost === $host && !isset($links[$href])) {
            // Avoid duplicates and junk links
            if (preg_match('/(login|signup|privacy|terms|cart|account)/i', $href)) continue;
            
            $links[$href] = $text;
            if (count($links) >= 15) break; // Limit to 15 key links
        }
    }

    // Generate llms.txt content
    $content = "# " . $title . "\n\n";
    $content .= "> " . $tagline . "\n\n";
    $content .= $description . "\n\n";
    
    if (!empty($links)) {
        $content .= "## Key Resources\n\n";
        foreach ($links as $href => $text) {
            $content .= "- [" . $text . "](" . $href . ")\n";
        }
    }

    json_response(['content' => $content]);

} catch (Exception $e) {
    json_error('An error occurred during scanning: ' . $e->getMessage());
}
