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
                        <a href="<?php echo SITE_URL; ?>#text" class="hover:text-white">Text Tools</a>
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
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-gray-950">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8">
            <div class="space-y-6">
                <div class="relative group">
                    <textarea id="text-input" class="w-full h-[400px] p-8 rounded-[40px] bg-gray-900 border border-gray-800 text-white text-lg placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all shadow-2xl resize-none" placeholder="Type in English here (e.g. hello) and hit space..."></textarea>
                    
                    <button onclick="document.getElementById('text-input').value = '';" class="absolute top-6 right-6 p-2 rounded-xl bg-gray-800 text-gray-400 hover:text-white transition-all" title="Clear Text">
                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                    </button>
                    
                    <button onclick="copyToClipboard('text-input')" class="absolute top-6 right-20 p-2 rounded-xl bg-indigo-600 text-white hover:bg-indigo-500 transition-all flex items-center gap-2 text-xs font-bold" title="Copy text">
                        <i data-lucide="copy" class="w-4 h-4"></i> Copy
                    </button>
                </div>
                
                <div class="flex items-center gap-4 text-sm text-gray-400">
                    <i data-lucide="info" class="w-4 h-4"></i>
                    Hit Space or Enter after typing an English word to convert it to Hindi.
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const textarea = document.getElementById('text-input');
    
    // Store cursor position and mapping
    textarea.addEventListener('keyup', async (e) => {
        if (e.key === ' ' || e.key === 'Enter') {
             await transliterateLastWord();
        }
    });

    async function transliterateLastWord() {
        const text = textarea.value;
        const selectionStart = textarea.selectionStart;
        
        // Find the word right before the cursor
        const textBeforeCursor = text.substring(0, selectionStart);
        const match = textBeforeCursor.match(/([a-zA-Z]+)(\s+)$/);
        
        if (match) {
            const word = match[1];
            const spacing = match[2];
            
            try {
                const response = await fetch(`https://inputtools.google.com/request?text=${word}&itc=hi-t-i0-und&num=1&cp=0&cs=1&ie=utf-8&oe=utf-8&app=demopage`);
                const data = await response.json();
                
                if (data[0] === 'SUCCESS') {
                    const hindiWord = data[1][0][1][0];
                    
                    // Replace the english word with hindi word
                    const newText = text.substring(0, selectionStart - word.length - spacing.length) + hindiWord + spacing + text.substring(selectionStart);
                    
                    textarea.value = newText;
                    
                    // Restore cursor position
                    const newCursorPos = selectionStart - word.length + hindiWord.length;
                    textarea.setSelectionRange(newCursorPos, newCursorPos);
                }
            } catch (err) {
                console.error("Transliteration failed:", err);
            }
        }
    }
    
    function copyToClipboard(id) {
        const copyText = document.getElementById(id);
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(copyText.value);
        alert("Copied to clipboard!");
    }
</script>

<?php
require_once '../../../includes/footer.php';
?>
