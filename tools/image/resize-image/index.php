<?php
require_once '../../../includes/header.php';
$tool = get_current_tool_info($_SERVER['REQUEST_URI']);
?>

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
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-gray-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div id="error-alert" class="hidden mb-8 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 flex items-start gap-3"><i data-lucide="alert-circle" class="w-5 h-5 text-red-500 mt-0.5"></i><div><p class="text-sm font-bold text-red-500 mb-1">Error Occurred</p><p class="text-sm text-red-400/80 error-msg"></p></div></div>

        <form id="tool-form" class="animate-fade-in" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="upload-zone rounded-[40px] p-12 text-center cursor-pointer group mb-10">
                <input type="file" name="file" id="file-input" class="hidden" accept=".jpg,.jpeg,.png,.webp">
                <div class="w-20 h-20 bg-indigo-600/10 rounded-full flex items-center justify-center text-indigo-400 mx-auto mb-8 group-hover:bg-indigo-600 group-hover:text-white transition-all"><i data-lucide="maximize" class="w-10 h-10"></i></div>
                <h2 class="text-2xl font-bold text-white mb-3">Select Image</h2>
                <div class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-indigo-600 text-white font-bold hover:bg-indigo-500 shadow-lg transition-all">Browse Image</div>
                <div class="file-display hidden mt-8 p-6 rounded-3xl bg-gray-900 border border-gray-800 text-left"><div class="flex items-center gap-4"><div class="p-3 bg-indigo-500/10 rounded-xl text-indigo-400"><i data-lucide="image" class="w-6 h-6"></i></div><div class="flex-grow"><p class="text-white font-bold text-sm mb-1 file-name"></p><p class="text-gray-500 text-xs file-size"></p></div></div></div>
            </div>

            <div class="glass-card rounded-3xl p-8 mb-10">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-white font-bold flex items-center gap-2"><i data-lucide="sliders" class="w-5 h-5 text-indigo-400"></i> Dimensions</h3>
                    <select id="unit-selector" name="unit" class="bg-gray-900 border border-gray-800 text-gray-400 text-xs font-bold rounded-lg px-3 py-1.5 focus:ring-0 outline-none cursor-pointer">
                        <option value="px" selected>Pixels (px)</option>
                        <option value="cm">Centimeters (cm)</option>
                        <option value="m">Meters (m)</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <label class="block text-gray-400 text-xs uppercase tracking-widest font-black mb-3 unit-label">Width (px)</label>
                        <input type="number" id="input-width" name="width" value="800" class="w-full px-5 py-4 rounded-2xl bg-gray-900 border border-gray-800 text-white font-mono text-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-gray-400 text-xs uppercase tracking-widest font-black mb-3 unit-label">Height (px)</label>
                        <input type="number" id="input-height" name="height" value="600" class="w-full px-5 py-4 rounded-2xl bg-gray-900 border border-gray-800 text-white font-mono text-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>
                </div>
                <div class="mt-8 flex items-center gap-3">
                    <input type="checkbox" name="aspect" checked id="aspect" class="w-5 h-5 rounded-lg text-indigo-600 bg-gray-900 border-gray-800 focus:ring-0 cursor-pointer">
                    <label for="aspect" class="text-gray-400 text-sm font-medium cursor-pointer select-none">Maintain Aspect Ratio</label>
                </div>
            </div>

            <button type="submit" class="w-full py-5 rounded-3xl bg-indigo-600 text-white font-extrabold text-lg hover:bg-indigo-500 shadow-2xl transition-all flex items-center justify-center gap-3">Resize Image <i data-lucide="arrow-right" class="w-6 h-6"></i></button>
        </form>

        <div id="progress-overlay" class="hidden animate-fade-in py-20 text-center"><div class="w-24 h-24 border-4 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin mx-auto mb-8"></div><h3 class="text-2xl font-bold text-white mb-2">Resizing Image...</h3></div>

        <div id="result-section" class="hidden animate-fade-in py-12"><div class="glass-card rounded-[40px] p-8 md:p-12 text-center border-indigo-500/20 shadow-indigo-500/10"><div class="w-20 h-20 bg-green-500/10 rounded-3xl flex items-center justify-center text-green-500 mx-auto mb-8"><i data-lucide="check-circle" class="w-12 h-12"></i></div><h2 class="text-3xl font-bold text-white mb-4">Image Resized!</h2><div class="flex gap-4 justify-center mt-10"><a id="download-btn" href="#" class="px-10 py-5 rounded-3xl bg-indigo-600 text-white font-extrabold text-lg flex items-center gap-2"><i data-lucide="download" class="w-6 h-6"></i> Download Image</a></div></div></div>
    </div>
</section>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const unitSelector = document.getElementById('unit-selector');
    const widthInput = document.getElementById('input-width');
    const heightInput = document.getElementById('input-height');
    const unitLabels = document.querySelectorAll('.unit-label');
    const aspectCheckbox = document.getElementById('aspect');
    
    let originalRatio = 0;
    
    // 96 DPI is standard for web
    const PX_PER_CM = 37.7952755906;
    const PX_PER_M = 3779.52755906;

    unitSelector.addEventListener('change', () => {
        const unit = unitSelector.value;
        unitLabels.forEach(label => {
            const base = label.innerText.split('(')[0].trim();
            label.innerText = `${base} (${unit})`;
        });
    });

    // Handle aspect ratio detection on file select
    const fileInput = document.getElementById('file-input');
    fileInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const img = new Image();
            img.onload = () => {
                originalRatio = img.width / img.height;
                widthInput.value = img.width;
                heightInput.value = img.height;
                unitSelector.value = 'px';
                unitLabels.forEach(l => l.innerText = l.innerText.split('(')[0] + '(px)');
            };
            img.src = URL.createObjectURL(file);
        }
    });

    const adjustHeight = () => {
        if (aspectCheckbox.checked && originalRatio > 0) {
            heightInput.value = Math.round(widthInput.value / originalRatio);
        }
    };

    const adjustWidth = () => {
        if (aspectCheckbox.checked && originalRatio > 0) {
            widthInput.value = Math.round(heightInput.value * originalRatio);
        }
    };

    widthInput.addEventListener('input', adjustHeight);
    heightInput.addEventListener('input', adjustWidth);

    handleToolForm('tool-form', 'process.php');
});
</script>
<?php require_once '../../../includes/footer.php'; ?>
