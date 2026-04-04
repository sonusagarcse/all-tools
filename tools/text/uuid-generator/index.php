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
            <div class="flex gap-3">
                <div class="px-4 py-2 rounded-xl bg-indigo-600/10 border border-indigo-600/20 flex items-center gap-2 text-indigo-400 shadow-lg shadow-indigo-600/5 transition-all">
                    <i data-lucide="zap" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Instant Generation</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-gray-950">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        
        <div class="glass-card rounded-[40px] p-12 mb-10">
            <h2 class="text-2xl font-bold text-white mb-6">Your v4 UUID</h2>
            
            <div class="relative group">
                <input type="text" id="uuid-output" class="w-full text-center py-6 px-6 mb-8 rounded-3xl bg-gray-900 border border-gray-800 text-indigo-400 text-2xl font-mono focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-xl" readonly value="Loading...">
                
                <button onclick="copyToClipboard('uuid-output')" class="absolute top-1/2 -translate-y-1/2 right-6 p-2 rounded-xl text-gray-500 hover:text-indigo-400 transition-all focus:outline-none" title="Copy UUID">
                    <i data-lucide="copy" class="w-6 h-6"></i>
                </button>
            </div>
            
            <button onclick="generateUUID()" class="w-full py-5 rounded-3xl bg-indigo-600 text-white font-extrabold text-lg hover:bg-indigo-500 shadow-2xl shadow-indigo-600/30 transition-all flex items-center justify-center gap-3">
                <i data-lucide="refresh-cw" class="w-6 h-6"></i> Generate New UUID
            </button>
        </div>

    </div>
</section>

<script>
    function generateUUID() {
        const output = document.getElementById('uuid-output');
        
        output.value = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            const r = Math.random() * 16 | 0, 
                  v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        generateUUID();
    });
</script>

<?php
require_once '../../../includes/footer.php';
?>
