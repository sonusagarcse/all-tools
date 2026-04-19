<?php
require_once '../../../includes/header.php';
?>

<div class="max-w-4xl mx-auto px-4 py-6 md:py-12">
    <!-- Tool Header -->
    <div class="text-center mb-8 md:mb-12">
        <div class="inline-flex items-center justify-center w-12 h-12 md:w-16 md:h-16 rounded-2xl bg-indigo-600/10 text-indigo-600 mb-4">
            <i data-lucide="scan-line" class="w-6 h-6 md:w-8 md:h-8"></i>
        </div>
        <h1 class="text-2xl md:text-4xl font-heading font-bold mb-3 px-2">QR Code Scanner from Image</h1>
        <p class="text-sm md:text-base text-slate-600 dark:text-gray-400 max-w-2xl mx-auto px-4">
            No camera? No problem. Simply upload a photo or screenshot of a QR code to decode its contents instantly and safely.
        </p>
    </div>

    <!-- Main Tool -->
    <div class="glass rounded-[2.5rem] p-6 md:p-10 shadow-2xl border border-slate-200 dark:border-gray-800">
        <div id="drop-zone" class="relative group cursor-pointer">
            <input type="file" id="qr-input" class="hidden" accept="image/*">
            <div class="flex flex-col items-center justify-center border-2 border-dashed border-slate-200 dark:border-gray-800 rounded-3xl p-10 md:p-16 transition-all group-hover:border-indigo-400 group-hover:bg-indigo-50/10 active:scale-[0.99]" onclick="document.getElementById('qr-input').click()">
                <div class="w-20 h-20 rounded-full bg-slate-50 dark:bg-gray-900 flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm">
                    <i data-lucide="upload-cloud" class="w-10 h-10"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Upload QR Code Image</h3>
                <p class="text-sm text-slate-400">Click to browse or drag and drop your image here</p>
            </div>
        </div>

        <!-- Progress Overlay -->
        <div id="scanning-status" class="hidden mt-8 text-center animate-pulse">
            <p class="text-indigo-600 font-bold uppercase tracking-widest text-xs">Scanning Image...</p>
        </div>

        <!-- Result Section -->
        <div id="result-container" class="hidden mt-10 p-8 rounded-3xl bg-slate-50 dark:bg-gray-900/50 border border-slate-200 dark:border-gray-800 animate-in fade-in zoom-in-95 duration-500">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <span class="px-3 py-1 bg-emerald-500/10 text-emerald-600 text-[10px] font-black uppercase rounded-lg">Success</span>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mt-2">Decoded Content</h3>
                </div>
                <button onclick="copyQRResult()" class="p-3 bg-white dark:bg-gray-800 rounded-xl border border-slate-100 dark:border-gray-700 text-slate-400 hover:text-indigo-500 shadow-sm transition-all">
                    <i data-lucide="copy" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div id="qr-result-text" class="p-6 bg-white dark:bg-gray-950 rounded-2xl border border-slate-100 dark:border-gray-800 font-mono text-sm text-slate-700 dark:text-slate-300 break-all whitespace-pre-wrap min-h-[100px]"></div>
            
            <div class="mt-6 flex items-center gap-4">
                <a id="btn-open-link" href="#" target="_blank" class="hidden flex-1 py-4 bg-indigo-600 text-white text-center font-bold rounded-2xl shadow-lg shadow-indigo-500/20 hover:bg-indigo-700 transition-all">
                    Follow Link
                </a>
                <button onclick="resetScanner()" class="flex-1 py-4 bg-slate-200 dark:bg-gray-800 text-slate-600 dark:text-slate-300 font-bold rounded-2xl hover:bg-slate-300 transition-all">
                    Scan New Image
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Canvas for Processing -->
    <canvas id="qr-canvas" class="hidden"></canvas>

    <!-- SEO Text Area -->
    <div class="mt-16 prose prose-slate dark:prose-invert max-w-none">
        <div class="p-8 rounded-[2rem] bg-indigo-50/50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-900/30">
            <?php echo $current_tool['seo_text']; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
<script>
const input = document.getElementById('qr-input');
const dropZone = document.getElementById('drop-zone');
const status = document.getElementById('scanning-status');
const resultContainer = document.getElementById('result-container');
const resultText = document.getElementById('qr-result-text');
const canvas = document.getElementById('qr-canvas');
const ctx = canvas.getContext('2d');
const openLinkBtn = document.getElementById('btn-open-link');

input.addEventListener('change', handleFile);

// Drag and drop handling
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

dropZone.addEventListener('drop', (e) => {
    const dt = e.dataTransfer;
    handleFile({ target: { files: dt.files } });
});

function handleFile(e) {
    const file = e.target.files[0];
    if (!file) return;

    status.classList.remove('hidden');
    dropZone.classList.add('opacity-40', 'pointer-events-none');
    resultContainer.classList.add('hidden');

    const reader = new FileReader();
    reader.onload = (event) => {
        const img = new Image();
        img.onload = () => {
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0);
            
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: "dontInvert",
            });

            status.classList.add('hidden');
            
            if (code) {
                displayResult(code.data);
            } else {
                alert("No QR code found in this image. Please try a clearer picture.");
                resetScanner();
            }
        };
        img.src = event.target.result;
    };
    reader.readAsDataURL(file);
}

function displayResult(content) {
    resultText.innerText = content;
    resultContainer.classList.remove('hidden');
    
    // Check if the content is a URL
    try {
        const url = new URL(content);
        openLinkBtn.href = content;
        openLinkBtn.classList.remove('hidden');
    } catch (_) {
        openLinkBtn.classList.add('hidden');
    }
}

function resetScanner() {
    input.value = '';
    dropZone.classList.remove('opacity-40', 'pointer-events-none');
    resultContainer.classList.add('hidden');
    status.classList.add('hidden');
}

function copyQRResult() {
    navigator.clipboard.writeText(resultText.innerText).then(() => {
        alert("Copied to clipboard!");
    });
}
</script>

<?php require_once '../../../includes/footer.php'; ?>
