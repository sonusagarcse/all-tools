<?php
// Send proper 404 HTTP status code - MUST be before any output
http_response_code(404);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

// Override page meta for SEO
$page_title    = '404 — Page Not Found | ' . SITE_NAME;
$page_desc     = 'The page you are looking for does not exist. Return to BulkTools to access free online image, text, and developer tools.';
$page_keywords = '404, page not found, BulkTools';
$canonical_url = SITE_URL . '/404';

// Detect what was requested for a helpful message
$requested_path = htmlspecialchars(strtok($_SERVER['REQUEST_URI'], '?'));
?>
<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <!-- Prevent FOUC -->
    <script>
        if (localStorage.getItem('theme') === 'light' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: light)').matches)) {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page_desc); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($page_keywords); ?>">
    <meta name="robots" content="noindex, nofollow">
    <link rel="canonical" href="<?php echo htmlspecialchars(SITE_URL); ?>">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236366f1' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polygon points='12 2 2 7 12 12 22 7 12 2'/><polyline points='2 17 12 22 22 17'/><polyline points='2 12 12 17 22 12'/></svg>">
    <link rel="shortcut icon" href="<?php echo SITE_URL; ?>/assets/img/favicon.ico">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=Space+Grotesk:wght@600;700;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS - Deferred -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Space Grotesk', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/custom.css">

    <style>
        .num-404 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(100px, 22vw, 180px);
            font-weight: 900;
            line-height: 1;
            letter-spacing: -6px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 45%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 12px 40px rgba(99,102,241,0.4));
            user-select: none;
        }

        .float-1 { animation: float 3.5s ease-in-out infinite; }
        .float-2 { animation: float 3.5s ease-in-out infinite 0.6s; }
        .float-3 { animation: float 3.5s ease-in-out infinite 1.2s; }
        .float-4 { animation: float 3.5s ease-in-out infinite 1.8s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50%       { transform: translateY(-10px) rotate(4deg); }
        }

        /* Animated background dots */
        .bg-dots {
            background-image: radial-gradient(circle, rgba(99,102,241,0.12) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        /* Glow pulse */
        .glow-pulse {
            animation: glow 5s ease-in-out infinite;
        }
        @keyframes glow {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50%       { opacity: 0.6; transform: scale(1.08); }
        }

        .glass {
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226,232,240,0.8);
        }
        .dark .glass {
            background: rgba(3,7,18,0.85);
            border-bottom: 1px solid rgba(31,41,55,0.8);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 dark:bg-gray-950 dark:text-gray-100 font-sans selection:bg-indigo-500/30 transition-colors duration-300 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 glass">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="<?php echo SITE_URL; ?>" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-500/30">
                        <i data-lucide="layers" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-xl font-heading font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 to-cyan-500">
                        <?php echo SITE_NAME; ?>
                    </span>
                </a>

                <!-- Nav actions -->
                <div class="flex items-center gap-3">
                    <a href="<?php echo SITE_URL; ?>" class="hidden sm:flex items-center gap-1.5 px-4 py-1.5 text-sm font-medium text-slate-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-gray-800/50 rounded-lg transition-colors">
                        <i data-lucide="home" class="w-4 h-4"></i>
                        Home
                    </a>
                    <a href="<?php echo SITE_URL; ?>" class="hidden sm:flex items-center gap-1.5 px-4 py-1.5 text-sm font-medium text-slate-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-gray-800/50 rounded-lg transition-colors">
                        <i data-lucide="layout-grid" class="w-4 h-4"></i>
                        All Tools
                    </a>
                    <button id="theme-toggle" class="p-2 rounded-full text-slate-500 hover:text-slate-900 hover:bg-slate-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-800/50 transition-colors">
                        <i id="theme-icon" data-lucide="moon" class="w-5 h-5 cursor-pointer"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main 404 Content -->
    <main class="flex-1 flex items-center justify-center py-20 px-4 relative overflow-hidden">

        <!-- Decorative background -->
        <div class="absolute inset-0 bg-dots opacity-60 dark:opacity-30 pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-indigo-500/10 dark:bg-indigo-500/5 rounded-full blur-3xl glow-pulse pointer-events-none"></div>

        <div class="relative z-10 max-w-2xl w-full text-center">

            <!-- Floating decorative icons -->
            <div class="relative inline-block mb-4">
                <!-- Floating badges -->
                <div class="absolute -top-8 -left-12 w-12 h-12 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-700 rounded-2xl flex items-center justify-center shadow-xl float-1">
                    <i data-lucide="search-x" class="w-6 h-6 text-indigo-500"></i>
                </div>
                <div class="absolute -top-4 -right-10 w-10 h-10 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-700 rounded-xl flex items-center justify-center shadow-lg float-2">
                    <i data-lucide="map-pin-off" class="w-5 h-5 text-violet-500"></i>
                </div>
                <div class="absolute -bottom-6 -right-14 w-11 h-11 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-700 rounded-2xl flex items-center justify-center shadow-xl float-3">
                    <i data-lucide="compass" class="w-5 h-5 text-cyan-500"></i>
                </div>
                <div class="absolute -bottom-2 -left-14 w-10 h-10 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-700 rounded-xl flex items-center justify-center shadow-lg float-4">
                    <i data-lucide="ghost" class="w-5 h-5 text-rose-400"></i>
                </div>

                <!-- The giant 404 -->
                <div class="num-404">404</div>
            </div>

            <!-- Text -->
            <h1 class="text-3xl sm:text-4xl font-heading font-black text-slate-900 dark:text-white mt-4 mb-3 tracking-tight">
                Page Not Found
            </h1>
            <p class="text-slate-500 dark:text-gray-400 text-base mb-2 max-w-md mx-auto leading-relaxed">
                Oops! The page you're looking for doesn't exist, has moved, or the URL was mistyped.
            </p>

            <?php if ($requested_path !== '/') : ?>
            <p class="text-xs text-slate-400 dark:text-gray-600 mb-8 font-mono bg-slate-100 dark:bg-gray-900 inline-block px-4 py-1.5 rounded-full border border-slate-200 dark:border-gray-800">
                <?php echo $requested_path; ?>
            </p>
            <?php else: ?>
            <div class="mb-8"></div>
            <?php endif; ?>

            <!-- Action buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mb-12">
                <a href="<?php echo SITE_URL; ?>"
                   class="flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-500 active:scale-95 text-white font-bold rounded-2xl text-sm transition-all shadow-xl shadow-indigo-500/25">
                    <i data-lucide="home" class="w-4 h-4"></i>
                    Back to Home
                </a>
                <button onclick="window.history.back()"
                   class="flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-900 hover:bg-slate-50 dark:hover:bg-gray-800 active:scale-95 text-slate-700 dark:text-gray-300 font-bold rounded-2xl text-sm transition-all border border-slate-200 dark:border-gray-700 shadow-sm">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Go Back
                </button>
                <a href="<?php echo SITE_URL; ?>/contact"
                   class="flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-900 hover:bg-slate-50 dark:hover:bg-gray-800 active:scale-95 text-slate-700 dark:text-gray-300 font-bold rounded-2xl text-sm transition-all border border-slate-200 dark:border-gray-700 shadow-sm">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    Report Issue
                </a>
            </div>

            <!-- Popular tools grid -->
            <div class="bg-white dark:bg-gray-900/60 rounded-3xl p-6 border border-slate-200 dark:border-gray-800 shadow-sm text-left backdrop-blur-sm">
                <p class="text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-5 text-center">
                    Popular Tools — Get Back to Work
                </p>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <?php
                    // Show first 6 tools from config
                    $count = 0;
                    $tool_icons = [
                        'compress-image'         => ['icon' => 'minimize-2',  'color' => 'emerald'],
                        'resize-image'           => ['icon' => 'maximize-2',   'color' => 'blue'],
                        'convert-image-format'   => ['icon' => 'image',        'color' => 'violet'],
                        'word-counter'           => ['icon' => 'type',         'color' => 'amber'],
                        'case-converter'         => ['icon' => 'case-sensitive','color' => 'rose'],
                        'password-generator'     => ['icon' => 'key',          'color' => 'indigo'],
                        'html-minifier'          => ['icon' => 'code-2',       'color' => 'cyan'],
                        'jwt-decoder'            => ['icon' => 'shield',       'color' => 'purple'],
                        'qr-code-generator'      => ['icon' => 'qr-code',      'color' => 'slate'],
                    ];
                    $color_map = [
                        'emerald' => 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 border-emerald-100 dark:border-emerald-800/30',
                        'blue'    => 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 border-blue-100 dark:border-blue-800/30',
                        'violet'  => 'bg-violet-50 dark:bg-violet-900/20 text-violet-700 dark:text-violet-400 border-violet-100 dark:border-violet-800/30',
                        'amber'   => 'bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 border-amber-100 dark:border-amber-800/30',
                        'rose'    => 'bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-400 border-rose-100 dark:border-rose-800/30',
                        'indigo'  => 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400 border-indigo-100 dark:border-indigo-800/30',
                        'cyan'    => 'bg-cyan-50 dark:bg-cyan-900/20 text-cyan-700 dark:text-cyan-400 border-cyan-100 dark:border-cyan-800/30',
                        'purple'  => 'bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-400 border-purple-100 dark:border-purple-800/30',
                        'slate'   => 'bg-slate-50 dark:bg-slate-800/40 text-slate-700 dark:text-slate-300 border-slate-100 dark:border-slate-700/30',
                    ];
                    foreach ($TOOL_CATEGORIES as $cat_id => $category):
                        foreach ($category['tools'] as $tool_id => $tool):
                            if ($count >= 6) break 2;
                            $meta  = $tool_icons[$tool_id] ?? ['icon' => 'wrench', 'color' => 'slate'];
                            $color = $color_map[$meta['color']] ?? $color_map['slate'];
                    ?>
                    <a href="<?php echo SITE_URL; ?>/tools/<?php echo $cat_id; ?>/<?php echo $tool_id; ?>"
                       class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl border text-xs font-semibold transition-all hover:scale-105 active:scale-95 <?php echo $color; ?>">
                        <i data-lucide="<?php echo $meta['icon']; ?>" class="w-4 h-4 shrink-0"></i>
                        <span class="truncate"><?php echo $tool['name']; ?></span>
                    </a>
                    <?php
                            $count++;
                        endforeach;
                    endforeach;
                    ?>
                </div>

                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-gray-800 text-center">
                    <a href="<?php echo SITE_URL; ?>" class="text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 font-bold transition-colors inline-flex items-center gap-1">
                        View all <?php echo array_sum(array_map(fn($c) => count($c['tools']), $TOOL_CATEGORIES)); ?>+ tools
                        <i data-lucide="arrow-right" class="w-3 h-3"></i>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- Minimal Footer -->
    <footer class="bg-white dark:bg-gray-950 border-t border-slate-200 dark:border-gray-900 py-6 text-center text-xs text-slate-400 dark:text-gray-600">
        &copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?> &mdash;
        <a href="<?php echo SITE_URL; ?>" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Home</a> &bull;
        <a href="<?php echo SITE_URL; ?>/about" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">About</a> &bull;
        <a href="<?php echo SITE_URL; ?>/contact" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Contact</a> &bull;
        <a href="<?php echo SITE_URL; ?>/sitemap.xml" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Sitemap</a>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/lucide@0.400.0/dist/umd/lucide.js"></script>
    <script>
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Theme toggle
        const themeToggle = document.getElementById('theme-toggle');
        const isDark = document.documentElement.classList.contains('dark');
        if (themeToggle) {
            themeToggle.innerHTML = isDark
                ? '<i id="theme-icon" data-lucide="sun" class="w-5 h-5 cursor-pointer"></i>'
                : '<i id="theme-icon" data-lucide="moon" class="w-5 h-5 cursor-pointer"></i>';
            if (typeof lucide !== 'undefined') lucide.createIcons();

            themeToggle.addEventListener('click', () => {
                document.documentElement.classList.toggle('dark');
                const dark = document.documentElement.classList.contains('dark');
                localStorage.setItem('theme', dark ? 'dark' : 'light');
                themeToggle.innerHTML = dark
                    ? '<i id="theme-icon" data-lucide="sun" class="w-5 h-5 cursor-pointer"></i>'
                    : '<i id="theme-icon" data-lucide="moon" class="w-5 h-5 cursor-pointer"></i>';
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        }
    </script>
</body>
</html>
