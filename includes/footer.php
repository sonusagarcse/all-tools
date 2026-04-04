    </main>

    <!-- Footer -->
    <footer class="bg-gray-950 border-t border-gray-900 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 mb-12">
                <!-- Brand -->
                <div class="col-span-2 lg:col-span-1">
                    <a href="<?php echo SITE_URL; ?>" class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                            <i data-lucide="layers" class="w-5 h-5 text-white"></i>
                        </div>
                        <span class="text-xl font-heading font-bold text-white"><?php echo SITE_NAME; ?></span>
                    </a>
                    <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                        <?php echo SITE_TAGLINE; ?> All tools are free to use and we process your files on our secure servers.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="text-gray-500 hover:text-white transition-colors"><i data-lucide="twitter" class="w-5 h-5"></i></a>
                        <a href="#" class="text-gray-500 hover:text-white transition-colors"><i data-lucide="github" class="w-5 h-5"></i></a>
                        <a href="#" class="text-gray-500 hover:text-white transition-colors"><i data-lucide="facebook" class="w-5 h-5"></i></a>
                    </div>
                </div>

                <?php foreach ($TOOL_CATEGORIES as $cat_id => $category): ?>
                <div>
                    <h3 class="text-white font-semibold mb-4 tracking-wider uppercase text-xs"><?php echo $category['name']; ?></h3>
                    <ul class="space-y-2">
                        <?php 
                        $count = 0;
                        foreach ($category['tools'] as $tool_id => $tool): 
                            if ($count++ >= 5) break; // Only show first 5 in footer
                        ?>
                        <li>
                            <a href="<?php echo SITE_URL; ?>/tools/<?php echo $cat_id; ?>/<?php echo $tool_id; ?>" class="text-gray-400 hover:text-indigo-400 text-sm transition-colors">
                                <?php echo $tool['name']; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                        <?php if (count($category['tools']) > 5): ?>
                        <li>
                            <a href="<?php echo SITE_URL; ?>#<?php echo $cat_id; ?>" class="text-indigo-500 hover:text-indigo-400 text-xs font-medium">View all <?php echo $category['name']; ?> →</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-8 border-t border-gray-900 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-xs">
                    &copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Built with <i data-lucide="heart" class="w-3 h-3 inline text-red-500 fill-red-500"></i> for productivity.
                </p>
                <div class="flex gap-6">
                    <a href="#" class="text-gray-500 hover:text-gray-300 text-xs">Privacy Policy</a>
                    <a href="#" class="text-gray-500 hover:text-gray-300 text-xs">Terms of Service</a>
                    <a href="#" class="text-gray-500 hover:text-gray-300 text-xs">Contact Us</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Mobile Menu Toggle
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (menuBtn) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Theme Toggle (Simplified)
        const themeToggle = document.getElementById('theme-toggle');
        themeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            const icon = themeToggle.querySelector('i');
            if (document.documentElement.classList.contains('dark')) {
                icon.setAttribute('data-lucide', 'sun');
            } else {
                icon.setAttribute('data-lucide', 'moon');
            }
            lucide.createIcons();
        });

        // Global Search
        const globalSearch = document.getElementById('global-search');
        if (globalSearch) {
            globalSearch.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    // Implement search redirect or filtering
                    console.log('Searching for:', this.value);
                }
            });
        }
    </script>
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
</body>
</html>
