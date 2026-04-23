<?php
require_once '../../../includes/header.php';
$tool = get_current_tool_info($_SERVER['REQUEST_URI']);

$target_url = $_POST['url'] ?? '';
$headers = [];
$error = '';

if (!empty($target_url)) {
    // Basic validation
    if (!filter_var($target_url, FILTER_VALIDATE_URL)) {
        $error = "Please enter a valid URL (including http:// or https://)";
    } else {
        // Fetch headers using CURL to have more control (MilesWeb should have it)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, 'BulkTools-Header-Checker/1.0');

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        if (curl_errno($ch)) {
            $error = "Error: " . curl_error($ch);
        } else {
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $raw_headers = substr($response, 0, $header_size);
            $headers = explode("\n", trim($raw_headers));
        }
        curl_close($ch);
    }
}
?>

<!-- Tool Header -->
<section class="pt-12 pb-8 bg-slate-50 dark:bg-gray-950 transition-colors">
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
                        <a href="<?php echo SITE_URL; ?>#web" class="hover:text-white">Web Utilities</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i>
                        <span class="text-slate-500 dark:text-gray-300"><?php echo $tool['name']; ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="max-w-2xl">
                <h1 class="text-3xl md:text-5xl font-heading font-extrabold text-slate-900 dark:text-white mb-4"><?php echo $tool['name']; ?></h1>
                <p class="text-slate-600 dark:text-gray-400 text-lg leading-relaxed"><?php echo $tool['desc']; ?></p>
            </div>
            <div class="flex gap-3">
                <div class="px-4 py-2 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center gap-2 text-blue-600 dark:text-blue-400 shadow-lg shadow-blue-500/5 transition-all">
                    <i data-lucide="activity" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Server Status</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="space-y-8">
            
            <!-- URL Input Form -->
            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 md:p-10 border border-slate-200 dark:border-gray-800 shadow-xl overflow-hidden relative">
                <form method="POST" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-grow">
                        <input type="url" name="url" value="<?php echo htmlspecialchars($target_url); ?>" placeholder="Enter URL (e.g., https://www.google.com)" class="w-full px-6 py-4 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-blue-500 rounded-2xl text-slate-900 dark:text-white font-bold transition-all outline-none" required>
                    </div>
                    <button type="submit" class="px-10 py-4 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl font-black uppercase tracking-widest shadow-xl shadow-blue-500/20 active:scale-95 transition-all flex items-center justify-center gap-2">
                        Check Headers
                    </button>
                </form>
                <?php if ($error): ?>
                    <p class="mt-4 text-red-500 text-sm font-bold flex items-center gap-2">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i> <?php echo $error; ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php if (!empty($headers)): ?>
            <!-- Results -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start animate-fade-in">
                
                <!-- Summary Card -->
                <div class="lg:col-span-4 bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 border border-slate-200 dark:border-gray-800 shadow-xl">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-6">Response Summary</label>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500">Status Code</span>
                            <span class="px-3 py-1 bg-green-500/10 text-green-500 rounded-lg text-sm font-black"><?php echo $info['http_code']; ?> OK</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500">Redirects</span>
                            <span class="text-sm font-black text-slate-900 dark:text-white"><?php echo $info['redirect_count']; ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500">Total Time</span>
                            <span class="text-sm font-black text-slate-900 dark:text-white"><?php echo round($info['total_time'], 3); ?>s</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500">Content Type</span>
                            <span class="text-xs font-black text-slate-900 dark:text-white truncate max-w-[150px]"><?php echo explode(';', $info['content_type'])[0]; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Raw Headers -->
                <div class="lg:col-span-8">
                    <div class="bg-slate-900 rounded-[2.5rem] p-8 md:p-10 shadow-2xl relative overflow-hidden">
                        <div class="flex items-center justify-between mb-8">
                            <span class="text-[10px] font-black uppercase tracking-widest text-blue-400">Raw HTTP Response Headers</span>
                            <button onclick="copyHeaders()" class="p-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-white transition-all">
                                <i data-lucide="copy" class="w-4 h-4"></i>
                            </button>
                        </div>
                        <div id="headers-output" class="font-mono text-sm leading-relaxed space-y-2">
                            <?php foreach ($headers as $header): 
                                $parts = explode(':', $header, 2);
                                if (count($parts) == 2):
                            ?>
                                <div class="flex gap-4 border-b border-white/5 pb-2">
                                    <span class="text-blue-400 font-bold shrink-0"><?php echo htmlspecialchars(trim($parts[0])); ?>:</span>
                                    <span class="text-slate-300 break-all"><?php echo htmlspecialchars(trim($parts[1])); ?></span>
                                </div>
                            <?php else: ?>
                                <div class="text-emerald-400 font-bold mb-4 bg-emerald-400/5 p-3 rounded-lg border border-emerald-400/20"><?php echo htmlspecialchars(trim($header)); ?></div>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
            <?php endif; ?>

        </div>

        <!-- SEO Content -->
        <div class="mt-20 prose prose-slate dark:prose-invert max-w-none">
            <div class="p-8 md:p-12 rounded-[3rem] bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
                <div class="relative z-10">
                    <?php echo $tool['seo_text']; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function copyHeaders() {
        const text = document.getElementById('headers-output').innerText;
        navigator.clipboard.writeText(text);
        alert('Headers copied to clipboard!');
    }
</script>

<?php require_once '../../../includes/footer.php'; ?>
