<?php
require_once '../../../includes/config.php';
require_once '../../../includes/functions.php';

$current_tool = get_current_tool_info($_SERVER['REQUEST_URI']);
$page_title = "Secure Image Share - E2EE Burn After Reading - " . SITE_NAME;
$page_description = "Free secure image sharing tool. Upload an image, encrypt it, and share using an 8-digit Receive ID. File is automatically deleted after viewing.";
$page_keywords = implode(', ', $current_tool['keywords'] ?? []);

require_once BASE_DIR . '/includes/header.php';
?>

<div class="container mx-auto px-4 py-12 max-w-3xl">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-400 mb-4">
            <i data-lucide="shield" class="w-8 h-8"></i>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-slate-100 mb-4"><?= htmlspecialchars($current_tool['name'] ?? 'Secure Image Share') ?></h1>
        <p class="text-slate-600 dark:text-slate-400 max-w-xl mx-auto">
            End-to-End Encrypted image sharing. The image is permanently wiped from our server <strong class="text-rose-500">the exact moment it is viewed</strong>.
        </p>
    </div>

    <!-- Tabs Container -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden border border-slate-200 dark:border-slate-700 relative">
        
        <!-- Loading Overlay -->
        <div id="loadingOverlay" class="hidden absolute inset-0 bg-white/80 dark:bg-slate-800/90 z-50 flex flex-col items-center justify-center backdrop-blur-sm transition-all">
            <i data-lucide="loader-2" class="w-12 h-12 text-primary-500 animate-spin mb-4"></i>
            <p id="loadingStatus" class="text-lg font-medium text-slate-800 dark:text-slate-100">Processing...</p>
        </div>

        <!-- Tab Nav -->
        <div class="flex border-b border-slate-200 dark:border-slate-700">
            <button id="tabBtnSend" class="flex-1 py-4 text-center font-bold text-lg text-primary-600 bg-primary-50 dark:bg-primary-900/20 dark:text-primary-400 border-b-2 border-primary-500 transition-colors">
                <i data-lucide="upload" class="inline w-5 h-5 mr-2"></i> Send Image
            </button>
            <button id="tabBtnReceive" class="flex-1 py-4 text-center font-semibold text-lg text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 transition-colors">
                <i data-lucide="download" class="inline w-5 h-5 mr-2"></i> Receive Image
            </button>
        </div>

        <div class="p-6 md:p-10">

            <!-- ================= SEND MODE ================= -->
            <div id="uploadSection" class="block transition-opacity duration-300">
                <div id="dropZone" class="border-3 border-dashed border-slate-300 dark:border-slate-600 rounded-xl p-8 text-center cursor-pointer hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/10 transition-colors">
                    <i data-lucide="image-plus" class="w-12 h-12 text-slate-400 mx-auto mb-4"></i>
                    <p class="text-lg font-medium text-slate-700 dark:text-slate-300 mb-1">Click or drag image here</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Supports JPG, PNG, WebP (Max 10MB)</p>
                    <input type="file" id="fileInput" class="hidden" accept="image/jpeg, image/png, image/webp" />
                </div>
                
                <div id="uploadOptions" class="mt-6 flex items-center justify-center border border-amber-200 dark:border-amber-900/40 bg-amber-50 dark:bg-amber-900/10 rounded-lg p-4">
                    <label class="flex items-center cursor-pointer select-none">
                        <div class="relative">
                            <input type="checkbox" id="requirePassword" class="sr-only" checked>
                            <div class="block bg-slate-200 dark:bg-slate-700 w-14 h-8 rounded-full transition-colors toggle-bg"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform"></div>
                        </div>
                        <div class="ml-4">
                            <span class="block text-slate-800 dark:text-slate-200 font-bold">Password Protect</span>
                            <span class="block text-sm text-slate-500 dark:text-slate-400">Generates an 8-digit PIN required to view</span>
                        </div>
                    </label>
                </div>

                <!-- Result Box (Hidden until upload) -->
                <div id="shareResult" class="hidden mt-6 p-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/50 rounded-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-3 opacity-20 pointer-events-none">
                        <i data-lucide="check-circle" class="w-24 h-24 text-emerald-500"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-emerald-800 dark:text-emerald-300 mb-4 flex items-center">
                        <i data-lucide="lock" class="w-5 h-5 mr-2"></i> Encrypted & Ready
                    </h3>
                    
                    <div class="space-y-6 relative z-10 text-center">
                        <div>
                            <label class="block text-sm font-medium text-slate-500 dark:text-slate-400 mb-1 uppercase tracking-wider">Receive ID</label>
                            <div class="flex">
                                <input type="text" id="shareReceiveId" readonly class="w-full bg-slate-100 dark:bg-slate-900 border border-emerald-200 dark:border-emerald-700 rounded-l-lg py-3 px-4 text-slate-800 dark:text-slate-100 font-mono focus:outline-none focus:ring-2 focus:ring-emerald-500 text-3xl text-center tracking-[0.2em] font-bold shadow-inner">
                                <button onclick="copyToClipboard('shareReceiveId')" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 rounded-r-lg flex justify-center items-center font-bold text-lg transition-colors">
                                    Copy
                                </button>
                            </div>
                            <p class="text-sm text-emerald-700 dark:text-emerald-400 mt-2 font-medium">Tell the recipient to enter this ID on this page.</p>
                        </div>
                        
                        <div id="pinResultContainer">
                            <label class="block text-sm font-bold text-rose-600 dark:text-rose-400 mb-1 uppercase tracking-wider flex justify-center items-center">
                                <i data-lucide="key" class="w-4 h-4 mr-1"></i> Secret Access PIN
                            </label>
                            <div class="flex">
                                <input type="text" id="sharePinKey" readonly class="w-full bg-slate-100 dark:bg-slate-900 border border-rose-200 dark:border-rose-900/50 rounded-l-lg py-3 px-4 text-slate-800 dark:text-slate-100 font-mono focus:outline-none focus:ring-2 focus:ring-rose-500 text-3xl text-center tracking-[0.2em] font-bold shadow-inner">
                                <button onclick="copyToClipboard('sharePinKey')" class="bg-rose-500 hover:bg-rose-600 text-white px-6 rounded-r-lg flex justify-center items-center font-bold text-lg transition-colors">
                                    Copy
                                </button>
                            </div>
                            <p class="text-sm text-rose-500 mt-2 font-medium">They will also need this PIN to decrypt the image.</p>
                        </div>
                        
                        <div class="pt-4 border-t border-emerald-200 dark:border-emerald-800/50">
                            <label class="block text-sm font-medium text-emerald-800 dark:text-emerald-300 mb-1 uppercase tracking-wider">Direct Sharable Link</label>
                            <div class="flex">
                                <input type="text" id="shareDirectLink" readonly class="w-full bg-white dark:bg-slate-900 border border-emerald-200 dark:border-emerald-700 rounded-l-lg py-2 px-3 text-slate-500 dark:text-slate-400 focus:outline-none text-sm shadow-inner">
                                <button onclick="copyToClipboard('shareDirectLink')" class="bg-slate-500 hover:bg-slate-600 text-white px-4 rounded-r-lg flex justify-center items-center font-medium transition-colors text-sm">
                                    Copy Link
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="resetBtnContainer" class="hidden mt-6 text-center">
                    <button onclick="location.reload();" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 font-medium flex justify-center items-center w-full bg-slate-100 dark:bg-slate-700 py-3 rounded-lg transition-colors">
                        <i data-lucide="refresh-cw" class="w-5 h-5 mr-2"></i> Send something else
                    </button>
                </div>
            </div>

            <!-- ================= RECEIVE MODE ================= -->
            <div id="receiveSection" class="hidden transition-opacity duration-300">
                
                <!-- Initial Fetch Box -->
                <div id="fetchPromptBox" class="text-center py-4">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 text-indigo-600 dark:bg-indigo-900/40 dark:text-indigo-400 mb-4">
                        <i data-lucide="inbox" class="w-8 h-8"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mb-2">Receive image</h2>
                    <p class="text-slate-600 dark:text-slate-400 mb-6 max-w-sm mx-auto">
                        Enter the 8-Digit Receive ID to fetch the encrypted file.
                    </p>
                    
                    <div class="max-w-xs mx-auto">
                        <div class="mb-4">
                            <input type="text" id="inputReceiveId" maxlength="8" placeholder="8-Digit ID" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-lg py-4 px-4 text-slate-800 dark:text-slate-100 font-mono font-bold tracking-[0.4em] focus:outline-none focus:ring-2 focus:ring-primary-500 text-center text-3xl shadow-inner">
                        </div>
                        <button id="fetchBtn" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-500/30 rounded-lg py-3 px-4 font-bold text-lg transition-all transform hover:scale-[1.02] active:scale-[0.98] flex justify-center items-center">
                            <i data-lucide="cloud-lightning" class="w-5 h-5 mr-2"></i> Fetch Secure File
                        </button>
                        <p id="fetchError" class="text-rose-500 text-sm font-medium mt-4 hidden"></p>
                    </div>
                </div>

                <!-- PIN Required Box -->
                <div id="pinPromptBox" class="hidden text-center py-4">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400 mb-4 animation-pulse">
                        <i data-lucide="lock-keyhole" class="w-8 h-8"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mb-2">Password Required</h2>
                    <p class="text-slate-600 dark:text-slate-400 mb-6 max-w-sm mx-auto">
                        File fetched and <strong class="text-rose-500">burned from server</strong>! Enter the 8-Digit PIN to decrypt it locally.
                    </p>
                    
                    <div class="max-w-xs mx-auto">
                        <div class="mb-4">
                            <input type="text" id="inputDecryptPin" maxlength="8" placeholder="8-Digit PIN" class="w-full bg-rose-50 dark:bg-slate-900 border border-rose-300 dark:border-rose-600 rounded-lg py-4 px-4 text-rose-800 dark:text-rose-100 font-mono font-bold tracking-[0.4em] focus:outline-none focus:ring-2 focus:ring-rose-500 text-center text-3xl shadow-inner">
                        </div>
                        <button id="decryptBtn" class="w-full bg-rose-600 hover:bg-rose-700 text-white shadow-lg shadow-rose-500/30 rounded-lg py-3 px-4 font-bold text-lg transition-all transform hover:scale-[1.02] active:scale-[0.98] flex justify-center items-center">
                            <i data-lucide="unlock" class="w-5 h-5 mr-2"></i> Decrypt Image
                        </button>
                        <p id="decryptError" class="text-rose-500 text-sm font-medium mt-4 hidden"></p>
                    </div>
                </div>
                
                <!-- Display Image Box -->
                <div id="imageResultBox" class="hidden">
                    <div class="flex justify-between items-end mb-4 border-b border-slate-200 dark:border-slate-700 pb-4">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 flex items-center">
                                <i data-lucide="unlock" class="w-5 h-5 text-emerald-500 mr-2"></i> Decrypted Successfully
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Image securely loaded and fully erased from server.</p>
                        </div>
                        <a id="downloadBtn" href="#" download="BulkTools_<?= rand(1000000, 9999999) ?>.png" class="bg-primary-600 hover:bg-primary-700 text-white rounded-lg py-2 px-6 font-bold shadow-lg transition-colors flex items-center transform hover:scale-[1.02]">
                            <i data-lucide="download" class="w-5 h-5 mr-2"></i> Save File
                        </a>
                    </div>
                    
                    <div class="bg-slate-100 dark:bg-slate-900 rounded-xl p-2 min-h-[200px] flex items-center justify-center max-w-full overflow-hidden">
                        <img id="decryptedImage" src="" class="max-w-full max-h-[65vh] object-contain rounded border border-slate-200 dark:border-slate-700">
                    </div>
                    <div class="mt-6 text-center">
                        <button onclick="location.reload();" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 font-medium flex justify-center items-center w-full bg-slate-50 dark:bg-slate-700 py-3 rounded-lg transition-colors">
                            <i data-lucide="rotate-ccw" class="w-5 h-5 mr-2"></i> Start Over
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* Custom Toggle Switch CSS */
.sr-only:checked ~ .toggle-bg { background-color: #10b981; border-color: #10b981; }
.sr-only:checked ~ .dot { transform: translateX(100%); }
</style>

<script>
// Tab Logic
const tabBtnSend = document.getElementById('tabBtnSend');
const tabBtnReceive = document.getElementById('tabBtnReceive');
const uploadSection = document.getElementById('uploadSection');
const receiveSection = document.getElementById('receiveSection');

function setTab(tab) {
    if (tab === 'send') {
        tabBtnSend.className = "flex-1 py-4 text-center font-bold text-lg text-primary-600 bg-primary-50 dark:bg-primary-900/20 dark:text-primary-400 border-b-2 border-primary-500 transition-colors";
        tabBtnReceive.className = "flex-1 py-4 text-center font-semibold text-lg text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 transition-colors";
        uploadSection.classList.remove('hidden');
        receiveSection.classList.add('hidden');
    } else {
        tabBtnReceive.className = "flex-1 py-4 text-center font-bold text-lg text-indigo-600 bg-indigo-50 dark:bg-indigo-900/20 dark:text-indigo-400 border-b-2 border-indigo-500 transition-colors";
        tabBtnSend.className = "flex-1 py-4 text-center font-semibold text-lg text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 transition-colors border-b border-transparent";
        receiveSection.classList.remove('hidden');
        uploadSection.classList.add('hidden');
    }
}

tabBtnSend.addEventListener('click', () => setTab('send'));
tabBtnReceive.addEventListener('click', () => setTab('receive'));

// Initial checks for pre-filled views (not strictly needed with new UX, but nice safety net if someone gives link anyway)
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.has('id')) {
    setTab('receive');
    document.getElementById('inputReceiveId').value = urlParams.get('id');
    setTimeout(() => performFetch(), 300);
}

