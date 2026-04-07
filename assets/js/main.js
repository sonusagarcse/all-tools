/**
 * Main JS for BulkTools - All Global Interactions
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize tool cards hover effects
    const toolCards = document.querySelectorAll('.tool-card');
    toolCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            // Add subtle hover effect if needed via JS
        });
    });

    // 2. Drag & Drop Upload Zone Initializer
    initUploadZones();

    // 3. Homepage Tool Search
    initToolSearch();
});

/**
 * Initialize Upload Zones dynamically
 */
function initUploadZones() {
    const uploadZones = document.querySelectorAll('.upload-zone');
    uploadZones.forEach(zone => {
        const input = zone.querySelector('input[type="file"]');
        const fileDisplay = zone.querySelector('.file-display');
        const fileName = zone.querySelector('.file-name');
        const fileSize = zone.querySelector('.file-size');

        // Click to trigger input
        zone.addEventListener('click', () => {
            if (input) input.click();
        });

        // Drag events
        ['dragenter', 'dragover'].forEach(eventName => {
            zone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                zone.classList.add('drag-over');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            zone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                zone.classList.remove('drag-over');
            });
        });

        // Handle drop
        zone.addEventListener('drop', (e) => {
            if (input) {
                const dt = e.dataTransfer;
                const files = dt.files;
                input.files = files;
                updateFileDisplay(files, fileName, fileSize, fileDisplay);
            }
        });

        // Handle selection
        if (input) {
            input.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    updateFileDisplay(e.target.files, fileName, fileSize, fileDisplay);
                }
            });
        }
    });

    /**
     * Update UI with file info
     */
    function updateFileDisplay(files, nameEl, sizeEl, displayEl) {
        if (!files || files.length === 0) return;
        
        if (files.length === 1) {
            const file = files[0];
            nameEl.textContent = file.name;
            sizeEl.textContent = formatBytes(file.size);
        } else {
            nameEl.textContent = `${files.length} files selected`;
            let totalSize = 0;
            for (let i = 0; i < files.length; i++) totalSize += files[i].size;
            sizeEl.textContent = `Total size: ${formatBytes(totalSize)}`;
        }
        
        if (displayEl) {
            displayEl.classList.remove('hidden');
            displayEl.previousElementSibling?.classList.add('hidden');
        }
    }
}

/**
 * Global Search for Tools
 */
/**
 * Global Search for Tools
 */
function initToolSearch() {
    const searchInputs = document.querySelectorAll('#global-search, #home-search');

    searchInputs.forEach(input => {
        let timeout = null;
        input.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            const dropdownId = input.id === 'global-search' ? 'global-search-dropdown' : 'home-search-dropdown';
            const dropdown = document.getElementById(dropdownId);
            
            if (!dropdown) return;
            
            if (query.length < 1) {
                dropdown.classList.add('hidden');
                return;
            }
            
            clearTimeout(timeout);
            timeout = setTimeout(async () => {
                try {
                    const res = await fetch(`${SITE_URL}/ajax/search.php?q=${encodeURIComponent(query)}`);
                    const data = await res.json();
                    
                    if (data.length > 0) {
                        let html = '<ul class="py-2 flex flex-col">';
                        data.forEach(item => {
                            html += `
                                <li>
                                    <a href="${item.url}" class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 dark:hover:bg-gray-800 transition-colors border-b border-slate-100 dark:border-gray-800 last:border-0">
                                        <div class="w-10 h-10 shrink-0 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-500">
                                            <i data-lucide="${item.icon}" class="w-5 h-5"></i>
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            <div class="text-sm font-bold text-slate-900 dark:text-white truncate">${item.name}</div>
                                            <div class="text-xs text-slate-500 dark:text-gray-400 truncate">${item.desc}</div>
                                        </div>
                                    </a>
                                </li>
                            `;
                        });
                        html += '</ul>';
                        dropdown.innerHTML = html;
                        if (typeof lucide !== 'undefined') lucide.createIcons();
                        dropdown.classList.remove('hidden');
                    } else {
                        dropdown.innerHTML = `
                            <div class="px-4 py-6 text-center">
                                <i data-lucide="search-x" class="w-8 h-8 mx-auto text-slate-400 mb-2"></i>
                                <span class="text-sm text-slate-500 block">No tools found matching "${query}"</span>
                            </div>
                        `;
                        if (typeof lucide !== 'undefined') lucide.createIcons();
                        dropdown.classList.remove('hidden');
                    }
                } catch (err) {
                    console.error("Search error", err);
                }
            }, 200);
        });
        
        // Hide when clicking outside
        document.addEventListener('click', (e) => {
            if (!input.contains(e.target) && !document.getElementById(input.id + '-dropdown')?.contains(e.target)) {
                document.getElementById(input.id + '-dropdown')?.classList.add('hidden');
            }
        });
    });
}

/**
 * AJAX Form Submission Handler (used by individual tools)
 */
