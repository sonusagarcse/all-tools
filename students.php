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
    .glow-purple { box-shadow: 0 0 50px -12px rgba(168, 85, 247, 0.4); }
    .hover-glow:hover { 
        box-shadow: 0 0 30px -5px rgba(168, 85, 247, 0.3); 
        transform: translateY(-4px); 
    }
</style>

<div class="bg-white dark:bg-[#050505] text-slate-900 dark:text-slate-200 selection:bg-purple-500/30 transition-colors duration-300">

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-purple-600/10 rounded-full blur-[120px] -z-10"></div>
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-500/10 border border-purple-500/20 text-purple-400 text-xs font-bold uppercase tracking-wider mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                </span>
                For Modern Learners
            </div>
            <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 dark:text-white mb-6 leading-tight">
                Free Tools Every <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400">Student Needs</span>
            </h1>
            <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                Save time, improve productivity, and crush your academic goals. All essential student utilities in one fast, privacy-focused platform.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#tools" class="px-8 py-4 bg-purple-600 text-slate-900 dark:text-white rounded-2xl font-bold shadow-xl shadow-purple-600/20 hover:bg-purple-700 transition-all flex items-center justify-center gap-2">
                    Start Using Free Tools <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
                <a href="<?php echo SITE_URL; ?>" class="px-8 py-4 glass-card text-slate-900 dark:text-white rounded-2xl font-bold hover:bg-white/5 transition-all">View All 40+ Tools</a>
            </div>
        </div>
    </section>

    <!-- Tools Section -->
    <section id="tools" class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Essential Student Utilities</h2>
                    <p class="text-slate-600 dark:text-slate-400">Handpicked tools to help you manage your studies efficiently.</p>
                </div>
                <div class="text-sm font-medium text-purple-400">Updated for 2026 Academic Year</div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Tool Card 1 -->
                <a href="<?php echo SITE_URL; ?>/tools/text/text-editor" class="group p-8 rounded-[2rem] glass-card hover-glow transition-all">
                    <div class="w-14 h-14 bg-purple-500/10 rounded-2xl flex items-center justify-center text-purple-500 mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="file-edit" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Online Text Editor</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">A clean, distraction-free rich text editor with auto-save for your essays and notes.</p>
                    <span class="text-xs font-bold text-purple-400 flex items-center gap-2 uppercase tracking-widest">Try Now <i data-lucide="chevron-right" class="w-4 h-4"></i></span>
                </a>

                <!-- Tool Card 2 -->
                <a href="<?php echo SITE_URL; ?>/tools/finance/percentage-calculator" class="group p-8 rounded-[2rem] glass-card hover-glow transition-all">
                    <div class="w-14 h-14 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-500 mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="percent" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Percentage Calc</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">Calculate grades, marks percentages, and increases instantly without errors.</p>
                    <span class="text-xs font-bold text-blue-400 flex items-center gap-2 uppercase tracking-widest">Try Now <i data-lucide="chevron-right" class="w-4 h-4"></i></span>
                </a>

                <!-- Tool Card 3 -->
                <a href="<?php echo SITE_URL; ?>/tools/time/age-calculator" class="group p-8 rounded-[2rem] glass-card hover-glow transition-all">
                    <div class="w-14 h-14 bg-pink-500/10 rounded-2xl flex items-center justify-center text-pink-500 mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="calendar" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Age Calculator</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">Need your exact age for exam forms? Get it in years, months, and days instantly.</p>
                    <span class="text-xs font-bold text-pink-400 flex items-center gap-2 uppercase tracking-widest">Try Now <i data-lucide="chevron-right" class="w-4 h-4"></i></span>
                </a>

                <!-- Tool Card 4 -->
                <a href="<?php echo SITE_URL; ?>/tools/text/resume-builder" class="group p-8 rounded-[2rem] glass-card hover-glow transition-all">
                    <div class="w-14 h-14 bg-cyan-500/10 rounded-2xl flex items-center justify-center text-cyan-500 mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="file-text" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Resume Builder</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">Create a professional, ATS-friendly resume in minutes. Export to high-quality PDF.</p>
                    <span class="text-xs font-bold text-cyan-400 flex items-center gap-2 uppercase tracking-widest">Try Now <i data-lucide="chevron-right" class="w-4 h-4"></i></span>
                </a>
            </div>
        </div>
    </section>

    <!-- Benefits -->
    <section class="py-20 bg-white/[0.02]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="flex gap-6">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-green-500/10 flex items-center justify-center text-green-500">
                        <i data-lucide="check-circle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">No Login Required</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Start using any tool instantly. We don't ask for your email or personal data.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-yellow-500/10 flex items-center justify-center text-yellow-500">
                        <i data-lucide="unlock" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">100% Free Forever</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400">No hidden subscriptions or "Pro" features. All tools are fully unlocked for students.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                        <i data-lucide="zap" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Fast & Secure</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Blazing fast processing with end-to-end encryption for your sensitive documents.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Proof -->
    <section class="py-20">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <div class="flex justify-center -space-x-3 mb-6">
                <img src="https://ui-avatars.com/api/?name=S&background=random" class="w-12 h-12 rounded-full border-2 border-black" alt="User">
                <img src="https://ui-avatars.com/api/?name=A&background=random" class="w-12 h-12 rounded-full border-2 border-black" alt="User">
                <img src="https://ui-avatars.com/api/?name=R&background=random" class="w-12 h-12 rounded-full border-2 border-black" alt="User">
                <div class="w-12 h-12 rounded-full bg-purple-600 flex items-center justify-center text-xs font-bold border-2 border-black text-slate-900 dark:text-white">+10k</div>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2 italic">"Used by 10,000+ students across India to simplify their daily academic tasks."</h3>
            <p class="text-slate-500 font-medium">Join the growing community of productive learners.</p>
        </div>
    </section>

    <!-- Footer CTA -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-[3rem] p-12 text-center relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20 group-hover:scale-110 transition-transform duration-700"></div>
                <h2 class="text-4xl font-extrabold text-slate-900 dark:text-white mb-6 relative z-10">Boost your productivity today</h2>
                <p class="text-purple-100 mb-10 text-lg relative z-10">Stop searching for tools. BulkTools has everything you need in one place.</p>
                <a href="<?php echo SITE_URL; ?>" class="px-10 py-5 bg-white text-purple-600 rounded-2xl font-black shadow-2xl hover:scale-105 transition-all relative z-10 inline-block uppercase tracking-wider">
                    Get Free Tools Access
                </a>
            </div>
        </div>
    </section>

</div>

<?php require_once 'includes/footer.php'; ?>
