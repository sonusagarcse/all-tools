<?php
require_once '../../../includes/header.php';
$tool = get_current_tool_info($_SERVER['REQUEST_URI']);
?>

<!-- Tool Header -->
<section class="pt-12 pb-8 bg-gray-950">
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
                        <a href="<?php echo SITE_URL; ?>#image" class="hover:text-white">Image Tools</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i>
                        <span class="text-gray-300"><?php echo $tool['name']; ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="max-w-2xl">
                <h1 class="text-3xl md:text-5xl font-heading font-extrabold text-white mb-4"><?php echo $tool['name']; ?></h1>
                <p class="text-gray-400 text-lg leading-relaxed"><?php echo $tool['desc']; ?></p>
            </div>
            <div class="flex gap-3">
                <div class="px-4 py-2 rounded-xl bg-gray-900 border border-gray-800 flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-5 h-5 text-indigo-400"></i>
                    <span class="text-sm font-medium text-gray-300">Premium Styles</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Sidebar: Controls -->
            <div class="lg:col-span-4 lg:sticky lg:top-24 h-fit">
                <div class="glass-card rounded-3xl p-6 mb-6">
                    <h3 class="text-white font-bold flex items-center gap-2 mb-6">
                        <i data-lucide="type" class="w-5 h-5 text-indigo-400"></i>
                        QR Content
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Text or URL</label>
                            <textarea id="qr-data" rows="3" class="w-full bg-gray-900 border-gray-800 rounded-xl text-white p-3 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter URL or text here...">https://bulktools.lkvmbihar.in</textarea>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-3xl p-6 mb-6">
                    <h3 class="text-white font-bold flex items-center gap-2 mb-6 text-sm">
                        <i data-lucide="palette" class="w-5 h-5 text-indigo-400"></i>
                        Logo & Design
                    </h3>
                    
                    <!-- Tabs for sub-controls -->
                    <div class="space-y-6">
                        <!-- Dots Style -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Dots Style</label>
                            <div class="grid grid-cols-3 gap-2">
                                <button data-dot-style="square" class="dot-style-btn p-2 rounded-lg bg-gray-900 border border-gray-800 text-xs text-gray-400 hover:border-indigo-500 focus:border-indigo-500 transition-all active ring-1 ring-indigo-500">Square</button>
                                <button data-dot-style="dots" class="dot-style-btn p-2 rounded-lg bg-gray-900 border border-gray-800 text-xs text-gray-400 hover:border-indigo-500 focus:border-indigo-500 transition-all">Dots</button>
                                <button data-dot-style="rounded" class="dot-style-btn p-2 rounded-lg bg-gray-900 border border-gray-800 text-xs text-gray-400 hover:border-indigo-500 focus:border-indigo-500 transition-all">Rounded</button>
                                <button data-dot-style="classy" class="dot-style-btn p-2 rounded-lg bg-gray-900 border border-gray-800 text-xs text-gray-400 hover:border-indigo-500 focus:border-indigo-500 transition-all">Classy</button>
                                <button data-dot-style="classy-rounded" class="dot-style-btn p-2 rounded-lg bg-gray-900 border border-gray-800 text-xs text-gray-400 hover:border-indigo-500 focus:border-indigo-500 transition-all">C-Rounded</button>
                                <button data-dot-style="extra-rounded" class="dot-style-btn p-2 rounded-lg bg-gray-900 border border-gray-800 text-xs text-gray-400 hover:border-indigo-500 focus:border-indigo-500 transition-all">E-Rounded</button>
                            </div>
                        </div>

                        <!-- Colors -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">QR Color</label>
                                <div class="flex items-center gap-2 px-3 py-2 bg-gray-900 border border-gray-800 rounded-xl">
                                    <input type="color" id="qr-color" value="#6366f1" class="w-6 h-6 rounded-md bg-transparent border-none cursor-pointer">
                                    <span id="qr-color-hex" class="text-xs text-gray-400 font-mono">#6366F1</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Background</label>
                                <div class="flex items-center gap-2 px-3 py-2 bg-gray-900 border border-gray-800 rounded-xl">
                                    <input type="color" id="qr-bg-color" value="#ffffff" class="w-6 h-6 rounded-md bg-transparent border-none cursor-pointer">
                                    <span id="qr-bg-hex" class="text-xs text-gray-400 font-mono">#FFFFFF</span>
                                </div>
                            </div>
                        </div>

                        <!-- Gradient Toggle -->
                        <div class="flex items-center justify-between p-3 bg-indigo-500/5 border border-indigo-500/10 rounded-xl">
                            <div class="flex items-center gap-2">
                                <i data-lucide="gradient" class="w-4 h-4 text-indigo-400"></i>
                                <span class="text-xs font-bold text-gray-300">Enable Gradient</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="qr-gradient-enable" class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-gray-400 after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>

                        <div id="gradient-controls" class="hidden space-y-4 animate-fade-in">
                             <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Gradient End</label>
                                <div class="flex items-center gap-2 px-3 py-2 bg-gray-900 border border-gray-800 rounded-xl">
                                    <input type="color" id="qr-color-2" value="#06b6d4" class="w-6 h-6 rounded-md bg-transparent border-none cursor-pointer">
                                    <span id="qr-color-2-hex" class="text-xs text-gray-400 font-mono">#06B6D4</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Gradient Type</label>
                                <select id="qr-gradient-type" class="w-full bg-gray-900 border-gray-800 rounded-xl text-white p-2 text-xs">
                                    <option value="linear">Linear</option>
                                    <option value="radial">Radial</option>
                                </select>
                            </div>
                        </div>

                        <!-- Logo Upload -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Upload Center Logo</label>
                            <label class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-gray-800 hover:border-indigo-500 bg-gray-900/50 rounded-2xl cursor-pointer transition-all">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i data-lucide="image" class="w-6 h-6 text-gray-500 mb-1"></i>
                                    <p class="text-[10px] text-gray-500 px-4 text-center">Click to upload brand logo (transparent PNG best)</p>
                                </div>
                                <input id="logo-input" type="file" class="hidden" accept="image/*" />
                            </label>
                            <div id="logo-preview" class="hidden mt-3 flex items-center justify-between p-2 bg-gray-900 border border-gray-800 rounded-xl">
                                <div class="flex items-center gap-2">
                                    <img src="" id="logo-preview-img" class="w-8 h-8 rounded p-1 bg-white object-contain">
                                    <span class="text-[10px] text-gray-400" id="logo-name">logo.png</span>
                                </div>
                                <button id="remove-logo" class="p-1 hover:text-red-500 text-gray-500 transition-colors">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-3xl p-6">
                    <h3 class="text-white font-bold flex items-center gap-2 mb-6 text-sm">
                        <i data-lucide="corners" class="w-5 h-5 text-indigo-400"></i>
                        Corners & Eyes
                    </h3>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Square Style</label>
                            <div class="grid grid-cols-3 gap-2">
                                <button data-corner-style="square" class="corner-style-btn p-2 rounded-lg bg-gray-900 border border-gray-800 text-xs text-gray-400 hover:border-indigo-500 transition-all active ring-1 ring-indigo-500">Square</button>
                                <button data-corner-style="dot" class="corner-style-btn p-2 rounded-lg bg-gray-900 border border-gray-800 text-xs text-gray-400 hover:border-indigo-500 transition-all">Dot</button>
                                <button data-corner-style="extra-rounded" class="corner-style-btn p-2 rounded-lg bg-gray-900 border border-gray-800 text-xs text-gray-400 hover:border-indigo-500 transition-all">Rounded</button>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Eye Boundary</label>
                                <div class="flex items-center gap-2 px-3 py-2 bg-gray-900 border border-gray-800 rounded-xl">
                                    <input type="color" id="qr-corner-color" value="#6366f1" class="w-6 h-6 rounded-md bg-transparent border-none cursor-pointer">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Eye Inner Dot</label>
                                <div class="flex items-center gap-2 px-3 py-2 bg-gray-900 border border-gray-800 rounded-xl">
                                    <input type="color" id="qr-corner-dot-color" value="#6366f1" class="w-6 h-6 rounded-md bg-transparent border-none cursor-pointer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content: Preview -->
            <div class="lg:col-span-8">
                <div class="glass-card rounded-[40px] p-8 md:p-12 border-indigo-500/10 min-h-[600px] flex flex-col">
                    <div class="flex items-center justify-between mb-10">
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-1">Live Preview</h2>
                            <p class="text-gray-400 text-sm">Scan to verify as you design</p>
                        </div>
                        <div class="flex gap-2">
                            <span class="px-3 py-1 bg-green-500/10 text-green-500 text-[10px] font-bold uppercase rounded-full border border-green-500/20 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> Ready to Scan
                            </span>
                        </div>
                    </div>

                    <!-- QR Display Area -->
                    <div class="flex-grow flex flex-col items-center justify-center py-12">
                        <div id="qr-canvas-container" class="relative group">
                            <div class="absolute -inset-4 bg-gradient-to-tr from-indigo-500/20 to-cyan-500/20 rounded-[48px] blur-2xl opacity-0 group-hover:opacity-100 transition-all duration-700"></div>
                            <div id="qr-canvas" class="relative z-10 bg-white p-6 rounded-[32px] shadow-2xl transition-all duration-500 hover:scale-[1.02]">
                                <!-- QR rendered here -->
                            </div>
                        </div>

                        <!-- Info/Warning about scanning -->
                        <div class="mt-12 text-center max-w-sm">
                            <p class="text-gray-500 text-xs italic">Heavy customization like large logos or low contrast colors can affect scannability. Always test with a scanner before printing.</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-auto border-t border-gray-800/50 pt-10">
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <div class="inline-flex rounded-2xl p-1 bg-gray-900/50 border border-gray-800">
                                <button data-ext="png" class="download-btn px-6 py-3 rounded-xl bg-indigo-600 text-white font-bold text-sm hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-600/20 flex items-center gap-2">
                                    <i data-lucide="download" class="w-4 h-4"></i> Download PNG
                                </button>
                                <button data-ext="svg" class="download-btn px-6 py-3 rounded-xl text-gray-400 font-bold text-sm hover:text-white transition-all flex items-center gap-2">
                                    <i data-lucide="file-code" class="w-4 h-4"></i> SVG
                                </button>
                                <button data-ext="jpeg" class="download-btn px-6 py-3 rounded-xl text-gray-400 font-bold text-sm hover:text-white transition-all flex items-center gap-2">
                                    <i data-lucide="file-image" class="w-4 h-4"></i> JPEG
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features Highlight -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
                    <div class="glass-card rounded-3xl p-6 text-center">
                        <div class="w-12 h-12 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-400 mx-auto mb-4">
                            <i data-lucide="shield-check" class="w-6 h-6"></i>
                        </div>
                        <h4 class="text-white font-bold mb-2">100% Secure</h4>
                        <p class="text-gray-500 text-xs">Processing is done in your browser. No data is stored.</p>
                    </div>
                    <div class="glass-card rounded-3xl p-6 text-center">
                        <div class="w-12 h-12 bg-cyan-500/10 rounded-2xl flex items-center justify-center text-cyan-400 mx-auto mb-4">
                            <i data-lucide="brush" class="w-6 h-6"></i>
                        </div>
                        <h4 class="text-white font-bold mb-2">High Quality</h4>
                        <p class="text-gray-500 text-xs">Vector exports (SVG) for professional printing.</p>
                    </div>
                    <div class="glass-card rounded-3xl p-6 text-center">
                        <div class="w-12 h-12 bg-purple-500/10 rounded-2xl flex items-center justify-center text-purple-400 mx-auto mb-4">
                            <i data-lucide="Zap" class="w-6 h-6"></i>
                        </div>
                        <h4 class="text-white font-bold mb-2">Instant Preview</h4>
                        <p class="text-gray-500 text-xs">See changes in real-time as you tweak styles.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include QR Library -->
