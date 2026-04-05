<?php
require_once '../../../includes/header.php';
$tool = get_current_tool_info($_SERVER['REQUEST_URI']);
?>

<style>
    .preview-container {
        position: relative;
        width: 100%;
        height: 70vh;
        max-height: 650px;
        overflow: hidden;
        border-radius: 2.5rem;
        background: #0a0a0a;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.7);
        border: 1px solid rgba(255,255,255,0.05);
    }
    #preview-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
        transition: filter 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .filter-grid label {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .filter-grid label:hover {
        transform: translateY(-4px);
    }
    /* Custom Scrollbar for side panel if needed */
    .side-panel {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
        scrollbar-width: none;
    }
    .side-panel::-webkit-scrollbar { display: none; }
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
            <div class="px-4 py-2 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center gap-2">
                <i data-lucide="layers" class="w-5 h-5 text-indigo-500"></i>
                <span class="text-sm font-medium text-indigo-400">Multi-Filter Mode</span>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-gray-950">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        
        <div id="error-alert" class="hidden mb-8 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 flex items-start gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 mt-0.5"></i>
            <div>
                <p class="text-sm font-bold text-red-500 mb-1">Error Occurred</p>
                <p class="text-sm text-red-400/80 error-msg"></p>
            </div>
        </div>

        <form id="tool-form" class="animate-fade-in" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <!-- Left: Controls (4 cols) -->
                <div class="lg:col-span-4 space-y-6 side-panel p-1">
                    
                    <!-- Upload Component (Initial) -->
                    <div id="upload-stage" class="upload-zone rounded-[40px] p-10 text-center cursor-pointer group border-2 border-dashed border-gray-800 hover:border-indigo-500/50 hover:bg-indigo-500/5 transition-all">
                        <input type="file" name="file" id="file-input" class="hidden" accept="image/*">
                        <div class="w-20 h-20 bg-indigo-600/10 rounded-[2rem] flex items-center justify-center text-indigo-400 mx-auto mb-6 group-hover:scale-110 transition-transform duration-500">
                            <i data-lucide="image-plus" class="w-10 h-10"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Drop your image here</h3>
                        <p class="text-gray-500 text-sm mb-6">Supports JPG, PNG, WebP up to 20MB</p>
                        <div class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-indigo-600 text-white font-bold group-hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-600/20">
                            Browse Files <i data-lucide="plus" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <!-- Post-Upload Controls (Hidden until file selected) -->
                    <div id="filter-controls" class="hidden animate-fade-in space-y-6">
                        
                        <!-- Change Image Button -->
                        <button type="button" onclick="document.getElementById('file-input').click()" class="w-full py-4 rounded-2xl bg-gray-900 border border-gray-800 text-gray-400 font-bold hover:bg-gray-800 hover:text-white transition-all flex items-center justify-center gap-2 mb-4">
                            <i data-lucide="refresh-cw" class="w-4 h-4"></i> Change Image
                        </button>

                        <!-- Filter Grid -->
                        <div class="glass-card rounded-[32px] p-8 border border-gray-800">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-white font-bold text-base flex items-center gap-2">
                                    <i data-lucide="wand-2" class="w-5 h-5 text-indigo-400"></i>
                                    Apply Effects
                                </h3>
                                <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Select Multiple</span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 filter-grid">
                                <?php
                                $filters = [
                                    ['id'=>'grayscale', 'name'=>'Grayscale', 'icon'=>'sun'],
                                    ['id'=>'sepia',     'name'=>'Sepia',     'icon'=>'coffee'],
                                    ['id'=>'invert',    'name'=>'Invert',    'icon'=>'repeat'],
                                    ['id'=>'blur',      'name'=>'Blur',      'icon'=>'droplet'],
                                    ['id'=>'emboss',    'name'=>'Emboss',    'icon'=>'layers'],
                                    ['id'=>'pixelate',  'name'=>'Pixelate',  'icon'=>'grid'],
                                ];
                                foreach ($filters as $filter): ?>
                                <label class="cursor-pointer group">
                                    <input type="checkbox" name="filters[]" value="<?php echo $filter['id']; ?>" class="hidden peer" onchange="updateLivePreview()">
                                    <div class="relative px-4 py-5 rounded-2xl bg-gray-900/50 border border-gray-800 text-gray-500 peer-checked:bg-gradient-to-br peer-checked:from-indigo-600 peer-checked:to-purple-600 peer-checked:border-transparent peer-checked:text-white transition-all text-center overflow-hidden">
                                        <i data-lucide="<?php echo $filter['icon']; ?>" class="w-6 h-6 mx-auto mb-3 opacity-60 group-hover:opacity-100 transition-opacity"></i>
                                        <span class="block text-[11px] font-bold tracking-wider uppercase"><?php echo $filter['name']; ?></span>
                                        <div class="absolute top-2 right-2 w-4 h-4 rounded-full border border-gray-700 flex items-center justify-center peer-checked:border-white/40">
                                            <div class="w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                        </div>
                                    </div>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Intensity Slider -->
                        <div class="glass-card rounded-[32px] p-8 border border-gray-800">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-white font-bold text-sm flex items-center gap-2">
                                    <i data-lucide="sliders" class="w-4 h-4 text-indigo-400"></i>
                                    Global Intensity
                                </h3>
                                <span id="intensity-val" class="px-3 py-1 bg-indigo-600/20 text-indigo-400 rounded-lg text-xs font-black border border-indigo-500/20">50%</span>
                            </div>
                            <input type="range" name="intensity" id="intensity-slider" min="0" max="100" value="50" oninput="updateLivePreview()" class="w-full h-2 bg-gray-800 rounded-full appearance-none cursor-pointer accent-indigo-500">
                            <div class="flex justify-between mt-3 text-[10px] text-gray-600 font-bold uppercase tracking-tighter">
                                <span>Subtle</span>
                                <span>Maximum</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-5 rounded-[2rem] bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-extrabold text-lg hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3 shadow-2xl shadow-indigo-600/30">
                            Download Final Image <i data-lucide="download" class="w-6 h-6"></i>
                        </button>
                    </div>

                </div>

                <!-- Right: Preview (8 cols) -->
                <div class="lg:col-span-8">
                    <div id="preview-stage" class="hidden animate-fade-in group">
                        <div class="preview-container">
                            <img id="preview-img" src="" alt="Preview">
                            
                            <!-- Overlay Badge -->
                            <div class="absolute top-6 left-6 px-4 py-2 rounded-xl bg-black/60 blur-backdrop-sm border border-white/10 text-white text-[10px] font-black uppercase tracking-widest pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity">
                                Live Preview Ready
                            </div>
                        </div>
                    </div>
                    
                    <div id="empty-stage" class="h-[650px] rounded-[40px] border-2 border-dashed border-gray-800 bg-gray-900/20 flex flex-col items-center justify-center text-center p-12 transition-all">
                        <div class="relative w-32 h-32 mb-8">
                            <div class="absolute inset-0 bg-indigo-600/20 rounded-full animate-ping opacity-20"></div>
                            <div class="relative w-full h-full bg-gray-900 border border-gray-800 rounded-full flex items-center justify-center">
                                <i data-lucide="sparkles" class="w-12 h-12 text-gray-700"></i>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-400 mb-3">Waiting for Image...</h3>
                        <p class="text-gray-600 max-w-sm text-lg leading-relaxed">Upload a photo to unlock the graphics engine and start applying professional filters.</p>
                    </div>

                    <!-- Result Section (Final) -->
                    <div id="result-section" class="hidden animate-fade-in absolute inset-0 z-20 flex items-center justify-center bg-gray-950/95 rounded-[40px]">
                        <div class="text-center p-12 glass-card rounded-[50px] border-indigo-500/20 shadow-2xl bg-gray-900/50 backdrop-blur-3xl">
                             <div class="w-24 h-24 bg-green-500/10 rounded-full flex items-center justify-center text-green-500 mx-auto mb-8 animate-bounce-slow">
                                <i data-lucide="check-circle-2" class="w-12 h-12"></i>
                            </div>
                            <h2 class="text-4xl font-heading font-extrabold text-white mb-4">Great Choice!</h2>
                            <p class="text-gray-400 mb-10 text-lg">Your filtered image is ready for download.</p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <a id="download-btn" href="#" class="px-10 py-5 rounded-2xl bg-indigo-600 text-white font-extrabold hover:bg-indigo-500 transition-all shadow-xl shadow-indigo-600/30 flex items-center justify-center gap-2">
                                    <i data-lucide="download" class="w-6 h-6"></i> Save Image
                                </a>
                                <button type="button" onclick="resetTool()" class="px-10 py-5 rounded-2xl bg-gray-800 text-gray-300 font-extrabold hover:bg-gray-700 transition-colors">
                                    Modify Filter
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>

        <div id="progress-overlay" class="hidden animate-fade-in fixed inset-0 z-50 flex items-center justify-center bg-gray-950/90 backdrop-blur-md">
            <div class="text-center">
                <div class="relative w-24 h-24 mx-auto mb-8">
                    <div class="absolute inset-0 border-4 border-indigo-600/20 rounded-full"></div>
                    <div class="absolute inset-0 border-4 border-t-indigo-500 rounded-full animate-spin"></div>
                </div>
                <h3 class="text-2xl font-heading font-bold text-white mb-2">Processing Layers...</h3>
                <p class="text-gray-500">Applying professional effects to your image</p>
            </div>
        </div>

    </div>
</section>

<script>
    const fileInput = document.getElementById('file-input');
    const previewImg = document.getElementById('preview-img');
    const intensitySlider = document.getElementById('intensity-slider');
    const intensityVal = document.getElementById('intensity-val');
    const previewStage = document.getElementById('preview-stage');
    const emptyStage = document.getElementById('empty-stage');
    const uploadStage = document.getElementById('upload-stage');
    const filterControls = document.getElementById('filter-controls');

    uploadStage.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = event => {
            previewImg.src = event.target.result;
            emptyStage.classList.add('hidden');
            uploadStage.classList.add('hidden');
            previewStage.classList.remove('hidden');
            filterControls.classList.remove('hidden');
            updateLivePreview();
        };
        reader.readAsDataURL(file);
    });

    function updateLivePreview() {
        if (!previewImg.src) return;
        
        const checkedFilters = Array.from(document.querySelectorAll('input[name="filters[]"]:checked')).map(cb => cb.value);
        const intensity = intensitySlider.value;
        intensityVal.textContent = intensity + '%';

        let filterStrings = [];
        checkedFilters.forEach(type => {
            switch (type) {
                case 'grayscale': filterStrings.push(`grayscale(${intensity}%)`); break;
                case 'sepia':     filterStrings.push(`sepia(${intensity / 100})`); break;
                case 'invert':    filterStrings.push(`invert(${intensity}%)`); break;
                case 'blur':      filterStrings.push(`blur(${intensity / 10}px)`); break;
                case 'emboss':    filterStrings.push(`contrast(${1 + intensity/100}) brightness(${1 - intensity/200})`); break;
                case 'pixelate':  filterStrings.push(`contrast(${1 + intensity/50})`); break;
            }
        });
        
        previewImg.style.filter = filterStrings.length > 0 ? filterStrings.join(' ') : 'none';
    }

    function resetTool() {
        document.getElementById('result-section').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', () => {
        handleToolForm('tool-form', 'process.php');
    });
</script>

<?php require_once '../../../includes/footer.php'; ?>
