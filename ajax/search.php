<?php
require_once dirname(__DIR__) . '/includes/config.php';
header('Content-Type: application/json');

$q = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';

$results = [];
if ($q === '') {
    echo json_encode($results);
    exit;
}

foreach ($TOOL_CATEGORIES as $cat_id => $category) {
    foreach ($category['tools'] as $tool_id => $tool) {
        $name = strtolower($tool['name']);
        $desc = strtolower($tool['desc']);
        $keywords = isset($tool['keywords']) ? strtolower(implode(' ', $tool['keywords'])) : '';
        
        if (strpos($name, $q) !== false || strpos($desc, $q) !== false || strpos($keywords, $q) !== false) {
            $results[] = [
                'name' => $tool['name'],
                'desc' => $tool['desc'],
                'url'  => SITE_URL . "/tools/{$cat_id}/{$tool_id}",
                'icon' => $category['icon'],
                'cat'  => $category['name']
            ];
        }
    }
}

// Limit dropdown to top 6 results
echo json_encode(array_slice($results, 0, 6));
