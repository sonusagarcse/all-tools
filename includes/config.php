<?php
/**
 * BulkTools Config
 */

// Site Information
define('SITE_NAME', 'BulkTools');
define('SITE_TAGLINE', 'Free Online Utilities: Image Tools, Developer Utilities, Hindi Typing, JWT Decoders & Security Tools.');

// Dynamically determine the SITE_URL to support both domain root and subfolders (Shared Hosting friendly)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? "https://" : "http://";
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
$doc_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? '');
$base_dir = str_replace('\\', '/', dirname(__DIR__));
$relative_path = '';

if ($doc_root && strpos($base_dir, $doc_root) === 0) {
    $relative_path = substr($base_dir, strlen($doc_root));
}
define('SITE_URL', rtrim($protocol . $host . $relative_path, '/'));

// Include Autoloader
if (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
}

// Paths
define('BASE_DIR', dirname(__DIR__));
define('UPLOAD_DIR', BASE_DIR . '/uploads');
define('LOG_DIR', BASE_DIR . '/logs');



// Security Configurations
define('MAX_FILE_SIZE', 50 * 1024 * 1024); // 50MB
define('ALLOWED_EXTENSIONS', ['pdf', 'jpg', 'jpeg', 'png', 'webp', 'doc', 'docx', 'xls', 'xlsx']);

// Session & Rate Limiting
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
define('RATE_LIMIT_COUNT', 100); // Max uploads per window
define('RATE_LIMIT_WINDOW', 3600); // 1 hour window

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create upload directory if it doesn't exist
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}

