<?php
require_once '../../../includes/header.php';
$tool = get_current_tool_info($_SERVER['REQUEST_URI']);
?>

<section class="pt-12 pb-8 bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-medium text-gray-500">
                <li class="inline-flex items-center"><a href="<?php echo SITE_URL; ?>" class="hover:text-white flex items-center"><i data-lucide="home" class="w-3 h-3 mr-1"></i> Home</a></li>
                <li><div class="flex items-center"><i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i><a href="<?php echo SITE_URL; ?>#downloader" class="hover:text-white">Video Downloader</a></div></li>
                <li aria-current="page"><div class="flex items-center"><i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i><span class="text-gray-300"><?php echo $tool['name']; ?></span></div></li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="max-w-2xl">
                <h1 class="text-3xl md:text-5xl font-heading font-extrabold text-white mb-4"><?php echo $tool['name']; ?></h1>
                <p class="text-gray-400 text-lg leading-relaxed"><?php echo $tool['desc']; ?></p>
            </div>
            <div class="px-4 py-2 rounded-xl bg-sky-500/10 border border-sky-500/20 flex items-center gap-2 text-sky-400">
                <i data-lucide="twitter" class="w-5 h-5"></i>
                <span class="text-sm font-medium">Videos & GIFs</span>
            </div>
        </div>
    </div>
</section>

