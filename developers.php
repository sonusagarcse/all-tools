<?php require_once 'includes/header.php'; ?>

<style>
    .mono { font-family: 'JetBrains Mono', monospace; }
    .glass-card { 
        background: rgba(255, 255, 255, 0.7); 
        backdrop-filter: blur(12px); 
        border: 1px solid rgba(0, 0, 0, 0.05); 
    }
    .dark .glass-card { 
        background: rgba(255, 255, 255, 0.02); 
        border: 1px solid rgba(255, 255, 255, 0.05); 
    }
    .glow-cyan { box-shadow: 0 0 50px -12px rgba(6, 182, 212, 0.4); }
    .hover-glow:hover { 
        box-shadow: 0 0 30px -5px rgba(6, 182, 212, 0.3); 
        transform: translateY(-4px); 
    }
    .code-bg { 
        background: linear-gradient(90deg, rgba(6, 182, 212, 0.05) 1px, transparent 1px), linear-gradient(rgba(6, 182, 212, 0.05) 1px, transparent 1px); 
        background-size: 40px 40px; 
    }
</style>

<div class="bg-white dark:bg-[#020617] text-slate-700 dark:text-slate-300 selection:bg-cyan-500/30 code-bg min-h-screen transition-colors duration-300">

    <!-- Hero Section -->
    <section class="relative pt-40 pb-32 overflow-hidden">
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-cyan-600/10 rounded-full blur-[120px] -z-10"></div>
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-xs font-bold uppercase tracking-widest mb-8 mono">
                v2.0.26 / stable build
            </div>
            <h1 class="text-5xl md:text-8xl font-extrabold text-slate-900 dark:text-white mb-8 leading-none tracking-tight">
                Powerful Dev Tools, <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">Zero Setup Required</span>
            </h1>
            <p class="text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto mb-12 leading-relaxed">
                A curated collection of essential utilities for the modern web developer. 100% client-side, blazing fast, and designed for productivity.
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="#tools" class="px-10 py-5 bg-white dark:bg-cyan-600 text-slate-900 dark:text-white rounded-xl font-bold hover:bg-slate-50 dark:hover:bg-cyan-500 transition-all flex items-center justify-center gap-2 shadow-2xl shadow-cyan-500/20">
                    Start Coding Smarter <i data-lucide="code-2" class="w-5 h-5"></i>
                </a>
                <div class="px-10 py-5 glass-card rounded-xl text-cyan-400 mono text-sm flex items-center gap-3 border border-cyan-500/20">
                    <span class="text-slate-600">$</span> brew install bulktools
                </div>
            </div>
        </div>
    </section>

    <!-- Tools Section -->
    <section id="tools" class="py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <h2 class="text-4xl font-bold text-slate-900 dark:text-white mb-6">Built for the Workflow</h2>
                    <p class="text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">Stop writing one-off scripts for common data tasks. Use our optimized utilities to format, encode, and debug in seconds.</p>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 text-sm text-cyan-500/80">
                            <i data-lucide="cpu" class="w-5 h-5"></i> 100% Browser Based
                        </div>
                        <div class="flex items-center gap-3 text-sm text-cyan-500/80">
                            <i data-lucide="shield-check" class="w-5 h-5"></i> No Data Leaves Your Device
                        </div>
                        <div class="flex items-center gap-3 text-sm text-cyan-500/80">
                            <i data-lucide="zap" class="w-5 h-5"></i> Sub-millisecond Latency
                        </div>
                    </div>
                </div>
                
                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tool Card 1 -->
                    <a href="<?php echo SITE_URL; ?>/tools/dev/json-formatter" class="group p-8 rounded-2xl glass-card hover-glow transition-all border border-white/5 hover:border-cyan-500/30">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-12 h-12 bg-cyan-500/10 rounded-lg flex items-center justify-center text-cyan-500">
                                <i data-lucide="braces" class="w-6 h-6"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 mono uppercase tracking-widest">Formatter</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 mono">JSON Formatter</h3>
                        <p class="text-sm text-slate-500 mb-6 leading-relaxed italic">// Pretty print, validate, and minify your JSON objects instantly.</p>
                        <div class="flex items-center gap-2 text-cyan-400 text-xs font-bold">
                            EXECUTE() <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </div>
                    </a>

                    <!-- Tool Card 2 -->
                    <a href="<?php echo SITE_URL; ?>/tools/text/base64-encode" class="group p-8 rounded-2xl glass-card hover-glow transition-all border border-white/5 hover:border-cyan-500/30">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-12 h-12 bg-blue-500/10 rounded-lg flex items-center justify-center text-blue-500">
                                <i data-lucide="binary" class="w-6 h-6"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 mono uppercase tracking-widest">Encoding</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 mono">Base64 Converter</h3>
                        <p class="text-sm text-slate-500 mb-6 leading-relaxed italic">// Encode/Decode strings and assets to Base64 format securely.</p>
                        <div class="flex items-center gap-2 text-blue-400 text-xs font-bold">
                            RUN_CONVERSION() <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </div>
                    </a>

                    <!-- Tool Card 3 -->
                    <a href="<?php echo SITE_URL; ?>/tools/dev/html-minifier" class="group p-8 rounded-2xl glass-card hover-glow transition-all border border-white/5 hover:border-cyan-500/30">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-12 h-12 bg-indigo-500/10 rounded-lg flex items-center justify-center text-indigo-500">
                                <i data-lucide="minimize-2" class="w-6 h-6"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 mono uppercase tracking-widest">Optimization</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 mono">Code Minifier</h3>
                        <p class="text-sm text-slate-500 mb-6 leading-relaxed italic">// Reduce bundle sizes by stripping whitespace and comments from HTML/CSS.</p>
                        <div class="flex items-center gap-2 text-indigo-400 text-xs font-bold">
                            OPTIMIZE.BUILD() <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </div>
                    </a>

                    <!-- Tool Card 4 -->
                    <a href="<?php echo SITE_URL; ?>/tools/dev/jwt-decoder" class="group p-8 rounded-2xl glass-card hover-glow transition-all border border-white/5 hover:border-cyan-500/30">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-12 h-12 bg-purple-500/10 rounded-lg flex items-center justify-center text-purple-500">
                                <i data-lucide="key" class="w-6 h-6"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 mono uppercase tracking-widest">Security</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 mono">JWT Decoder</h3>
                        <p class="text-sm text-slate-500 mb-6 leading-relaxed italic">// Inspect JSON Web Tokens safely. Unpack headers and payloads locally.</p>
                        <div class="flex items-center gap-2 text-purple-400 text-xs font-bold">
                            INSPECT_TOKEN() <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Tech Benefits -->
    <section class="py-20 bg-cyan-950/20 border-y border-white/5">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-16 text-center">
            <div>
                <div class="text-slate-900 dark:text-white text-4xl font-bold mb-4 mono">&lt;0.5ms</div>
                <p class="text-slate-500 text-sm uppercase tracking-widest font-bold">Execution Latency</p>
            </div>
            <div>
                <div class="text-slate-900 dark:text-white text-4xl font-bold mb-4 mono">0.0kb</div>
                <p class="text-slate-500 text-sm uppercase tracking-widest font-bold">Server Data Storage</p>
            </div>
            <div>
                <div class="text-slate-900 dark:text-white text-4xl font-bold mb-4 mono">∞</div>
                <p class="text-slate-500 text-sm uppercase tracking-widest font-bold">Total Daily API Calls</p>
            </div>
        </div>
    </section>

</div>

<?php require_once 'includes/footer.php'; ?>