<script src="https://unpkg.com/qr-code-styling@1.5.0/lib/qr-code-styling.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let qrCode;
        let logoData = null;

        const container = document.getElementById("qr-canvas");
        const dataInput = document.getElementById("qr-data");
        const qrColorInput = document.getElementById("qr-color");
        const qrBgColorInput = document.getElementById("qr-bg-color");
        const gradientEnable = document.getElementById("qr-gradient-enable");
        const color2Input = document.getElementById("qr-color-2");
        const gradientTypeSelect = document.getElementById("qr-gradient-type");
        const logoInput = document.getElementById("logo-input");

        const updateHex = (id, val) => {
            const el = document.getElementById(id + '-hex');
            if (el) el.textContent = val.toUpperCase();
        };

        const getOptions = () => {
            const isGradient = gradientEnable.checked;
            
            const options = {
                width: 300,
                height: 300,
                type: "svg",
                data: dataInput.value || " ",
                image: logoData,
                dotsOptions: {
                    color: qrColorInput.value,
                    type: document.querySelector('.dot-style-btn.active').dataset.dotStyle,
                },
                backgroundOptions: {
                    color: qrBgColorInput.value,
                },
                imageOptions: {
                    crossOrigin: "anonymous",
                    margin: 10,
                    imageSize: 0.4
                },
                cornersSquareOptions: {
                    color: document.getElementById('qr-corner-color').value,
                    type: document.querySelector('.corner-style-btn.active').dataset.cornerStyle,
                },
                cornersDotOptions: {
                    color: document.getElementById('qr-corner-dot-color').value,
                    type: "dot"
                }
            };

            if (isGradient) {
                options.dotsOptions.gradient = {
                    type: gradientTypeSelect.value,
                    rotation: 0,
                    colorStops: [
                        { offset: 0, color: qrColorInput.value },
                        { offset: 1, color: color2Input.value }
                    ]
                };
            }

            return options;
        };

        const renderQR = () => {
            container.innerHTML = "";
            qrCode = new QRCodeStyling(getOptions());
            qrCode.append(container);
        };

        // Event Listeners
        dataInput.addEventListener('input', renderQR);
        
        qrColorInput.addEventListener('input', (e) => {
            updateHex('qr-color', e.target.value);
            renderQR();
        });

        qrBgColorInput.addEventListener('input', (e) => {
            updateHex('qr-bg', e.target.value);
            renderQR();
        });

        color2Input.addEventListener('input', (e) => {
            updateHex('qr-color-2', e.target.value);
            renderQR();
        });

        gradientEnable.addEventListener('change', (e) => {
            document.getElementById('gradient-controls').classList.toggle('hidden', !e.target.checked);
            renderQR();
        });

        gradientTypeSelect.addEventListener('change', renderQR);

        document.getElementById('qr-corner-color').addEventListener('input', renderQR);
        document.getElementById('qr-corner-dot-color').addEventListener('input', renderQR);

        // Dot Style Buttons
        document.querySelectorAll('.dot-style-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.dot-style-btn').forEach(b => b.classList.remove('active', 'ring-1', 'ring-indigo-500'));
                btn.classList.add('active', 'ring-1', 'ring-indigo-500');
                renderQR();
            });
        });

        // Corner Style Buttons
        document.querySelectorAll('.corner-style-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.corner-style-btn').forEach(b => b.classList.remove('active', 'ring-1', 'ring-indigo-500'));
                btn.classList.add('active', 'ring-1', 'ring-indigo-500');
                renderQR();
            });
        });

        // Logo Upload
        logoInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    logoData = event.target.result;
                    document.getElementById('logo-preview-img').src = logoData;
                    document.getElementById('logo-name').textContent = file.name;
                    document.getElementById('logo-preview').classList.remove('hidden');
                    renderQR();
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('remove-logo').addEventListener('click', () => {
            logoData = null;
            logoInput.value = "";
            document.getElementById('logo-preview').classList.add('hidden');
            renderQR();
        });

        // Download
        document.querySelectorAll('.download-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const extension = btn.dataset.ext;
                qrCode.download({ name: "bulktools-qr", extension: extension });
            });
        });

        // Initial Render
        renderQR();
    });
</script>

<?php
require_once '../../../includes/footer.php';
?>
