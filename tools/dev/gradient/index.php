<?php
require_once '../../../includes/header.php';
?>

<div class="max-w-5xl mx-auto px-4 py-6 md:py-12">
    <!-- Tool Header -->
    <div class="text-center mb-8 md:mb-12">
        <div class="inline-flex items-center justify-center w-12 h-12 md:w-16 md:h-16 rounded-2xl bg-orange-600/10 text-orange-600 mb-4">
            <i data-lucide="palette" class="w-6 h-6 md:w-8 md:h-8"></i>
        </div>
        <h1 class="text-2xl md:text-4xl font-heading font-bold mb-3 px-2">CSS Gradient Generator</h1>
        <p class="text-sm md:text-base text-slate-600 dark:text-gray-400 max-w-2xl mx-auto px-4">
            Create stunning, professional CSS gradients visually. Adjust stops, angles, and colors to generate pixel-perfect UI backgrounds.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Controls Panel -->
        <div class="lg:col-span-4">
            <div class="glass rounded-[2rem] p-6 md:p-8 shadow-xl border border-slate-200 dark:border-gray-800 space-y-8">
                
                <!-- Type Selection -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Gradient Type</label>
                    <div class="flex p-1 bg-slate-100 dark:bg-gray-950 rounded-xl">
                        <button onclick="setType('linear')" id="type-linear" class="flex-1 py-2 rounded-lg text-xs font-bold transition-all bg-white dark:bg-gray-800 shadow-sm text-orange-600">Linear</button>
                        <button onclick="setType('radial')" id="type-radial" class="flex-1 py-2 rounded-lg text-xs font-bold transition-all text-slate-400">Radial</button>
                    </div>
                </div>

                <!-- Angle Slider -->
                <div id="angle-container">
                    <div class="flex justify-between items-center mb-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Angle (deg)</label>
                        <span class="text-xs font-bold text-orange-600" id="angle-val">135°</span>
                    </div>
                    <input type="range" id="angle" min="0" max="360" value="135" class="w-full h-1.5 bg-slate-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-orange-600">
                </div>

                <!-- Color Stops -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Color Stops</label>
                        <button onclick="addStop()" class="text-orange-600 text-[10px] font-black uppercase tracking-widest hover:underline">+ Add Stop</button>
                    </div>
                    <div id="stops-container" class="space-y-3">
                        <!-- Stops will be injected here -->
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 dark:border-gray-800">
                    <button onclick="copyCSS()" class="w-full py-4 bg-orange-600 hover:bg-orange-700 text-white font-black rounded-2xl shadow-lg shadow-orange-500/20 transition-all flex items-center justify-center gap-3 active:scale-[0.98]">
                        <i data-lucide="copy" class="w-5 h-5"></i>
                        Copy CSS Code
                    </button>
                </div>
            </div>
        </div>

        <!-- Preview Panel -->
        <div class="lg:col-span-8">
            <div class="glass rounded-[2.5rem] p-4 border border-slate-200 dark:border-gray-800 h-full flex flex-col">
                <!-- Visual Preview -->
                <div id="gradient-preview" class="flex-1 min-h-[300px] md:min-h-0 rounded-[2rem] shadow-inner mb-6 transition-all duration-300"></div>
                
                <!-- CSS Output -->
                <div class="bg-gray-900 rounded-2xl p-6 relative group border border-gray-800">
                    <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">CSS Background</p>
                    <pre class="text-xs md:text-sm font-mono text-orange-400 whitespace-pre-wrap break-all" id="css-output"></pre>
                </div>
            </div>
        </div>
    </div>

    <!-- SEO -->
    <div class="mt-16 prose prose-slate dark:prose-invert max-w-none">
        <div class="p-8 rounded-[2rem] bg-orange-50/50 dark:bg-orange-900/10 border border-orange-100 dark:border-orange-900/30">
            <?php echo $current_tool['seo_text']; ?>
        </div>
    </div>
</div>

<script>
let gradientType = 'linear';
let stops = [
    { color: '#f59e0b', pos: 0 },
    { color: '#ef4444', pos: 100 }
];

function setType(type) {
    gradientType = type;
    document.getElementById('type-linear').className = type === 'linear' ? 'flex-1 py-2 rounded-lg text-xs font-bold transition-all bg-white dark:bg-gray-800 shadow-sm text-orange-600' : 'flex-1 py-2 rounded-lg text-xs font-bold transition-all text-slate-400';
    document.getElementById('type-radial').className = type === 'radial' ? 'flex-1 py-2 rounded-lg text-xs font-bold transition-all bg-white dark:bg-gray-800 shadow-sm text-orange-600' : 'flex-1 py-2 rounded-lg text-xs font-bold transition-all text-slate-400';
    document.getElementById('angle-container').style.opacity = type === 'linear' ? '1' : '0.3';
    document.getElementById('angle-container').style.pointerEvents = type === 'linear' ? 'auto' : 'none';
    updateGradient();
}

function renderStops() {
    const container = document.getElementById('stops-container');
    container.innerHTML = '';
    stops.forEach((stop, index) => {
        const div = document.createElement('div');
        div.className = 'flex items-center gap-3 animate-in fade-in slide-in-from-left-2 duration-300';
        div.innerHTML = `
            <input type="color" value="${stop.color}" oninput="updateStop(${index}, 'color', this.value)" class="w-10 h-10 rounded-lg p-0 border-0 bg-transparent cursor-pointer">
            <input type="range" min="0" max="100" value="${stop.pos}" oninput="updateStop(${index}, 'pos', this.value)" class="flex-1 h-1 bg-slate-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-orange-600">
            <button onclick="removeStop(${index})" class="text-slate-300 hover:text-red-500 ${stops.length < 3 ? 'hidden' : ''}">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        `;
        container.appendChild(div);
    });
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function updateStop(index, prop, val) {
    if (prop === 'pos') val = parseInt(val);
    stops[index][prop] = val;
    updateGradient();
}

function addStop() {
    if (stops.length >= 5) return alert("Max 5 stops for stability.");
    stops.push({ color: '#ffffff', pos: 50 });
    stops.sort((a,b) => a.pos - b.pos);
    renderStops();
    updateGradient();
}

function removeStop(index) {
    stops.splice(index, 1);
    renderStops();
    updateGradient();
}

function updateGradient() {
    const angle = document.getElementById('angle').value;
    document.getElementById('angle-val').innerText = angle + '°';
    
    // Sort stops by position for consistent CSS
    const sortedStops = [...stops].sort((a,b) => a.pos - b.pos);
    const stopString = sortedStops.map(s => `${s.color} ${s.pos}%`).join(', ');
    
    let css = '';
    if (gradientType === 'linear') {
        css = `linear-gradient(${angle}deg, ${stopString})`;
    } else {
        css = `radial-gradient(circle, ${stopString})`;
    }

    const fullCss = `background: ${css};`;
    document.getElementById('gradient-preview').style.background = css;
    document.getElementById('css-output').innerText = fullCss;
}

function copyCSS() {
    const css = document.getElementById('css-output').innerText;
    navigator.clipboard.writeText(css).then(() => {
        alert("CSS Copied!");
    });
}

document.getElementById('angle').addEventListener('input', updateGradient);

// Init
renderStops();
updateGradient();
</script>

<?php require_once '../../../includes/footer.php'; ?>
