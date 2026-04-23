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
                    <i data-lucide="shield-check" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Legally Ready</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Step-by-Step Form -->
            <div class="lg:col-span-5 bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 md:p-10 border border-slate-200 dark:border-gray-800 shadow-xl overflow-hidden relative">
                <div id="form-steps" class="space-y-8">
                    <div class="step" data-step="1">
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Website Info</label>
                        <div class="space-y-4">
                            <input type="text" id="site-name" placeholder="Website Name (e.g., BulkTools)" class="w-full px-6 py-4 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-blue-500 rounded-2xl text-slate-900 dark:text-white font-bold transition-all outline-none">
                            <input type="url" id="site-url" placeholder="Website URL (e.g., https://example.com)" class="w-full px-6 py-4 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-blue-500 rounded-2xl text-slate-900 dark:text-white font-bold transition-all outline-none">
                        </div>
                    </div>

                    <div class="step" data-step="2">
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Tracking & Cookies</label>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-gray-800 rounded-2xl cursor-pointer hover:bg-slate-100 dark:hover:bg-gray-750 transition-colors">
                                <input type="checkbox" id="check-cookies" class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-sm font-bold text-slate-700 dark:text-gray-300">Do you use cookies?</span>
                            </label>
                            <label class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-gray-800 rounded-2xl cursor-pointer hover:bg-slate-100 dark:hover:bg-gray-750 transition-colors">
                                <input type="checkbox" id="check-adsense" class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-sm font-bold text-slate-700 dark:text-gray-300">Do you use Google AdSense?</span>
                            </label>
                            <label class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-gray-800 rounded-2xl cursor-pointer hover:bg-slate-100 dark:hover:bg-gray-750 transition-colors">
                                <input type="checkbox" id="check-analytics" class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-sm font-bold text-slate-700 dark:text-gray-300">Do you use Google Analytics?</span>
                            </label>
                        </div>
                    </div>

                    <div class="step" data-step="3">
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Contact Info</label>
                        <input type="email" id="site-email" placeholder="Contact Email (e.g., support@example.com)" class="w-full px-6 py-4 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-blue-500 rounded-2xl text-slate-900 dark:text-white font-bold transition-all outline-none">
                    </div>

                    <button onclick="generatePolicy()" class="w-full py-5 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl font-black uppercase tracking-widest shadow-xl shadow-blue-500/20 active:scale-95 transition-all flex items-center justify-center gap-2">
                        <i data-lucide="file-text" class="w-5 h-5"></i> Generate Policy
                    </button>
                </div>
            </div>

            <!-- Policy Preview -->
            <div class="lg:col-span-7">
                <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-1 border border-slate-200 dark:border-gray-800 shadow-xl overflow-hidden min-h-[500px] flex flex-col">
                    <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-gray-800 bg-slate-50/50 dark:bg-gray-800/50">
                        <span class="text-xs font-black uppercase tracking-widest text-slate-400">Live Preview</span>
                        <div class="flex gap-2">
                            <button onclick="copyPolicy()" class="p-2.5 rounded-xl bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 text-slate-500 hover:text-blue-500 transition-colors shadow-sm" title="Copy to Clipboard">
                                <i data-lucide="copy" class="w-4 h-4"></i>
                            </button>
                            <button onclick="downloadPolicy()" class="p-2.5 rounded-xl bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 text-slate-500 hover:text-blue-500 transition-colors shadow-sm" title="Download as .txt">
                                <i data-lucide="download" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div id="policy-preview" class="p-8 md:p-12 font-mono text-sm text-slate-600 dark:text-gray-400 overflow-y-auto max-h-[600px] leading-relaxed whitespace-pre-wrap">
Enter your details on the left to generate your customized privacy policy.

Our generator creates a comprehensive, legally-sound document that covers data collection, cookies, third-party services, and user rights.
                    </div>
                </div>
            </div>

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
    function generatePolicy() {
        const siteName = document.getElementById('site-name').value || '[Website Name]';
        const siteUrl = document.getElementById('site-url').value || '[Website URL]';
        const siteEmail = document.getElementById('site-email').value || '[Email Address]';
        const useCookies = document.getElementById('check-cookies').checked;
        const useAdsense = document.getElementById('check-adsense').checked;
        const useAnalytics = document.getElementById('check-analytics').checked;

        const date = new Date().toLocaleDateString();

        let policy = `Privacy Policy for ${siteName}\n`;
        policy += `Last Updated: ${date}\n\n`;
        
        policy += `At ${siteName}, accessible from ${siteUrl}, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by ${siteName} and how we use it.\n\n`;
        
        policy += `If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us at ${siteEmail}.\n\n`;

        policy += `1. Consent\nBy using our website, you hereby consent to our Privacy Policy and agree to its terms.\n\n`;

        policy += `2. Information we collect\nThe personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.\n\n`;

        if (useCookies) {
            policy += `3. Log Files and Cookies\n${siteName} follows a standard procedure of using log files. These files log visitors when they visit websites. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable.\n\n`;
        }

        if (useAdsense) {
            policy += `4. Google DoubleClick DART Cookie\nGoogle is one of a third-party vendor on our site. It also uses cookies, known as DART cookies, to serve ads to our site visitors based upon their visit to www.website.com and other sites on the internet. However, visitors may choose to decline the use of DART cookies by visiting the Google ad and content network Privacy Policy.\n\n`;
        }

        policy += `5. Third Party Privacy Policies\n${siteName}'s Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information.\n\n`;

        policy += `6. GDPR Data Protection Rights\nWe would like to make sure you are fully aware of all of your data protection rights. Every user is entitled to the following:\nThe right to access – You have the right to request copies of your personal data.\nThe right to rectification – You have the right to request that we correct any information you believe is inaccurate.\n\n`;

        policy += `7. Children's Information\nAnother part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity. ${siteName} does not knowingly collect any Personal Identifiable Information from children under the age of 13.`;

        document.getElementById('policy-preview').textContent = policy;
        document.getElementById('policy-preview').classList.add('text-slate-900', 'dark:text-white');
        lucide.createIcons();
    }

    function copyPolicy() {
        const text = document.getElementById('policy-preview').textContent;
        navigator.clipboard.writeText(text);
        alert('Privacy Policy copied to clipboard!');
    }

    function downloadPolicy() {
        const text = document.getElementById('policy-preview').textContent;
        const blob = new Blob([text], { type: 'text/plain' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'privacy-policy.txt';
        a.click();
    }
</script>

<?php require_once '../../../includes/footer.php'; ?>
