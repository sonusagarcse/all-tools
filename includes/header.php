<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

// Get page title for SEO
$current_tool = get_current_tool_info($_SERVER['REQUEST_URI']);
$page_title = $current_tool ? $current_tool['name'] . ' | ' . SITE_NAME : SITE_NAME . ' - ' . SITE_TAGLINE;
$page_desc = $current_tool ? $current_tool['desc'] : SITE_TAGLINE;
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $page_desc; ?>">
    
    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?php echo $page_title; ?>">
    <meta property="og:description" content="<?php echo $page_desc; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:image" content="<?php echo SITE_URL; ?>/assets/img/og-image.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

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
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/custom.css">
    
    <style>
        .glass {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .tool-card:hover {
            transform: translateY(-4px);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-950 text-gray-100 font-sans selection:bg-indigo-500/30">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 glass">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <a href="<?php echo SITE_URL; ?>" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                            <i data-lucide="layers" class="w-5 h-5 text-white"></i>
                        </div>
                        <span class="text-xl font-heading font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-cyan-400">
                            <?php echo SITE_NAME; ?>
                        </span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                    <?php foreach ($TOOL_CATEGORIES as $cat_id => $category): ?>
                    <div class="relative group">
                        <button class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800/50 flex items-center gap-1">
                            <?php echo $category['name']; ?>
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </button>
                        <div class="absolute left-0 mt-2 w-56 rounded-xl shadow-2xl bg-gray-900 border border-gray-800 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-2 z-50">
                            <div class="py-2 grid grid-cols-1 gap-1 px-1">
                                <?php foreach ($category['tools'] as $tool_id => $tool): ?>
                                <a href="<?php echo SITE_URL; ?>/tools/<?php echo $cat_id; ?>/<?php echo $tool_id; ?>" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg">
                                    <i data-lucide="file-text" class="w-4 h-4 opacity-50"></i>
                                    <?php echo $tool['name']; ?>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Search & Actions -->
                <div class="flex items-center gap-4">
                    <div class="relative hidden sm:block">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="w-4 h-4 text-gray-500"></i>
                        </div>
                        <input type="text" id="global-search" class="block w-full pl-10 pr-3 py-1.5 border border-gray-800 rounded-full bg-gray-900/50 text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Search tools...">
                    </div>
                    
                    <button id="theme-toggle" class="p-2 rounded-full hover:bg-gray-800/50 transition-colors">
                        <i data-lucide="moon" class="w-5 h-5 text-gray-400"></i>
                    </button>

                    <!-- Mobile Menu Button -->
                    <div class="flex md:hidden">
                        <button id="mobile-menu-btn" class="p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-800/50">
                            <i data-lucide="menu" class="w-6 h-6"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden border-t border-gray-800 bg-gray-950/95 overflow-y-auto max-h-[80vh]">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <?php foreach ($TOOL_CATEGORIES as $cat_id => $category): ?>
                <div class="px-3 py-2">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2"><?php echo $category['name']; ?></div>
                    <div class="grid grid-cols-1 gap-1">
                        <?php foreach ($category['tools'] as $tool_id => $tool): ?>
                        <a href="<?php echo SITE_URL; ?>/tools/<?php echo $cat_id; ?>/<?php echo $tool_id; ?>" class="flex items-center gap-2 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-800">
                            <i data-lucide="file-text" class="w-4 h-4 opacity-50"></i>
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
