<?php
require_once __DIR__ . '/includes/header.php';
?>

<section class="pt-16 pb-8 bg-slate-50 dark:bg-gray-950 border-b border-slate-200 dark:border-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2 text-xs font-medium text-slate-500 dark:text-gray-500">
                <li><a href="<?php echo SITE_URL; ?>" class="hover:text-indigo-600 flex items-center gap-1"><i data-lucide="home" class="w-3 h-3"></i> Home</a></li>
                <li><i data-lucide="chevron-right" class="w-3 h-3"></i></li>
                <li class="text-slate-700 dark:text-gray-300 font-semibold">Privacy Policy</li>
            </ol>
        </nav>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-xs font-bold uppercase tracking-widest mb-4">
            <i data-lucide="shield" class="w-3.5 h-3.5"></i> Legal
        </div>
        <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-slate-900 dark:text-white mb-3">Privacy Policy</h1>
        <p class="text-slate-500 dark:text-gray-400 text-sm">Last updated: <?php echo date('F d, Y'); ?> &nbsp;·&nbsp; Effective: January 1, 2024</p>
    </div>
</section>

<section class="py-16 bg-white dark:bg-gray-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-slate dark:prose-invert max-w-none space-y-10 text-slate-600 dark:text-gray-400 leading-relaxed">

            <div class="p-6 rounded-2xl bg-green-50 dark:bg-green-500/10 border border-green-100 dark:border-green-500/20">
                <p class="text-green-700 dark:text-green-400 font-semibold text-sm flex items-start gap-2"><i data-lucide="shield-check" class="w-5 h-5 flex-shrink-0 mt-0.5"></i> <strong>Short version:</strong> We do not sell your data. We do not store uploaded files beyond your session. We do not require registration. Your privacy is our top priority.</p>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">1. Information We Collect</h2>
                <p>BulkTools is designed to be a privacy-first platform. We collect minimal information necessary to operate the service:</p>
                <ul class="mt-4 space-y-2 list-disc list-inside">
                    <li><strong>Files you upload:</strong> Images or text you submit to our tools are processed server-side and automatically deleted from our servers within minutes of your session ending. We never store, analyze, or share your uploaded content.</li>
                    <li><strong>Text inputs:</strong> Text-based tools (Word Counter, Case Converter, JSON Formatter, etc.) process all data locally in your browser. Nothing is sent to our servers.</li>
                    <li><strong>Usage data:</strong> We may collect anonymized, aggregated analytics such as page views, tool usage frequency, and approximate geographic region (country-level) via privacy-respecting tools (Umami Analytics). No personally identifiable information is collected.</li>
                    <li><strong>Log files:</strong> Standard web server logs (IP address, browser type, pages visited, timestamps) may be retained for up to 30 days for security and error-monitoring purposes.</li>
                </ul>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">2. How We Use Your Information</h2>
                <p>Any data collected is used exclusively to:</p>
                <ul class="mt-4 space-y-2 list-disc list-inside">
                    <li>Process and return results from tool requests</li>
                    <li>Improve site performance and identify errors</li>
                    <li>Monitor for abuse or security threats</li>
                    <li>Understand aggregate usage patterns to prioritize new features</li>
                </ul>
                <p class="mt-4">We do <strong>not</strong> use your data for advertising, profiling, or any commercial purposes beyond operating BulkTools.</p>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">3. File Upload Security</h2>
                <p>Files uploaded to BulkTools are:</p>
                <ul class="mt-4 space-y-2 list-disc list-inside">
                    <li>Stored in an isolated, private server directory inaccessible to other users</li>
                    <li>Processed exclusively for the purpose of the requested tool operation</li>
                    <li>Automatically deleted from our servers within 15–60 minutes after processing</li>
                    <li>Never shared with, sold to, or accessible by any third party</li>
                    <li>Never used to train AI models or for any other secondary purpose</li>
                </ul>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">4. Cookies &amp; Local Storage</h2>
                <p>BulkTools uses minimal, privacy-respecting browser storage:</p>
                <ul class="mt-4 space-y-2 list-disc list-inside">
                    <li><strong>Theme preference:</strong> We store your dark/light mode preference in <code class="bg-slate-100 dark:bg-gray-800 px-1.5 py-0.5 rounded text-xs font-mono">localStorage</code> so your choice persists across visits. No server communication occurs.</li>
                    <li><strong>Session cookies:</strong> A short-lived session cookie is used for security purposes (CSRF protection) when using file upload tools. This expires when you close your browser.</li>
                    <li>We do <strong>not</strong> use tracking cookies, advertising cookies, or third-party marketing cookies.</li>
                </ul>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">5. Third-Party Services</h2>
                <p>We use the following limited third-party services:</p>
                <ul class="mt-4 space-y-2 list-disc list-inside">
                    <li><strong>Umami Analytics:</strong> A self-hosted, privacy-friendly analytics platform. Collects no personal data and is fully GDPR-compliant. No data is shared with Google or other ad companies.</li>
                    <li><strong>Google Fonts &amp; Tailwind CDN:</strong> Font and CSS library loaded from CDN. Font providers may log standard HTTP request data per their own privacy policies.</li>
                </ul>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">6. Children's Privacy</h2>
                <p>BulkTools is not directed at children under the age of 13. We do not knowingly collect any personal information from children. If you believe a child has submitted personal information through our service, please contact us immediately.</p>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">7. Changes to This Policy</h2>
                <p>We may update this Privacy Policy occasionally. Changes will be reflected by updating the "Last Updated" date at the top of this page. We encourage you to review this policy periodically. Your continued use of BulkTools after changes constitutes acceptance of the updated policy.</p>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">8. Contact Us</h2>
                <p>If you have questions, concerns, or requests regarding this Privacy Policy, please contact us:</p>
                <div class="mt-4 p-5 rounded-2xl bg-slate-50 dark:bg-gray-900 border border-slate-200 dark:border-gray-800">
                    <p class="font-semibold text-slate-900 dark:text-white"><?php echo SITE_NAME; ?></p>
                    <p class="text-sm mt-1"><i data-lucide="mail" class="w-4 h-4 inline mr-1 text-indigo-500"></i> <a href="<?php echo SITE_URL; ?>/contact" class="text-indigo-600 dark:text-indigo-400 hover:underline">Contact via our Contact Page</a></p>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
