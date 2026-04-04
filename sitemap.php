<?php
require_once __DIR__ . '/includes/config.php';
header('Content-Type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <!-- Homepage -->
    <url>
        <loc><?php echo SITE_URL; ?>/</loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
        <lastmod><?php echo date('Y-m-d'); ?></lastmod>
    </url>

    <!-- Static pages -->
    <url>
        <loc><?php echo SITE_URL; ?>/about</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc><?php echo SITE_URL; ?>/contact</loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc><?php echo SITE_URL; ?>/privacy-policy</loc>
        <changefreq>yearly</changefreq>
        <priority>0.4</priority>
    </url>
    <url>
        <loc><?php echo SITE_URL; ?>/terms</loc>
        <changefreq>yearly</changefreq>
        <priority>0.4</priority>
    </url>

    <!-- Tool Pages -->
    <?php foreach ($TOOL_CATEGORIES as $cat_id => $category): ?>
    <?php foreach ($category['tools'] as $tool_id => $tool): ?>
    <url>
        <loc><?php echo SITE_URL; ?>/tools/<?php echo $cat_id; ?>/<?php echo $tool_id; ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.9</priority>
        <lastmod><?php echo date('Y-m-d'); ?></lastmod>
    </url>
    <?php endforeach; ?>
    <?php endforeach; ?>

</urlset>
