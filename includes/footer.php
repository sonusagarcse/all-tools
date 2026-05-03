    </main>

    <?php if (isset($current_tool) && isset($current_tool['seo_text'])): ?>
    <section class="py-16 bg-slate-50 dark:bg-gray-950 border-t border-slate-200 dark:border-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-heading font-extrabold text-slate-900 dark:text-white mb-6">About <?php echo $current_tool['name']; ?></h2>
            <div class="prose dark:prose-invert max-w-none text-slate-600 dark:text-gray-400 font-medium leading-relaxed">
                <?php echo $current_tool['seo_text']; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if (isset($current_tool)): 
        $cat_id = $current_tool['category_id'];
        $cat_info = $TOOL_CATEGORIES[$cat_id];
        $acc = $CAT_ACCENTS[$cat_id] ?? $CAT_ACCENTS['image'];
    ?>
    <!-- Related Tools (Internal Linking) -->
    <section class="py-12 bg-white dark:bg-gray-950 border-t border-slate-200 dark:border-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-heading font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <div class="p-1.5 <?php echo $acc['bg']; ?> <?php echo $acc['text']; ?> rounded-lg">
                        <i data-lucide="<?php echo $cat_info['icon']; ?>" class="w-4 h-4"></i>
                    </div>
                    Related <?php echo $current_tool['category_name']; ?>
                </h3>
                <a href="<?php echo SITE_URL; ?>#<?php echo $cat_id; ?>" class="text-xs font-bold <?php echo $acc['text']; ?> hover:underline">View All</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php 
                $related_count = 0;
                foreach ($cat_info['tools'] as $rel_id => $rel_tool): 
                    if ($rel_id === $current_tool['tool_id']) continue;
                    if ($related_count++ >= 4) break;
                ?>
                <a href="<?php echo SITE_URL; ?>/tools/<?php echo $cat_id; ?>/<?php echo $rel_id; ?>" 
                   class="group p-4 rounded-2xl border border-slate-200 dark:border-gray-800 hover:border-transparent bg-slate-50 dark:bg-gray-900/50 hover:bg-white dark:hover:bg-gray-900 transition-all hover:shadow-xl hover:shadow-indigo-500/5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white dark:bg-gray-800 flex items-center justify-center border border-slate-200 dark:border-gray-700 group-hover:<?php echo $acc['bg']; ?> group-hover:<?php echo $acc['text']; ?> transition-all">
                            <i data-lucide="<?php echo $cat_info['icon']; ?>" class="w-5 h-5 opacity-70"></i>
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white group-hover:<?php echo $acc['text']; ?> transition-colors truncate">
                                <?php echo $rel_tool['name']; ?>
                            </h4>
                            <p class="text-[10px] text-slate-500 dark:text-gray-500 line-clamp-1">
                                <?php echo $rel_tool['desc']; ?>
                            </p>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-950 border-t border-slate-200 dark:border-gray-900 pt-16 pb-8 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 mb-12">
                <!-- Brand -->
                <div class="col-span-2 lg:col-span-1">
                    <a href="<?php echo SITE_URL; ?>" class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-500/30">
                            <i data-lucide="layers" class="w-5 h-5 text-white"></i>
                        </div>
                        <span class="text-xl font-heading font-bold text-slate-900 dark:text-white"><?php echo SITE_NAME; ?></span>
                    </a>
                    <p class="text-slate-500 dark:text-gray-400 text-sm mb-6 leading-relaxed">
                        <?php echo SITE_TAGLINE; ?> All tools are free to use and we process your files on our secure servers.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="text-slate-400 hover:text-indigo-600 dark:text-gray-500 dark:hover:text-white transition-colors"><i data-lucide="twitter" class="w-5 h-5"></i></a>
                        <a href="#" class="text-slate-400 hover:text-indigo-600 dark:text-gray-500 dark:hover:text-white transition-colors"><i data-lucide="github" class="w-5 h-5"></i></a>
                        <a href="#" class="text-slate-400 hover:text-indigo-600 dark:text-gray-500 dark:hover:text-white transition-colors"><i data-lucide="facebook" class="w-5 h-5"></i></a>
                    </div>
                </div>

                <?php foreach ($TOOL_CATEGORIES as $cat_id => $category): ?>
                <div>
                    <h3 class="text-slate-900 dark:text-white font-semibold mb-4 tracking-wider uppercase text-xs"><?php echo $category['name']; ?></h3>
                    <ul class="space-y-2">
                        <?php 
                        $count = 0;
                        foreach ($category['tools'] as $tool_id => $tool): 
                            if ($count++ >= 5) break; // Only show first 5 in footer
                        ?>
                        <li>
                            <a href="<?php echo SITE_URL; ?>/tools/<?php echo $cat_id; ?>/<?php echo $tool_id; ?>" class="text-slate-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 text-sm transition-colors">
                                <?php echo $tool['name']; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                        <?php if (count($category['tools']) > 5): ?>
                        <li>
                            <a href="<?php echo SITE_URL; ?>#<?php echo $cat_id; ?>" class="text-indigo-600 dark:text-indigo-500 hover:text-indigo-500 dark:hover:text-indigo-400 text-xs font-medium">View all <?php echo $category['name']; ?> →</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-8 border-t border-slate-200 dark:border-gray-900 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-500 dark:text-gray-500 text-xs">
                    &copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Built with <i data-lucide="heart" class="w-3 h-3 inline text-red-500 fill-red-500"></i> for productivity.
                </p>
                <div class="flex flex-wrap justify-center md:justify-end gap-5">
                    <a href="<?php echo SITE_URL; ?>/about" class="text-slate-500 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 text-xs transition-colors font-medium">About Us</a>
                    <a href="<?php echo SITE_URL; ?>/privacy-policy" class="text-slate-500 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 text-xs transition-colors font-medium">Privacy Policy</a>
                    <a href="<?php echo SITE_URL; ?>/terms" class="text-slate-500 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 text-xs transition-colors font-medium">Terms of Service</a>
                    <a href="<?php echo SITE_URL; ?>/contact" class="text-slate-500 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 text-xs transition-colors font-medium">Contact Us</a>
                    <a href="<?php echo SITE_URL; ?>/sitemap.xml" class="text-slate-500 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 text-xs transition-colors font-medium">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script defer src="https://cloud.umami.is/script.js" data-website-id="8b8d45e5-b6ea-4122-9f1d-c67d5767cbe0"></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.400.0/dist/umd/lucide.js"></script>
    
    <script>
        // Global PWA State
        window.pwaState = { deferredPrompt: null };

        // Register Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('<?php echo SITE_URL; ?>/pwa-app/sw.js')
                    .then(reg => console.log('PWA SW Registered'))
                    .catch(err => console.log('SW Reg failed', err));
            });
        }

        // Capture Install Prompt
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            window.pwaState.deferredPrompt = e;
            window.dispatchEvent(new CustomEvent('pwa-installable'));
        });

        // Mobile Menu Toggle
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (menuBtn) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Theme Toggle logic
        const themeToggle = document.getElementById('theme-toggle');
        const isDark = document.documentElement.classList.contains('dark');
        
        if (themeToggle) {
            if (isDark) {
                themeToggle.innerHTML = '<i id="theme-icon" data-lucide="sun" class="w-5 h-5 cursor-pointer"></i>';
            } else {
                themeToggle.innerHTML = '<i id="theme-icon" data-lucide="moon" class="w-5 h-5 cursor-pointer"></i>';
            }
        }
        
        // Initialize Lucide Icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                document.documentElement.classList.toggle('dark');
                const darkActive = document.documentElement.classList.contains('dark');
                
                if (darkActive) {
                    localStorage.setItem('theme', 'dark');
                    themeToggle.innerHTML = '<i id="theme-icon" data-lucide="sun" class="w-5 h-5 cursor-pointer"></i>';
                } else {
                    localStorage.setItem('theme', 'light');
                    themeToggle.innerHTML = '<i id="theme-icon" data-lucide="moon" class="w-5 h-5 cursor-pointer"></i>';
                }
                lucide.createIcons();
            });
        }

        // Global Search
        const globalSearch = document.getElementById('global-search');
        if (globalSearch) {
            globalSearch.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    const query = this.value.trim();
                    if(query !== "") {
                        window.location.href = "<?php echo SITE_URL; ?>" + "/#search=" + encodeURIComponent(query);
                    }
                }
            });
        }
    </script>
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js?v=<?php echo time(); ?>"></script>
</body>
</html>
<?php
// Flush and minify
if (ob_get_level() > 0) ob_end_flush();
?>