async function handleToolForm(formId, processUrl) {
    const form = document.getElementById(formId);
    if (!form) return;

    const progressOverlay = document.getElementById('progress-overlay');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const resultSection = document.getElementById('result-section');
    const errorAlert = document.getElementById('error-alert');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // 1. Validate form (files, etc.)
        const files = form.querySelector('input[type="file"]')?.files;
        if (!files || files.length === 0) {
            showError('Please select a file first.');
            return;
        }

        // 2. Prepare Data
        const formData = new FormData(form);
        
        // 3. UI State: Processing
        hideError();
        form.classList.add('hidden');
        if (progressOverlay) progressOverlay.classList.remove('hidden');
        if (resultSection) resultSection.classList.add('hidden');

        try {
            // Fake progress animation for first 80%
            let progress = 0;
            const interval = setInterval(() => {
                progress += Math.random() * 10;
                if (progress > 85) clearInterval(interval);
                updateProgress(Math.min(progress, 85));
            }, 500);

            // 4. Fetch Response
            const response = await fetch(processUrl, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            clearInterval(interval);

            // Read response as text first to handle PHP warnings mixed with JSON
            const rawText = await response.text();
            let result;
            try {
                // Try to extract JSON even if PHP warnings are prepended
                const jsonMatch = rawText.match(/\{[\s\S]*\}$/);
                result = jsonMatch ? JSON.parse(jsonMatch[0]) : JSON.parse(rawText);
            } catch (parseErr) {
                console.error('Server response (not JSON):', rawText);
                if (progressOverlay) progressOverlay.classList.add('hidden');
                form.classList.remove('hidden');
                // Extract readable error from raw HTML/text
                const errMatch = rawText.match(/Fatal error:.*?(?:<br|$)/i) || rawText.match(/Warning:.*?(?:<br|$)/i);
                showError(errMatch ? 'Server error: ' + errMatch[0].replace(/<[^>]*>/g,'') : 'Server returned an invalid response. Check PHP error logs.');
                return;
            }

            if (result.success) {
                updateProgress(100);
                setTimeout(() => {
                    if (progressOverlay) progressOverlay.classList.add('hidden');
                    showResult(result);
                }, 500);
            } else {
                if (progressOverlay) progressOverlay.classList.add('hidden');
                form.classList.remove('hidden');
                showError(result.message || 'An error occurred during processing.');
            }
        } catch (error) {
            if (progressOverlay) progressOverlay.classList.add('hidden');
            form.classList.remove('hidden');
            showError('Network error: ' + (error.message || 'Server unavailable.'));
            console.error('Fetch error:', error);
        }
    });

    function updateProgress(value) {
        if (progressBar) progressBar.style.width = `${value}%`;
        if (progressText) progressText.textContent = `${Math.round(value)}%`;
    }

    function showResult(data) {
        if (resultSection) {
            resultSection.classList.remove('hidden');
            const downloadLink = resultSection.querySelector('#download-btn');
            if (downloadLink) {
                let dlUrl = data.download_url;
                if (dlUrl.includes('/uploads/')) {
                    const parts = dlUrl.split('/uploads/');
                    dlUrl = parts[0] + '/download.php?file=' + encodeURIComponent(parts[1]);
                }
                downloadLink.href = dlUrl;
                downloadLink.setAttribute('download', ''); // Forces automatic download instead of opening in a new tab
            }

            const savingsTextEl = resultSection.querySelector('#savings-text');
            if (savingsTextEl && data.original_size_str && data.compressed_size_str) {
                const pct = data.savings_pct || 0;
                let textStr = `Size Changed: ${data.original_size_str} → ${data.compressed_size_str}`;
                if (pct > 0) {
                    textStr = `Saved ${pct}% (${data.original_size_str} → ${data.compressed_size_str})`;
                } else if (pct < 0) {
                    textStr = `Increased by ${Math.abs(pct)}% (${data.original_size_str} → ${data.compressed_size_str})`;
                }
                savingsTextEl.textContent = textStr;
            }

            
            const previewImg = resultSection.querySelector('#preview-img');
            if (previewImg && data.preview_url) {
                previewImg.src = data.preview_url;
                previewImg.classList.remove('hidden');
            }
            
            resultSection.scrollIntoView({ behavior: 'smooth' });
        }
    }

    function showError(msg) {
        if (errorAlert) {
            errorAlert.querySelector('.error-msg').textContent = msg;
            errorAlert.classList.remove('hidden');
            errorAlert.scrollIntoView({ behavior: 'smooth' });
        } else {
            alert(msg);
        }
    }

    function hideError() {
        if (errorAlert) errorAlert.classList.add('hidden');
    }
}

/**
 * Utility: Format bytes to human readable
 */
function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

/**
 * Copy to Clipboard Utility
 */
function copyToClipboard(textId) {
    const el = document.getElementById(textId);
    const text = (el.tagName === 'TEXTAREA' || el.tagName === 'INPUT') ? el.value : el.innerText;
    navigator.clipboard.writeText(text).then(() => {
        const btn = document.querySelector(`[onclick="copyToClipboard('${textId}')"]`);
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i data-lucide="check" class="w-4 h-4"></i> Copied!';
        lucide.createIcons();
        setTimeout(() => {
            btn.innerHTML = originalHtml;
            lucide.createIcons();
        }, 2000);
    });
}
