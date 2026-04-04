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
        <div class="space-y-6">
            <div class="relative">
                <textarea id="case-input" class="w-full h-[400px] p-8 rounded-[40px] bg-gray-900 border border-gray-800 text-white text-lg focus:ring-2 focus:ring-indigo-500 transition-all shadow-2xl resize-none" placeholder="Enter text here..."></textarea>
                <div class="absolute top-6 right-6 flex gap-2">
                    <button onclick="copyToClipboard('case-input')" class="p-2 rounded-xl bg-indigo-600 text-white hover:bg-indigo-500 transition-all font-bold text-xs flex items-center gap-2"><i data-lucide="copy" class="w-4 h-4"></i> Copy</button>
                    <button onclick="document.getElementById('case-input').value = ''" class="p-2 rounded-xl bg-gray-800 text-gray-400 hover:text-white transition-all"><i data-lucide="trash-2" class="w-5 h-5"></i></button>
                </div>
            </div>

            <div class="flex flex-wrap gap-4">
                <button onclick="changeCase('upper')" class="px-6 py-3 rounded-2xl bg-gray-800 text-white font-bold hover:bg-indigo-600 transition-all">UPPER CASE</button>
                <button onclick="changeCase('lower')" class="px-6 py-3 rounded-2xl bg-gray-800 text-white font-bold hover:bg-indigo-600 transition-all">lower case</button>
                <button onclick="changeCase('sentence')" class="px-6 py-3 rounded-2xl bg-gray-800 text-white font-bold hover:bg-indigo-600 transition-all">Sentence case</button>
                <button onclick="changeCase('capital')" class="px-6 py-3 rounded-2xl bg-gray-800 text-white font-bold hover:bg-indigo-600 transition-all">Capital Case</button>
                <button onclick="changeCase('inverse')" class="px-6 py-3 rounded-2xl bg-gray-800 text-white font-bold hover:bg-indigo-600 transition-all">iNvErSe cAsE</button>
            </div>
        </div>
    </div>
</section>

<script>
    function changeCase(type) {
        const area = document.getElementById('case-input');
        let text = area.value;
        if (type === 'upper') area.value = text.toUpperCase();
        if (type === 'lower') area.value = text.toLowerCase();
        if (type === 'sentence') {
            area.value = text.toLowerCase().replace(/(^\s*\w|[\.\!\?]\s*\w)/g, c => c.toUpperCase());
        }
        if (type === 'capital') {
            area.value = text.toLowerCase().split(' ').map(s => s.charAt(0).toUpperCase() + s.substring(1)).join(' ');
        }
        if (type === 'inverse') {
            area.value = text.split('').map(c => c === c.toUpperCase() ? c.toLowerCase() : c.toUpperCase()).join('');
        }
    }
</script>

<?php require_once '../../../includes/footer.php'; ?>
