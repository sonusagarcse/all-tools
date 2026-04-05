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
                        <a href="<?php echo SITE_URL; ?>#dev" class="hover:text-white">Developer Tools</a>
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
                <div class="px-4 py-2 rounded-xl bg-green-500/10 border border-green-500/20 flex items-center gap-2 text-green-400 shadow-lg shadow-green-500/5 transition-all">
                    <i data-lucide="lock" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">100% Client Side</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Input -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-white font-bold inline-flex items-center gap-2">
                        <i data-lucide="key" class="w-4 h-4 text-indigo-400"></i> Encoded JWT
                    </h3>
                    <button onclick="document.getElementById('input-jwt').value = ''; decodeJWT();" class="text-xs text-gray-500 hover:text-white transition-colors">Clear</button>
                </div>
                <div class="relative">
                    <textarea id="input-jwt" oninput="decodeJWT()" class="w-full h-[500px] p-6 rounded-2xl bg-gray-900 border border-gray-800 text-indigo-300 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all resize-none shadow-inner leading-relaxed break-all" placeholder="Paste your JWT (eyJh...) here..."></textarea>
                </div>
            </div>

            <!-- Output -->
            <div class="space-y-6">
                <!-- Header Component -->
                <div class="space-y-3">
                    <h3 class="text-white font-bold inline-flex items-center gap-2">
                        <i data-lucide="file-json" class="w-4 h-4 text-cyan-400"></i> Header (Algorithm & Token Type)
                    </h3>
                    <div class="relative bg-gray-900/50 rounded-2xl border border-gray-800 overflow-hidden">
                        <pre id="output-header" class="p-6 text-cyan-300 font-mono text-sm overflow-x-auto m-0"></pre>
                    </div>
                </div>

                <!-- Payload Component -->
                <div class="space-y-3">
                    <h3 class="text-white font-bold inline-flex items-center gap-2">
                        <i data-lucide="database" class="w-4 h-4 text-purple-400"></i> Payload (Data)
                    </h3>
                    <div class="relative bg-gray-900/50 rounded-2xl border border-gray-800 overflow-hidden">
                        <pre id="output-payload" class="p-6 text-purple-300 font-mono text-sm overflow-x-auto m-0 h-[280px]"></pre>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    function decodeJWT() {
        const input = document.getElementById('input-jwt').value.trim();
        const headerEl = document.getElementById('output-header');
        const payloadEl = document.getElementById('output-payload');

        headerEl.innerHTML = '';
        payloadEl.innerHTML = '';

        if (!input) {
            headerEl.innerHTML = '<span class="text-gray-600">Waiting for input...</span>';
            payloadEl.innerHTML = '<span class="text-gray-600">Waiting for input...</span>';
            return;
        }

        const parts = input.split('.');
        
        if (parts.length !== 3) {
            headerEl.innerHTML = '<span class="text-red-400">Invalid JWT: Must have exactly 3 parts separated by dots.</span>';
            return;
        }

        try {
            // Note: Use decodeURIComponent to safely parse Unicode from Base64
            const header = JSON.stringify(JSON.parse(atob(parts[0].replace(/-/g, '+').replace(/_/g, '/'))), null, 4);
            const payload = JSON.stringify(JSON.parse(atob(parts[1].replace(/-/g, '+').replace(/_/g, '/'))), null, 4);
            
            headerEl.textContent = header;
            payloadEl.textContent = payload;
        } catch (e) {
            headerEl.innerHTML = '<span class="text-red-400">Error decoding JWT part. Ensure it is a valid Base64 URL encoded token.</span>';
            payloadEl.textContent = '';
        }
    }
    
    // Initialize state
    decodeJWT();
</script>

<?php require_once '../../../includes/footer.php'; ?>