<section class="pb-24 bg-gray-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div id="error-alert" class="hidden mb-8 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 flex items-start gap-3"><i data-lucide="alert-circle" class="w-5 h-5 text-red-500 mt-0.5"></i><div><p class="text-sm font-bold text-red-500 mb-1">Error Occurred</p><p class="text-sm text-red-400/80 error-msg"></p></div></div>

        <form id="url-form" class="animate-fade-in mb-12">
            <input type="hidden" name="action" value="fetch_info">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="relative group">
                <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none"><i data-lucide="link" class="w-6 h-6 text-gray-500"></i></div>
                <input type="url" name="url" required class="block w-full pl-14 pr-32 py-5 rounded-3xl bg-gray-900 border border-gray-800 text-lg text-white focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all shadow-2xl" placeholder="Paste Twitter/X link here...">
                <button type="submit" class="absolute right-3 top-2.5 px-6 py-2.5 rounded-2xl bg-sky-500 text-white font-bold hover:bg-sky-400 transition-all flex items-center gap-2">Fetch Info <i data-lucide="zap" class="w-4 h-4"></i></button>
            </div>
        </form>

        <div id="progress-overlay" class="hidden animate-fade-in py-20 text-center"><div class="relative w-24 h-24 mx-auto mb-8"><div class="absolute inset-0 border-4 border-gray-800 rounded-full"></div><div class="absolute inset-0 border-4 border-sky-500 rounded-full border-t-transparent animate-spin"></div></div><h3 class="text-2xl font-bold text-white mb-2">Analyzing URL</h3><p class="text-gray-400">This may take a few seconds...</p></div>

        <div id="result-section" class="hidden animate-fade-in space-y-8">
            <div class="glass-card rounded-[40px] p-8 md:p-12 flex flex-col md:flex-row gap-8">
                <div class="w-full md:w-1/3"><img id="video-thumbnail" src="" alt="Thumbnail" class="w-full rounded-2xl shadow-2xl object-cover aspect-video"></div>
                <div class="w-full md:w-2/3">
                    <h2 id="video-title" class="text-2xl font-bold text-white mb-2 line-clamp-2">Loading...</h2>
                    <p class="text-gray-400 text-sm mb-6 flex items-center gap-4"><span id="video-duration" class="flex items-center gap-1.5"><i data-lucide="clock" class="w-4 h-4"></i> --:--</span><span id="video-uploader" class="flex items-center gap-1.5"><i data-lucide="user" class="w-4 h-4"></i> Loading...</span></p>
                    <form id="download-form" action="process.php" method="POST">
                        <input type="hidden" name="action" value="download"><input type="hidden" name="url" id="hidden-url"><input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="space-y-4 mb-8"><label class="block text-white font-bold text-sm mb-3">Select Format:</label><div id="format-list" class="grid grid-cols-1 sm:grid-cols-2 gap-3"></div></div>
                        <button type="submit" class="w-full py-4 rounded-2xl bg-sky-500 text-white font-extrabold text-lg hover:bg-sky-400 shadow-xl transition-all flex items-center justify-center gap-2"><i data-lucide="download" class="w-6 h-6"></i> Download Selected</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="final-download" class="hidden animate-fade-in py-12"><div class="glass-card rounded-[40px] p-8 md:p-12 text-center border-sky-500/20"><div class="w-20 h-20 bg-green-500/10 rounded-3xl flex items-center justify-center text-green-500 mx-auto mb-8"><i data-lucide="check-circle" class="w-12 h-12"></i></div><h2 class="text-3xl font-bold text-white mb-4">File is Ready!</h2><div class="flex gap-4 justify-center mt-10"><a id="final-btn" href="#" class="px-10 py-5 rounded-3xl bg-sky-500 text-white font-extrabold text-lg flex items-center gap-2"><i data-lucide="download" class="w-6 h-6"></i> Download File</a></div></div></div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const urlForm = document.getElementById('url-form'), progressOverlay = document.getElementById('progress-overlay'), resultSection = document.getElementById('result-section'), finalDownload = document.getElementById('final-download'), errorAlert = document.getElementById('error-alert');
    urlForm.addEventListener('submit', async (e) => { e.preventDefault(); errorAlert.classList.add('hidden'); progressOverlay.classList.remove('hidden'); resultSection.classList.add('hidden'); finalDownload.classList.add('hidden'); const formData = new FormData(urlForm); try { const response = await fetch('process.php', { method: 'POST', body: formData }); const result = await response.json(); progressOverlay.classList.add('hidden'); if (result.success) { document.getElementById('video-thumbnail').src = result.thumbnail; document.getElementById('video-title').textContent = result.title; document.getElementById('video-duration').innerHTML = `<i data-lucide="clock" class="w-4 h-4"></i> ${result.duration_string}`; document.getElementById('video-uploader').innerHTML = `<i data-lucide="user" class="w-4 h-4"></i> ${result.uploader}`; document.getElementById('hidden-url').value = result.webpage_url; const formatList = document.getElementById('format-list'); formatList.innerHTML = ''; result.formats.forEach(f => { const div = document.createElement('label'); div.className = 'cursor-pointer'; div.innerHTML = `<input type="radio" name="format_id" value="${f.format_id}" checked class="peer sr-only"><div class="px-4 py-3 rounded-xl border border-gray-800 bg-gray-900 text-gray-400 text-sm flex justify-between items-center peer-checked:border-sky-500 peer-checked:bg-sky-500/10 peer-checked:text-white transition-all"><span>${f.quality} (${f.ext})</span><span class="opacity-50">${f.filesize_str}</span></div>`; formatList.appendChild(div); }); resultSection.classList.remove('hidden'); lucide.createIcons(); } else { errorAlert.querySelector('.error-msg').textContent = result.message; errorAlert.classList.remove('hidden'); } } catch (err) { progressOverlay.classList.add('hidden'); errorAlert.querySelector('.error-msg').textContent = 'Network error or yt-dlp unavailable.'; errorAlert.classList.remove('hidden'); } });
    const downloadForm = document.getElementById('download-form'); downloadForm.addEventListener('submit', async (e) => { e.preventDefault(); progressOverlay.classList.remove('hidden'); progressOverlay.querySelector('h3').textContent = 'Generating Download Link'; const formData = new FormData(downloadForm); try { const response = await fetch('process.php', { method: 'POST', body: formData }); const result = await response.json(); progressOverlay.classList.add('hidden'); if (result.success) { resultSection.classList.add('hidden'); document.getElementById('final-btn').href = result.download_url; finalDownload.classList.remove('hidden'); } else { errorAlert.querySelector('.error-msg').textContent = result.message; errorAlert.classList.remove('hidden'); } } catch (err) { progressOverlay.classList.add('hidden'); errorAlert.querySelector('.error-msg').textContent = 'Download failed.'; errorAlert.classList.remove('hidden'); } });
});
</script>
<?php require_once '../../../includes/footer.php'; ?>
