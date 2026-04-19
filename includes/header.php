<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

// Static page meta map
$static_pages = [
    'about'          => ['title' => 'About Us', 'desc' => 'Learn about BulkTools — a free, privacy-first collection of image, text, developer, and security tools for everyone.'],
    'contact'        => ['title' => 'Contact Us', 'desc' => 'Get in touch with the BulkTools team. Report a bug, suggest a new tool, or ask any question — we read every message.'],
    'privacy-policy' => ['title' => 'Privacy Policy', 'desc' => 'Read how BulkTools collects, uses, and protects your data. We never store files beyond your session and never sell your data.'],
    'terms'          => ['title' => 'Terms of Service', 'desc' => 'Read the BulkTools Terms of Service governing use of all free online tools on the platform.'],
];

// Detect current static page from URI
$uri_slug = trim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
// Strip subfolder prefix if installed in /tools/
$uri_slug = preg_replace('#^tools/?#', '', $uri_slug);
$static_page = $static_pages[$uri_slug] ?? null;

// Get page title for SEO
$current_tool = get_current_tool_info($_SERVER['REQUEST_URI']);
if ($static_page) {
    $page_title    = $static_page['title'] . ' | ' . SITE_NAME;
    $page_desc     = $static_page['desc'];
    $page_keywords = 'free online tools, ' . strtolower($static_page['title']) . ', BulkTools';
} elseif ($current_tool) {
    $page_title    = $current_tool['name'] . ' - Free Online Tool | ' . SITE_NAME;
    $page_desc     = $current_tool['seo_desc'] ?? $current_tool['desc'];
    $page_keywords = isset($current_tool['keywords']) ? implode(', ', $current_tool['keywords']) : 'free online tools';
} else {
    $page_title    = SITE_NAME . ' - ' . SITE_TAGLINE;
    $page_desc     = 'BulkTools offers free online Image, Text, Developer, and Security tools. No registration needed. 100% secure, instant results.';
    $page_keywords = 'free online tools, browser tools, image compression, developer utilities, html minifier, jwt decoder, hindi transliteration, bcrypt generator, online security tools, password generator, text converters, free utility website, no registration tools';
}