// Overlays
const loadingOverlay = document.getElementById('loadingOverlay');
const loadingStatus = document.getElementById('loadingStatus');

function showLoading(text) {
    loadingStatus.textContent = text;
    loadingOverlay.classList.remove('hidden');
}
function hideLoading() {
    loadingOverlay.classList.add('hidden');
}

function copyToClipboard(elementId) {
    const input = document.getElementById(elementId);
    input.select();
    document.execCommand('copy');
    const originalText = input.value;
    input.value = "Copied!";
    setTimeout(() => { input.value = originalText; }, 1200);
}

// ====================== SEND MODE ======================
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');
const requirePassword = document.getElementById('requirePassword');

dropZone.addEventListener('click', () => fileInput.click());
dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-primary-500', 'bg-primary-50'); });
dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-primary-500', 'bg-primary-50'));
dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-primary-500', 'bg-primary-50');
    if (e.dataTransfer.files.length) handleFile(e.dataTransfer.files[0]);
});
fileInput.addEventListener('change', (e) => {
    if (e.target.files.length) handleFile(e.target.files[0]);
});

async function handleFile(file) {
    if (file.size > 10 * 1024 * 1024) { alert("File must be 10MB or less."); return; }
    if (!file.type.startsWith('image/')) { alert("Please upload an image file."); return; }

    try {
        showLoading('Deriving key and encrypting globally...');
        
        const base64DataUrl = await new Promise((resolve) => {
            const reader = new FileReader();
            reader.onload = (e) => resolve(e.target.result);
            reader.readAsDataURL(file);
        });

        // Crypto Logic
        let pinText = "";
        let displayPin = "";
        if (requirePassword.checked) {
            displayPin = Math.floor(10000000 + Math.random() * 90000000).toString();
            pinText = displayPin; // PIN we use to derive
        }

        const salt = crypto.getRandomValues(new Uint8Array(16));
        const iv = crypto.getRandomValues(new Uint8Array(12));

        const encoder = new TextEncoder();
        const pinMaterial = await crypto.subtle.importKey(
            "raw", encoder.encode(pinText), { name: "PBKDF2" }, false, ["deriveBits", "deriveKey"]
        );
        
        const key = await crypto.subtle.deriveKey(
            { name: "PBKDF2", salt: salt, iterations: 100000, hash: "SHA-256" },
            pinMaterial, { name: "AES-GCM", length: 256 }, true, ["encrypt"]
        );

        const dataToEncrypt = encoder.encode(base64DataUrl);
        const encryptedBuffer = await crypto.subtle.encrypt(
            { name: "AES-GCM", iv: iv }, key, dataToEncrypt
        );

        const encryptedArray = new Uint8Array(encryptedBuffer);
        const payloadArray = new Uint8Array(salt.length + iv.length + encryptedArray.length);
        payloadArray.set(salt, 0);
        payloadArray.set(iv, salt.length);
        payloadArray.set(encryptedArray, salt.length + iv.length);

        showLoading('Uploading securely...');
        const formData = new FormData();
        const blobToUpload = new Blob([payloadArray], { type: 'application/octet-stream' });
        formData.append('file', blobToUpload, 'encrypted.bin');

        const response = await fetch('process.php', { method: 'POST', body: formData });
        const result = await response.json();
        
        if (result.success && result.id) {
            hideLoading();
            dropZone.classList.add('hidden');
            document.getElementById('uploadOptions').classList.add('hidden');
            
            document.getElementById('shareReceiveId').value = result.id;
            
            const baseUrl = window.location.href.split('?')[0];
            document.getElementById('shareDirectLink').value = `${baseUrl}?id=${result.id}`;

            if (requirePassword.checked) {
                document.getElementById('sharePinKey').value = displayPin;
            } else {
                document.getElementById('pinResultContainer').style.display = 'none';
            }
            
            document.getElementById('shareResult').classList.remove('hidden');
            document.getElementById('resetBtnContainer').classList.remove('hidden');
        } else {
            hideLoading();
            alert("Error uploading: " + (result.message || "Unknown error"));
        }
    } catch (e) {
        console.error(e);
        hideLoading();
        alert("Encryption failed: " + e.message);
    }
}

