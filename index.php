<?php
require_once __DIR__ . '/includes/header.php';

// Count total tools dynamically
$total_tools = 0;
foreach ($TOOL_CATEGORIES as $cat) {
    $total_tools += count($cat['tools']);
}

// Category accent colors
$cat_accents = [
    'image' => ['bg' => 'bg-violet-500/10', 'text' => 'text-violet-500', 'border' => 'border-violet-500/20', 'hover_bg' => 'group-hover:bg-violet-500', 'glow' => 'rgba(139,92,246,0.3)', 'gradient' => 'from-violet-500 to-purple-600'],
    'text' => ['bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-500', 'border' => 'border-emerald-500/20', 'hover_bg' => 'group-hover:bg-emerald-500', 'glow' => 'rgba(16,185,129,0.3)', 'gradient' => 'from-emerald-500 to-teal-600'],
    'dev' => ['bg' => 'bg-sky-500/10', 'text' => 'text-sky-500', 'border' => 'border-sky-500/20', 'hover_bg' => 'group-hover:bg-sky-500', 'glow' => 'rgba(14,165,233,0.3)', 'gradient' => 'from-sky-500 to-cyan-600'],
    'sec' => ['bg' => 'bg-orange-500/10', 'text' => 'text-orange-500', 'border' => 'border-orange-500/20', 'hover_bg' => 'group-hover:bg-orange-500', 'glow' => 'rgba(249,115,22,0.3)', 'gradient' => 'from-orange-500 to-red-500'],
];
?>

