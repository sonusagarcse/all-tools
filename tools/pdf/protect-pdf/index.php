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
                <li><div class="flex items-center"><i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i><a href="<?php echo SITE_URL; ?>#pdf" class="hover:text-white">PDF Tools</a></div></li>
                <li aria-current="page"><div class="flex items-center"><i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i><span class="text-gray-300"><?php echo $tool['name']; ?></span></div></li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="max-w-2xl">
                <h1 class="text-3xl md:text-5xl font-heading font-extrabold text-white mb-4"><?php echo $tool['name']; ?></h1>
                <p class="text-gray-400 text-lg leading-relaxed"><?php echo $tool['desc']; ?></p>
            </div>
            <div class="px-4 py-2 rounded-xl bg-rose-500/10 border border-rose-500/20 flex items-center gap-2 text-rose-400">
                <i data-lucide="shield" class="w-5 h-5"></i>
                <span class="text-sm font-medium">AES-128 Encryption</span>
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
            <div class="upload-zone rounded-[40px] p-12 text-center cursor-pointer group mb-10">
                <input type="file" name="file" id="file-input" class="hidden" accept=".pdf">
                <div class="w-20 h-20 bg-rose-600/10 rounded-full flex items-center justify-center text-rose-400 mx-auto mb-8 group-hover:bg-rose-600 group-hover:text-white transition-all duration-300"><i data-lucide="shield" class="w-10 h-10"></i></div>
                <h2 class="text-2xl font-bold text-white mb-3">Select PDF to Protect</h2>
                <p class="text-gray-400 mb-8">Add password protection (Max 50MB)</p>
                <div class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-indigo-600 text-white font-bold hover:bg-indigo-500 shadow-lg shadow-indigo-600/20 transition-all">Browse File</div>
                <div class="file-display hidden mt-8 p-6 rounded-3xl bg-gray-900 border border-gray-800 text-left"><div class="flex items-center gap-4"><div class="p-3 bg-rose-500/10 rounded-xl text-rose-400"><i data-lucide="file-text" class="w-6 h-6"></i></div><div class="flex-grow"><p class="text-white font-bold text-sm mb-1 file-name"></p><p class="text-gray-500 text-xs file-size"></p></div></div></div>
            </div>

            <div class="glass-card rounded-3xl p-8 mb-10">
                <h3 class="text-white font-bold mb-6 flex items-center gap-2"><i data-lucide="lock" class="w-5 h-5 text-indigo-400"></i> Password Settings</h3>
                <div class="space-y-6">
                    <div>
                        <label class="block text-gray-400 text-sm font-medium mb-3">Set Password</label>
                        <input type="password" name="password" required minlength="4" placeholder="Minimum 4 characters" class="w-full px-4 py-3 rounded-xl border border-gray-800 bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-gray-400 text-sm font-medium mb-3">Confirm Password</label>
                        <input type="password" name="password_confirm" required minlength="4" placeholder="Re-enter password" class="w-full px-4 py-3 rounded-xl border border-gray-800 bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full py-5 rounded-3xl bg-indigo-600 text-white font-extrabold text-lg hover:bg-indigo-500 shadow-2xl shadow-indigo-600/30 transition-all flex items-center justify-center gap-3">Protect PDF <i data-lucide="arrow-right" class="w-6 h-6"></i></button>
        </form>

        <div id="progress-overlay" class="hidden animate-fade-in py-20 text-center"><div class="w-24 h-24 border-4 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin mx-auto mb-8"></div><h3 class="text-2xl font-bold text-white mb-2">Encrypting PDF</h3><p class="text-gray-400">Applying password protection...</p></div>

        <div id="result-section" class="hidden animate-fade-in py-12"><div class="glass-card rounded-[40px] p-8 md:p-12 text-center border-indigo-500/20 shadow-indigo-500/10"><div class="w-20 h-20 bg-green-500/10 rounded-3xl flex items-center justify-center text-green-500 mx-auto mb-8"><i data-lucide="check-circle" class="w-12 h-12"></i></div><h2 class="text-3xl font-bold text-white mb-4">PDF Protected!</h2><p class="text-gray-400 mb-10">Your PDF is now password-protected. Remember your password!</p><div class="flex gap-4 justify-center"><a id="download-btn" href="#" class="px-10 py-5 rounded-3xl bg-indigo-600 text-white font-extrabold text-lg flex items-center gap-2"><i data-lucide="download" class="w-6 h-6"></i> Download PDF</a></div></div></div>
    </div>
</section>

<script>document.addEventListener('DOMContentLoaded',()=>{handleToolForm('tool-form','process.php');});</script>
<?php require_once '../../../includes/footer.php'; ?>
