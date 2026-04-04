<?php
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<section class="relative pt-20 pb-24 overflow-hidden">
    <!-- Background Accents -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-600/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-cyan-600/10 rounded-full blur-[120px]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold mb-6 animate-fade-in">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
            </span>
            25+ Professional Tools
        </div>
        
        <h1 class="text-4xl md:text-6xl font-heading font-extrabold text-white mb-6 tracking-tight leading-tight animate-fade-in" style="animation-delay: 0.1s">
            Every tool you need,<br> 
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 via-purple-400 to-cyan-400">all in one place.</span>
        </h1>
        
        <p class="max-w-2xl mx-auto text-gray-400 text-lg mb-10 leading-relaxed animate-fade-in" style="animation-delay: 0.2s">
            High-performance PDF, Video, Image, and Text tools. 100% free, secure, and no registration required. Transform your files in seconds.
        </p>

        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto relative animate-fade-in" style="animation-delay: 0.3s">
            <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none">
                <i data-lucide="search" class="w-6 h-6 text-gray-500"></i>
            </div>
            <input type="text" id="home-search" class="block w-full pl-14 pr-6 py-4 rounded-2xl bg-gray-900 border border-gray-800 text-lg text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all shadow-2xl" placeholder="Search for any tool (e.g. JPG to PDF)">
            <div class="absolute right-3 top-2.5 hidden sm:block">
                <kbd class="px-2 py-1.5 rounded-lg bg-gray-800 text-gray-400 text-xs font-sans border border-gray-700">CTRL + K</kbd>
            </div>
        </div>
    </div>
</section>

<!-- Stats Bar -->
<section class="border-y border-gray-900 bg-gray-950/50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-2xl font-bold text-white mb-1">10M+</div>
                <div class="text-gray-500 text-xs uppercase tracking-widest font-semibold">Processed</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-white mb-1">25+</div>
                <div class="text-gray-500 text-xs uppercase tracking-widest font-semibold">Active Tools</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-white mb-1">100%</div>
                <div class="text-gray-500 text-xs uppercase tracking-widest font-semibold">Free to use</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-white mb-1">24/7</div>
                <div class="text-gray-500 text-xs uppercase tracking-widest font-semibold">Secure Server</div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Grid -->
<section class="py-24 bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-12">
            <div>
                <h2 class="text-3xl font-heading font-bold text-white mb-2">Explore Categories</h2>
                <p class="text-gray-400">Discover tools for every digital task.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($TOOL_CATEGORIES as $cat_id => $category): ?>
            <a href="#<?php echo $cat_id; ?>" class="glass-card p-6 rounded-3xl group flex flex-col items-center text-center">
                <div class="w-14 h-14 bg-indigo-600/10 rounded-2xl flex items-center justify-center text-indigo-400 mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                    <i data-lucide="<?php echo $category['icon']; ?>" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xl font-heading font-bold text-white mb-2"><?php echo $category['name']; ?></h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    <?php echo count($category['tools']); ?> powerful tools to boost your productivity.
                </p>
                <div class="mt-6 text-indigo-400 text-xs font-bold uppercase tracking-widest group-hover:translate-x-1 transition-transform">
                    Explore Tools →
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Tools Sections -->
<?php foreach ($TOOL_CATEGORIES as $cat_id => $category): ?>
<section id="<?php echo $cat_id; ?>" class="py-24 category-section <?php echo $cat_id % 2 == 0 ? 'bg-gray-950' : 'bg-gray-900/20'; ?>">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4 mb-12">
            <div class="p-3 bg-indigo-600/20 rounded-xl text-indigo-400">
                <i data-lucide="<?php echo $category['icon']; ?>" class="w-6 h-6"></i>
            </div>
            <h2 class="text-3xl font-heading font-bold text-white"><?php echo $category['name']; ?></h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($category['tools'] as $tool_id => $tool): ?>
            <div class="tool-card glass-card p-6 rounded-2xl flex flex-col h-full hover:shadow-indigo-500/10 transition-all">
                <div class="mb-4 text-indigo-400 opacity-60">
                    <i data-lucide="file-text" class="w-6 h-6"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2"><?php echo $tool['name']; ?></h3>
                <p class="text-gray-400 text-sm mb-6 flex-grow"><?php echo $tool['desc']; ?></p>
                <a href="<?php echo SITE_URL; ?>/tools/<?php echo $cat_id; ?>/<?php echo $tool_id; ?>" class="w-full py-2.5 rounded-xl bg-gray-800 text-white text-sm font-semibold hover:bg-indigo-600 transition-colors text-center">
                    Use Tool →
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endforeach; ?>

<!-- How It Works -->
<section class="py-24 bg-gray-950 border-t border-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-heading font-bold text-white mb-2">How It Works</h2>
            <p class="text-gray-400 text-lg">Simple steps to process your files.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="relative text-center px-4">
                <div class="w-20 h-20 bg-indigo-600/10 rounded-full flex items-center justify-center text-indigo-400 mx-auto mb-6 relative z-10">
                    <i data-lucide="upload-cloud" class="w-10 h-10"></i>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-bold">1</div>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Upload Files</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Select or drag & drop files onto our tool pages. All files are handled securely.</p>
                <!-- Connector Line (Desktop) -->
                <div class="hidden md:block absolute top-10 left-[60%] w-full border-t-2 border-dashed border-gray-800 -z-0"></div>
            </div>

            <div class="relative text-center px-4">
                <div class="w-20 h-20 bg-indigo-600/10 rounded-full flex items-center justify-center text-indigo-400 mx-auto mb-6 relative z-10">
                    <i data-lucide="cpu" class="w-10 h-10"></i>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-bold">2</div>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Wait a Moment</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Our advanced servers process your request instantly using high-performance libraries.</p>
                <!-- Connector Line (Desktop) -->
                <div class="hidden md:block absolute top-10 left-[60%] w-full border-t-2 border-dashed border-gray-800 -z-0"></div>
            </div>

            <div class="relative text-center px-4">
                <div class="w-20 h-20 bg-indigo-600/10 rounded-full flex items-center justify-center text-indigo-400 mx-auto mb-6 relative z-10">
                    <i data-lucide="download" class="w-10 h-10"></i>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-bold">3</div>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Download Result</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Download your processed file immediately. Files are automatically deleted for your safety.</p>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-24">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-card rounded-[40px] p-8 md:p-16 text-center overflow-hidden relative">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full -mr-32 -mt-32 blur-[80px]"></div>
            
            <h2 class="text-3xl md:text-4xl font-heading font-extrabold text-white mb-6">Stay ahead with new tools.</h2>
            <p class="text-gray-400 text-lg mb-10 max-w-2xl mx-auto">Subscribe to our newsletter to receive updates when we launch new tools and productivity tips.</p>
            
            <form class="max-w-md mx-auto flex flex-col sm:flex-row gap-4">
                <input type="email" placeholder="Enter your email" class="flex-grow px-6 py-4 rounded-2xl bg-gray-900 border border-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="submit" class="px-8 py-4 rounded-2xl bg-indigo-600 text-white font-bold hover:bg-indigo-500 transition-all shadow-lg hover:shadow-indigo-500/20 whitespace-nowrap">
                    Subscribe
                </button>
            </form>
            <p class="mt-6 text-gray-500 text-xs">No spam, promise. Unsubscribe at any time.</p>
        </div>
    </div>
</section>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