<!-- ==================== HERO ==================== -->
<section class="relative min-h-[92vh] flex items-center bg-white dark:bg-gray-950 z-30">

    <!-- Animated Background Orbs -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none -z-10">
        <div
            class="hero-orb w-[500px] h-[500px] bg-indigo-400/20 dark:bg-indigo-600/15 top-[-10%] left-[-8%] animate-blob">
        </div>
        <div class="hero-orb w-[400px] h-[400px] bg-purple-400/20 dark:bg-purple-600/15 top-[30%] right-[-5%] animate-blob"
            style="animation-delay:2s"></div>
        <div class="hero-orb w-[350px] h-[350px] bg-cyan-400/15 dark:bg-cyan-600/10 bottom-[-10%] left-[30%] animate-blob"
            style="animation-delay:4s"></div>
        <!-- Floating Particles -->
        <div class="absolute top-[15%] left-[20%] w-2 h-2 bg-indigo-400 rounded-full animate-float opacity-50"></div>
        <div class="absolute top-[40%] right-[25%] w-1.5 h-1.5 bg-purple-400 rounded-full animate-float"
            style="animation-delay:1.5s; opacity:0.4"></div>
        <div class="absolute bottom-[25%] left-[15%] w-2.5 h-2.5 bg-cyan-400 rounded-full animate-float2"
            style="animation-delay:0.8s; opacity:0.35"></div>
        <div class="absolute top-[60%] right-[15%] w-1.5 h-1.5 bg-pink-400 rounded-full animate-float"
            style="animation-delay:3s; opacity:0.45"></div>
        <!-- Grid pattern -->
        <div class="absolute inset-0 opacity-[0.02] dark:opacity-[0.04]"
            style="background-image: linear-gradient(rgba(99,102,241,1) 1px, transparent 1px), linear-gradient(to right, rgba(99,102,241,1) 1px, transparent 1px); background-size: 40px 40px;">
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <!-- Left: Content -->
            <div>
                <!-- Live badge -->
                <div
                    class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/25 text-indigo-600 dark:text-indigo-400 text-xs font-bold uppercase tracking-wider mb-8 animate-fade-in shadow-sm">
                    <div
                        class="w-5 h-5 rounded-md bg-indigo-600 flex items-center justify-center text-white force-white p-1">
                        <i data-lucide="layout-grid" class="w-full h-full"></i>
                    </div>
                    <?php echo $total_tools; ?>+ Free Online Tools — No Login Required
                </div>

                <h1 class="text-5xl md:text-6xl lg:text-7xl font-heading font-extrabold text-slate-900 dark:text-white mb-6 tracking-tight leading-[1.08] animate-fade-in"
                    style="animation-delay:0.1s">
                    Powerful Tools,<br>
                    <span class="gradient-text">Zero Complexity.</span>
                </h1>

                <p class="text-slate-600 dark:text-gray-400 text-lg md:text-xl mb-10 leading-relaxed animate-fade-in font-medium max-w-xl"
                    style="animation-delay:0.2s">
                    Compress images, process text, format code, and generate secure passwords — all in one place. Fast,
                    free, and works right in your browser.
                </p>

                <!-- Search -->
                <div class="relative animate-fade-in mb-8 z-40" style="animation-delay:0.3s">
                    <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none">
                        <i data-lucide="search" class="w-5 h-5 text-slate-400 dark:text-gray-500"></i>
                    </div>
                    <input type="text" id="home-search" autocomplete="off"
                        class="block w-full pl-14 pr-28 py-4 rounded-2xl bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all shadow-lg shadow-slate-100 dark:shadow-none font-medium text-base"
                        placeholder="Search tools… e.g. Compress Image">
                    <div class="absolute right-3 top-1/2 -translate-y-1/2">
                        <kbd
                            class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-gray-800 text-slate-500 dark:text-gray-400 text-xs font-bold border border-slate-200 dark:border-gray-700">⌘K</kbd>
                    </div>
                    <div id="home-search-dropdown"
                        class="absolute left-0 right-0 mt-2 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl shadow-2xl overflow-hidden z-50 hidden text-left">
                    </div>
                </div>

                <!-- Trust Badges -->
                <div class="flex flex-wrap gap-3 animate-fade-in" style="animation-delay:0.4s">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-50 dark:bg-green-500/10 text-green-700 dark:text-green-400 text-xs font-bold border border-green-100 dark:border-green-500/20">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> 100% Secure
                    </span>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 text-xs font-bold border border-indigo-100 dark:border-indigo-500/20">
                        <i data-lucide="zap" class="w-3.5 h-3.5"></i> Instant Results
                    </span>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-purple-50 dark:bg-purple-500/10 text-purple-700 dark:text-purple-400 text-xs font-bold border border-purple-100 dark:border-purple-500/20">
                        <i data-lucide="user-x" class="w-3.5 h-3.5"></i> No Registration
                    </span>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-cyan-50 dark:bg-cyan-500/10 text-cyan-700 dark:text-cyan-400 text-xs font-bold border border-cyan-100 dark:border-cyan-500/20">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Auto File Deletion
                    </span>
                </div>
            </div>

            <!-- Right: Floating Tool Showcase -->
            <div class="hidden lg:flex items-center justify-center relative">
                <!-- Central ring -->
                <div class="relative w-72 h-72 flex items-center justify-center">
                    <div class="absolute inset-0 rounded-full animate-spin-slow"
                        style="border: 2px dashed rgba(99,102,241,0.2)"></div>
                    <div class="absolute inset-6 rounded-full animate-spin-slow"
                        style="border: 1px dashed rgba(139,92,246,0.15); animation-direction:reverse; animation-duration:16s">
                    </div>

                    <!-- Center logo -->
                    <div
                        class="relative w-28 h-28 rounded-3xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center shadow-2xl shadow-indigo-500/40 animate-float">
                        <i data-lucide="layers" class="w-14 h-14 text-white"></i>
                    </div>
                </div>

                <!-- Orbiting Tool Cards -->
                <?php
                $orbit_tools = [
                    ['icon' => 'image', 'label' => 'Compress Image', 'color' => 'indigo', 'pos' => '-top-4 left-1/2 -translate-x-1/2'],
                    ['icon' => 'type', 'label' => 'Word Counter', 'color' => 'emerald', 'pos' => 'top-1/2 -right-8 -translate-y-1/2'],
                    ['icon' => 'code-2', 'label' => 'JSON Formatter', 'color' => 'sky', 'pos' => '-bottom-4 left-1/2 -translate-x-1/2'],
                    ['icon' => 'shield', 'label' => 'Password Gen', 'color' => 'orange', 'pos' => 'top-1/2 -left-8 -translate-y-1/2'],
                ];
                $color_map = [
                    'indigo' => 'bg-indigo-50 dark:bg-indigo-600/15 text-indigo-600 dark:text-indigo-400 border-indigo-100 dark:border-indigo-500/20',
                    'emerald' => 'bg-emerald-50 dark:bg-emerald-600/15 text-emerald-600 dark:text-emerald-400 border-emerald-100 dark:border-emerald-500/20',
                    'sky' => 'bg-sky-50 dark:bg-sky-600/15 text-sky-600 dark:text-sky-400 border-sky-100 dark:border-sky-500/20',
                    'orange' => 'bg-orange-50 dark:bg-orange-600/15 text-orange-600 dark:text-orange-400 border-orange-100 dark:border-orange-500/20',
                ];
                foreach ($orbit_tools as $i => $ot): ?>
                    <div class="absolute <?php echo $ot['pos']; ?> glass-card px-4 py-3 rounded-2xl border flex items-center gap-3 shadow-xl animate-float <?php echo $color_map[$ot['color']]; ?>"
                        style="animation-delay:<?php echo $i * 0.8; ?>s">
                        <div
                            class="w-9 h-9 rounded-xl flex items-center justify-center <?php echo $color_map[$ot['color']]; ?> border">
                            <i data-lucide="<?php echo $ot['icon']; ?>" class="w-4 h-4"></i>
                        </div>
                        <span
                            class="text-xs font-bold text-slate-800 dark:text-white whitespace-nowrap"><?php echo $ot['label']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ==================== STATS ==================== -->
