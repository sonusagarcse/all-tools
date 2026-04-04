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
                <li><div class="flex items-center"><i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i><a href="<?php echo SITE_URL; ?>#text" class="hover:text-white">Text Tools</a></div></li>
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
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-1 space-y-6">
                <div class="glass-card rounded-[32px] p-8">
                    <h3 class="text-white font-bold mb-6 flex items-center gap-2"><i data-lucide="settings" class="w-5 h-5 text-indigo-400"></i> Generation</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Paragraphs</label>
                            <input type="number" id="paras" value="3" min="1" max="20" class="w-full px-4 py-2 rounded-xl bg-gray-900 border border-gray-800 text-white">
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Length</label>
                            <select id="length" class="w-full px-4 py-2 rounded-xl bg-gray-900 border border-gray-800 text-white">
                                <option value="short">Short</option>
                                <option value="medium" selected>Medium</option>
                                <option value="long">Long</option>
                            </select>
                        </div>
                        <button id="gen-btn" class="w-full py-3 rounded-2xl bg-indigo-600 text-white font-bold hover:bg-indigo-500 transition-all mt-4">Generate</button>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-3 space-y-6">
                <div class="relative group">
                    <textarea id="output" readonly class="w-full h-[500px] p-8 rounded-[40px] bg-gray-900 border border-gray-800 text-white leading-relaxed focus:outline-none transition-all shadow-2xl resize-none"></textarea>
                    <button onclick="copyToClipboard('output')" class="absolute top-6 right-6 p-2 rounded-xl bg-indigo-600 text-white hover:bg-indigo-500 transition-all flex items-center gap-2 text-xs font-bold"><i data-lucide="copy" class="w-4 h-4"></i> Copy</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const loremParts = [
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. ", "Fusce non nunc in lacus condimentum gravida. ",
        "Sed volutpat neque sit amet semper venenatis. ", "Maecenas at nunc vitae metus semper vulputate. ",
        "Suspendisse nec tellus sed tellus pulvinar aliquet. ", "Donec sit amet arcu id tellus efficitur gravida. ",
        "Vivamus euismod justo nec nibh vulputate, nec semper neque dignissim. ", "Proin rhoncus risus in nunc lacinia, eu facilisis lorem vulputate. "
    ];
    
    document.getElementById('gen-btn').addEventListener('click', () => {
        const count = parseInt(document.getElementById('paras').value);
        const length = document.getElementById('length').value;
        const multiplier = length === 'short' ? 2 : (length === 'medium' ? 5 : 10);
        
        let output = "";
        for(let i=0; i<count; i++) {
            let p = "";
            for(let j=0; j<multiplier; j++) {
                p += loremParts[Math.floor(Math.random() * loremParts.length)];
            }
            output += p + "\n\n";
        }
        document.getElementById('output').value = output.trim();
    });

    // Auto-generate on load
    document.getElementById('gen-btn').click();
</script>

<?php require_once '../../../includes/footer.php'; ?>