// ====================== RECEIVE MODE ======================
const fetchBtn = document.getElementById('fetchBtn');
const inputReceiveId = document.getElementById('inputReceiveId');
const fetchError = document.getElementById('fetchError');

const decryptBtn = document.getElementById('decryptBtn');
const inputDecryptPin = document.getElementById('inputDecryptPin');
const decryptError = document.getElementById('decryptError');

const fetchPromptBox = document.getElementById('fetchPromptBox');
const pinPromptBox = document.getElementById('pinPromptBox');
const imageResultBox = document.getElementById('imageResultBox');

let fetchedPayload = null; // Store buffer globally after Burn fetch

fetchBtn.addEventListener('click', performFetch);
inputReceiveId.addEventListener('keypress', (e) => { if (e.key === 'Enter') performFetch(); });

decryptBtn.addEventListener('click', performDecryption);
inputDecryptPin.addEventListener('keypress', (e) => { if (e.key === 'Enter') performDecryption(); });

async function performFetch() {
    const id = inputReceiveId.value.trim();
    if (!id.match(/^[0-9]{8}$/)) {
        fetchError.textContent = "Please enter a valid 8-digit Receive ID.";
        fetchError.classList.remove('hidden');
        return;
    }
    fetchError.classList.add('hidden');

    try {
        showLoading('Fetching and Burning from server...');
        const response = await fetch(`fetch.php?id=${id}`);
        if (!response.ok) throw new Error(await response.text() || "File not found or already viewed.");
        
        const payloadBuffer = await response.arrayBuffer();
        
        // Cache payload array
        fetchedPayload = new Uint8Array(payloadBuffer);
        if (fetchedPayload.length < 28) throw new Error("Invalid crypt payload data.");

        // Silent Decrypt Attempt (Empty string password check)
        const isUnprotected = await attemptSilentDecrypt(fetchedPayload, "");
        if (isUnprotected) return; // If successful, attemptSilentDecrypt handles UI update!

        // If silent failed, it implies a password is required!
        hideLoading();
        fetchPromptBox.classList.add('hidden');
        pinPromptBox.classList.remove('hidden');
        setTimeout(() => inputDecryptPin.focus(), 100);

    } catch (e) {
        console.error(e);
        hideLoading();
        fetchError.textContent = "Error: " + e.message;
        fetchError.classList.remove('hidden');
    }
}