<section class="border-y border-slate-100 dark:border-gray-900 bg-white/80 dark:bg-gray-950/80 backdrop-blur-lg py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-10">
            <?php
            $stats = [
                ['val' => '10M+', 'label' => 'Files Processed', 'icon' => 'files'],
                ['val' => $total_tools . '+', 'label' => 'Free Tools', 'icon' => 'tool'],
                ['val' => '100%', 'label' => 'Free Forever', 'icon' => 'badge-check'],
                ['val' => '24/7', 'label' => 'Always Online', 'icon' => 'activity'],
            ];
            foreach ($stats as $i => $s): ?>
                <div class="text-center reveal" style="transition-delay:<?php echo $i * 0.1; ?>s">
                    <div
                        class="inline-flex items-center justify-center w-12 h-12 bg-indigo-50 dark:bg-indigo-600/10 rounded-2xl text-indigo-600 dark:text-indigo-400 mb-3 mx-auto">
                        <i data-lucide="<?php echo $s['icon']; ?>" class="w-5 h-5"></i>
                    </div>
                    <div class="text-4xl font-heading font-extrabold stat-value mb-1"
                        data-count-target="<?php echo $s['val']; ?>"><?php echo $s['val']; ?></div>
                    <div class="text-slate-500 dark:text-gray-500 text-xs uppercase tracking-widest font-bold">
                        <?php echo $s['label']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==================== CATEGORIES ==================== -->
