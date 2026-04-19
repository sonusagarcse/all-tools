<?php
require_once dirname(dirname(dirname(__DIR__))) . '/includes/header.php';
?>

<div class="max-w-4xl mx-auto px-4 py-12">
    <!-- Tool Header -->
    <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-emerald-600/10 text-emerald-600 mb-4">
            <i data-lucide="message-circle" class="w-8 h-8"></i>
        </div>
        <h1 class="text-3xl md:text-4xl font-heading font-bold mb-4">WhatsApp Link Generator</h1>
        <p class="text-slate-600 dark:text-gray-400 max-w-2xl mx-auto">
            Create custom "Click to Chat" links for your WhatsApp account. Perfect for businesses, ads, and bios.
        </p>
    </div>

    <!-- Input Section -->
    <div class="glass rounded-[2rem] md:rounded-[2.5rem] p-6 md:p-10 shadow-xl mb-12 border border-slate-200 dark:border-gray-800">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 mb-8">
            <!-- Phone Number -->
            <div>
                <label class="block text-[10px] md:text-xs font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest mb-3">WhatsApp Number</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 font-bold">
                        +
                    </div>
                    <input type="number" id="phone" 
                        placeholder="919876543210" 
                        class="block w-full pl-8 pr-4 py-4 rounded-2xl border border-slate-200 dark:border-gray-800 bg-white dark:bg-gray-900 text-base md:text-lg font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                </div>
                <p class="text-[10px] text-slate-400 mt-2 ml-1 italic leading-tight">Include country code without symbols (e.g. 91xxxxxxxxxx)</p>
            </div>

            <!-- Custom Message -->
            <div>
                <label class="block text-[10px] md:text-xs font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-3">Custom Message (Optional)</label>
                <textarea id="message" rows="1" 
                    placeholder="Hi, I'm interested in your services..." 
                    class="block w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-gray-800 bg-white dark:bg-gray-900 text-sm md:text-base font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all resize-none"></textarea>
            </div>
        </div>

        <button id="gen-btn" class="w-full py-4 md:py-5 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-base md:text-lg rounded-2xl transition-all active:scale-[0.98] shadow-xl shadow-emerald-500/20 flex items-center justify-center gap-3">
            <i data-lucide="zap" class="w-5 h-5 md:w-6 md:h-6"></i>
            Generate WhatsApp Link
        </button>
    </div>

    <!-- Results Section (Hidden initially) -->
    <div id="results" class="hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
        <h2 class="text-lg md:text-xl font-heading font-bold mb-6 flex items-center gap-2 px-2">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500"></i> Your Link is Ready!
        </h2>

        <div class="glass rounded-[2rem] p-4 md:p-8 border border-emerald-100 dark:border-emerald-900/30">
            <!-- Link Display -->
            <div class="flex flex-col md:flex-row items-center gap-3 md:gap-4 mb-6 md:mb-8">
                <div class="flex-1 w-full bg-slate-50 dark:bg-gray-900/50 p-4 rounded-xl border border-dashed border-slate-300 dark:border-gray-700 font-mono text-xs md:text-sm break-all text-emerald-600 dark:text-emerald-400" id="link-display">
                    https://wa.me/919876543210
                </div>
                <div class="flex gap-2 w-full md:w-auto">
                    <button onclick="copyLink(this)" class="flex-1 md:flex-none px-4 md:px-6 py-3 md:py-4 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 font-bold rounded-xl hover:bg-emerald-600 hover:text-white transition-all flex items-center justify-center gap-2 text-sm md:text-base">
                        <i data-lucide="copy" class="w-4 h-4"></i> Copy
                    </button>
                    <button onclick="testLink()" class="flex-1 md:flex-none px-4 md:px-6 py-3 md:py-4 bg-slate-100 dark:bg-gray-800 text-slate-700 dark:text-slate-300 font-bold rounded-xl hover:bg-slate-900 dark:hover:bg-white dark:hover:text-black hover:text-white transition-all flex items-center justify-center gap-2 text-sm md:text-base">
                        <i data-lucide="external-link" class="w-4 h-4"></i> Test
                    </button>
                </div>
            </div>

            <!-- Preview/QR Area -->
            <div class="flex flex-col md:flex-row gap-8 items-stretch md:items-center pt-6 md:pt-8 border-t border-slate-100 dark:border-gray-800">
                <div class="flex-1">
                    <h4 class="text-[10px] md:text-xs font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-3 text-center md:text-left">Message Preview</h4>
                    <div class="bg-[#e5ddd5] dark:bg-[#0b141a] p-4 md:p-6 rounded-2xl relative overflow-hidden shadow-inner min-h-[100px] flex items-center justify-start">
                        <div class="bg-white dark:bg-[#1f2c33] p-3 rounded-xl rounded-tl-none shadow-sm text-sm text-slate-900 dark:text-white relative z-10 max-w-[90%] md:max-w-[85%] self-start">
                            <p id="msg-preview" class="break-words">Hi, I'm interested in your services...</p>
                            <span class="text-[9px] opacity-40 block text-right mt-1">10:45 AM ✓✓</span>
                        </div>
                        <div class="absolute inset-0 opacity-5 grayscale bg-[url('https://upload.wikimedia.org/wikipedia/commons/thumb/d/d9/WhatsApp_Wallpaper.jpg/1200px-WhatsApp_Wallpaper.jpg')]"></div>
                    </div>
                </div>
                <div class="flex flex-col items-center">
                    <h4 class="text-[10px] md:text-xs font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-3">Scan to Chat</h4>
                    <div id="qr-container" class="bg-white p-3 rounded-2xl shadow-lg border border-slate-100 flex items-center justify-center">
                        <!-- QR Code -->
                        <div class="w-32 h-32 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 overflow-hidden">
                            <i data-lucide="qr-code" class="w-12 h-12"></i>
                        </div>
                    </div>
                    <p class="text-[9px] text-slate-400 mt-3 font-bold uppercase tracking-widest">Click to download</p>
                </div>
            </div>
        </div>
    </div>

    <!-- SEO Text Section -->
    <div class="mt-16 prose prose-slate dark:prose-invert max-w-none">
        <div class="p-8 rounded-[2rem] bg-emerald-50/50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-900/30">
            <?php echo $current_tool['seo_text']; ?>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const phoneInput = document.getElementById('phone');
    const msgInput = document.getElementById('message');
    const genBtn = document.getElementById('gen-btn');
    const results = document.getElementById('results');
    const linkDisplay = document.getElementById('link-display');
    const msgPreview = document.getElementById('msg-preview');
    const qrContainer = document.getElementById('qr-container');

    let currentLink = '';
    let qrGenerator = null;

    genBtn.onclick = () => {
        const phone = phoneInput.value.replace(/\D/g, '');
        const message = msgInput.value.trim();

        if (phone.length < 7) {
            alert("Please enter a valid phone number with country code.");
            return;
        }

        currentLink = `https://wa.me/${phone}`;
        if (message) {
            currentLink += `?text=${encodeURIComponent(message)}`;
            msgPreview.innerText = message;
        } else {
            msgPreview.innerText = "Hello!";
        }

        linkDisplay.innerText = currentLink;
        
        // Generate QR Code
        qrContainer.innerHTML = ''; // Clear previous
        qrGenerator = new QRCode(qrContainer, {
            text: currentLink,
            width: 128,
            height: 128,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        results.classList.remove('hidden');
        results.scrollIntoView({ behavior: 'smooth', block: 'start' });
        
        if (typeof lucide !== 'undefined') lucide.createIcons();
    };

    // Download QR Code logic
    qrContainer.onclick = () => {
        const img = qrContainer.querySelector('img');
        if (!img) return;
        
        const a = document.createElement('a');
        a.href = img.src;
        a.download = `whatsapp-qr-${phoneInput.value}.png`;
        a.click();
    };

    window.copyLink = (btn) => {
        navigator.clipboard.writeText(currentLink).then(() => {
            const originalIcon = btn.innerHTML;
            btn.innerHTML = '<i data-lucide="check" class="w-4 h-4"></i> Sent!';
            btn.classList.add('bg-emerald-600', 'text-white');
            
            if (typeof lucide !== 'undefined') lucide.createIcons();
            
            setTimeout(() => {
                btn.innerHTML = originalIcon;
                btn.classList.remove('bg-emerald-600', 'text-white');
                if (typeof lucide !== 'undefined') lucide.createIcons();
            }, 2000);
        });
    };

    window.testLink = () => {
        window.open(currentLink, '_blank');
    };
});
</script>

<?php require_once dirname(dirname(dirname(__DIR__))) . '/includes/footer.php'; ?>
