<?php require_once 'includes/header.php'; ?>

<style>
    .glass-card { 
        background: rgba(255, 255, 255, 0.7); 
        backdrop-filter: blur(12px); 
        border: 1px solid rgba(0, 0, 0, 0.05); 
    }
    .dark .glass-card { 
        background: rgba(255, 255, 255, 0.03); 
        border: 1px solid rgba(255, 255, 255, 0.05); 
    }
    .glow-rose { box-shadow: 0 0 50px -12px rgba(244, 63, 94, 0.4); }
    .hover-glow:hover { 
        box-shadow: 0 0 30px -5px rgba(244, 63, 94, 0.3); 
        transform: translateY(-4px); 
    }
</style>

<div class="bg-white dark:bg-[#050505] text-slate-900 dark:text-slate-200 selection:bg-rose-500/30 transition-colors duration-300">

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-rose-600/10 rounded-full blur-[120px] -z-10"></div>
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs font-bold uppercase tracking-wider mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                </span>
                For Creators & Influencers
            </div>
            <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 dark:text-white mb-6 leading-tight">
                Grow Faster with <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-400 to-pink-400">Free Creator Tools</span>
            </h1>
            <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                Unlock viral growth for your YouTube channel and Instagram profile. Professional SEO and optimization tools, completely free.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#tools" class="px-8 py-4 bg-rose-600 text-white rounded-2xl font-bold shadow-xl shadow-rose-600/20 hover:bg-rose-700 transition-all flex items-center justify-center gap-2">
                    Start Growing Today <i data-lucide="zap" class="w-5 h-5"></i>
                </a>
                <a href="<?php echo SITE_URL; ?>" class="px-8 py-4 glass-card text-slate-900 dark:text-white rounded-2xl font-bold hover:bg-white/5 transition-all">Free Forever</a>
            </div>
        </div>
    </section>

    <!-- Tools Section -->
    <section id="tools" class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Content Optimization Suite</h2>
                    <p class="text-slate-600 dark:text-slate-400">Everything you need to beat the algorithm and increase your reach.</p>
                </div>
                <div class="text-sm font-medium text-rose-400 flex items-center gap-2">
                    <i data-lucide="trending-up" class="w-4 h-4"></i> Used by Top Creators
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Tool Card 1 -->
                <a href="<?php echo SITE_URL; ?>/tools/youtube/yt-tags" class="group p-8 rounded-[2rem] glass-card hover-glow transition-all">
                    <div class="w-14 h-14 bg-rose-500/10 rounded-2xl flex items-center justify-center text-rose-500 mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="tag" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">YouTube Tag Extractor</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">Spy on your competitors. Extract hidden SEO tags from any viral video instantly.</p>
                    <span class="text-xs font-bold text-rose-400 flex items-center gap-2 uppercase tracking-widest">Spy Now <i data-lucide="chevron-right" class="w-4 h-4"></i></span>
                </a>

                <!-- Tool Card 2 -->
                <a href="<?php echo SITE_URL; ?>/tools/text/case-converter" class="group p-8 rounded-[2rem] glass-card hover-glow transition-all">
                    <div class="w-14 h-14 bg-pink-500/10 rounded-2xl flex items-center justify-center text-pink-500 mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="sparkles" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Viral Title Generator</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">Format your titles for maximum CTR using Title Case or UPPERCASE effects.</p>
                    <span class="text-xs font-bold text-pink-400 flex items-center gap-2 uppercase tracking-widest">Format <i data-lucide="chevron-right" class="w-4 h-4"></i></span>
                </a>

                <!-- Tool Card 3 -->
                <a href="<?php echo SITE_URL; ?>/tools/youtube/yt-thumbnail" class="group p-8 rounded-[2rem] glass-card hover-glow transition-all">
                    <div class="w-14 h-14 bg-orange-500/10 rounded-2xl flex items-center justify-center text-orange-500 mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="download" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Thumbnail Downloader</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">Get inspiration. Download high-resolution thumbnails from any YouTube video URL.</p>
                    <span class="text-xs font-bold text-orange-400 flex items-center gap-2 uppercase tracking-widest">Download <i data-lucide="chevron-right" class="w-4 h-4"></i></span>
                </a>

                <!-- Tool Card 4 -->
                <a href="<?php echo SITE_URL; ?>/tools/text/insta-fonts" class="group p-8 rounded-[2rem] glass-card hover-glow transition-all">
                    <div class="w-14 h-14 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-500 mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="instagram" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Hashtag & Bio Fonts</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">Generate stylish fonts and trending hashtags for your Instagram bio and posts.</p>
                    <span class="text-xs font-bold text-indigo-400 flex items-center gap-2 uppercase tracking-widest">Stylish <i data-lucide="chevron-right" class="w-4 h-4"></i></span>
                </a>
            </div>
        </div>
    </section>

    <!-- Benefits -->
    <section class="py-20 bg-white/[0.02]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="flex gap-6">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-rose-500/10 flex items-center justify-center text-rose-500">
                        <i data-lucide="rocket" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Increase Reach</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Optimize your metadata to rank higher in search and suggested video feeds.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-pink-500/10 flex items-center justify-center text-pink-500">
                        <i data-lucide="clock" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Save Hours Weekly</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Automate tedious research tasks so you can focus on creating more content.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-orange-500/10 flex items-center justify-center text-orange-500">
                        <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Optimize Everything</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400">From tags to titles, ensure every post is perfectly tuned for the platform.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="bg-gradient-to-br from-rose-600 to-pink-700 rounded-[3rem] p-16 relative overflow-hidden group shadow-2xl">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
                <div class="relative z-10">
                    <h2 class="text-4xl md:text-6xl font-black text-slate-900 dark:text-white mb-8 tracking-tight">Ready to go viral?</h2>
                    <p class="text-rose-100 text-xl mb-12 max-w-2xl mx-auto">Join thousands of creators using BulkTools to dominate their niche.</p>
                    <a href="<?php echo SITE_URL; ?>" class="px-12 py-6 bg-white text-rose-600 rounded-[2rem] font-black hover:scale-105 transition-all shadow-2xl inline-flex items-center gap-3 uppercase tracking-widest text-lg">
                        Get Instant Access <i data-lucide="arrow-right" class="w-6 h-6"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>

<?php require_once 'includes/footer.php'; ?>
