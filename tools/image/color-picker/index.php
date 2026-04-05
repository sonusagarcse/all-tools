<?php
require_once '../../../includes/header.php';
$tool = get_current_tool_info($_SERVER['REQUEST_URI']);
?>

<style>
    .picker-container {
        position: relative;
        max-width: 100%;
        overflow: hidden;
        border-radius: 1.5rem;
        background: #000;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }
    #image-canvas {
        max-width: 100%;
        height: auto;
        cursor: crosshair;
        display: block;
        margin: 0 auto;
    }
    .magnifier {
        position: absolute;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid #fff;
        pointer-events: none;
        display: none;
        z-index: 100;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
        background-repeat: no-repeat;
    }
    .color-swatch {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        border: 2px solid rgba(255,255,255,0.1);
    }
</style>

<!-- Tool Header -->
<section class="pt-12 pb-8 bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-medium text-gray-500">
                <li class="inline-flex items-center"><a href="<?php echo SITE_URL; ?>" class="hover:text-white flex items-center"><i data-lucide="home" class="w-3 h-3 mr-1"></i> Home</a></li>
                <li><div class="flex items-center"><i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i><a href="<?php echo SITE_URL; ?>#image" class="hover:text-white">Image Tools</a></div></li>
                <li aria-current="page"><div class="flex items-center"><i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i><span class="text-gray-300"><?php echo $tool['name']; ?></span></div></li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="max-w-2xl">
                <h1 class="text-3xl md:text-5xl font-heading font-extrabold text-white mb-4"><?php echo $tool['name']; ?></h1>
                <p class="text-gray-400 text-lg leading-relaxed"><?php echo $tool['desc']; ?></p>
            </div>
            <div class="px-4 py-2 rounded-xl bg-gray-900 border border-gray-800 flex items-center gap-2">
                <i data-lucide="pipette" class="w-5 h-5 text-indigo-500"></i>
                <span class="text-sm font-medium text-gray-300">Live Picker</span>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-gray-950">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Workspace -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Upload Zone (Hidden after upload) -->
                <div id="upload-stage" class="upload-zone rounded-[40px] p-12 text-center cursor-pointer group">
                    <input type="file" id="file-picker" class="hidden" accept="image/*">
                    <div class="w-20 h-20 bg-indigo-600/10 rounded-full flex items-center justify-center text-indigo-400 mx-auto mb-8 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                        <i data-lucide="image" class="w-10 h-10"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-3">Upload Image to Pick Colors</h2>
                    <p class="text-gray-400 mb-8">Works with JPG, PNG, WEBP, and GIF</p>
                    <div class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-indigo-600 text-white font-bold hover:bg-indigo-500 shadow-lg shadow-indigo-600/20 transition-all">
                        Browse Image
                    </div>
                </div>

                <!-- Canvas Area -->
                <div id="canvas-stage" class="hidden space-y-4">
                    <div class="flex justify-between items-center text-white p-4 glass-card rounded-2xl">
                        <span class="text-sm font-medium flex items-center gap-2">
                            <i data-lucide="info" class="w-4 h-4 text-indigo-400"></i>
                            Move mouse to see color. Click to lock.
                        </span>
                        <button onclick="location.reload()" class="text-xs text-gray-400 hover:text-white transition-colors">Change Image</button>
                    </div>
                    <div class="picker-container">
                        <canvas id="image-canvas"></canvas>
                        <div id="magnifier" class="magnifier"></div>
                    </div>
                </div>
            </div>

            <!-- Right: Results Panel -->
            <div class="space-y-6">
                <!-- Current Color -->
                <div class="glass-card rounded-3xl p-8 border-indigo-500/10">
                    <h3 class="text-white font-bold mb-6 flex items-center gap-2">
                        <i data-lucide="eye" class="w-5 h-5 text-indigo-400"></i>
                        Active Color
                    </h3>
                    
                    <div class="flex items-center gap-6 mb-8">
                        <div id="active-swatch" class="w-24 h-24 rounded-3xl border-4 border-white/10 bg-transparent"></div>
                        <div class="space-y-1">
                            <p id="active-hex" class="text-2xl font-black text-white">#000000</p>
                            <p id="active-rgb" class="text-xs text-gray-500 font-mono">rgb(0, 0, 0)</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-4 bg-gray-900 rounded-2xl border border-gray-800">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">HEX</span>
                            <button onclick="copyToClipboard('active-hex')" class="text-indigo-400 hover:text-indigo-300 transition-colors">
                                <i data-lucide="copy" class="w-4 h-4"></i>
                            </button>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-gray-900 rounded-2xl border border-gray-800">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">RGB</span>
                            <button onclick="copyToClipboard('active-rgb')" class="text-indigo-400 hover:text-indigo-300 transition-colors">
                                <i data-lucide="copy" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- History -->
                <div class="glass-card rounded-3xl p-8">
                    <h3 class="text-white font-bold mb-6 flex items-center gap-2">
                        <i data-lucide="history" class="w-5 h-5 text-indigo-400"></i>
                        Saved Palette
                    </h3>
                    <div id="color-history" class="grid grid-cols-5 gap-3">
                        <!-- History items populated by JS -->
                        <div class="w-full aspect-square bg-gray-800/50 border border-dashed border-gray-700/50 rounded-lg"></div>
                        <div class="w-full aspect-square bg-gray-800/50 border border-dashed border-gray-700/50 rounded-lg"></div>
                        <div class="w-full aspect-square bg-gray-800/50 border border-dashed border-gray-700/50 rounded-lg"></div>
                        <div class="w-full aspect-square bg-gray-800/50 border border-dashed border-gray-700/50 rounded-lg"></div>
                        <div class="w-full aspect-square bg-gray-800/50 border border-dashed border-gray-700/50 rounded-lg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const uploadStage = document.getElementById('upload-stage');
    const canvasStage = document.getElementById('canvas-stage');
    const filePicker = document.getElementById('file-picker');
    const canvas = document.getElementById('image-canvas');
    const ctx = canvas.getContext('2d', { willReadFrequently: true });
    const mag = document.getElementById('magnifier');
    
    uploadStage.addEventListener('click', () => filePicker.click());
    
    filePicker.addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;
        
        const reader = new FileReader();
        reader.onload = event => {
            const img = new Image();
            img.onload = () => {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);
                
                uploadStage.classList.add('hidden');
                canvasStage.classList.remove('hidden');
                
                // Initialize Magnifier background
                mag.style.backgroundImage = `url(${event.target.result})`;
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    });

    canvas.addEventListener('mousemove', e => {
        updatePicker(e, false);
    });

    canvas.addEventListener('click', e => {
        updatePicker(e, true);
    });

    canvas.addEventListener('mouseleave', () => {
        mag.style.display = 'none';
    });

    function updatePicker(e, isLock) {
        const rect = canvas.getBoundingClientRect();
        const x = (e.clientX - rect.left) * (canvas.width / rect.width);
        const y = (e.clientY - rect.top) * (canvas.height / rect.height);
        
        const pixel = ctx.getImageData(x, y, 1, 1).data;
        const hex = rgbToHex(pixel[0], pixel[1], pixel[2]);
        const rgb = `rgb(${pixel[0]}, ${pixel[1]}, ${pixel[2]})`;
        
        // Update UI
        document.getElementById('active-swatch').style.backgroundColor = hex;
        document.getElementById('active-hex').textContent = hex.toUpperCase();
        document.getElementById('active-rgb').textContent = rgb;
        
        // Update Magnifier
        mag.style.display = 'block';
        mag.style.left = (e.clientX - rect.left - 60) + 'px';
        mag.style.top = (e.clientY - rect.top - 60) + 'px';
        mag.style.backgroundPosition = `-${(x * 4) - 60}px -${(y * 4) - 60}px`;
        mag.style.backgroundSize = `${canvas.width * 4}px ${canvas.height * 4}px`;
        
        if (isLock) {
            addToHistory(hex);
            flashIndicator();
        }
    }

    function rgbToHex(r, g, b) {
        return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
    }

    const history = [];
    function addToHistory(hex) {
        if (history.includes(hex)) return;
        history.unshift(hex);
        if (history.length > 10) history.pop();
        renderHistory();
    }

    function renderHistory() {
        const container = document.getElementById('color-history');
        container.innerHTML = history.map(hex => `
            <div class="relative group cursor-pointer" onclick="copyValue('${hex}')">
                <div class="w-full aspect-square rounded-lg border border-white/10 group-hover:scale-105 transition-transform" style="background-color: ${hex}"></div>
                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-indigo-600 text-[10px] text-white px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                    ${hex.toUpperCase()}
                </div>
            </div>
        `).join('');
    }

    function copyValue(val) {
        navigator.clipboard.writeText(val);
        showToast('Copied to clipboard');
    }

    function copyToClipboard(elementId) {
        const text = document.getElementById(elementId).textContent;
        navigator.clipboard.writeText(text);
        showToast('Copied to clipboard');
    }

    function flashIndicator() {
        const swatch = document.getElementById('active-swatch');
        swatch.classList.add('ring-4', 'ring-indigo-500/50');
        setTimeout(() => swatch.classList.remove('ring-4', 'ring-indigo-500/50'), 200);
    }
</script>

<?php require_once '../../../includes/footer.php'; ?>
