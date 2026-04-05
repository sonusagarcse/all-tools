<?php
require_once __DIR__ . '/includes/header.php';
?>

<section class="pt-16 pb-8 bg-slate-50 dark:bg-gray-950 border-b border-slate-200 dark:border-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2 text-xs font-medium text-slate-500 dark:text-gray-500">
                <li><a href="<?php echo SITE_URL; ?>" class="hover:text-indigo-600 flex items-center gap-1"><i data-lucide="home" class="w-3 h-3"></i> Home</a></li>
                <li><i data-lucide="chevron-right" class="w-3 h-3"></i></li>
                <li class="text-slate-700 dark:text-gray-300 font-semibold">Terms of Service</li>
            </ol>
        </nav>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-xs font-bold uppercase tracking-widest mb-4">
            <i data-lucide="file-text" class="w-3.5 h-3.5"></i> Legal
        </div>
        <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-slate-900 dark:text-white mb-3">Terms of Service</h1>
        <p class="text-slate-500 dark:text-gray-400 text-sm">Last updated: <?php echo date('F d, Y'); ?> &nbsp;·&nbsp; Effective: January 1, 2024</p>
    </div>
</section>

<section class="py-16 bg-white dark:bg-gray-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-10 text-slate-600 dark:text-gray-400 leading-relaxed">

            <div class="p-6 rounded-2xl bg-blue-50 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-500/20">
                <p class="text-blue-700 dark:text-blue-400 font-semibold text-sm flex items-start gap-2"><i data-lucide="info" class="w-5 h-5 flex-shrink-0 mt-0.5"></i> By using BulkTools, you agree to the following terms. Please read them carefully. If you disagree with any part, please discontinue use of the service.</p>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">1. Acceptance of Terms</h2>
                <p>By accessing or using BulkTools ("the Service"), you agree to be bound by these Terms of Service. These terms apply to all visitors, users, and others who access or use the service. We reserve the right to modify these terms at any time with or without prior notice.</p>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">2. Description of Service</h2>
                <p>BulkTools provides a collection of free, web-based utility tools for image manipulation, text processing, developer utilities, and security tools. These tools are provided "as-is" without any guarantee of uptime, accuracy, or fitness for a specific purpose.</p>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">3. Acceptable Use</h2>
                <p>You agree NOT to use BulkTools to:</p>
                <ul class="mt-4 space-y-2 list-disc list-inside">
                    <li>Upload files containing malware, viruses, or malicious code</li>
                    <li>Process copyrighted content without appropriate authorization</li>
                    <li>Engage in automated scraping, bot traffic, or denial-of-service attacks</li>
                    <li>Attempt to circumvent rate limits, security measures, or access controls</li>
                    <li>Upload child sexual abuse material (CSAM) or any illegal content</li>
                    <li>Use the service for any unlawful purpose under applicable law</li>
                    <li>Attempt to reverse-engineer, decompile, or extract proprietary code</li>
                </ul>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">4. Intellectual Property</h2>
                <p>All content, code, design, trademarks, and other materials on BulkTools are the property of BulkTools or its licensors. You may not copy, reproduce, distribute, or create derivative works without explicit written permission.</p>
                <p class="mt-4">Files you upload remain your property. By uploading files, you grant BulkTools a limited, temporary, non-exclusive license to process them solely for delivering the requested tool output. This license terminates when your files are deleted.</p>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">5. Disclaimer of Warranties</h2>
                <p>BulkTools is provided on an <strong>"AS IS" and "AS AVAILABLE"</strong> basis without warranties of any kind, either express or implied. We do not warrant that:</p>
                <ul class="mt-4 space-y-2 list-disc list-inside">
                    <li>The service will be uninterrupted, error-free, or completely secure</li>
                    <li>Results from tool processing will be 100% accurate or suitable for your needs</li>
                    <li>The service will be available at any particular time or location</li>
                </ul>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">6. Limitation of Liability</h2>
                <p>To the maximum extent permitted by applicable law, BulkTools and its operators shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including loss of data, resulting from your use of or inability to use the service.</p>
                <p class="mt-4">You use BulkTools at your own risk. We strongly recommend maintaining independent backups of all important files before processing them through any online tool.</p>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">7. Rate Limiting</h2>
                <p>To ensure fair access for all users, BulkTools enforces reasonable rate limits on file uploads and tool processing. Excessive use may result in temporary access restrictions. Deliberate circumvention of these limits is a violation of these terms.</p>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">8. Termination</h2>
                <p>We reserve the right to restrict or terminate access to BulkTools, without notice, for conduct that violates these Terms or is harmful to other users, us, third parties, or the Service itself.</p>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">9. Governing Law</h2>
                <p>These Terms shall be governed by and construed in accordance with applicable law. Any disputes shall be resolved through good-faith negotiation; if unresolved, subject to arbitration or the appropriate jurisdiction.</p>
            </div>

            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-3">10. Contact</h2>
                <div class="mt-4 p-5 rounded-2xl bg-slate-50 dark:bg-gray-900 border border-slate-200 dark:border-gray-800">
                    <p class="font-semibold text-slate-900 dark:text-white"><?php echo SITE_NAME; ?></p>
                    <p class="text-sm mt-1"><i data-lucide="mail" class="w-4 h-4 inline mr-1 text-indigo-500"></i> <a href="<?php echo SITE_URL; ?>/contact" class="text-indigo-600 dark:text-indigo-400 hover:underline">Contact via our Contact Page</a></p>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
