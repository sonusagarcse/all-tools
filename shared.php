<?php
/**
 * BULKTOOLS - Public Image Viewer
 * Branded page to display images shared via the PWA.
 */

$shareId = $_GET['id'] ?? '';
$imagePath = '';
$found = false;

if (!empty($shareId) && preg_match('/^[a-f0-9]{12}$/', $shareId)) {
    $uploadDir = __DIR__ . '/uploads/shared/';
    $files = glob($uploadDir . $shareId . '.*');

    if (!empty($files)) {
        $found = true;
        $fullPath = $files[0];
        $filename = basename($fullPath);
        $imageUrl = 'uploads/shared/' . $filename;
    }
}

// Redirect to home if not found
if (!$found) {
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shared Image | BulkTools</title>

    <!-- OpenGraph Meta Tags for Social Sharing -->
    <meta property="og:title" content="Shared Image via BulkTools">
    <meta property="og:description" content="Click to view this image shared via BulkTools PWA.">
    <meta property="og:image" content="<?php echo $imageUrl; ?>">
    <meta property="og:type" content="image.gallery">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=Space+Grotesk:wght@700;900&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .brand {
            font-family: 'Space Grotesk', sans-serif;
        }

        body {
            background: #0f172a;
        }

        .glass {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col text-white">

    <!-- Header / Nav -->
    <header class="p-6 flex items-center justify-between max-w-5xl mx-auto w-full">
        <div class="flex items-center gap-2">
            <div
                class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-500/20">
                <i data-lucide="layers" class="w-5 h-5 text-white"></i>
            </div>
            <span class="brand font-bold text-xl tracking-tight">BulkTools</span>
        </div>
        <a href="pwa-app/"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 rounded-xl text-sm font-bold transition-all active:scale-95 shadow-lg shadow-indigo-500/20 flex items-center gap-2">
            <i data-lucide="download-cloud" class="w-4 h-4"></i> Get App
        </a>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col items-center justify-center p-4">
        <div class="max-w-4xl w-full">
            <!-- Image Card -->
            <div class="glass rounded-[2rem] overflow-hidden shadow-2xl relative group">
                <div class="p-4 bg-slate-800/50 flex items-center justify-between border-b border-white/5">
                    <div class="flex items-center gap-2">
                        <i data-lucide="image" class="w-4 h-4 text-indigo-400"></i>
                        <span class="text-xs font-medium text-slate-400">shared_image_<?php echo $shareId; ?></span>
                    </div>
                    <a href="<?php echo $imageUrl; ?>" download
                        class="p-2 hover:bg-white/10 rounded-lg transition-colors" title="Download">
                        <i data-lucide="download" class="w-4 h-4 text-slate-400"></i>
                    </a>
                </div>

                <div class="flex items-center justify-center bg-slate-900/50 min-h-[300px]">
                    <img src="<?php echo $imageUrl; ?>" alt="Shared via BulkTools"
                        class="max-w-full max-h-[70vh] object-contain">
                </div>
            </div>

            <!-- CTA Section -->
            <div class="mt-12 text-center">
                <h2 class="text-2xl font-black mb-3">Want more tools like this?</h2>
                <p class="text-slate-400 text-sm max-w-md mx-auto mb-8">
                    BulkTools is a premium PWA for image compression, QR generation, text editing, and more. Use it
                    anywhere, even offline.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="pwa-app/#image-share"
                        class="px-8 py-4 bg-white text-slate-900 font-black rounded-2xl flex items-center gap-3 active:scale-95 transition-all">
                        <i data-lucide="share-2" class="w-5 h-5"></i> Start Sharing Now
                    </a>
                    <button onclick="copyCurrentUrl()"
                        class="px-8 py-4 glass text-white font-bold rounded-2xl flex items-center gap-3 active:scale-95 transition-all">
                        <i data-lucide="copy" class="w-5 h-5"></i> Copy Link
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="p-8 text-center text-slate-500 text-[10px] font-medium uppercase tracking-[0.2em]">
        &copy; 2026 BULKTOOLS ECOSYSTEM &bull; SECURE &bull; FAST &bull; OFFLINE
    </footer>

    <script>
        lucide.createIcons();

        function copyCurrentUrl() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link copied to clipboard!');
            });
        }
    </script>
</body>

</html>