// Global Category Map
$TOOL_CATEGORIES = [
    'youtube' => [
        'name' => 'YouTube Creator Tools',
        'icon' => 'youtube',
        'hidden_nav' => true,
        'tools' => [
            'yt-thumbnail' => [
                'name' => 'YouTube Thumbnail Downloader',
                'desc' => 'Download high-quality YouTube video thumbnails effortlessly.',
                'seo_desc' => 'Free online YouTube thumbnail downloader. Get HD, High, Medium, and Default thumbnails from any YouTube video URL. No signup required.',
                'keywords' => ['youtube thumbnail downloader', 'download youtube thumbnail', 'extract youtube image', 'yt thumb download', 'hd youtube thumbnail', 'get youtube video cover', 'save youtube thumbnail'],
                'seo_text' => '<p>BulkTools\'s <strong>YouTube Thumbnail Downloader</strong> is a fast and free utility that lets you extract and download the cover images of any YouTube video. Whether you\'re a creator looking for inspiration, a researcher, or a blogger, getting the high-definition thumbnail is now just one click away.</p><p class="mt-4"><strong>Resolutions available:</strong> We provide links to the MaxRes (1280x720), standard, medium, and low-resolution thumbnails automatically extracted from the video ID. All you need to do is paste the URL of the video, and we do the rest.</p>',
            ],
            'yt-tags' => [
                'name' => 'YouTube Tag Extractor',
                'desc' => 'Extract hidden SEO tags and keywords from any YouTube video.',
                'seo_desc' => 'Free online YouTube tag extractor. View hidden meta tags, keywords and categories of any YouTube video to improve your own channel SEO.',
                'keywords' => ['youtube tag extractor', 'extract yt tags', 'view hidden video keywords', 'spy on youtube seo', 'video tag finder', 'youtube metadata extractor', 'seo keywords from youtube video'],
                'seo_text' => '<p>Master your video marketing with BulkTools\'s <strong>YouTube Tag Extractor</strong>. By identifying the specific keywords and tags used by top-performing creators in your niche, you can replicate their success and optimize your own content for higher visibility.</p><p class="mt-4"><strong>Why tags matter:</strong> While YouTube\'s algorithm has evolved, tags still provide valuable context to the system and help your videos appear in matching "Suggested Video" sidebars. Our tool extracts these hidden tags instantly, ready to be copied into your YouTube Studio.</p>',
            ],
            'comment-picker' => [
                'name' => 'YouTube Comment Picker',
                'desc' => 'Randomly pick winners from YouTube video comments for giveaways.',
                'seo_desc' => 'Free online YouTube comment picker. Pick a random winner from your video comments fairly. Filter duplicate users and choose multiple winners instantly.',
                'keywords' => ['youtube comment picker', 'random winner generator', 'youtube giveaway tool', 'pick winner from comments', 'fair giveaway picker', 'random youtube name picker'],
                'seo_text' => '<p>Run fair and transparent giveaways with the BulkTools <strong>YouTube Comment Picker</strong>. Gone are the days of manual scrolling — simply paste your video URL, load the comments, and let our algorithm randomly select a winner for you.</p><p class="mt-4"><strong>Giveaway Professionalism:</strong> Our tool supports advanced filtering, allowing you to remove duplicate users so everyone has one fair entry. Perfect for YouTubers, brand influencers, and marketers looking to increase engagement through rewards.</p>',
            ],
            'yt-money' => [
                'name' => 'YouTube Money Calculator',
                'desc' => 'Estimate potential earnings of a YouTube video or channel.',
                'seo_desc' => 'Free online YouTube earnings calculator. Estimate how much a YouTube video or channel makes based on views, CPM, and engagement rates.',
                'keywords' => ['youtube money calculator', 'yt earnings estimator', 'how much do youtubers make', 'youtube cpm calculator', 'revenue estimator youtube', 'channel income calculator'],
                'seo_text' => '<p>Ever wondered how much your favorite creators earn? Our <strong>YouTube Money Calculator</strong> provides a realistic estimate of video revenue based on views and industry-standard CPM (Cost Per Mille) rates.</p><p class="mt-4"><strong>Understand the Economics:</strong> Revenue is influenced by niche (Finance vs. Gaming), audience location, and engagement. Use our sliders to adjust the parameters and see the gross daily, monthly, and yearly income potential for any video size.</p>',
            ],
        ]
    ],
    'image' => [
        'name' => 'Image Tools',
        'icon' => 'image',
        'tools' => [
            'compress-image' => [
                'name' => 'Compress Image',
                'desc' => 'Reduce image file size without visible quality loss.',
                'seo_desc' => 'Free online image compressor. Reduce JPG, PNG, and WebP file sizes without quality loss. No registration, instant download.',
                'keywords' => ['compress image online', 'reduce image size', 'image compressor', 'JPG compressor', 'PNG compressor', 'WebP compressor', 'free image compression', 'optimize image', 'shrink image size', 'lossy compression', 'lossless compression'],
                'seo_text' => '<p>Our <strong>free online image compressor</strong> helps you reduce the file size of your JPG, PNG, and WebP images without compromising visible quality. Whether you\'re a web developer optimizing assets for faster page loads, a blogger reducing upload sizes, or a business reducing storage costs, BulkTools\'s image compression tool has you covered.</p><p class="mt-4">Image compression is one of the most impactful performance optimizations you can make. Large images slow down websites, increase bandwidth costs, and frustrate users. By compressing images, you can achieve <strong>50–80% file size reduction</strong> while keeping images visually sharp.</p><p class="mt-4"><strong>Supported formats:</strong> JPG / JPEG, PNG, WebP. Max file size: 50MB. All processing is done on our secure server and your files are automatically deleted after download.</p>',
            ],
            'compress-image-in-kb' => [
                'name' => 'Compress Image in KB',
                'desc' => 'Forcefully compress images to an exact target file size (KB).',
                'seo_desc' => 'Free online image compressor. Enter a target KB size and perfectly shrink JPG, PNG, and WebP images to that exact size.',
                'keywords' => ['compress image in kb', 'reduce image to 50kb', 'shrink image to 100kb', 'compress jpg to kb', 'target file size compressor'],
                'seo_text' => '<p>BulkTools\'s <strong>Compress Image in KB tool</strong> allows you to specify an exact target file size in Kilobytes (KB) and actively compresses your image to match it as closely as possible.</p><p class="mt-4">This tool uses a smart binary search algorithm to intelligently reduce quality perfectly so it falls just under your requested limit. Perfect for upload portals, job applications, and government forms with strict file size limits!</p>',
            ],
            'resize-image' => [
                'name' => 'Resize Image',
                'desc' => 'Resize images to any custom pixel dimensions.',
                'seo_desc' => 'Free online image resizer. Change image dimensions to any custom pixel width and height. Supports JPG, PNG, WebP. No upload limits.',
                'keywords' => ['resize image online', 'change image dimensions', 'image resizer', 'scale image', 'crop to size', 'JPG resizer', 'PNG resizer', 'free image resizer', 'resize photo online', 'bulk image resize'],
                'seo_text' => '<p>BulkTools\'s <strong>free image resizer</strong> lets you change the dimensions of any JPG, PNG, or WebP image to your desired width and height in seconds. Whether you\'re preparing images for social media, e-commerce product listings, email campaigns, or web design mockups, this tool makes it effortless.</p><p class="mt-4">Simply upload your image, enter the target width and height in pixels, and click resize. You can choose to maintain the <strong>original aspect ratio</strong> or stretch to exact dimensions. The tool uses high-quality bicubic interpolation to ensure your resized images look crisp and sharp.</p><p class="mt-4"><strong>Common use cases:</strong> Resize images for Instagram (1080×1080), Facebook cover photos (820×312), Twitter banners (1500×500), and more. All files are securely processed and deleted after download.</p>',
            ],
            'convert-image' => [
                'name' => 'Convert Image',
                'desc' => 'Convert images between JPG, PNG, and WebP formats.',
                'seo_desc' => 'Free online image converter. Convert JPG to PNG, PNG to WebP, WebP to JPG, and more. Fast, secure, and no registration required.',
                'keywords' => ['convert image online', 'JPG to PNG', 'PNG to WebP', 'WebP to JPG', 'image format converter', 'free image conversion', 'convert photo format', 'online image converter', 'change image format'],
                'seo_text' => '<p>Convert images between popular formats instantly with BulkTools\'s <strong>free online image converter</strong>. Whether you need to convert a JPG to PNG for transparency support, a PNG to WebP for smaller file sizes, or a WebP to JPG for broader compatibility, this tool handles it all in one click.</p><p class="mt-4"><strong>Why convert image formats?</strong> Different platforms and use cases require different image formats. WebP offers superior compression and quality compared to JPG and PNG, making it ideal for modern websites. PNG is lossless and supports transparency, perfect for logos and graphics. JPG is universally compatible with near-universal browser and device support.</p><p class="mt-4"><strong>Supported conversions:</strong> JPG ↔ PNG, PNG ↔ WebP, JPG ↔ WebP. Max upload size: 50MB. Files are processed securely and deleted automatically.</p>',
            ],
            'crop-image' => [
                'name' => 'Crop Image',
                'desc' => 'Crop images to focus on what matters most.',
                'seo_desc' => 'Free online image cropper with an interactive drag-and-drop interface. Crop JPG, PNG, and WebP images to any size. No signup needed.',
                'keywords' => ['crop image online', 'free image cropper', 'cut image online', 'crop photo', 'trim image', 'crop JPG online', 'crop PNG online', 'online photo cropper', 'image crop tool free'],
                'seo_text' => '<p>BulkTools\'s <strong>free online image cropping tool</strong> features an interactive, real-time crop editor that lets you precisely select and crop any region of your image. Unlike basic crop tools, our visual crop editor gives you full control over the crop area with draggable handles and live coordinate display.</p><p class="mt-4">Perfect for cropping profile pictures, removing unwanted backgrounds, focusing on product details, or preparing images for specific aspect ratios. The intuitive interface works on all devices including smartphones and tablets.</p><p class="mt-4"><strong>How to crop an image:</strong> Upload your JPG, PNG, or WebP image → Drag the crop handles to select the area you want → Click "Crop Image" → Download your result. Simple, fast, and free with no registration required.</p>',
            ],
            'flip-rotate' => [
                'name' => 'Flip & Rotate',
                'desc' => 'Rotate images or flip them horizontally/vertically.',
                'seo_desc' => 'Free online flip and rotate tool. Mirror images or rotate them 90, 180, or 270 degrees. Supports JPG, PNG, WebP.',
                'keywords' => ['flip image online', 'rotate image online', 'mirror image', 'image orientation', 'vertical flip', 'horizontal flip', 'rotate 90 degrees'],
                'seo_text' => '<p>Rotate and flip your images instantly with BulkTools\'s <strong>free Flip & Rotate tool</strong>. Whether you need to fix a sideways photo or mirror an image for a design project, our tool makes it effortless.</p><p class="mt-4">Simply upload your image and choose from clockwise rotation or horizontal/vertical flipping. The tool maintains image quality and works directly in your browser or on our secure server.</p>',
            ],
            'image-filters' => [
                'name' => 'Image Filters',
                'desc' => 'Apply aesthetic filters like Grayscale, Sepia, and Blur.',
                'seo_desc' => 'Free online image filters. Apply artistic effects like grayscale, sepia, invert, and blur to your JPG, PNG, or WebP images.',
                'keywords' => ['image filters online', 'grayscale image', 'sepia filter', 'invert colors', 'blur image', 'artistic image effects', 'black and white converter'],
                'seo_text' => '<p>Transform your photos with BulkTools\'s <strong>free Image Filters tool</strong>. Enhance your images with professional artistic effects in a single click — no advanced software like Photoshop required.</p><p class="mt-4"><strong>Available filters:</strong> Grayscale (Black & White), Sepia (Classic look), Invert (Negative effect), and Gaussian Blur (Depth of field effect). Our tool processes your images instantly while preserving original dimensions.</p>',
            ],
            'color-picker' => [
                'name' => 'Color Picker',
                'desc' => 'Extract HEX/RGB color codes directly from any image.',
                'seo_desc' => 'Free online color picker from image. Upload an image and click anywhere to get HEX, RGB, and HSL color codes. Perfect for designers and developers.',
                'keywords' => ['color picker from image', 'image color extractor', 'get hex code from image', 'rgb color picker', 'color palette generator', 'online eye dropper tool'],
                'seo_text' => '<p>Find the perfect color with BulkTools\'s <strong>interactive Color Picker from Image</strong>. Simply upload any image and click on any pixel to instantly get its HEX, RGB, and HSL values.</p><p class="mt-4">This tool is a favorite among web designers and front-end developers who need to match brand colors or find inspiration from photographs. The tool features a real-time magnifying glass for precision picking.</p>',
            ],
            'drawing-board' => [
                'name' => 'Online Drawing Board',
                'desc' => 'Sketch, draw, and design with a professional online canvas tool.',
                'seo_desc' => 'Free online drawing board and sketch tool. Create professional drawings, add shapes, text, and export to PNG or JPG. Perfect for quick mockups and artistic sketches.',
                'keywords' => ['online drawing board', 'sketch tool online', 'free whiteboard', 'web canvas', 'draw online', 'digital sketchbook', 'shapes and text drawing', 'export drawing to png'],
                'seo_text' => '<p>BulkTools\'s <strong>Online Drawing Board</strong> is a powerful, professional-grade sketching tool that works directly in your browser. Whether you need to create a quick diagram, sketch out a design concept, or just doodle, our feature-rich canvas provides everything you need.</p><p class="mt-4"><strong>Key Features:</strong> Multiple drawing tools (Brush, Pencil, Eraser), geometric shapes (Rectangle, Circle, Triangle, Arrows), text labels, custom color palettes, and object manipulation. You can easily move, resize, and rotate any element you add to the board.</p><p class="mt-4">Our drawing tool is built for performance and privacy. Everything happens 100% client-side, meaning your art never leaves your computer unless you choose to download it. Save your masterpieces in high-quality PNG or JPG formats instantly.</p>',
            ],
            'qr-generator' => [
                'name' => 'Custom QR Generator',
                'desc' => 'Generate premium QR codes with custom colors, logos, and styles.',
                'seo_desc' => 'Free online premium QR code generator. Customize your QR code with logos, gradients, custom shapes, and colors. Download in PNG, SVG, or JPEG.',
                'keywords' => ['qr code generator', 'custom qr code', 'qr code with logo', 'qr code designer', 'free qr generator', 'branded qr code', 'dynamic qr code', 'qr code styling', 'professional qr code'],
                'seo_text' => '<p>Create stunning, professional QR codes with BulkTools\'s <strong>Premium QR Code Generator</strong>. Unlike basic QR tools, our designer gives you full creative control over every aspect of your code, from the shape of the dots to the style of the corner eyes.</p><p class="mt-4"><strong>All Possible Customizations:</strong> Choose from various dot styles (rounded, classy, dots), customize corner shapes, apply linear or radial gradients, and even upload your own <strong>center logo</strong> for brand recognition. All processing happens 100% client-side, meaning your data and logos never leave your device.</p><p class="mt-4">Download your finished masterpiece in high-resolution PNG, SVG (for scaling), or JPEG formats. Perfect for business cards, marketing materials, restaurant menus, and more.</p>',
            ],
            'qr-scanner' => [
                'name' => 'QR Code Scanner (from Image)',
                'desc' => 'Decode and read any QR code instantly by uploading an image.',
                'seo_desc' => 'Free online QR code scanner from image. Upload a QR code photo to see its contents, destination URL, or hidden text without needing a camera.',
                'keywords' => ['qr code scanner from image', 'read qr code online', 'qr code decoder', 'scan qr code photo', 'extract text from qr code', 'safe qr reader online'],
                'seo_text' => '<p>Don\'t have a camera handy? No problem. The BulkTools <strong>QR Code Scanner from Image</strong> lets you decode any QR code instantly by uploading a screenshot or photo. It\'s the safest way to "peek" at a link before opening it on your device.</p><p class="mt-4"><strong>Privacy First:</strong> The scanning happens entirely within your browser. Your images are never uploaded to our servers, keeping your scanned data 100% private and secure. Supports all standard QR formats.</p>',
            ],
        ]
    ],
    'text' => [
        'name' => 'Text Tools',
        'icon' => 'type',
        'tools' => [
            'word-counter' => [
                'name' => 'Word Counter',
                'desc' => 'Count words, characters, sentences, and paragraphs.',
                'seo_desc' => 'Free online word counter. Count words, characters (with/without spaces), sentences, and paragraphs instantly. Great for essays and SEO content.',
                'keywords' => ['word counter', 'character counter', 'count words online', 'word count tool', 'text length checker', 'word count for essay', 'sentence counter', 'paragraph counter', 'SEO word counter', 'free word counter'],
                'seo_text' => '<p>BulkTools\'s <strong>free online word counter</strong> gives you an instant, real-time count of words, characters (with and without spaces), sentences, and paragraphs. Simply paste or type your text, and the count updates automatically as you type — no button clicks required.</p><p class="mt-4"><strong>Who uses a word counter?</strong> Students checking essay word limits, bloggers and content marketers tracking SEO content length targets, novelists monitoring chapter progress, social media managers fitting posts to character limits, and academic researchers meeting journal word count requirements.</p><p class="mt-4">Our word counter is especially useful for SEO, where <strong>ideal blog post length is between 1,500 and 2,500 words</strong> for most topics. Track your content length in real time and hit your target every time — completely free, no account needed.</p>',
            ],
            'case-converter' => [
                'name' => 'Case Converter',
                'desc' => 'Convert text to UPPER, lower, Title, or Sentence case.',
                'seo_desc' => 'Free online case converter. Transform text to UPPERCASE, lowercase, Title Case, Sentence case, or camelCase instantly. Supports any language.',
                'keywords' => ['case converter', 'text case converter', 'uppercase converter', 'lowercase converter', 'title case converter', 'sentence case converter', 'camelCase converter', 'convert text case online', 'change text case free'],
                'seo_text' => '<p>The <strong>free BulkTools Case Converter</strong> lets you instantly transform any block of text into any capitalization style you need. Whether you need UPPERCASE for headings, lowercase for uniformity, Title Case for proper nouns, or Sentence case for readable text, this tool handles it with a single click.</p><p class="mt-4"><strong>Supported cases:</strong> UPPERCASE, lowercase, Title Case, Sentence case, camelCase, and PascalCase. Perfect for developers formatting variable names, writers editing manuscripts, marketers repurposing content across platforms, or anyone who needs to fix text formatting without manual editing.</p><p class="mt-4">Simply paste your text, click the conversion type you need, and copy the result. No installation, no sign-up, and completely free to use as many times as you need.</p>',
            ],
            'lorem-ipsum' => [
                'name' => 'Lorem Ipsum Generator',
                'desc' => 'Generate placeholder Lorem Ipsum text for designs and prototypes.',
                'seo_desc' => 'Free Lorem Ipsum generator. Generate placeholder text by words, sentences, or paragraphs for UI mockups, design projects, and website prototypes.',
                'keywords' => ['lorem ipsum generator', 'placeholder text generator', 'dummy text generator', 'generate lorem ipsum', 'fake text generator', 'lorem ipsum online', 'random text generator', 'design placeholder text'],
                'seo_text' => '<p>The <strong>BulkTools Lorem Ipsum Generator</strong> creates professional placeholder text for design mockups, wireframes, website prototypes, and development projects. Lorem Ipsum has been the industry-standard dummy text since the 1500s and is used universally by designers and developers worldwide.</p><p class="mt-4"><strong>Why use Lorem Ipsum?</strong> When you\'re designing a layout, website, or app interface, you need realistic-looking text to fill the space and test typography. Using Lorem Ipsum prevents readers from being distracted by the content and keeps focus on the visual design.</p><p class="mt-4">Generate any number of words, sentences, or full paragraphs with a single click. The generated text is clean, copy-paste ready, and completely free with no watermarks or limits.</p>',
            ],
            'base64-encode' => [
                'name' => 'Base64 Encode',
                'desc' => 'Encode any text or string into Base64 format.',
                'seo_desc' => 'Free online Base64 encoder. Convert any text, string, or data to Base64 encoding instantly. Useful for APIs, emails, and data embedding.',
                'keywords' => ['base64 encode', 'base64 encoder online', 'text to base64', 'encode string base64', 'base64 encoding tool', 'online base64 converter', 'encode data base64', 'free base64 encoder'],
                'seo_text' => '<p>BulkTools\'s <strong>free online Base64 encoder</strong> converts any plain text, URL, or data string into Base64-encoded format instantly. Base64 encoding is widely used in web development, APIs, email systems (MIME), and data embedding.</p><p class="mt-4"><strong>Common use cases for Base64 encoding:</strong> Embedding images directly in HTML or CSS as data URIs, sending binary data over text-based protocols like JSON or XML, encoding credentials for HTTP Basic Authentication headers, and storing binary data in databases or configuration files.</p><p class="mt-4">Paste your text into the input box and the Base64 encoded output is generated in real time. No data is sent to any server — encoding happens entirely in your browser for maximum privacy and security.</p>',
            ],
            'base64-decode' => [
                'name' => 'Base64 Decode',
                'desc' => 'Decode Base64-encoded strings back into readable text.',
                'seo_desc' => 'Free online Base64 decoder. Convert Base64-encoded strings back to plain text, URLs, or data instantly. Works in-browser for maximum privacy.',
                'keywords' => ['base64 decode', 'base64 decoder online', 'decode base64 string', 'base64 to text', 'decode base64 online free', 'base64 decoding tool', 'online base64 decoder'],
                'seo_text' => '<p>The <strong>free BulkTools Base64 Decoder</strong> converts Base64-encoded strings back into their original plain text, URLs, or binary data representation. If you\'ve received a Base64-encoded value and need to read the underlying content, this tool decodes it instantly.</p><p class="mt-4"><strong>Why decode Base64?</strong> Developers often encounter Base64-encoded data when working with APIs, JWT tokens, email MIME parts, or configuration files. Decoding makes it readable and helps you debug, inspect, or transform the underlying data without writing custom scripts.</p><p class="mt-4">All decoding happens directly in your browser — your data never leaves your device, ensuring complete privacy. No login or registration required. Completely free and unlimited use.</p>',
            ],
            'text-editor' => [
                'name' => 'Online Text Editor',
                'desc' => 'Write, format, and edit text with a professional rich-text editor.',
                'seo_desc' => 'Free online rich text editor. Create, format, and edit documents with bold, italics, lists, and more. Features real-time word count, auto-save, and export to TXT or HTML.',
                'keywords' => ['online text editor', 'rich text editor online', 'free text editor', 'word processor online', 'edit text online', 'quill text editor', 'notepad online with formatting', 'clean text tool', 'word count editor', 'auto save text editor'],
                'seo_text' => '<p>BulkTools\'s <strong>Online Text Editor</strong> is a powerful, professional-grade writing tool that works directly in your browser. Whether you need to draft a blog post, format a report, or just need a clean space for focus writing, our feature-rich editor provides everything you need.</p><p class="mt-4"><strong>Key Features:</strong> Advanced rich-text formatting (Bold, Italic, Underline, Lists, Links), real-time document statistics (word count, character count, estimated reading time), and one-click text cleaning utilities. The editor features a distraction-free mode and a premium glassmorphic UI that adapts to your theme preference.</p><p class="mt-4">Our editor is built for productivity and reliability. With <strong>built-in auto-save</strong>, your work is stored automatically in your browser\'s local storage, ensuring you never lose a draft. Export your finished work instantly in clean TXT or HTML formats. Everything happens 100% client-side, maintaining your privacy at all times.</p>',
            ],
            'uuid-generator' => [
                'name' => 'UUID Generator',
                'desc' => 'Generate cryptographically random UUID v4 identifiers.',
                'seo_desc' => 'Free UUID v4 generator online. Generate one or multiple unique, cryptographically random UUIDs instantly. Used by developers and database architects.',
                'keywords' => ['UUID generator', 'generate UUID online', 'UUID v4 generator', 'unique ID generator', 'GUID generator', 'random UUID generator', 'create UUID free', 'UUID tool online', 'developer UUID generator', 'best seo tools free', 'free utility website'],
                'seo_text' => '<p>BulkTools\'s <strong>free UUID generator</strong> creates cryptographically random UUID v4 (Universally Unique Identifier) strings that are statistically guaranteed to be globally unique. UUIDs are 128-bit values formatted as 32 hexadecimal characters grouped in the pattern <code>xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx</code>.</p><p class="mt-4"><strong>When to use UUIDs:</strong> Database primary keys for distributed systems (no central counter needed), unique session tokens, API request tracking, file naming to prevent conflicts, product or entity identifiers in microservices architectures, and anywhere you need a value guaranteed to be unique across time and space without coordination.</p><p class="mt-4">Generate a single UUID or a batch of multiple UUIDs at once. Output is instantly copyable. Works entirely in your browser — no data is transmitted. Free and unlimited.</p>',
            ],
            'hindi-typing' => [
                'name' => 'Hindi Typing Tool',
                'desc' => 'Type Hindi transliteration easily (e.g., hello -> हैलो).',
                'seo_desc' => 'Free online English to Hindi typing tool. Type in English and automatically convert to Hindi Devnagari script text without any keyboard installation.',
                'keywords' => ['hindi typing', 'english to hindi typing', 'hindi transliteration', 'type in hindi online', 'online hindi keyboard', 'hinglish to hindi', 'convert english words to hindi font', 'free online hindi converter', 'india typing tool'],
                'seo_text' => '<p>BulkTools\'s <strong>free Hindi Typing Tool</strong> lets you type comfortably in English (Hinglish) and automatically transliterates it into native Hindi (Devanagari) script instantly. Try typing "namaste" to instantly get "नमस्ते".</p><p class="mt-4"><strong>Why use a transliteration tool?</strong> Most users lack native Hindi keyword setups on their hardware. By utilizing phonetics, our tool acts as an easy bridge allowing seamless communication in Hindi for chat, articles, or comments. Simply type out the phonetic English equivalent and hit space.</p><p class="mt-4">Works right in your browser, completely free, and without requiring any complex software installations.</p>',
            ],
            'insta-fonts' => [
                'name' => 'Instagram Font Generator',
                'desc' => 'Generate fancy, stylish Unicode fonts for Instagram Bios and social media.',
                'seo_desc' => 'Free online fancy font generator for Instagram, Twitter, and WhatsApp. Convert normal text into stylish fonts with emojis and symbols. Copy and paste instantly.',
                'keywords' => ['instagram font generator', 'fancy font generator', 'stylish text converter', 'unicode fonts', 'copy and paste fonts', 'cool fonts for bio', 'twitter font generator', 'whatsapp stylish text'],
                'seo_text' => '<p>Make your social media profiles stand out with BulkTools\'s <strong>Instagram Font Generator</strong>. Our tool takes your standard text and converts it into dozens of unique, eye-catching Unicode styles that you can copy and paste directly into your Instagram Bio, Twitter profile, or WhatsApp messages.</p><p class="mt-4"><strong>How it works:</strong> Unicode provides a massive range of mathematical and decorative symbols that look like characters. We map your input to these symbols in real-time, giving you styles like 𝔹𝕠𝕝𝕕, 𝔉𝔯𝔞𝔨𝔱𝔲𝔯, 𝓢𝓬𝓻𝓲𝓹𝓽, and more. It works on all modern devices and platforms because it uses standard symbols, not custom font files!</p>',
            ],
            'whatsapp-link' => [
                'name' => 'WhatsApp Link Generator',
                'desc' => 'Create "Click to Chat" links with custom pre-filled messages.',
                'seo_desc' => 'Free online WhatsApp link generator. Create a direct chat link with your phone number and a custom message. Perfect for businesses and social media.',
                'keywords' => ['whatsapp link generator', 'wa.me link creator', 'create whatsapp link', 'click to chat generator', 'whatsapp message link', 'direct wa link', 'free wa link tool'],
                'seo_text' => '<p>Connect with your audience faster using BulkTools\'s <strong>WhatsApp Link Generator</strong>. Instead of asking customers to save your number, give them a simple link that opens a chat with you instantly, complete with a pre-written message!</p><p class="mt-4"><strong>Why use it?</strong> It reduces friction for potential customers, improves conversion rates on social ads, and allows you to track where your leads are coming from using unique custom messages. Just enter your phone number and message, and we\'ll generate the short <code>wa.me</code> link for you.</p>',
            ],
            'tts' => [
                'name' => 'Text to Speech (Voice Generator)',
                'desc' => 'Convert written text into natural-sounding voice audio instantly.',
                'seo_desc' => 'Free online Text to Speech (TTS) tool. Convert any text into speech using multiple natural voices. Choose your speed, pitch and download audio.',
                'keywords' => ['text to speech', 'online tts generator', 'convert text to voice', 'voice generator free', 'natural sounding voices', 'speech synthesizer', 'read text aloud'],
                'seo_text' => '<p>Give your content a voice with the BulkTools <strong>Text to Speech Generator</strong>. Whether you\'re creating a video script, listening to an article, or testing accessibility, our TTS tool provides high-quality, natural-sounding voice synthesis directly in your browser.</p><p class="mt-4"><strong>Premium Features:</strong> Supports multiple languages and accents (depending on your browser), adjustable reading speed, and pitch control. Simply type your text, choose a voice, and hear it speak instantly. Perfect for educators, creators, and professionals.</p>',
            ],
            'resume-builder' => [
                'name' => 'Resume Builder',
                'desc' => 'Create a professional, ATS-friendly resume in minutes.',
                'seo_desc' => 'Free online resume builder. Create a professional, ATS-friendly resume for job applications in India and worldwide. Export to high-quality PDF.',
                'keywords' => ['resume builder', 'free resume maker', 'cv generator online', 'ats friendly resume', 'india resume builder', 'professional cv maker', 'create resume free'],
                'seo_text' => '<p>Landing your dream job starts with a great first impression. The BulkTools <strong>Free Resume Builder</strong> helps you create a professional, industry-standard CV that stands out to recruiters and passes through Applicant Tracking Systems (ATS) with ease.</p><p class="mt-4"><strong>Key Features:</strong> Choose from clean, modern templates, add your work experience, education, and skills with a simple interface, and get real-time previews. Our tool is optimized for the Indian job market but works perfectly for international roles too. No signup required — just build and download your PDF.</p>',
            ],
        ]
    ],
    'dev' => [
        'name' => 'Developer Tools',
        'icon' => 'code',
        'tools' => [
            'json-formatter' => [
                'name' => 'JSON Formatter',
                'desc' => 'Format, validate, and minify JSON data with syntax highlighting.',
                'seo_desc' => 'Free online JSON formatter and validator. Beautify, minify, and validate JSON data with syntax highlighting. Perfect for API debugging and development.',
                'keywords' => ['JSON formatter', 'JSON validator online', 'JSON beautifier', 'format JSON online', 'JSON minifier', 'pretty print JSON', 'validate JSON', 'JSON viewer', 'online JSON formatter free', 'JSON lint'],
                'seo_text' => '<p>The <strong>BulkTools JSON Formatter</strong> is a powerful free tool for developers to format, beautify, validate, and minify JSON data. Whether you\'re working with API responses, configuration files, or data exports, this tool makes JSON easy to read and debug with full syntax highlighting.</p><p class="mt-4"><strong>Features:</strong> One-click JSON beautification (pretty print with 2-space or 4-space indentation), JSON minification (compact output for production use), real-time JSON validation with helpful error messages showing exact line and position of syntax errors, and full syntax highlighting for keys, strings, numbers, booleans, and null values.</p><p class="mt-4"><strong>Why use a JSON formatter?</strong> Raw JSON from APIs and databases is often minified and unreadable. Formatting it correctly saves developer time when debugging, reviewing data structures, or writing documentation. All formatting happens in your browser — no data is uploaded to any server.</p>',
            ],
            'url-encoder' => [
                'name' => 'URL Encoder / Decoder',
                'desc' => 'Encode or decode URLs and query strings for safe web use.',
                'seo_desc' => 'Free online URL encoder and decoder. Percent-encode special characters in URLs or decode encoded URLs to readable text. Essential for web developers.',
                'keywords' => ['URL encoder', 'URL decoder', 'percent encoding', 'encode URL online', 'decode URL online', 'URL encoding tool free', 'URL encode special characters', 'URL decode online', 'web URL encoder decoder', 'seo optimization tools'],
                'seo_text' => '<p>BulkTools\'s <strong>free URL Encoder / Decoder</strong> converts URLs and query strings between their human-readable form and their percent-encoded (URL-encoded) format as defined in RFC 3986. This is an essential utility for web developers, SEO professionals, and API integrators.</p><p class="mt-4"><strong>URL Encoding:</strong> Converts special characters (spaces, &, =, #, /, etc.) into their percent-encoded equivalents (e.g., space becomes <code>%20</code>, & becomes <code>%26</code>). This is required for safely embedding values in query strings, HTTP headers, and form data.</p><p class="mt-4"><strong>URL Decoding:</strong> Converts percent-encoded strings back to their human-readable form, useful for reading encoded URLs from logs, browser network tabs, or API responses. Completely in-browser, no data uploaded, free and unlimited.</p>',
            ],
            'html-minifier' => [
                'name' => 'HTML Minifier',
                'desc' => 'Compress and minify HTML code to reduce file sizes.',
                'seo_desc' => 'Free online HTML minifier. Remove comments, whitespace, and compress HTML code for faster page load times and better performance.',
                'keywords' => ['html minifier', 'minify html online', 'html compressor', 'reduce html file size', 'clean html code', 'seo fast loading tools', 'website optimizer', 'developer html tools'],
                'seo_text' => '<p>BulkTools\'s <strong>free HTML Minifier</strong> compresses your HTML code by safely stripping out unnecessary whitespaces, line breaks, and HTML comments. This drastically reduces the file payload size leading to faster load speeds and improved SEO performance.</p><p class="mt-4">Perfect for software developers optimizing front-end code before production deployments. Paste your boilerplate, hit compress, and receive an instant lightweight file immediately.</p>',
            ],
            'speed-test' => [
                'name' => 'Internet Speed Test',
                'desc' => 'Measure your internet download, upload speeds and latency instantly.',
                'seo_desc' => 'Free online internet speed test. Check your download and upload Mbps and network ping in seconds. No login or app installation required.',
                'keywords' => ['speed test', 'internet speed test', 'check internet speed', 'download speed test', 'upload speed test', 'ping test', 'network speed', 'online speed test free', 'wifi speed test'],
                'seo_text' => '<p>BulkTools\'s <strong>Internet Speed Test</strong> is a high-performance, browser-based utility that gives you accurate results for your network connection. Unlike bloated tools with heavy ads, our speed test is optimized for speed and privacy.</p><p class="mt-4"><strong>What we measure:</strong> We calculate your <strong>Download speed</strong> (how fast data moves from the web to you), <strong>Upload speed</strong> (how fast you send data to the web), and <strong>Latency / Ping</strong> (the delay in your connection). This helps you troubleshoot slow WiFi, verify ISP promises, and ensure your connection is ready for streaming or gaming.</p>',
            ],
            'jwt-decoder' => [
                'name' => 'JWT Decoder',
                'desc' => 'Decode JSON Web Tokens and view payload claims safely.',
                'seo_desc' => 'Free online JWT decoder. Decode JSON Web Tokens (JWT) safely in your browser to inspect header and payload claims without servers.',
                'keywords' => ['jwt decoder online', 'decode json web token', 'jwt viewer', 'jwt payload inspector', 'json web token decoder', 'developer security utility', 'jwt unpacker tool free'],
                'seo_text' => '<p>BulkTools\'s <strong>free JWT Decoder</strong> allows developers to safely unpack and inspect JSON Web Tokens in real-time. Simply paste your base64 encoded JWT into the tool, and instantly view your token header, algorithm details, and payload claims like expiration times and user IDs.</p><p class="mt-4"><strong>Security First:</strong> All decoding is executed securely inside your browser using JavaScript. We never upload our users\' secure tokens or API keys to any back-end servers.</p>',
            ],
            'gradient' => [
                'name' => 'CSS Gradient Generator',
                'desc' => 'Create beautiful CSS gradients visually and copy the code.',
                'seo_desc' => 'Free online CSS gradient generator. Create linear and radial gradients with multiple color stops. Copy-paste standard CSS code for your designs.',
                'keywords' => ['css gradient generator', 'online gradient maker', 'linear gradient css', 'radial gradient generator', 'beautiful css background', 'ui design tools'],
                'seo_text' => '<p>Design stunning website backgrounds with the BulkTools <strong>Premium CSS Gradient Generator</strong>. Our visual interface lets you create complex, multi-stop gradients with ease, providing you with cross-browser compatible CSS code instantly.</p><p class="mt-4"><strong>Design Flexibility:</strong> Switch between linear and radial modes, adjust angles, and fine-tune opacity for every color stop. Whether you\'re building a modern a "Glassmorphism" UI or a vibrant landing page, this tool is your essential design companion.</p>',
            ],
            'glassmorphism-generator' => [
                'name' => 'CSS Glassmorphism Generator',
                'desc' => 'Create stunning frosted glass effects with real-time CSS code generation.',
                'seo_desc' => 'Free online CSS glassmorphism generator. Create professional frosted glass effects with blur, transparency, and borders. Copy-paste CSS code for your modern UI designs.',
                'keywords' => ['glassmorphism generator', 'css glassmorphism', 'frosted glass effect', 'modern ui design tools', 'glass css generator', 'transparent background css', 'backdrop filter blur generator'],
                'seo_text' => '<h2>Modern CSS Glassmorphism Generator</h2><p>Glassmorphism is a popular UI design trend characterized by a "frosted glass" effect. Our <strong>Glassmorphism Generator</strong> allows you to create this aesthetic visually and receive the exact CSS code for your project.</p><h3>Creating the Glass Effect</h3><p>The secret to glassmorphism lies in the combination of transparency (alpha channel), background blur (`backdrop-filter`), and subtle white borders. Our tool provides sliders to adjust the **Transparency**, **Blur Intensity**, and **Outline Opacity** so you can find the perfect balance for your design.</p><h3>Browser Compatibility</h3><p>While most modern browsers support `backdrop-filter`, our tool generates the necessary vendor prefixes (like `-webkit-`) to ensure your glass effects look great on all platforms. Perfect for building cards, navigation bars, and overlays.</p>',
            ],
            'html-entities' => [
                'name' => 'HTML Entity Converter',
                'desc' => 'Encode or decode special characters into HTML entities safely.',
                'seo_desc' => 'Free online HTML entity encoder and decoder. Convert special characters into HTML entities (like &amp;amp;) or decode them back to plain text. Essential for web security and character display.',
                'keywords' => ['html entity converter', 'html encoder', 'html decoder', 'encode special characters', 'html entities list', 'web security tools', 'format html entities'],
                'seo_text' => '<h2>Professional HTML Entity Encoder/Decoder</h2><p>Properly encoding special characters is essential for web security (to prevent XSS) and ensuring that characters like `<`, `>`, and `&` are displayed correctly by browsers. Our <strong>HTML Entity Converter</strong> makes this process effortless.</p><h3>Why Encode HTML Entities?</h3><p>Browsers reserve certain characters for HTML syntax. If you want to display the character `<` in your text without the browser interpreting it as the start of a tag, you must use the entity `&lt;`. Our tool handles all common and obscure entities, ensuring your code remains valid and safe.</p><h3>Bi-directional Conversion</h3><p>Whether you have a block of text that needs to be "sanitized" for HTML display, or an encoded snippet you need to read as plain text, our tool provides instant, one-click conversion.</p>',
            ],
        ]
    ],
    'sec' => [
        'name' => 'Security Tools',
        'icon' => 'shield',
        'tools' => [
            'password-generator' => [
                'name' => 'Password Generator',
                'desc' => 'Generate strong, secure, and random passwords.',
                'seo_desc' => 'Free strong password generator. Create secure random passwords with custom length, uppercase, numbers, and symbols. No data stored or transmitted.',
                'keywords' => ['password generator', 'strong password generator', 'random password generator', 'secure password creator', 'generate password online', 'complex password generator', 'free password generator', 'password maker online'],
                'seo_text' => '<p>The <strong>BulkTools Password Generator</strong> creates cryptographically strong, completely random passwords to protect your online accounts and data. Weak or reused passwords are one of the leading causes of account breaches — using a unique, strong password for every account is one of the most important security habits you can form.</p><p class="mt-4"><strong>Customization options:</strong> Set password length from 8 to 128 characters, toggle inclusion of uppercase letters (A-Z), lowercase letters (a-z), numbers (0-9), and special symbols (!@#$%^&*). Passwords are generated using cryptographically secure random algorithms.</p><p class="mt-4"><strong>Privacy guaranteed:</strong> All passwords are generated exclusively in your browser. No generated passwords are ever transmitted to our servers, stored in logs, or shared with anyone. Generate as many passwords as you need — completely free.</p>',
            ],
            'hash-generator' => [
                'name' => 'Hash Generator',
                'desc' => 'Generate MD5, SHA-1, SHA-256, and SHA-512 hashes.',
                'seo_desc' => 'Free online hash generator. Generate MD5, SHA-1, SHA-256, and SHA-512 cryptographic hashes from any text. Fast, accurate, and in-browser.',
                'keywords' => ['hash generator', 'MD5 generator', 'SHA-256 generator', 'SHA-1 generator', 'SHA-512 hash', 'text to hash', 'cryptographic hash online', 'checksum generator', 'hash string online free', 'generate hash value', 'secure data tools'],
                'seo_text' => '<p>BulkTools\'s <strong>free online hash generator</strong> computes cryptographic hash values for any input text using industry-standard algorithms including MD5, SHA-1, SHA-256, and SHA-512. Hashing is a fundamental operation in computer security, data integrity verification, and software development.</p><p class="mt-4"><strong>Use cases for hash generation:</strong> Verifying file integrity (checksum validation), password hashing (for development/testing), digital signatures, data deduplication, creating cache keys, generating short unique identifiers from longer strings, and verifying data hasn\'t been tampered with in transit.</p><p class="mt-4"><strong>Important note:</strong> MD5 and SHA-1 are no longer considered cryptographically secure for password storage or security-critical applications. For passwords, always use a dedicated password hashing algorithm (bcrypt, Argon2). Use SHA-256 or SHA-512 for general integrity verification. All hashing happens in your browser — your input text is never uploaded.</p>',
            ],
            'bcrypt-generator' => [
                'name' => 'Bcrypt Generator',
                'desc' => 'Generate secure bcrypt password hashes with customizable rounds.',
                'seo_desc' => 'Free online bcrypt hash generator. Generate securely salted password hashing using modern bcrypt algorithms. Keep your credentials safe.',
                'keywords' => ['bcrypt generator', 'bcrypt hash online', 'generate bcrypt password', 'password hashing tool', 'salt and hash online', 'bcrypt encrypt decrypt', 'secure password storage tester'],
                'seo_text' => '<p>BulkTools\'s <strong>free Bcrypt Generator</strong> produces cryptographically hardened, securely salted hashes ideal for credential storage. In modern web standards, algorithms like MD5/SHA-256 are susceptible to rainbow tables and fast hardware cracking, rendering bcrypt the industry standard for securing passwords.</p><p class="mt-4">Adjust the salt rounds (work factor) to increase computational difficulty, reinforcing the hash against brute-force attacks. As always, everything operates precisely within the browser environment assuring maximum privacy.</p>',
            ],
            'secure-image-share' => [
                'name' => 'Secure Image Share',
                'desc' => 'End-to-End Encrypted one-time image sharing.',
                'seo_desc' => 'Free secure image sharing tool. Upload an image up to 10MB, encrypt it in your browser, and share a one-time use link that automatically deletes the file after viewing.',
                'keywords' => ['secure image share', 'encrypted image upload', 'burn after reading image', 'one time view image', 'secure drop', 'private image share', 'e2ee image sharing'],
                'seo_text' => '<p>BulkTools\'s <strong>Secure Image Share</strong> provides ultimate privacy for sending sensitive photos. Images are encrypted directly in your browser using End-to-End Encryption (E2EE). Our servers never see your image, they only see garbled ciphertext.</p><p class="mt-4"><strong>Burn After Reading:</strong> Once the recipient opens the link and decrypts the image, it is permanently and irreversibly deleted from our servers. The link will never work again, guaranteeing that no one else can intercept it.</p>',
            ],
        ]
    ],
    'time' => [
        'name' => 'Time Tools',
        'icon' => 'clock',
        'tools' => [
            'countdown-timer' => [
                'name' => 'Countdown Timer',
                'desc' => 'Set a custom timer that triggers a buzzer when it hits zero.',
                'seo_desc' => 'Free online countdown timer with alarm buzzer. Set your target time in hours, minutes, and seconds, and run the counter down to zero with an alarm.',
                'keywords' => ['countdown timer', 'online timer with alarm', 'counter tool', 'buzzer timer', 'free countdown clock', 'stopwatch and timer', 'time tracker', 'productivity timer'],
                'seo_text' => '<p>BulkTools\'s <strong>free online Countdown Timer</strong> is the perfect utility for tracking time for tasks, cooking, workouts, or study sessions. Simply enter your desired hours, minutes, and seconds, and start the timer.</p><p class="mt-4"><strong>Key Features:</strong> Features a clear digital display, pause/resume functionality, and an audible <strong>alarm buzzer</strong> that sounds automatically when the timer reaches zero. Never miss a deadline or burn a meal again!</p><p class="mt-4">Our countdown timer works directly in your web browser without any installation, meaning you can keep it running in a background tab.</p>',
            ],
            'age-calculator' => [
                'name' => 'Age Calculator',
                'desc' => 'Calculate your exact age in years, months, and days.',
                'seo_desc' => 'Free online age calculator. Find your exact age down to the day, see your total weeks, days, and hours alive, and countdown to your next birthday.',
                'keywords' => ['age calculator', 'calculate age online', 'how old am i', 'birthday calculator', 'exact age finder', 'date of birth calculator', 'age in days weeks months'],
                'seo_text' => '<p>Find out exactly how old you are with BulkTools\'s <strong>Premium Age Calculator</strong>. Whether you need your age for a job application, a sports registration, or just out of curiosity, our tool provides a detailed breakdown of your life in time.</p><p class="mt-4"><strong>Beyond just years:</strong> We calculate your age in Years, Months, and Days simultaneously. We also provide "Lifetime Stats" showing your total weeks, total hours, and even total seconds since you were born. Plus, get a live countdown to your next birthday!</p>',
            ],
            'bmi-calculator' => [
                'name' => 'BMI Calculator',
                'desc' => 'Calculate your Body Mass Index (BMI) and health category.',
                'seo_desc' => 'Free online BMI calculator. Calculate your body mass index, see your weight category, and find your ideal weight range based on WHO standards.',
                'keywords' => ['bmi calculator', 'calculate body mass index', 'weight category finder', 'health tools online', 'ideal weight calculator', 'body fat index tool', 'bmi health check'],
                'seo_text' => '<p>Take control of your health journey with the BulkTools <strong>Professional BMI Calculator</strong>. Body Mass Index (BMI) is a simple numerical measure of your body fat based on height and weight. While not a definitive diagnostic tool, it is the primary screening tool used by health professionals to identify weight categories like underweight, healthy weight, overweight, and obesity.</p><p class="mt-4"><strong>Detailed Insights:</strong> Our tool doesn\'t just give you a number. We provide a color-coded visual gauge showing where you fall on the WHO health scale, along with your <strong>Ideal Weight Range</strong> based on your height. Supports both Metric (kg/cm) and Imperial (lbs/ft/in) measurement systems.</p>',
            ],
            'stopwatch' => [
                'name' => 'Online Stopwatch',
                'desc' => 'A precise stopwatch with lap timing capabilities and millisecond accuracy.',
                'seo_desc' => 'Free online stopwatch with lap timing. Measure time with millisecond precision. Perfect for sports, workouts, cooking, and productivity.',
                'keywords' => ['online stopwatch', 'lap timer', 'split timer', 'millisecond stopwatch', 'sports timer', 'workout stopwatch', 'free online timer', 'precision stopwatch'],
                'seo_text' => '<p>Track time with extreme precision using BulkTools\'s <strong>Professional Online Stopwatch</strong>. Whether you\'re timing a sprint, a coding sprint, or a scientific experiment, our stopwatch provides millisecond accuracy and a clean, high-visibility interface.</p><p class="mt-4"><strong>Advanced Features:</strong> Our tool supports <strong>Unlimited Laps</strong>, allowing you to record split times without stopping the counter. The interface is optimized for both desktop and mobile, featuring large, easy-to-tap buttons and a fullscreen mode for remote viewing.</p><p class="mt-4"><strong>Privacy & Performance:</strong> The stopwatch runs entirely in your browser using high-resolution performance timers. Your data is never sent to any server, ensuring 100% privacy and zero latency.</p>',
            ],
            'world-clock' => [
                'name' => 'World Clock',
                'desc' => 'View current local time in major cities around the globe instantly.',
                'seo_desc' => 'Free online world clock. View current local time for major cities across all time zones. Compare global times and check GMT/UTC instantly.',
                'keywords' => ['world clock', 'global time', 'current time in world cities', 'time zone converter', 'GMT time', 'UTC clock', 'world time zones', 'compare time zones'],
                'seo_text' => '<p>Stay connected with the world using the BulkTools <strong>Global World Clock</strong>. In our interconnected world, knowing the local time in London, New York, Tokyo, or Mumbai is essential for international business, travel planning, and staying in touch with loved ones.</p><p class="mt-4"><strong>Real-Time Updates:</strong> Our world clock provides live, second-by-second updates for major global hubs. We automatically account for Daylight Saving Time (DST) and display the time zone offset (GMT/UTC) for every city. Add your favorite cities to a custom dashboard for quick reference.</p>',
            ],
            'unix-timestamp' => [
                'name' => 'Unix Timestamp Converter',
                'desc' => 'Convert between Unix Epoch timestamps and human-readable dates.',
                'seo_desc' => 'Free online Unix timestamp converter. Convert seconds/milliseconds to human-readable dates and vice versa. Essential for developers and database admins.',
                'keywords' => ['unix timestamp converter', 'epoch converter', 'unix to date', 'date to unix', 'current unix time', 'timestamp to human readable', 'linux timestamp converter', 'seconds since epoch'],
                'seo_text' => '<p>Master your time data with the BulkTools <strong>Advanced Unix Timestamp Converter</strong>. For developers, database administrators, and system engineers, working with Unix Epoch time (the number of seconds since January 1, 1970) is a daily necessity. Our tool simplifies this process by providing instant, bi-directional conversion.</p><p class="mt-4"><strong>Comprehensive Data:</strong> Convert a Unix timestamp into a full ISO-8601 date, UTC time, and your local time zone simultaneously. You can also pick a date using our calendar interface to generate its corresponding Unix timestamp. Supports both <strong>seconds</strong> and <strong>milliseconds</strong> (JavaScript style) formats.</p>',
            ],
        ]
    ],
    'finance' => [
        'name' => 'Financial Tools',
        'icon' => 'calculator',
        'hidden_nav' => true,
        'tools' => [
            'gst-calculator' => [
                'name' => 'GST Calculator',
                'desc' => 'Calculate GST (Goods and Services Tax) for any amount with multiple tax slabs.',
                'seo_desc' => 'Free online GST calculator. Calculate GST for India, Australia, and other countries. Support for 5%, 12%, 18%, and 28% tax slabs. Add or remove GST instantly.',
                'keywords' => ['gst calculator', 'calculate gst online', 'indian gst calculator', 'add gst calculator', 'remove gst calculator', 'gst tax slabs', 'free gst tool'],
                'seo_text' => '<h2>Accurate Online GST Calculator</h2><p>Our <strong>GST Calculator</strong> is a versatile tool designed to help business owners, accountants, and shoppers calculate the Goods and Services Tax for any transaction. Whether you need to find the "GST inclusive" or "GST exclusive" price, our tool provides precise results in seconds.</p><h3>How to Use the GST Calculator</h3><p>Using our tool is simple: enter the net or gross amount, select your tax slab (e.g., 5%, 12%, 18%, or 28%), and choose whether you want to **Add GST** or **Remove GST**. The tool will instantly display the GST amount and the total final price.</p><h3>Why GST Calculation Matters</h3><p>GST is a comprehensive, multi-stage, destination-based tax that is levied on every value addition. For businesses in India, calculating the correct GST is crucial for invoice accuracy and tax filing. Our tool simplifies this process, reducing manual errors and saving time.</p>',
            ],
            'sip-calculator' => [
                'name' => 'SIP Calculator',
                'desc' => 'Calculate your future wealth and returns from Systematic Investment Plans (SIP).',
                'seo_desc' => 'Free online SIP calculator. Estimate returns on your mutual fund investments. Calculate future wealth based on monthly investment, tenure, and expected return rate.',
                'keywords' => ['sip calculator', 'mutual fund returns calculator', 'investment calculator', 'future wealth calculator', 'sip return estimator', 'compound interest calculator', 'systematic investment plan'],
                'seo_text' => '<h2>Professional SIP Returns Calculator</h2><p>Plan your financial future with our <strong>SIP Calculator</strong>. A Systematic Investment Plan (SIP) is a disciplined way to invest in mutual funds, allowing you to benefit from the power of compounding and rupee cost averaging over the long term.</p><h3>Estimate Your Wealth Growth</h3><p>Simply enter your monthly investment amount, the expected annual return rate, and the time period (in years). Our calculator will show you the **Total Investment**, the **Estimated Returns**, and the **Total Wealth** you could accumulate. It\'s an essential tool for goal-based financial planning.</p><h3>The Power of Compounding</h3><p>The secret to wealth creation through SIP is starting early and staying consistent. By reinvesting your returns, your money grows exponentially. Use our tool to visualize how even small monthly contributions can grow into a significant corpus over 10, 20, or 30 years.</p>',
            ],
            'percentage-calculator' => [
                'name' => 'Percentage Calculator',
                'desc' => 'Calculate percentages, increases, and decreases instantly.',
                'seo_desc' => 'Free online percentage calculator. Calculate percentage of a value, percentage change, and fractional percentages for students and finance.',
                'keywords' => ['percentage calculator', 'calculate percentage online', 'percent change calculator', 'student grade calculator', 'marks percentage finder', 'free math tools'],
                'seo_text' => '<p>The BulkTools <strong>Percentage Calculator</strong> is an essential tool for students, teachers, and business professionals. Whether you\'re calculating your exam marks, a discount at a store, or a year-over-year growth rate, our tool provides instant and accurate results.</p><p class="mt-4"><strong>Versatile Calculations:</strong> Find the percentage of a number, calculate what percentage one number is of another, and determine the percentage increase or decrease between two values. Simple, fast, and 100% free.</p>',
            ],
        ]
    ],
    'web' => [
        'name' => 'Web Utilities',
        'icon' => 'globe',
        'hidden_nav' => true,
        'tools' => [
            'privacy-policy-generator' => [
                'name' => 'Privacy Policy Generator',
                'desc' => 'Create a professional privacy policy for your website or app in seconds.',
                'seo_desc' => 'Free online privacy policy generator. Create a professional, GDPR and CCPA compliant privacy policy for your website, blog, or mobile app for free.',
                'keywords' => ['privacy policy generator', 'free privacy policy', 'create privacy policy', 'gdpr privacy policy', 'ccpa privacy policy', 'privacy policy for blog', 'website legal pages'],
                'seo_text' => '<h2>Free Website Privacy Policy Generator</h2><p>Every website and mobile app that collects user data needs a clear and transparent privacy policy. Our <strong>Privacy Policy Generator</strong> helps you create a professional legal document that complies with international regulations like GDPR and CCPA.</p><h3>Why You Need a Privacy Policy</h3><p>Besides being a legal requirement in many jurisdictions, a privacy policy builds trust with your users. It explains what data you collect, why you collect it, and how you protect it. Many third-party services like Google AdSense and Analytics also require a privacy policy to be present on your site.</p><h3>Easy to Use & Customisable</h3><p>Just fill in your business details and the types of cookies or data you use, and our tool will generate a copy-paste ready policy. It\'s 100% free and requires no account or credit card.</p>',
            ],
            'http-headers' => [
                'name' => 'HTTP Header Checker',
                'desc' => 'View the HTTP response headers of any URL to debug server issues.',
                'seo_desc' => 'Free online HTTP header checker. View raw response headers, status codes, and server information for any URL. Essential for web developers and SEOs.',
                'keywords' => ['http header checker', 'view http headers', 'url header viewer', 'server response headers', 'http status code checker', 'get headers online', 'web debugging tool'],
                'seo_text' => '<h2>Professional HTTP Header Viewer</h2><p>Our <strong>HTTP Header Checker</strong> is a powerful tool for web developers, SEO specialists, and security researchers. It allows you to inspect the raw "handshake" between a client and a server for any URL.</p><h3>What are HTTP Headers?</h3><p>HTTP headers provide essential information about the server, the content type, caching policies, and security settings. By checking headers, you can verify if your site is using **HTTPS**, if **HSTS** is enabled, and if your **Cache-Control** settings are optimized for performance.</p><h3>Debug Server Responses</h3><p>Simply enter a URL and hit "Check Headers" to see the status code (e.g., 200 OK, 301 Redirect, 404 Not Found) and the full list of headers returned by the server. This is crucial for troubleshooting redirects and server-side errors.</p>',
            ],
            'llms-generator' => [
                'name' => 'LLMs.txt Generator',
                'desc' => 'Generate an AI-optimized llms.txt file to help LLMs understand your website.',
                'seo_desc' => 'Free online llms.txt generator. Create a structured markdown file for AI models like ChatGPT and Claude to better understand and crawl your website.',
                'keywords' => ['llms.txt generator', 'ai seo tool', 'generate llms.txt', 'llmstxt online', 'ai crawler optimization', 'markdown sitemap for ai', 'chatgpt seo tool'],
                'seo_text' => '<h2>Optimize Your Website for the AI Era with llms.txt</h2><p>The <strong>llms.txt Generator</strong> by BulkTools creates a structured markdown file that helps AI models like ChatGPT, Claude, and Perplexity understand what your website is about, who you serve, and what content you offer. As AI search engines become the primary way users find information, having an optimized `llms.txt` file is essential for Modern SEO.</p><h3>What is llms.txt?</h3><p>The `llms.txt` file is an emerging web standard proposed to provide Large Language Models (LLMs) with a concise, machine-readable overview of a website. Think of it as `robots.txt` but designed specifically for AI context windows. Instead of forcing an AI to parse complex HTML and JavaScript, `llms.txt` gives them clear descriptions and direct links to your most important content.</p><h3>Benefits for AI Visibility (GEO)</h3><p>By implementing an `llms.txt` file, you practice **Generative Engine Optimization (GEO)**. This helps your brand gain better representation in AI answers, ensures accurate citations, and allows AI crawlers to discover your deep content more efficiently. Our tool crawls your homepage, extracts key metadata, and formats it into the official specification automatically.</p>',
            ],
        ]
    ]
];
