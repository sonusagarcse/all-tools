<?php
require_once '../../../includes/header.php';
$tool = get_current_tool_info($_SERVER['REQUEST_URI']);
?>

<!-- Add Cropper.js -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

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
            <div class="px-4 py-2 rounded-xl bg-orange-500/10 border border-orange-500/20 flex items-center gap-2 text-orange-400">
                <i data-lucide="crop" class="w-5 h-5"></i>
                <span class="text-sm font-medium">Custom dimensions</span>
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
            
            <div id="upload-container" class="upload-zone rounded-[40px] p-12 text-center cursor-pointer group mb-10">
                <input type="file" name="file" id="file-input" class="hidden" accept=".jpg,.jpeg,.png,.webp">
                <div class="w-20 h-20 bg-orange-600/10 rounded-full flex items-center justify-center text-orange-400 mx-auto mb-8 group-hover:bg-orange-600 group-hover:text-white transition-all duration-300"><i data-lucide="crop" class="w-10 h-10"></i></div>
                <h2 class="text-2xl font-bold text-white mb-3">Select Image to Crop</h2>
                <p class="text-gray-400 mb-8">JPG, PNG, or WebP (Max 20MB)</p>
                <div class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-indigo-600 text-white font-bold hover:bg-indigo-500 shadow-lg shadow-indigo-600/20 transition-all">Browse Image</div>
                <div class="file-display hidden mt-8 p-6 rounded-3xl bg-gray-900 border border-gray-800 text-left"><div class="flex items-center gap-4"><div class="p-3 bg-orange-500/10 rounded-xl text-orange-400"><i data-lucide="file-image" class="w-6 h-6"></i></div><div class="flex-grow"><p class="text-white font-bold text-sm mb-1 file-name"></p><p class="text-gray-500 text-xs file-size"></p></div></div></div>
            </div>

            <div id="cropper-container" class="hidden glass-card rounded-3xl p-8 mb-10">
                <h3 class="text-white font-bold mb-6 flex items-center justify-between">
                    <span class="flex items-center gap-2"><i data-lucide="crop" class="w-5 h-5 text-indigo-400"></i> Adjust Crop Area</span>
                    <button type="button" id="reset-crop" class="text-sm px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg transition-colors flex items-center gap-2"><i data-lucide="rotate-ccw" class="w-4 h-4"></i> Reset</button>
                </h3>
                <div class="w-full bg-gray-900 rounded-2xl overflow-hidden flex items-center justify-center p-2 border border-gray-800" style="max-height: 500px; min-height: 300px;">
                    <img id="image-to-crop" class="max-w-full max-h-full hidden" src="" alt="Image to crop">
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                    <div><label class="block text-gray-400 text-xs mb-1 font-bold">X Position (px)</label><input type="number" id="crop_x" name="crop_x" value="0" readonly class="w-full px-3 py-2 rounded-lg bg-gray-900 border border-gray-800 text-gray-400 font-mono"></div>
                    <div><label class="block text-gray-400 text-xs mb-1 font-bold">Y Position (px)</label><input type="number" id="crop_y" name="crop_y" value="0" readonly class="w-full px-3 py-2 rounded-lg bg-gray-900 border border-gray-800 text-gray-400 font-mono"></div>
                    <div><label class="block text-gray-400 text-xs mb-1 font-bold">Width (px)</label><input type="number" id="crop_w" name="crop_w" value="0" readonly class="w-full px-3 py-2 rounded-lg bg-gray-900 border border-gray-800 text-gray-400 font-mono"></div>
                    <div><label class="block text-gray-400 text-xs mb-1 font-bold">Height (px)</label><input type="number" id="crop_h" name="crop_h" value="0" readonly class="w-full px-3 py-2 rounded-lg bg-gray-900 border border-gray-800 text-gray-400 font-mono"></div>
                </div>
            </div>

            <button type="submit" id="submit-btn" class="w-full py-5 rounded-3xl bg-indigo-600 text-white font-extrabold text-lg hover:bg-indigo-500 shadow-2xl shadow-indigo-600/30 transition-all flex items-center justify-center gap-3 opacity-50 cursor-not-allowed" disabled>Crop Image <i data-lucide="arrow-right" class="w-6 h-6"></i></button>
        </form>

        <div id="progress-overlay" class="hidden animate-fade-in py-20 text-center"><div class="w-24 h-24 border-4 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin mx-auto mb-8"></div><h3 class="text-2xl font-bold text-white mb-2">Cropping Image</h3><p class="text-gray-400">Extracting selected region...</p></div>

        <div id="result-section" class="hidden animate-fade-in py-12"><div class="glass-card rounded-[40px] p-8 md:p-12 text-center border-indigo-500/20 shadow-indigo-500/10"><div class="w-20 h-20 bg-green-500/10 rounded-3xl flex items-center justify-center text-green-500 mx-auto mb-8"><i data-lucide="check-circle" class="w-12 h-12"></i></div><h2 class="text-3xl font-bold text-white mb-4">Image Cropped!</h2><div class="flex gap-4 justify-center mt-10"><a id="download-btn" href="#" class="px-10 py-5 rounded-3xl bg-indigo-600 text-white font-extrabold text-lg flex items-center gap-2"><i data-lucide="download" class="w-6 h-6"></i> Download Image</a></div></div></div>

        <!-- More Tools Category -->
        <div class="mt-20 pt-12 border-t border-gray-800">
            <h3 class="text-2xl font-bold text-white mb-8 flex items-center gap-3"><i data-lucide="grid" class="w-6 h-6 text-orange-500"></i> More Image Tools</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <a href="<?php echo SITE_URL; ?>/tools/image/compress-image/" class="block glass-card rounded-3xl p-6 hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center text-green-500 mb-4 group-hover:bg-green-500 group-hover:text-white transition-all"><i data-lucide="minimize" class="w-6 h-6"></i></div>
                    <h4 class="text-lg font-bold text-white mb-2 group-hover:text-green-400 transition-colors">Compress Image</h4>
                    <p class="text-gray-400 text-sm">Reduce file size without losing quality.</p>
                </a>
                <a href="<?php echo SITE_URL; ?>/tools/image/resize-image/" class="block glass-card rounded-3xl p-6 hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-500 mb-4 group-hover:bg-blue-500 group-hover:text-white transition-all"><i data-lucide="maximize" class="w-6 h-6"></i></div>
                    <h4 class="text-lg font-bold text-white mb-2 group-hover:text-blue-400 transition-colors">Resize Image</h4>
                    <p class="text-gray-400 text-sm">Change the dimensions of your image.</p>
                </a>
                <a href="<?php echo SITE_URL; ?>/tools/image/convert-to-jpg/" class="block glass-card rounded-3xl p-6 hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center text-purple-500 mb-4 group-hover:bg-purple-500 group-hover:text-white transition-all"><i data-lucide="arrow-right-left" class="w-6 h-6"></i></div>
                    <h4 class="text-lg font-bold text-white mb-2 group-hover:text-purple-400 transition-colors">Convert to JPG</h4>
                    <p class="text-gray-400 text-sm">Convert PNG, WebP to JPG format.</p>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Custom cropper styles to fit the dark theme */