<section class="py-24 bg-gradient-to-b from-slate-50 to-white dark:from-gray-950 dark:to-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 reveal">
            <span
                class="inline-block px-4 py-1.5 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-xs font-bold uppercase tracking-widest rounded-full mb-4 border border-indigo-100 dark:border-indigo-500/20">Tool
                Categories</span>
            <h2 class="text-4xl md:text-5xl font-heading font-extrabold text-slate-900 dark:text-white mb-4">Everything
                You Need,<br><span class="gradient-text">Neatly Organized</span></h2>
            <p class="text-slate-500 dark:text-gray-400 text-lg max-w-2xl mx-auto">From image editing to developer
                utilities — browse tools by category and find exactly what you're looking for.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($TOOL_CATEGORIES as $cat_id => $category):
                $acc = $cat_accents[$cat_id] ?? $cat_accents['image'];
                $tool_count = count($category['tools']);
                ?>
                <a href="#<?php echo $cat_id; ?>"
                    class="cat-card glass-card p-8 rounded-3xl group flex flex-col items-center text-center reveal"
                    style="transition-delay:<?php echo (array_search($cat_id, array_keys($TOOL_CATEGORIES)) * 0.1); ?>s">
                    <div
                        class="w-16 h-16 <?php echo $acc['bg']; ?> border <?php echo $acc['border']; ?> rounded-2xl flex items-center justify-center <?php echo $acc['text']; ?> mb-5 <?php echo $acc['hover_bg']; ?> group-hover:text-white group-hover:scale-110 transition-all duration-300 group-hover:shadow-lg">
                        <i data-lucide="<?php echo $category['icon']; ?>" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-slate-900 dark:text-white mb-2">
                        <?php echo $category['name']; ?></h3>
                    <p class="text-sm text-slate-500 dark:text-gray-400 leading-relaxed mb-6 flex-grow">
                        <?php echo $tool_count; ?> powerful tools built to supercharge your productivity.
                    </p>
                    <div
                        class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest <?php echo $acc['text']; ?> group-hover:gap-3 transition-all animate-bounce-x">
                        Explore <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==================== TOOLS GRID ==================== -->
<?php $section_idx = 0;
foreach ($TOOL_CATEGORIES as $cat_id => $category):
    $acc = $cat_accents[$cat_id] ?? $cat_accents['image'];
    $alt_bg = ($section_idx % 2 === 0) ? 'bg-white dark:bg-gray-950' : 'bg-slate-50 dark:bg-gray-900/30';
    $section_idx++;
    ?>
    <section id="<?php echo $cat_id; ?>"
        class="py-24 category-section border-t border-slate-100 dark:border-gray-900 <?php echo $alt_bg; ?> relative overflow-hidden">
        <!-- Decorative BG Orb -->
        <div
            class="absolute -top-20 -right-20 w-80 h-80 <?php echo $acc['bg']; ?> rounded-full blur-[100px] opacity-50 pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14 reveal">
                <div class="flex items-center gap-4">
                    <div
                        class="p-3 <?php echo $acc['bg']; ?> border <?php echo $acc['border']; ?> rounded-2xl <?php echo $acc['text']; ?> shadow-sm">
                        <i data-lucide="<?php echo $category['icon']; ?>" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest <?php echo $acc['text']; ?> mb-1">
                            <?php echo count($category['tools']); ?> tools available</p>
                        <h2 class="text-3xl md:text-4xl font-heading font-extrabold text-slate-900 dark:text-white">
                            <?php echo $category['name']; ?></h2>
                    </div>
                </div>
            </div>

            <!-- Tool Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                <?php foreach ($category['tools'] as $tool_id => $tool): ?>
                    <div class="tool-card glass-card rounded-2xl flex flex-col h-full border border-slate-200 dark:border-gray-800 reveal"
                        style="transition-delay:0.05s">
                        <div class="p-6 flex flex-col h-full">
                            <div
                                class="w-11 h-11 <?php echo $acc['bg']; ?> border <?php echo $acc['border']; ?> rounded-xl flex items-center justify-center <?php echo $acc['text']; ?> mb-4 group-hover:scale-110 transition-transform">
                                <i data-lucide="<?php echo $category['icon']; ?>" class="w-5 h-5"></i>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2"><?php echo $tool['name']; ?>
                            </h3>
                            <p class="text-slate-500 dark:text-gray-400 text-sm mb-6 flex-grow leading-relaxed">
                                <?php echo $tool['desc']; ?></p>
                            <a href="<?php echo SITE_URL; ?>/tools/<?php echo $cat_id; ?>/<?php echo $tool_id; ?>"
                                class="block w-full py-2.5 px-4 rounded-xl border border-slate-200 dark:border-gray-700 bg-slate-50 dark:bg-gray-800/60 text-slate-900 dark:text-white text-sm font-bold text-center hover:bg-gradient-to-r hover:<?php echo str_replace('/10', '', $acc['bg']); ?> hover:text-white hover:border-transparent transition-all duration-200 group">
                                Use Tool <span class="ml-1 group-hover:ml-2 transition-all">→</span>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endforeach; ?>

