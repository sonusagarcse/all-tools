# ToolNest - All-in-One Tools Platform

ToolNest is a high-performance, dark-themed, all-in-one web tools platform built with PHP 8.2+, Tailwind CSS, and Vanilla JavaScript. It provides a suite of professional tools for PDF manipulation, video downloading, image processing, and text analysis.

## Features
- **Premium Dark UI**: Glassmorphism, smooth animations, and mobile-first design.
- **25+ Tools**: Including PDF to Image, Image to PDF, YouTube Downloader, Word to PDF, and more.
- **Secure Processing**: Files are processed on the server and automatically deleted after 1 hour.
- **Zero Dependencies (Browser)**: No heavy JS frameworks. Powered by Vanilla JS and AJAX Fetch API.
- **SEO Ready**: Unique titles, meta descriptions, and sitemaps for every tool.

## Installation & Setup

### 1. Requirements
- Apache 2.4+ (with `mod_rewrite` enabled)
- PHP 8.2+ (with `gd`, `imagick`, `curl`, and `zip` extensions)
- [Composer](https://getcomposer.org/)
- **External Binaries (Required for some tools):**
  - **Ghostscript**: For PDF compression and merging. (e.g., `gswin64c.exe` on Windows)
  - **LibreOffice**: For Word-to-PDF conversion (`soffice --headless`).
  - **yt-dlp**: For video downloading features.

### 2. Quick Start
1. Clone or copy the files to your web root (e.g., `C:\xampp\htdocs\tools`).
2. Run `composer install` to install PHP dependencies.
3. Configure your server paths in `includes/config.php`:
   ```php
   define('SITE_URL', 'http://localhost/tools'); 
   define('GHOSTSCRIPT_PATH', 'path/to/gs.exe');
   define('LIBREOFFICE_PATH', 'path/to/soffice.exe');
   define('YT_DLP_PATH', 'path/to/yt-dlp.exe');
   ```
4. Ensure the `uploads/` directory is writable by the web server.

### 3. Setup Cron Job
Add the following cron job to your server to clean up temporary files every hour:
```bash
0 * * * * php /path/to/tools/cleanup.php
```

## Creating New Tools
To add a new tool, simply duplicate an existing tool folder (e.g., `tools/pdf/jpg-to-pdf`) and update:
1. `index.php`: The UI and options.
2. `process.php`: The backend logic.
3. Add the tool to the `$TOOL_CATEGORIES` array in `includes/config.php`.

## Security
- CSRF Protection on all forms.
- Rate Limiting (10 uploads per hour per user).
- Input Sanitation and MIME type validation.
- Secure `.htaccess` rules blocking direct access to uploads and PHP execution in upload folders.

## License
MIT License.