.cropper-view-box,
.cropper-face {
    border-radius: 8px;
}
.cropper-line, .cropper-point {
    background-color: #4f46e5 !important;
}
.cropper-view-box {
    outline-color: #4f46e5 !important;
}
.cropper-bg {
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQAQMAAAAlPW0iAAAAA3NCSVQICAjb4U/gAAAABlBMVEXMzMz////TjRV2AAAACXBIWXMAAArrAAAK6wGCiw1aAAAAHHRFWHRTb2Z0d2FyZQBBZG9iZSBGaXJld29ya3MgQ1M26LyyjAAAABFJREFUCJlj+M/AgBVhF/0PAH6/D/HkDxfoAAAAAElFTkSuQmCC');
}
.cropper-modal {
    opacity: 0.8;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let cropper = null;
    const fileInput = document.getElementById('file-input');
    const imageToCrop = document.getElementById('image-to-crop');
    const cropperContainer = document.getElementById('cropper-container');
    const submitBtn = document.getElementById('submit-btn');
    const resetBtn = document.getElementById('reset-crop');

    const inputX = document.getElementById('crop_x');
    const inputY = document.getElementById('crop_y');
    const inputW = document.getElementById('crop_w');
    const inputH = document.getElementById('crop_h');

    fileInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files.length > 0) {
            const file = e.target.files[0];
            const reader = new FileReader();
            
            reader.onload = function(event) {
                if (cropper) {
                    cropper.destroy();
                }
                
                imageToCrop.src = event.target.result;
                imageToCrop.classList.remove('hidden');
                cropperContainer.classList.remove('hidden');
                
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');

                cropper = new Cropper(imageToCrop, {
                    viewMode: 1,
                    dragMode: 'crop',
                    autoCropArea: 0.8,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    background: false,
                    crop(event) {
                        inputX.value = Math.round(event.detail.x);
                        inputY.value = Math.round(event.detail.y);
                        inputW.value = Math.round(event.detail.width);
                        inputH.value = Math.round(event.detail.height);
                    },
                });
            };
            
            reader.readAsDataURL(file);
        }
    });

    resetBtn.addEventListener('click', () => {
        if (cropper) {
            cropper.reset();
        }
    });

    // Handle form submission via AJAX
    handleToolForm('tool-form', 'process.php');
});
</script>
<?php require_once '../../../includes/footer.php'; ?>