<!-- ==================== NO RESULTS ==================== -->
<section id="no-results" class="py-24 hidden bg-white dark:bg-gray-950 text-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div
            class="p-16 rounded-[40px] border-2 border-dashed border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-900/30">
            <div
                class="w-20 h-20 bg-slate-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="search-x" class="w-10 h-10 text-slate-400 dark:text-gray-500"></i>
            </div>
            <h2 class="text-3xl font-heading font-extrabold text-slate-900 dark:text-white mb-4">No tools found matching
                your search.</h2>
            <p class="text-slate-500 dark:text-gray-400 text-lg mb-8">Try searching for something else, like "compress"
                or "json".</p>
            <button onclick="clearSearch()"
                class="px-7 py-3 rounded-2xl bg-indigo-600 text-white font-bold hover:bg-indigo-500 transition-all shadow-lg hover:shadow-indigo-500/30">
                Clear Search
            </button>
        </div>
    </div>
</section>

<!-- ==================== HOW IT WORKS ==================== -->
<section
    class="py-28 bg-white dark:bg-gray-950 border-t border-slate-100 dark:border-gray-900 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none -z-0">
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-1 bg-gradient-to-r from-transparent via-indigo-500/30 to-transparent">
        </div>
    </div>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-20 reveal">
            <span
                class="inline-block px-4 py-1.5 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-xs font-bold uppercase tracking-widest rounded-full mb-4 border border-indigo-100 dark:border-indigo-500/20">Simple
                Process</span>
            <h2 class="text-4xl md:text-5xl font-heading font-extrabold text-slate-900 dark:text-white mb-4">How It
                <span class="gradient-text">Works</span></h2>
            <p class="text-slate-500 dark:text-gray-400 text-lg max-w-2xl mx-auto">Three simple steps is all it takes —
                no manuals, no tutorials, no waiting.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            <!-- Connector lines for desktop -->
            <div class="hidden md:block absolute top-16 left-1/3 right-1/3 h-0.5 bg-gradient-to-r from-indigo-200 to-indigo-200 dark:from-indigo-800 dark:to-indigo-800"
                style="top:56px"></div>

            <?php
            $steps = [
                ['icon' => 'upload-cloud', 'title' => 'Upload or Paste', 'desc' => 'Choose your file or paste your text directly into the tool. No account needed — just open and go.', 'num' => '01', 'color' => 'bg-indigo-600'],
                ['icon' => 'cpu', 'title' => 'Instant Processing', 'desc' => 'Our high-performance server processes your request in milliseconds using optimized, battle-tested libraries.', 'num' => '02', 'color' => 'bg-purple-600'],
                ['icon' => 'download-cloud', 'title' => 'Download & Done', 'desc' => 'Get your result immediately. Files are auto-deleted from our servers within minutes for your privacy.', 'num' => '03', 'color' => 'bg-cyan-600'],
            ];
            foreach ($steps as $i => $step): ?>
                <div class="relative text-center px-4 reveal" style="transition-delay:<?php echo $i * 0.15; ?>s">
                    <div class="relative inline-block mb-8">
                        <div class="icon-ring">
                            <div
                                class="w-24 h-24 <?php echo $step['color']; ?>/10 rounded-full flex items-center justify-center mx-auto border border-indigo-100 dark:border-gray-800 bg-white dark:bg-gray-950 shadow-xl">
                                <i data-lucide="<?php echo $step['icon']; ?>"
                                    class="w-10 h-10 text-indigo-500 dark:text-indigo-400"></i>
                            </div>
                        </div>
                        <div
                            class="absolute -top-2 -right-2 w-9 h-9 <?php echo $step['color']; ?> rounded-full flex items-center justify-center text-white text-xs font-black shadow-lg">
                            <?php echo $step['num']; ?></div>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-slate-900 dark:text-white mb-3">
                        <?php echo $step['title']; ?></h3>
                    <p class="text-slate-500 dark:text-gray-400 text-sm leading-relaxed"><?php echo $step['desc']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==================== FEATURES ==================== -->
