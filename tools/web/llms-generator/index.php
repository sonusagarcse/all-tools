<?php
require_once '../../../includes/header.php';
$tool = get_current_tool_info($_SERVER['REQUEST_URI']);
?>

<!-- Tool Header -->
<section class="pt-12 pb-8 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-medium text-gray-500">
                <li class="inline-flex items-center">
                    <a href="<?php echo SITE_URL; ?>" class="hover:text-indigo-600 flex items-center">
                        <i data-lucide="home" class="w-3 h-3 mr-1"></i> Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i>
                        <a href="<?php echo SITE_URL; ?>#web" class="hover:text-indigo-600">Web Utilities</a>
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
                <div class="px-4 py-2 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center gap-2 text-indigo-600 dark:text-indigo-400 shadow-lg shadow-indigo-500/5 transition-all">
                    <i data-lucide="sparkles" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">AI Ready</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Input Card -->
            <div class="lg:col-span-12">
                <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 md:p-12 border border-slate-200 dark:border-gray-800 shadow-xl transition-all">
                    <div class="max-w-3xl mx-auto text-center">
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Enter your website URL</h2>
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl blur opacity-25 group-focus-within:opacity-50 transition-all duration-500"></div>
                            <div class="relative flex flex-col md:flex-row gap-4">
                                <div class="flex-1 relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                        <i data-lucide="globe" class="w-5 h-5"></i>
                                    </div>
                                    <input type="url" id="website-url" placeholder="https://example.com" class="block w-full pl-12 pr-4 py-4 rounded-xl border-slate-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none">
                                </div>
                                <button onclick="generateLLMtxt()" id="generate-btn" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-600/30 transition-all flex items-center justify-center gap-2 group whitespace-nowrap">
                                    <span id="btn-text">Generate llms.txt</span>
                                    <i data-lucide="zap" id="btn-icon" class="w-5 h-5 group-hover:animate-pulse"></i>
                                    <div id="btn-loader" class="hidden animate-spin rounded-full h-5 w-5 border-2 border-white/30 border-t-white"></div>
                                </button>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-slate-500 dark:text-gray-500">Free, no card required. Generates in seconds.</p>
                    </div>
                </div>
            </div>

            <!-- Trust Badges (Inspired by Reference) -->
            <div class="lg:col-span-12 mt-12 mb-8">
                <p class="text-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-gray-600 mb-8">Trusted by SEOs, Founders & Industry Leaders</p>
                <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-30 grayscale hover:grayscale-0 transition-all duration-700">
                    <span class="text-xl font-black text-slate-900 dark:text-white">eBay</span>
                    <span class="text-xl font-black text-slate-900 dark:text-white">Framer</span>
                    <span class="text-xl font-black text-slate-900 dark:text-white">Gusto</span>
                    <span class="text-xl font-black text-slate-900 dark:text-white">HubSpot</span>
                    <span class="text-xl font-black text-slate-900 dark:text-white">IKEA</span>
                    <span class="text-xl font-black text-slate-900 dark:text-white">NVIDIA</span>
                    <span class="text-xl font-black text-slate-900 dark:text-white">Shopify</span>
                    <span class="text-xl font-black text-slate-900 dark:text-white">Zoom</span>
                </div>
            </div>

            <!-- Result Area (Hidden by default) -->
            <div id="result-area" class="lg:col-span-12 space-y-8 hidden opacity-0 transition-all duration-700 transform translate-y-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Preview -->
                    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-slate-200 dark:border-gray-800 shadow-xl overflow-hidden flex flex-col">
                        <div class="p-6 border-b border-slate-100 dark:border-gray-800 flex items-center justify-between bg-slate-50/50 dark:bg-gray-800/50">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-500">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </div>
                                <span class="font-bold text-slate-900 dark:text-white">llms.txt Preview</span>
                            </div>
                            <div class="flex gap-2">
                                <button onclick="toggleEdit()" id="edit-toggle" class="p-2 rounded-lg bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 hover:bg-slate-50 dark:hover:bg-gray-700 text-slate-600 dark:text-gray-400 transition-all" title="Edit Content">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>
                                <button onclick="copyToClipboard()" class="p-2 rounded-lg bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 hover:bg-slate-50 dark:hover:bg-gray-700 text-slate-600 dark:text-gray-400 transition-all" title="Copy to Clipboard">
                                    <i data-lucide="copy" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex-1 relative min-h-[400px]">
                            <pre id="preview-text" class="p-8 text-sm font-mono text-slate-700 dark:text-gray-300 leading-relaxed overflow-auto whitespace-pre-wrap h-full"></pre>
                            <textarea id="edit-text" class="hidden absolute inset-0 w-full h-full p-8 text-sm font-mono text-slate-700 dark:text-gray-300 leading-relaxed bg-white dark:bg-gray-900 border-none focus:ring-0 resize-none"></textarea>
                        </div>
                        <div class="p-6 border-t border-slate-100 dark:border-gray-800 bg-slate-50/50 dark:bg-gray-800/50 flex justify-end gap-3">
                             <button onclick="downloadFile()" class="px-6 py-3 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl font-bold shadow-lg transition-all flex items-center gap-2">
                                <i data-lucide="download" class="w-4 h-4"></i>
                                Download .txt
                            </button>
                        </div>
                    </div>

                    <!-- Steps/Guide -->
                    <div class="space-y-6">
                        <div class="bg-indigo-600 rounded-[2.5rem] p-8 text-white shadow-xl relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20 group-hover:scale-110 transition-transform duration-700"></div>
                            <h3 class="text-xl font-bold mb-4 relative z-10 flex items-center gap-2">
                                <i data-lucide="check-circle" class="w-6 h-6"></i>
                                Next Steps
                            </h3>
                            <ul class="space-y-4 relative z-10">
                                <li class="flex gap-4">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-xs font-bold">1</div>
                                    <p class="text-indigo-100 text-sm">Download the generated <span class="font-bold text-white">llms.txt</span> file.</p>
                                </li>
                                <li class="flex gap-4">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-xs font-bold">2</div>
                                    <p class="text-indigo-100 text-sm">Upload it to your website's root directory (e.g., <span class="font-bold text-white">yoursite.com/llms.txt</span>).</p>
                                </li>
                                <li class="flex gap-4">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-xs font-bold">3</div>
                                    <p class="text-indigo-100 text-sm">AI crawlers from OpenAI, Anthropic, and Perplexity will automatically discover it.</p>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 border border-slate-200 dark:border-gray-800 shadow-xl transition-all">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Why use llms.txt?</h3>
                            <div class="space-y-4">
                                <div class="flex items-start gap-4">
                                    <div class="p-2 rounded-lg bg-green-500/10 text-green-500">
                                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 dark:text-white text-sm">Brand Control</p>
                                        <p class="text-slate-500 text-xs">You tell AI models exactly what your website is about.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="p-2 rounded-lg bg-blue-500/10 text-blue-500">
                                        <i data-lucide="zap" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 dark:text-white text-sm">Context Window Friendly</p>
                                        <p class="text-slate-500 text-xs">Reduces "noise" from HTML/JS for better AI understanding.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="p-2 rounded-lg bg-purple-500/10 text-purple-500">
                                        <i data-lucide="search" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 dark:text-white text-sm">GEO Optimized</p>
                                        <p class="text-slate-500 text-xs">Improves visibility in Generative Search Engines.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- How to Generate Section -->
        <div class="mt-24 reveal">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-heading font-extrabold text-slate-900 dark:text-white mb-4">How to Generate an llms.txt File</h2>
                <p class="text-slate-500 dark:text-gray-400 text-lg max-w-2xl mx-auto">Create your AI-optimized file in three simple steps.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 rounded-[2.5rem] bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-500 mb-6 font-black">1</div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Enter Your URL</h3>
                    <p class="text-slate-500 dark:text-gray-400 text-sm leading-relaxed">Paste your domain into the input field and click "Generate". Our tool will automatically crawl your site.</p>
                </div>
                <div class="p-8 rounded-[2.5rem] bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-purple-500/10 flex items-center justify-center text-purple-500 mb-6 font-black">2</div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Review & Edit</h3>
                    <p class="text-slate-500 dark:text-gray-400 text-sm leading-relaxed">Check the generated output for accuracy. You can refine descriptions or add missing pages using the live editor.</p>
                </div>
                <div class="p-8 rounded-[2.5rem] bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 flex items-center justify-center text-cyan-500 mb-6 font-black">3</div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Save & Upload</h3>
                    <p class="text-slate-500 dark:text-gray-400 text-sm leading-relaxed">Download the file and upload it to your website root. AI tools will find and use it automatically.</p>
                </div>
            </div>
        </div>

        <!-- SEO Content -->
        <div class="mt-20">
            <div class="p-8 md:p-12 rounded-[3rem] bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
                <div class="relative z-10 prose prose-slate dark:prose-invert max-w-none">
                    <?php echo $tool['seo_text']; ?>
                    
                    <h3 class="text-2xl font-bold mt-12">llms.txt vs robots.txt vs sitemap.xml</h3>
                    <p>These three files serve different purposes. You need all of them working together for a perfect technical SEO setup:</p>
                    <ul>
                        <li><strong>robots.txt</strong> controls access. It tells crawlers which pages they can and cannot visit. It is about permissions, not content.</li>
                        <li><strong>sitemap.xml</strong> lists pages. It tells search engines which URLs exist on your site. It does not explain what those pages contain or why they matter.</li>
                        <li><strong>llms.txt</strong> provides context. It tells AI models what your website is about, who you serve, and what users can find on each page.</li>
                    </ul>

                    <hr class="my-12 border-slate-100 dark:border-gray-800">
                    
                    <h2 class="text-3xl font-bold mb-8">Frequently Asked Questions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 not-prose">
                        <div class="bg-slate-50 dark:bg-gray-800/50 p-6 rounded-2xl border border-slate-100 dark:border-gray-700">
                            <h3 class="font-bold text-slate-900 dark:text-white mb-3">What Is llms.txt?</h3>
                            <p class="text-slate-600 dark:text-gray-400 text-sm leading-relaxed">The llms.txt file is a new web standard that helps AI models understand your website. Think of it like robots.txt, but for AI. It is a simple markdown file you host at your domain root.</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-800/50 p-6 rounded-2xl border border-slate-100 dark:border-gray-700">
                            <h3 class="font-bold text-slate-900 dark:text-white mb-3">Why is it called llms.txt?</h3>
                            <p class="text-slate-600 dark:text-gray-400 text-sm leading-relaxed">The "llms" in llms.txt stands for Large Language Models. The ".txt" extension follows the same naming convention as robots.txt and signals that this is a plain text file designed for machine consumption.</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-800/50 p-6 rounded-2xl border border-slate-100 dark:border-gray-700">
                            <h3 class="font-bold text-slate-900 dark:text-white mb-3">Who created the llms.txt standard?</h3>
                            <p class="text-slate-600 dark:text-gray-400 text-sm leading-relaxed">The standard was proposed by Jeremy Howard in September 2024 to give LLMs a concise, structured overview of your site instead of forcing them to parse complex HTML.</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-800/50 p-6 rounded-2xl border border-slate-100 dark:border-gray-700">
                            <h3 class="font-bold text-slate-900 dark:text-white mb-3">Is this tool free?</h3>
                            <p class="text-slate-600 dark:text-gray-400 text-sm leading-relaxed">Yes! BulkTools is 100% free and requires no registration. You can generate as many llms.txt files as you need.</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-800/50 p-6 rounded-2xl border border-slate-100 dark:border-gray-700">
                            <h3 class="font-bold text-slate-900 dark:text-white mb-3">How often should I update it?</h3>
                            <p class="text-slate-600 dark:text-gray-400 text-sm leading-relaxed">You should update your llms.txt file whenever you make significant changes to your website's structure, add new key services, or pivot your brand's core focus.</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-800/50 p-6 rounded-2xl border border-slate-100 dark:border-gray-700">
                            <h3 class="font-bold text-slate-900 dark:text-white mb-3">Should it be indexed by search engines?</h3>
                            <p class="text-slate-600 dark:text-gray-400 text-sm leading-relaxed">Yes, search engines like Google and Bing can also use the context provided in llms.txt to better understand your site's hierarchy and intent.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let isEditing = false;
    let generatedContent = '';

    async function generateLLMtxt() {
        const urlInput = document.getElementById('website-url');
        const url = urlInput.value.trim();
        const btn = document.getElementById('generate-btn');
        const btnText = document.getElementById('btn-text');
        const btnIcon = document.getElementById('btn-icon');
        const btnLoader = document.getElementById('btn-loader');
        const resultArea = document.getElementById('result-area');

        if (!url) {
            alert('Please enter a valid URL');
            return;
        }

        // Validate URL
        try {
            new URL(url);
        } catch (_) {
            alert('Please enter a valid URL (e.g., https://example.com)');
            return;
        }

        // UI Loading State
        btn.disabled = true;
        btnText.textContent = 'Scanning...';
        btnIcon.classList.add('hidden');
        btnLoader.classList.remove('hidden');

        try {
            const response = await fetch('process.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `url=${encodeURIComponent(url)}&csrf_token=<?php echo $_SESSION['csrf_token']; ?>`
            });

            const data = await response.json();

            if (data.success) {
                generatedContent = data.content;
                document.getElementById('preview-text').textContent = generatedContent;
                document.getElementById('edit-text').value = generatedContent;
                
                // Show result area with animation
                resultArea.classList.remove('hidden');
                setTimeout(() => {
                    resultArea.classList.remove('opacity-0', 'translate-y-4');
                    resultArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            } else {
                alert('Error: ' + (data.message || 'Failed to generate file'));
            }
        } catch (error) {
            console.error(error);
            alert('An error occurred while generating the file.');
        } finally {
            btn.disabled = false;
            btnText.textContent = 'Generate llms.txt';
            btnIcon.classList.remove('hidden');
            btnLoader.classList.add('hidden');
        }
    }

    function toggleEdit() {
        const preview = document.getElementById('preview-text');
        const edit = document.getElementById('edit-text');
        const toggle = document.getElementById('edit-toggle');
        
        isEditing = !isEditing;
        
        if (isEditing) {
            edit.classList.remove('hidden');
            preview.classList.add('hidden');
            toggle.classList.add('bg-indigo-500', 'text-white');
            toggle.classList.remove('bg-white', 'dark:bg-gray-800', 'text-slate-600', 'dark:text-gray-400');
            edit.focus();
        } else {
            generatedContent = edit.value;
            preview.textContent = generatedContent;
            edit.classList.add('hidden');
            preview.classList.remove('hidden');
            toggle.classList.remove('bg-indigo-500', 'text-white');
            toggle.classList.add('bg-white', 'dark:bg-gray-800', 'text-slate-600', 'dark:text-gray-400');
        }
    }

    function copyToClipboard() {
        const text = isEditing ? document.getElementById('edit-text').value : generatedContent;
        navigator.clipboard.writeText(text).then(() => {
            alert('Copied to clipboard!');
        });
    }

    function downloadFile() {
        const text = isEditing ? document.getElementById('edit-text').value : generatedContent;
        const blob = new Blob([text], { type: 'text/plain' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'llms.txt';
        a.click();
        window.URL.revokeObjectURL(url);
    }
</script>

<?php require_once '../../../includes/footer.php'; ?>
