# BulkTools PWA Production Guide & APK Conversion

The project has now been successfully converted into a modern, offline-capable Progressive Web App (PWA) with a robust API-driven PHP backend.

## 📂 Project Architecture

```plaintext
pwa-app/
│
├── api/
│   ├── config.php            # Secure database & global config
│   └── v1/
│       ├── auth.php          # Login, Logout, OTP Auth endpoints
│       ├── dashboard.php     # Admin analytics & logs endpoints
│       └── tools.php         # Functional tool logic (compression, etc.)
│
├── app/
│   ├── app.js                # Core SPA Router & Offline handling
│   ├── components/           # HTML fragments injected dynamically via AJAX
│   │   ├── home.html         # Homepage UI
│   │   ├── dashboard.html    # Tools listing UI
│   │   └── profile.html      # Settings & Profile UI
│   └── assets/
│       └── css/
│           └── style.css     # PWA Tailwind extensions & custom CSS
│
├── index.html                # App shell (Bottom Nav, App Bar, Splash Screen)
├── manifest.json             # PWA properties (App name, colors, icons)
├── sw.js                     # Service Worker (Offline caching strategy)
└── .htaccess                 # Security headers & URL routing
```

## 🛠️ API Layer Integration

The legacy PHP logic has been cleanly decoupled. 
1. **Frontend**: Sends asynchronous Requests wrapper (via `fetch` or `XMLHttpRequest`).
2. **Backend**: `api/v1/auth.php`, `tools.php`, and `dashboard.php` consume POST/GET and always respond with pure JSON.
3. **Security**: We enabled Prepared Statements via PDO in `config.php`, enforced strict `application/json` output, and added `X-Content-Type-Options: nosniff`.

## 🚀 Converting to Android APK

Since you want to convert this PWA to an Android APK without heavily modifying the codebase, you have two primary production-ready paths. TWA is recommended for pure PWAs.

### Method 1: Trusted Web Activity (TWA) - Recommended
TWA wraps your PWA into a native Android container while using Google Chrome's engine. It runs fullscreen, feels 100% native, and supports the Google Play Store perfectly.

**Steps:**
1. **Host Live:** Upload your BulkTools PWA folder to your cPanel hosting. Ensure SSL (HTTPS) is active.
2. **Bubblewrap CLI** (Requires Node.js installed only simply on your LOCAL machine, not your hosting):
   * Run: `npm i -g @google/bubblewrap/cli`
   * Run: `bubblewrap init --manifest https://yourdomain.com/pwa-app/manifest.json`
   * Run: `bubblewrap build`
3. **Digital Asset Links:** 
   * Bubblewrap will output an `assetlinks.json` file.
   * Upload this file to your cPanel root so it is accessible at: `https://yourdomain.com/.well-known/assetlinks.json`
   * This proves you own the domain and removes the browser URL bar permanently.
4. **Result:** You'll have an `app-release.apk` ready for the Play Store or direct distribution.

### Method 2: WebView (Android Studio)
If you want hardware-specific integrations later (like native file compression via Java/Kotlin in the future), you can use a WebView.

**Steps:**
1. Open Android Studio and create an "Empty Activity".
2. In `activity_main.xml`, add a `WebView` that fills the screen.
3. In `MainActivity.java` or `MainActivity.kt`:
   ```kotlin
   val webView: WebView = findViewById(R.id.webView)
   webView.settings.javaScriptEnabled = true
   webView.settings.domStorageEnabled = true // Required for PWA local storage
   webView.webViewClient = WebViewClient() // Opens links internally
   webView.loadUrl("https://yourdomain.com/pwa-app/")
   ```
4. Build the APK. This requires more manual maintenance but gives complete device control.

## 🔒 Shared Hosting (cPanel) Deployment Checklist

Your application is entirely built on standard PHP without Node.js dependencies on the server, making it perfect for cPanel.

- [ ] **Upload Files:** Upload the entirety of `pwa-app` directory via FTP or cPanel File Manager.
- [ ] **Config Setup:** Edit `api/config.php` and update the DB connection (`DB_USER`, `DB_PASS`, `DB_NAME`).
- [ ] **HTTPS Verification:** PWAs **mandate** HTTPS. Ensure your cPanel Let's Encrypt certificate is active. 
- [ ] **Service Worker Check:** Verify the service worker is loaded over `https://` checking Chrome DevTools -> Application -> Service Workers. 
- [ ] **Folder Permissions:** Tool endpoints that do file transformations should have their upload directories (e.g. `/uploads`) set to `CHMOD 755`.