// Returns TRUE if successful, FALSE if fails (MAC mismatch)
async function attemptSilentDecrypt(payloadArray, pinString) {
    try {
        const salt = payloadArray.slice(0, 16);
        const iv = payloadArray.slice(16, 28);
        const encryptedData = payloadArray.slice(28);

        const encoder = new TextEncoder();
        const pinMaterial = await crypto.subtle.importKey(
            "raw", encoder.encode(pinString), { name: "PBKDF2" }, false, ["deriveBits", "deriveKey"]
        );

        const key = await crypto.subtle.deriveKey(
            { name: "PBKDF2", salt: salt, iterations: 100000, hash: "SHA-256" },
            pinMaterial, { name: "AES-GCM", length: 256 }, true, ["decrypt"]
        );

        const decryptedBuffer = await crypto.subtle.decrypt(
            { name: "AES-GCM", iv: iv }, key, encryptedData
        );

        // Success!
        const decoder = new TextDecoder();
        const dataUrlStr = decoder.decode(decryptedBuffer);
        
        hideLoading();
        fetchPromptBox.classList.add('hidden');
        pinPromptBox.classList.add('hidden');
        imageResultBox.classList.remove('hidden');
        
        document.getElementById('decryptedImage').src = dataUrlStr;
        document.getElementById('downloadBtn').href = dataUrlStr;
        
        return true; 
    } catch(e) {
        return false; // Decrypt failed (wrong/empty PIN)
    }
}

async function performDecryption() {
    const pin = inputDecryptPin.value.trim();
    if (!pin) {
        decryptError.textContent = "Please enter the 8-digit PIN.";
        decryptError.classList.remove('hidden');
        return;
    }
    decryptError.classList.add('hidden');
    showLoading('Decrypting...');

    const success = await attemptSilentDecrypt(fetchedPayload, pin);
    if (!success) {
        hideLoading();
        decryptError.textContent = "Incorrect PIN. The image cannot be decrypted.";
        decryptError.classList.remove('hidden');
    }
}

</script>

<?php require_once BASE_DIR . '/includes/footer.php'; ?>
