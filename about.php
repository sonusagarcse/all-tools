<?php
require_once __DIR__ . '/includes/header.php';
$year_founded = 2024;
$tools_count = 0;
foreach ($TOOL_CATEGORIES as $cat) $tools_count += count($cat['tools']);
?>

<!-- Hero -->
<section class="relative pt-24 pb-16 overflow-hidden bg-gradient-to-br from-slate-50 to-white dark:from-gray-950 dark:to-gray-900 border-b border-slate-200 dark:border-gray-900">
    <div class="absolute inset-0 pointer-events-none overflow-hidden -z-0">
        <div class="absolute -top-24 -left-24 w-80 h-80 bg-indigo-400/15 dark:bg-indigo-600/10 rounded-full blur-[100px] animate-blob"></div>
        <div class="absolute top-20 right-0 w-64 h-64 bg-purple-400/10 dark:bg-purple-600/10 rounded-full blur-[80px] animate-blob" style="animation-delay:2s"></div>
    </div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-xs font-bold uppercase tracking-widest mb-5">
            <i data-lucide="info" class="w-3.5 h-3.5"></i> About BulkTools
        </div>
        <h1 class="text-4xl md:text-6xl font-heading font-extrabold text-slate-900 dark:text-white mb-5 leading-tight">
            Built for Everyone.<br><span class="gradient-text">Powered by Simplicity.</span>
        </h1>
        <p class="text-slate-600 dark:text-gray-400 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
            BulkTools is a free, privacy-first collection of professional utility tools designed to make your digital life easier — no sign-up, no paywalls, just results.
        </p>
    </div>
</section>

<!-- Mission -->
<section class="py-20 bg-white dark:bg-gray-950">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-14 items-center">
            <div>
                <h2 class="text-3xl font-heading font-extrabold text-slate-900 dark:text-white mb-5">Our Mission</h2>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed mb-5">
                    We believe that the best utility tools should be free — truly free, without ads, tracking, or upsells. BulkTools was built out of frustration with bloated, slow, and privacy-invasive online tools that demanded email sign-ups just to resize a photo or count words.
                </p>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed mb-5">
                    Our mission is simple: build a curated, high-quality toolbox that works instantly in the browser, respects your privacy, and keeps improving based on what users actually need.
                </p>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed">
                    Every tool on BulkTools is carefully designed, mobile-ready, and optimized for speed — whether you're a student, developer, designer, marketer, or just someone who needs to get things done quickly.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <?php
                $highlights = [
                    ['val' => $tools_count . '+', 'label' => 'Free Tools', 'icon' => 'tool', 'color' => 'indigo'],
                    ['val' => '100%', 'label' => 'Free Forever', 'icon' => 'gift', 'color' => 'emerald'],
                    ['val' => '0', 'label' => 'Ads / Trackers', 'icon' => 'eye-off', 'color' => 'orange'],
                    ['val' => $year_founded, 'label' => 'Year Founded', 'icon' => 'calendar', 'color' => 'purple'],
                ];
                $colors = [
                    'indigo' => 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border-indigo-100 dark:border-indigo-500/20',
                    'emerald' => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-100 dark:border-emerald-500/20',
                    'orange' => 'bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-400 border-orange-100 dark:border-orange-500/20',
                    'purple' => 'bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 border-purple-100 dark:border-purple-500/20',
                ];
                foreach ($highlights as $h):
                    $cls = $colors[$h['color']];
                ?>
                <div class="p-6 rounded-2xl border glass-card text-center">
                    <div class="w-12 h-12 <?php echo $cls; ?> border rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="<?php echo $h['icon']; ?>" class="w-6 h-6"></i>
                    </div>
                    <div class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1"><?php echo $h['val']; ?></div>
                    <div class="text-slate-500 dark:text-gray-400 text-xs font-semibold uppercase tracking-wider"><?php echo $h['label']; ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="py-20 bg-slate-50 dark:bg-gray-900/30 border-t border-slate-100 dark:border-gray-900">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-heading font-extrabold text-slate-900 dark:text-white mb-3">What We Stand For</h2>
            <p class="text-slate-500 dark:text-gray-400">The principles that guide every tool we build.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $values = [
                ['icon' => 'shield-check', 'title' => 'Privacy First', 'desc' => 'Your files and data are never stored, analyzed, or shared. Browser-based tools never touch our servers at all.', 'color' => 'green'],
                ['icon' => 'gift', 'title' => 'Always Free', 'desc' => 'No subscriptions, credits, or paywalls. Every tool on BulkTools is free to use as many times as you need.', 'color' => 'indigo'],
                ['icon' => 'zap', 'title' => 'Built for Speed', 'desc' => 'Optimized for performance. Most tools deliver results in under a second with zero loading screens.', 'color' => 'yellow'],
                ['icon' => 'smartphone', 'title' => 'Works Everywhere', 'desc' => 'Fully responsive and tested on desktop, tablet, and mobile devices across all major browsers.', 'color' => 'sky'],
                ['icon' => 'user-x', 'title' => 'No Registration', 'desc' => 'Use any tool anonymously without creating an account or providing any personal information.', 'color' => 'purple'],
                ['icon' => 'refresh-cw', 'title' => 'Always Improving', 'desc' => 'We continuously add new tools, fix bugs, and improve existing tools based on user feedback.', 'color' => 'emerald'],
            ];
            $val_colors = [
                'green' => 'bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 border-green-100 dark:border-green-500/20',
                'indigo' => 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border-indigo-100 dark:border-indigo-500/20',
                'yellow' => 'bg-yellow-50 dark:bg-yellow-500/10 text-yellow-600 dark:text-yellow-400 border-yellow-100 dark:border-yellow-500/20',
                'sky' => 'bg-sky-50 dark:bg-sky-500/10 text-sky-600 dark:text-sky-400 border-sky-100 dark:border-sky-500/20',
                'purple' => 'bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 border-purple-100 dark:border-purple-500/20',
                'emerald' => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-100 dark:border-emerald-500/20',
            ];
            foreach ($values as $v):
                $vcls = $val_colors[$v['color']];
            ?>
            <div class="glass-card p-6 rounded-2xl border border-slate-200 dark:border-gray-800">
                <div class="w-11 h-11 <?php echo $vcls; ?> border rounded-xl flex items-center justify-center mb-4">
                    <i data-lucide="<?php echo $v['icon']; ?>" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-slate-900 dark:text-white mb-2"><?php echo $v['title']; ?></h3>
                <p class="text-sm text-slate-500 dark:text-gray-400 leading-relaxed"><?php echo $v['desc']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-white dark:bg-gray-950 border-t border-slate-100 dark:border-gray-900">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-heading font-extrabold text-slate-900 dark:text-white mb-4">Ready to Get Started?</h2>
        <p class="text-slate-500 dark:text-gray-400 text-lg mb-8">Explore our complete collection of free tools and supercharge your workflow today.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo SITE_URL; ?>" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-2xl bg-indigo-600 text-white font-bold hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-500/25 text-sm">
                <i data-lucide="layers" class="w-4 h-4"></i> Explore All Tools
            </a>
            <a href="<?php echo SITE_URL; ?>/contact" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-2xl border border-slate-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-slate-900 dark:text-white font-bold hover:bg-slate-50 dark:hover:bg-gray-800 transition-all text-sm">
                <i data-lucide="mail" class="w-4 h-4"></i> Contact Us
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