<section class="py-28 bg-slate-50 dark:bg-gray-900/40 border-t border-slate-100 dark:border-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-20 items-center">

            <!-- Left -->
            <div class="reveal-left">
                <span
                    class="inline-block px-4 py-1.5 bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 text-xs font-bold uppercase tracking-widest rounded-full mb-5 border border-purple-100 dark:border-purple-500/20">Why
                    BulkTools?</span>
                <h2 class="text-4xl md:text-5xl font-heading font-extrabold text-slate-900 dark:text-white mb-6">Built
                    for Speed,<br><span class="gradient-text">Designed for Everyone</span></h2>
                <p class="text-slate-600 dark:text-gray-400 text-lg leading-relaxed mb-8">
                    BulkTools is a curated collection of high-quality utility tools for professionals, students,
                    developers, and designers alike. No ads, no paywalls, no clutter.
                </p>
                <a href="#image"
                    class="inline-flex items-center gap-2 px-7 py-3.5 rounded-2xl bg-indigo-600 text-white force-white font-bold hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:gap-3">
                    Explore All Tools <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <!-- Right: Feature Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 reveal-right">
                <?php
                $features = [
                    ['icon' => 'zap', 'title' => 'Lightning Fast', 'desc' => 'Results in under a second. No loading screens, no waiting.', 'color' => 'bg-yellow-50 dark:bg-yellow-500/10 text-yellow-600 dark:text-yellow-400 border-yellow-100 dark:border-yellow-500/20'],
                    ['icon' => 'lock', 'title' => 'Private & Secure', 'desc' => 'Files are deleted automatically. We never store or share your data.', 'color' => 'bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 border-green-100 dark:border-green-500/20'],
                    ['icon' => 'smartphone', 'title' => 'Works on Any Device', 'desc' => 'Fully responsive on desktop, tablet, and mobile browsers.', 'color' => 'bg-sky-50 dark:bg-sky-500/10 text-sky-600 dark:text-sky-400 border-sky-100 dark:border-sky-500/20'],
                    ['icon' => 'gift', 'title' => 'Always Free', 'desc' => 'No subscriptions, no credits, no hidden charges. Ever.', 'color' => 'bg-pink-50 dark:bg-pink-500/10 text-pink-600 dark:text-pink-400 border-pink-100 dark:border-pink-500/20'],
                    ['icon' => 'refresh-cw', 'title' => 'Always Updated', 'desc' => 'New tools added regularly. We listen to user feedback.', 'color' => 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border-indigo-100 dark:border-indigo-500/20'],
                    ['icon' => 'globe', 'title' => 'Works Offline-Ready', 'desc' => 'Browser-based tools work even on slow connections.', 'color' => 'bg-violet-50 dark:bg-violet-500/10 text-violet-600 dark:text-violet-400 border-violet-100 dark:border-violet-500/20'],
                ];
                foreach ($features as $i => $f): ?>
                    <div class="glass-card p-5 rounded-2xl border flex items-start gap-4 reveal"
                        style="transition-delay:<?php echo $i * 0.08; ?>s">
                        <div
                            class="w-10 h-10 flex-shrink-0 rounded-xl flex items-center justify-center border <?php echo $f['color']; ?>">
                            <i data-lucide="<?php echo $f['icon']; ?>" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 dark:text-white text-sm mb-1"><?php echo $f['title']; ?>
                            </h4>
                            <p class="text-slate-500 dark:text-gray-400 text-xs leading-relaxed"><?php echo $f['desc']; ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ==================== TOOLS MARQUEE ==================== -->
<section class="py-12 bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600 overflow-hidden relative">
    <div class="absolute inset-0 opacity-10"
        style="background-image: linear-gradient(rgba(255,255,255,0.5) 1px, transparent 1px), linear-gradient(to right, rgba(255,255,255,0.5) 1px, transparent 1px); background-size: 30px 30px;">
    </div>
    <div class="overflow-hidden relative">
        <div class="marquee-inner gap-4 py-2">
            <?php
            $marquee_items = [];
            foreach ($TOOL_CATEGORIES as $cat_id => $category) {
                foreach ($category['tools'] as $tool_id => $tool) {
                    $marquee_items[] = ['name' => $tool['name'], 'icon' => $category['icon'], 'url' => SITE_URL . '/tools/' . $cat_id . '/' . $tool_id];
                }
            }
            // Duplicate for infinite scroll
            $marquee_double = array_merge($marquee_items, $marquee_items);
            ?>
            <?php foreach ($marquee_double as $item): ?>
                <a href="<?php echo $item['url']; ?>"
                    class="inline-flex items-center gap-2.5 px-5 py-2.5 bg-white/10 hover:bg-white/20 border border-white/20 rounded-full text-white force-white text-sm font-semibold whitespace-nowrap transition-all mr-4 hover:scale-105">
                    <i data-lucide="<?php echo $item['icon']; ?>" class="w-3.5 h-3.5 opacity-70"></i>
                    <?php echo $item['name']; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==================== FAQ ==================== -->
<section class="py-28 bg-white dark:bg-gray-950 border-t border-slate-100 dark:border-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 reveal">
            <span
                class="inline-block px-4 py-1.5 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-xs font-bold uppercase tracking-widest rounded-full mb-4 border border-emerald-100 dark:border-emerald-500/20">FAQ</span>
            <h2 class="text-4xl md:text-5xl font-heading font-extrabold text-slate-900 dark:text-white mb-4">Frequently
                Asked <span class="gradient-text">Questions</span></h2>
            <p class="text-slate-500 dark:text-gray-400 text-lg">Everything you need to know about BulkTools.</p>
        </div>

        <div class="space-y-1 reveal">
            <?php
            $faqs = [
                ['q' => 'Are all tools completely free?', 'a' => 'Yes! Every single tool on BulkTools is 100% free to use, forever. There are no hidden plans, no premium tiers, and no credit limits. We believe essential online tools should be accessible to everyone.'],
                ['q' => 'Do I need to create an account?', 'a' => 'No account, no email, no sign-up. You can use every tool on BulkTools anonymously. Simply open a tool, use it, and you\'re done. Your privacy is our top priority.'],
                ['q' => 'Are my files safe and private?', 'a' => 'Absolutely. Files you upload are processed on our secure servers and automatically deleted shortly after your session ends. We never store, share, or analyze your files or data.'],
                ['q' => 'What file formats do the Image Tools support?', 'a' => 'Our image tools support JPG/JPEG, PNG, and WebP formats. Each tool page lists the specific supported formats and the maximum file size allowed (typically 50MB).'],
                ['q' => 'Do the text and developer tools upload anything?', 'a' => 'No! Tools like the Word Counter, Case Converter, JSON Formatter, URL Encoder, and all Security Tools run entirely in your browser. No data is ever sent to our servers for these tools.'],
                ['q' => 'How often are new tools added?', 'a' => 'We continuously add new tools based on user requests and demand. You can check back regularly or subscribe to our newsletter to get notified when new tools launch.'],
            ];
            foreach ($faqs as $i => $faq): ?>
                <div class="faq-item py-5 cursor-pointer" onclick="toggleFaq(this)">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="font-bold text-slate-900 dark:text-white text-base"><?php echo $faq['q']; ?></h3>
                        <div
                            class="flex-shrink-0 w-8 h-8 bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/20 rounded-full flex items-center justify-center text-indigo-600 dark:text-indigo-400 faq-icon transition-transform duration-300">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <p class="text-slate-500 dark:text-gray-400 text-sm leading-relaxed pt-4 pr-12">
                            <?php echo $faq['a']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==================== CTA / NEWSLETTER ==================== -->
<section class="py-24 bg-slate-50 dark:bg-gray-950 border-t border-slate-100 dark:border-gray-900">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div
            class="relative glass-card rounded-[40px] p-10 md:p-20 text-center overflow-hidden border border-slate-200 dark:border-gray-800 shadow-2xl shadow-slate-200/30 dark:shadow-none reveal">
            <!-- Decorative glow elements -->
            <div
                class="absolute top-0 left-1/2 -translate-x-1/2 w-64 h-64 bg-indigo-500/15 dark:bg-indigo-500/25 rounded-full blur-[80px] -mt-20 pointer-events-none">
            </div>
            <div
                class="absolute bottom-0 right-0 w-48 h-48 bg-purple-500/10 dark:bg-purple-500/20 rounded-full blur-[60px] pointer-events-none">
            </div>

            <!-- Animated badge -->
            <div
                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/25 rounded-full text-indigo-600 dark:text-indigo-400 text-xs font-bold uppercase tracking-widest mb-7">
                <span class="relative flex h-2 w-2"><span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span><span
                        class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span></span>
                New Tools Launching Soon
            </div>

            <h2 class="text-3xl md:text-5xl font-heading font-extrabold text-slate-900 dark:text-white mb-5 relative">
                Stay in the Loop.<br><span class="gradient-text">Never Miss a Tool.</span>
            </h2>
            <p class="text-slate-600 dark:text-gray-400 text-lg mb-10 max-w-xl mx-auto leading-relaxed relative">
                Get notified when we release new tools, features, and productivity tips. Join thousands of users who
                rely on BulkTools daily.
            </p>

            <form class="max-w-md mx-auto flex flex-col sm:flex-row gap-3 relative" onsubmit="return false;">
                <input type="email" placeholder="Enter your email address"
                    class="flex-grow px-5 py-4 rounded-2xl bg-slate-50 dark:bg-gray-900 border border-slate-200 dark:border-gray-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm font-medium">
                <button type="submit"
                    class="px-7 py-4 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white force-white font-bold hover:from-indigo-500 hover:to-purple-500 transition-all shadow-xl shadow-indigo-500/30 hover:shadow-indigo-500/50 whitespace-nowrap text-sm">
                    Subscribe Free
                </button>
            </form>
            <p class="mt-5 text-slate-400 dark:text-gray-600 text-xs font-bold uppercase tracking-widest">No spam.
                Unsubscribe anytime.</p>
        </div>
    </div>
</section>

<!-- ==================== PAGE SCRIPTS ==================== -->
<script>
    // Scroll Reveal
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => {
        revealObserver.observe(el);
    });

    // CTRL+K focus search
    document.addEventListener('keydown', e => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            document.getElementById('home-search')?.focus();
        }
    });

    // FAQ accordion
    function toggleFaq(el) {
        const answer = el.querySelector('.faq-answer');
        const icon = el.querySelector('.faq-icon');
        const isOpen = answer.classList.contains('open');

        // Close all FAQs
        document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('open'));
        document.querySelectorAll('.faq-icon').forEach(i => {
            i.style.transform = '';
            i.querySelector('i')?.setAttribute('data-lucide', 'plus');
        });
        lucide.createIcons();

        if (!isOpen) {
            answer.classList.add('open');
            icon.style.transform = 'rotate(45deg)';
            icon.querySelector('i')?.setAttribute('data-lucide', 'x');
            lucide.createIcons();
        }
    }
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>