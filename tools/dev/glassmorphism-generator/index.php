<?php
require_once '../../../includes/header.php';
$tool = get_current_tool_info($_SERVER['REQUEST_URI']);
?>

<!-- Tool Header -->
<section class="pt-12 pb-8 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-medium text-gray-500">
                <li class="inline-flex items-center">
                    <a href="<?php echo SITE_URL; ?>" class="hover:text-white flex items-center">
                        <i data-lucide="home" class="w-3 h-3 mr-1"></i> Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i>
                        <a href="<?php echo SITE_URL; ?>#dev" class="hover:text-white">Developer Tools</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i>
                        <span class="text-slate-500 dark:text-gray-300"><?php echo $tool['name']; ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="max-w-2xl">
                <h1 class="text-3xl md:text-5xl font-heading font-extrabold text-slate-900 dark:text-white mb-4"><?php echo $tool['name']; ?></h1>
                <p class="text-slate-600 dark:text-gray-400 text-lg leading-relaxed"><?php echo $tool['desc']; ?></p>
            </div>
            <div class="flex gap-3">
                <div class="px-4 py-2 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center gap-2 text-indigo-600 dark:text-indigo-400 shadow-lg shadow-indigo-500/5 transition-all">
                    <i data-lucide="sparkles" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">UI Trends</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Controls -->
            <div class="lg:col-span-4 bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 border border-slate-200 dark:border-gray-800 shadow-xl space-y-8">
                <div>
                    <div class="flex justify-between mb-3">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Transparency</label>
                        <span id="val-trans" class="text-xs font-bold text-indigo-500">0.2</span>
                    </div>
                    <input type="range" id="input-trans" min="0" max="1" step="0.05" value="0.2" class="w-full h-1.5 bg-slate-100 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                </div>

                <div>
                    <div class="flex justify-between mb-3">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Blur Intensity</label>
                        <span id="val-blur" class="text-xs font-bold text-indigo-500">10px</span>
                    </div>
                    <input type="range" id="input-blur" min="0" max="40" step="1" value="10" class="w-full h-1.5 bg-slate-100 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                </div>

                <div>
                    <div class="flex justify-between mb-3">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Outline Opacity</label>
                        <span id="val-outline" class="text-xs font-bold text-indigo-500">0.1</span>
                    </div>
                    <input type="range" id="input-outline" min="0" max="1" step="0.05" value="0.1" class="w-full h-1.5 bg-slate-100 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                </div>

                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-3">Glass Color</label>
                    <input type="color" id="input-color" value="#ffffff" class="w-full h-12 rounded-xl border-none cursor-pointer bg-transparent">
                </div>
            </div>

            <!-- Preview & Code -->
            <div class="lg:col-span-8 space-y-8">
                <!-- Preview Window -->
                <div id="preview-bg" class="w-full aspect-video rounded-[3rem] relative flex items-center justify-center overflow-hidden border border-slate-200 dark:border-gray-800 shadow-2xl transition-all" style="background: linear-gradient(45deg, #6366f1, #a855f7, #ec4899);">
                    <!-- Decorative Orbs -->
                    <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-yellow-400 rounded-full blur-xl animate-blob"></div>
                    <div class="absolute bottom-1/4 right-1/4 w-48 h-48 bg-cyan-400 rounded-full blur-2xl animate-blob" style="animation-delay: 2s"></div>
                    
                    <!-- The Glass Element -->
                    <div id="glass-element" class="w-2/3 h-1/2 rounded-3xl relative z-10 flex flex-col items-center justify-center p-8 text-center">
                        <h3 class="text-2xl font-black mb-2">Glass Effect</h3>
                        <p class="text-sm opacity-80">This is how your UI element will look with the current settings.</p>
                    </div>
                </div>

                <!-- Code Window -->
                <div class="bg-slate-900 rounded-[2rem] p-8 shadow-2xl relative group">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-[10px] font-black uppercase tracking-widest text-indigo-400">CSS Styles</span>
                        <button onclick="copyCSS()" class="p-2 rounded-lg bg-white/5 hover:bg-white/10 text-white transition-all">
                            <i data-lucide="copy" class="w-4 h-4"></i>
                        </button>
                    </div>
                    <pre id="css-code" class="text-indigo-100 font-mono text-sm leading-relaxed overflow-x-auto whitespace-pre-wrap"></pre>
                </div>
            </div>

        </div>

        <!-- SEO Content -->
        <div class="mt-20 prose prose-slate dark:prose-invert max-w-none">
            <div class="p-8 md:p-12 rounded-[3rem] bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
                <div class="relative z-10">
                    <?php echo $tool['seo_text']; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const inputTrans = document.getElementById('input-trans');
    const inputBlur = document.getElementById('input-blur');
    const inputOutline = document.getElementById('input-outline');
    const inputColor = document.getElementById('input-color');

    const valTrans = document.getElementById('val-trans');
    const valBlur = document.getElementById('val-blur');
    const valOutline = document.getElementById('val-outline');

    const glass = document.getElementById('glass-element');
    const code = document.getElementById('css-code');

    function hexToRgb(hex) {
        const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    }

    function update() {
        const trans = inputTrans.value;
        const blur = inputBlur.value;
        const outline = inputOutline.value;
        const hex = inputColor.value;
        const rgb = hexToRgb(hex);

        valTrans.textContent = trans;
        valBlur.textContent = blur + 'px';
        valOutline.textContent = outline;

        const rgba = `rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, ${trans})`;
        const borderRgba = `rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, ${outline})`;

        const styles = `background: ${rgba};\nbackdrop-filter: blur(${blur}px);\n-webkit-backdrop-filter: blur(${blur}px);\nborder: 1px solid ${borderRgba};\nborder-radius: 24px;\nbox-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);`;

        glass.style.background = rgba;
        glass.style.backdropFilter = `blur(${blur}px)`;
        glass.style.webkitBackdropFilter = `blur(${blur}px)`;
        glass.style.border = `1px solid ${borderRgba}`;
        
        // Contrast text color based on glass color
        const brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
        glass.style.color = brightness > 125 ? '#1e293b' : '#ffffff';

        code.textContent = styles;
    }

    [inputTrans, inputBlur, inputOutline, inputColor].forEach(el => el.addEventListener('input', update));
    update();

    function copyCSS() {
        navigator.clipboard.writeText(code.textContent);
        alert('CSS copied to clipboard!');
    }
</script>

<?php require_once '../../../includes/footer.php'; ?>
