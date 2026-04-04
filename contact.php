<?php
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero -->
<section class="pt-16 pb-8 bg-slate-50 dark:bg-gray-950 border-b border-slate-200 dark:border-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2 text-xs font-medium text-slate-500 dark:text-gray-500">
                <li><a href="<?php echo SITE_URL; ?>" class="hover:text-indigo-600 flex items-center gap-1"><i data-lucide="home" class="w-3 h-3"></i> Home</a></li>
                <li><i data-lucide="chevron-right" class="w-3 h-3"></i></li>
                <li class="text-slate-700 dark:text-gray-300 font-semibold">Contact Us</li>
            </ol>
        </nav>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-xs font-bold uppercase tracking-widest mb-4">
            <i data-lucide="mail" class="w-3.5 h-3.5"></i> Get in Touch
        </div>
        <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-slate-900 dark:text-white mb-3">Contact Us</h1>
        <p class="text-slate-500 dark:text-gray-400 text-lg max-w-xl">Have a question, found a bug, or want to suggest a new tool? We'd love to hear from you.</p>
    </div>
</section>

<section class="py-16 bg-white dark:bg-gray-950">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12 items-start">

            <!-- Contact Info -->
            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900 dark:text-white mb-6">How Can We Help?</h2>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed mb-8">We're a small team passionate about building great free tools. While we may not respond immediately, we read every message and appreciate your feedback.</p>

                <div class="space-y-5">
                    <div class="flex items-start gap-4 p-5 rounded-2xl border border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-900">
                        <div class="w-10 h-10 flex-shrink-0 bg-indigo-50 dark:bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                            <i data-lucide="bug" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white mb-1">Report a Bug</h3>
                            <p class="text-sm text-slate-500 dark:text-gray-400">Found something broken? Tell us the tool name, what you did, and what happened.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 rounded-2xl border border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-900">
                        <div class="w-10 h-10 flex-shrink-0 bg-emerald-50 dark:bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <i data-lucide="lightbulb" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white mb-1">Suggest a Tool</h3>
                            <p class="text-sm text-slate-500 dark:text-gray-400">Have an idea for a useful tool we don't have yet? We consider all suggestions!</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 rounded-2xl border border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-900">
                        <div class="w-10 h-10 flex-shrink-0 bg-sky-50 dark:bg-sky-500/10 rounded-xl flex items-center justify-center text-sky-600 dark:text-sky-400">
                            <i data-lucide="handshake" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white mb-1">General Inquiry</h3>
                            <p class="text-sm text-slate-500 dark:text-gray-400">Questions about the service, privacy, or partnerships — we're here to help.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="glass-card rounded-3xl p-8 border border-slate-200 dark:border-gray-800">
                <h2 class="text-xl font-heading font-bold text-slate-900 dark:text-white mb-6">Send a Message</h2>

                <div id="form-success" class="hidden mb-6 p-4 rounded-2xl bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/20 text-green-700 dark:text-green-400 text-sm font-semibold flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5"></i> Message sent successfully! We'll get back to you soon.
                </div>

                <form id="contact-form" class="space-y-5" onsubmit="handleContactForm(event)">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-gray-300 mb-2" for="contact-name">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" id="contact-name" name="name" required placeholder="Your name"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-gray-300 mb-2" for="contact-email">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" id="contact-email" name="email" required placeholder="you@example.com"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-gray-300 mb-2" for="contact-subject">Subject</label>
                        <select id="contact-subject" name="subject"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-sm">
                            <option>Bug Report</option>
                            <option>Tool Suggestion</option>
                            <option>Privacy / Data Question</option>
                            <option>General Inquiry</option>
                            <option>Partnership</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-gray-300 mb-2" for="contact-message">Message <span class="text-red-500">*</span></label>
                        <textarea id="contact-message" name="message" required rows="5" placeholder="Describe your question or feedback in detail..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-sm resize-none"></textarea>
                    </div>

                    <button type="submit" id="contact-submit"
                        class="w-full py-3.5 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2 text-sm">
                        <i data-lucide="send" class="w-4 h-4"></i> Send Message
                    </button>
                    <p class="text-center text-xs text-slate-400 dark:text-gray-600">We typically respond within 1–3 business days.</p>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
function handleContactForm(e) {
    e.preventDefault();
    const btn = document.getElementById('contact-submit');
    btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Sending...';
    btn.disabled = true;
    lucide.createIcons();

    // Simulate submission (replace with real AJAX if you have a backend)
    setTimeout(() => {
        document.getElementById('contact-form').reset();
        document.getElementById('form-success').classList.remove('hidden');
        btn.innerHTML = '<i data-lucide="send" class="w-4 h-4"></i> Send Message';
        btn.disabled = false;
        lucide.createIcons();
        document.getElementById('form-success').scrollIntoView({ behavior: 'smooth' });
    }, 1200);
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