$canonical_url = SITE_URL . strtok($_SERVER['REQUEST_URI'], '?');
?>
<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <!-- Prevent FOUC (Flash of Unstyled Content) -->
    <script>
        if (localStorage.getItem('theme') === 'light' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: light)').matches)) {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
    </script>
    <script defer src="https://cloud.umami.is/script.js"
        data-website-id="8b8d45e5-b6ea-4122-9f1d-c67d5767cbe0"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page_desc); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($page_keywords); ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url); ?>">
    <link rel="manifest" href="<?php echo SITE_URL; ?>/pwa-app/manifest.json">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236366f1' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polygon points='12 2 2 7 12 12 22 7 12 2'/><polyline points='2 17 12 22 22 17'/><polyline points='2 12 12 17 22 12'/></svg>">

    <script>
        // Global PWA State for root site
        window.pwaState = {
            deferredPrompt: null
        };

        // Register Service Worker from root
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('<?php echo SITE_URL; ?>/pwa-app/sw.js')
                .then(reg => console.log('PWA SW Registered from Root'))
                .catch(err => console.log('SW Reg failed', err));
            });
        }

        // Capture Install Prompt
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            window.pwaState.deferredPrompt = e;
            // Dispatch event for UI components to listen
            window.dispatchEvent(new CustomEvent('pwa-installable'));
        });
    </script>

    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page_desc); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical_url); ?>">
    <meta property="og:image" content="<?php echo SITE_URL; ?>/assets/img/og-image.png">
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($page_desc); ?>">
    <meta name="twitter:image" content="<?php echo SITE_URL; ?>/assets/img/og-image.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        gray: {
                            950: '#030712',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Space Grotesk', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Icons (Lucide Icons) -->
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.400.0/dist/umd/lucide.js"></script>

    <!-- Global Variables for JS -->
    <script>const SITE_URL = '<?php echo SITE_URL; ?>';</script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/custom.css">

    <style>
        .tool-card:hover {
            transform: translateY(-4px);
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 dark:bg-gray-950 dark:text-gray-100 font-sans selection:bg-indigo-500/30 transition-colors duration-300">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 glass">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <a href="<?php echo SITE_URL; ?>" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-500/30">
                            <i data-lucide="layers" class="w-5 h-5 text-white"></i>
                        </div>
                        <span
                            class="text-xl font-heading font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 to-cyan-500 dark:from-indigo-400 dark:to-cyan-400">
                            <?php echo SITE_NAME; ?>
                        </span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                    <?php foreach ($TOOL_CATEGORIES as $cat_id => $category): ?>
                        <?php if (isset($category['hidden_nav']) && $category['hidden_nav']) continue; ?>
                        <div class="relative group">
                            <button
                                class="px-3 py-2 rounded-md text-sm font-medium text-slate-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-gray-800/50 flex items-center gap-1 transition-colors">
                                <?php echo $category['name']; ?>
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </button>
                            <div
                                class="absolute left-0 mt-2 w-56 rounded-xl shadow-2xl bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-2 z-50">
                                <div class="py-2 grid grid-cols-1 gap-1 px-1">
                                    <?php foreach ($category['tools'] as $tool_id => $tool): ?>
                                        <a href="<?php echo SITE_URL; ?>/tools/<?php echo $cat_id; ?>/<?php echo $tool_id; ?>"
                                            class="flex items-center gap-2 px-3 py-2 text-sm text-slate-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                                            <i data-lucide="file-text" class="w-4 h-4 opacity-50 text-indigo-500"></i>
                                            <?php echo $tool['name']; ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

                <!-- Search & Actions -->
                <div class="flex items-center gap-4 border-l border-slate-200 dark:border-gray-800 pl-4">
                    <div class="relative hidden sm:block">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="w-4 h-4 text-slate-400 dark:text-gray-500"></i>
                        </div>
                        <input type="text" id="global-search" autocomplete="off"
                            class="block w-full pl-10 pr-3 py-1.5 border border-slate-200 dark:border-gray-800 rounded-full bg-slate-100 dark:bg-gray-900/50 text-sm placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                            placeholder="Search tools...">
                        <div id="global-search-dropdown" class="absolute left-0 right-0 mt-2 w-72 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl shadow-2xl overflow-hidden z-50 hidden text-left"></div>
                    </div>

                    <button id="theme-toggle" class="p-2 rounded-full text-slate-500 hover:text-slate-900 hover:bg-slate-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-800/50 transition-colors">
                        <i id="theme-icon" data-lucide="moon" class="w-5 h-5 cursor-pointer"></i>
                    </button>

                    <!-- Mobile Menu Button -->
                    <div class="flex md:hidden">
                        <button id="mobile-menu-btn"
                            class="p-2 rounded-md text-slate-400 hover:text-slate-600 dark:text-gray-400 dark:hover:text-white focus:outline-none">
                            <i data-lucide="menu" class="w-6 h-6"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu"
            class="md:hidden hidden border-t border-slate-200 dark:border-gray-800 bg-white/95 dark:bg-gray-950/95 overflow-y-auto max-h-[80vh] backdrop-blur-md">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <?php foreach ($TOOL_CATEGORIES as $cat_id => $category): ?>
                    <?php if (isset($category['hidden_nav']) && $category['hidden_nav']) continue; ?>
                    <div class="px-3 py-2">
                        <div class="text-xs font-semibold text-slate-500 dark:text-gray-500 uppercase tracking-wider mb-2">
                            <?php echo $category['name']; ?></div>
                        <div class="grid grid-cols-1 gap-1">
                            <?php foreach ($category['tools'] as $tool_id => $tool): ?>
                                <a href="<?php echo SITE_URL; ?>/tools/<?php echo $cat_id; ?>/<?php echo $tool_id; ?>"
                                    class="flex items-center gap-2 block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800 transition-colors">
                                    <i data-lucide="file-text" class="w-4 h-4 opacity-50 text-indigo-500"></i>
                                    <?php echo $tool['name']; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </nav>

    <main class="min-h-screen">