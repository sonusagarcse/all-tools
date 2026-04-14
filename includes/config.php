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
        ]
    ]
];
