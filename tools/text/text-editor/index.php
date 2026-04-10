<?php
require_once '../../../includes/header.php';
$tool = get_current_tool_info($_SERVER['REQUEST_URI']);
?>

<!-- Tool Header -->
<section class="pt-12 pb-8 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-medium text-gray-500">
                <li class="inline-flex items-center">
                    <a href="<?php echo SITE_URL; ?>" class="hover:text-white flex items-center">
                        <i data-lucide="home" class="w-3 h-3 mr-1"></i> Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i>
                        <a href="<?php echo SITE_URL; ?>#text" class="hover:text-white">Text Tools</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i>
                        <span class="text-slate-500 dark:text-gray-300"><?php echo $tool['name']; ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="max-w-2xl">
                <h1 class="text-3xl md:text-5xl font-heading font-extrabold text-slate-900 dark:text-white mb-4"><?php echo $tool['name']; ?></h1>
                <p class="text-slate-600 dark:text-gray-400 text-lg leading-relaxed"><?php echo $tool['desc']; ?></p>
            </div>
            <div class="flex gap-3">
                <div class="px-4 py-2 rounded-xl bg-green-500/10 border border-green-500/20 flex items-center gap-2 text-green-600 dark:text-green-400 shadow-lg shadow-green-500/5 transition-all">
                    <i data-lucide="shield-check" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Safe & Encrypted</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-slate-50 dark:bg-gray-950 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-8">
            
            <!-- Main Editor Space -->
            <div class="space-y-6">
                <!-- Editor Toolbar Branding Area -->
                <div class="bg-white dark:bg-gray-900 p-4 rounded-t-3xl border-t border-x border-slate-200 dark:border-gray-800 flex items-center justify-between transition-colors">
                    <div class="flex items-center gap-3 px-2">
                        <div class="w-8 h-8 rounded-lg bg-indigo-500 flex items-center justify-center text-white">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                        </div>
                        <span class="font-bold text-slate-700 dark:text-white tracking-tight">Active Document</span>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="downloadAs('txt')" class="p-2 rounded-xl bg-slate-100 dark:bg-gray-800 text-slate-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-white transition-all shadow-sm" title="Download TXT">
                            <i data-lucide="file-down" class="w-5 h-5"></i>
                        </button>
                        <button onclick="downloadAs('html')" class="p-2 rounded-xl bg-slate-100 dark:bg-gray-800 text-slate-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-white transition-all shadow-sm" title="Download HTML">
                            <i data-lucide="code" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <!-- Quill Editor Target -->
                <div id="editor-wrapper" class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-xl overflow-hidden transition-colors min-h-[600px]">
                    <div id="editor-container" class="h-[600px] text-lg"></div>
                </div>

                <!-- Footer Quick Actions -->
                <div class="bg-white dark:bg-gray-900 p-4 rounded-b-3xl border-b border-x border-slate-200 dark:border-gray-800 flex flex-wrap gap-4 transition-colors">
                    <button onclick="copyToClipboard()" class="flex items-center gap-2 px-6 py-2 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                        <i data-lucide="copy" class="w-4 h-4"></i> Copy Content
                    </button>
                    <button onclick="clearEditor()" class="flex items-center gap-2 px-6 py-2 rounded-xl bg-slate-100 dark:bg-gray-800 text-slate-500 dark:text-gray-400 font-bold hover:bg-red-500 hover:text-white transition-all active:scale-95">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> Clear All
                    </button>
                </div>
            </div>

            <!-- Stats & Tools Sidebar -->
            <aside class="space-y-6">
                <!-- Document Statistics -->
                <div class="bg-white dark:bg-gray-900 p-6 rounded-3xl border border-slate-200 dark:border-gray-800 shadow-sm transition-colors sticky top-24">
                    <h3 class="text-xs font-bold text-slate-500 dark:text-gray-500 uppercase tracking-widest mb-6 px-1">Document Stats</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-gray-800/50 border border-slate-100 dark:border-gray-800">
                            <div class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-wider mb-1">Words</div>
                            <div id="stat-words" class="text-2xl font-black text-indigo-600 dark:text-indigo-400">0</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-gray-800/50 border border-slate-100 dark:border-gray-800">
                            <div class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-wider mb-1">Characters</div>
                            <div id="stat-chars" class="text-2xl font-black text-indigo-600 dark:text-indigo-400">0</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-gray-800/50 border border-slate-100 dark:border-gray-800">
                            <div class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-wider mb-1">Sentences</div>
                            <div id="stat-sentences" class="text-2xl font-black text-indigo-600 dark:text-indigo-400">0</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-gray-800/50 border border-slate-100 dark:border-gray-800">
                            <div class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-wider mb-1">Read Time</div>
                            <div id="stat-read" class="text-sm font-bold text-slate-700 dark:text-gray-300">< 1m</div>
                        </div>
                    </div>

                    <div class="w-full h-px bg-slate-200 dark:bg-gray-800 my-8"></div>

                    <h3 class="text-xs font-bold text-slate-500 dark:text-gray-500 uppercase tracking-widest mb-6 px-1">Utility Actions</h3>
                    
                    <div class="space-y-3">
                        <button onclick="cleanFormatting()" class="w-full flex items-center justify-between p-3 rounded-xl bg-slate-50 dark:bg-gray-800/50 border border-slate-100 dark:border-gray-800 text-slate-600 dark:text-gray-300 hover:border-indigo-500 transition-all group">
                            <span class="text-sm font-medium">Clean Formatting</span>
                            <i data-lucide="wand-2" class="w-4 h-4 group-hover:text-indigo-500"></i>
                        </button>
                        <button onclick="changeCase('upper')" class="w-full flex items-center justify-between p-3 rounded-xl bg-slate-50 dark:bg-gray-800/50 border border-slate-100 dark:border-gray-800 text-slate-600 dark:text-gray-300 hover:border-indigo-500 transition-all group">
                            <span class="text-sm font-medium">To UPPERCASE</span>
                            <i data-lucide="type" class="w-4 h-4 group-hover:text-indigo-500"></i>
                        </button>
                        <button onclick="changeCase('lower')" class="w-full flex items-center justify-between p-3 rounded-xl bg-slate-50 dark:bg-gray-800/50 border border-slate-100 dark:border-gray-800 text-slate-600 dark:text-gray-300 hover:border-indigo-500 transition-all group">
                            <span class="text-sm font-medium">To lowercase</span>
                            <i data-lucide="type" class="w-4 h-4 group-hover:text-indigo-500"></i>
                        </button>
                        <button onclick="removeExtraSpaces()" class="w-full flex items-center justify-between p-3 rounded-xl bg-slate-50 dark:bg-gray-800/50 border border-slate-100 dark:border-gray-800 text-slate-600 dark:text-gray-300 hover:border-indigo-500 transition-all group">
                            <span class="text-sm font-medium">Remove Extra Spaces</span>
                            <i data-lucide="space" class="w-4 h-4 group-hover:text-indigo-500"></i>
                        </button>
                    </div>

                    <!-- Auto-save notification -->
                    <div id="auto-save-status" class="mt-8 text-[10px] font-bold text-slate-400 dark:text-gray-600 flex items-center gap-2 px-1">
                        <i data-lucide="save" class="w-3 h-3"></i> Auto-saved locally
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

<!-- Include Quill.js -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<style>
    /* Quill Theme Customization */
    .ql-toolbar.ql-snow {
        border: none !important;
        background: transparent !important;
        padding: 8px 16px !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }
    .dark .ql-toolbar.ql-snow {
        border-bottom: 1px solid #1f2937 !important;
    }
    .ql-container.ql-snow {
        border: none !important;
    }
    .ql-editor {
        padding: 32px !important;
        min-height: 500px;
        color: inherit;
        font-family: 'Inter', sans-serif;
        line-height: 1.6;
    }
    .ql-editor.ql-blank::before {
        color: #94a3b8;
        font-style: italic;
    }
    .dark .ql-editor.ql-blank::before {
        color: #4b5563;
    }
    .dark .ql-snow .ql-stroke {
        stroke: #94a3b8;
    }
    .dark .ql-snow .ql-fill {
        fill: #94a3b8;
    }
    .dark .ql-snow .ql-picker {
        color: #94a3b8;
    }
    /* Toolbar button hover */
    .ql-snow .ql-toolbar button:hover,
    .ql-snow.ql-toolbar button:hover {
        color: #6366f1 !important;
    }
    .ql-snow .ql-toolbar button:hover .ql-stroke,
    .ql-snow.ql-toolbar button:hover .ql-stroke {
        stroke: #6366f1 !important;
    }
    .ql-editor::-webkit-scrollbar {
        width: 6px;
    }
    .ql-editor::-webkit-scrollbar-track {
        background: transparent;
    }
    .ql-editor::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .dark .ql-editor::-webkit-scrollbar-thumb {
        background: #334155;
    }
</style>

<script>
    let quill;
    const STORAGE_KEY = 'bulktools_text_editor_content';

    document.addEventListener('DOMContentLoaded', () => {
        // Init Quill
        quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Start writing your professional document here...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'color': [] }, { 'background': [] }],
                    ['link', 'blockquote', 'code-block'],
                    ['clean']
                ]
            }
        });

        // Load saved content
        const saved = localStorage.getItem(STORAGE_KEY);
        if (saved) {
            quill.setContents(JSON.parse(saved));
        }

        // Listen for changes
        quill.on('text-change', () => {
            updateStats();
            handleAutoSave();
        });

        // Initial stats
        updateStats();
    });

    function updateStats() {
        const text = quill.getText().trim();
        const html = quill.root.innerHTML;

        const words = text ? text.split(/\s+/).length : 0;
        const chars = text.length;
        const sentences = text ? text.split(/[.!?]+/).length - 1 : 0;
        const readTime = Math.ceil(words / 200);

        document.getElementById('stat-words').textContent = words;
        document.getElementById('stat-chars').textContent = chars;
        document.getElementById('stat-sentences').textContent = sentences;
        document.getElementById('stat-read').textContent = readTime + (readTime === 1 ? ' min' : ' mins');
    }

    let autoSaveTimeout;
    function handleAutoSave() {
        clearTimeout(autoSaveTimeout);
        const status = document.getElementById('auto-save-status');
        status.innerHTML = '<i data-lucide="loader-2" class="w-3 h-3 animate-spin"></i> Saving...';
        lucide.createIcons();

        autoSaveTimeout = setTimeout(() => {
            const contents = quill.getContents();
            localStorage.setItem(STORAGE_KEY, JSON.stringify(contents));
            status.innerHTML = '<i data-lucide="check-circle-2" class="w-3 h-3 text-green-500"></i> Draft saved';
            lucide.createIcons();
            
            setTimeout(() => {
                status.innerHTML = '<i data-lucide="save" class="w-3 h-3"></i> Auto-saved locally';
                lucide.createIcons();
            }, 2000);
        }, 1000);
    }

    function copyToClipboard() {
        const text = quill.getText();
        navigator.clipboard.writeText(text).then(() => {
            alert('Plain text copied to clipboard!');
        });
    }

    function clearEditor() {
        if (confirm('Are you sure you want to clear all content? This action cannot be undone.')) {
            quill.setContents([]);
            localStorage.removeItem(STORAGE_KEY);
            updateStats();
        }
    }

    function downloadAs(format) {
        const timestamp = new Date().toISOString().replace(/[:.]/g, '-').slice(0, 19);
        const filename = `bulktools-document-${timestamp}`;
        let content, mime;

        if (format === 'txt') {
            content = quill.getText();
            mime = 'text/plain';
        } else {
            content = quill.root.innerHTML;
            mime = 'text/html';
        }

        const blob = new Blob([content], { type: mime });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `${filename}.${format}`;
        a.click();
        URL.revokeObjectURL(url);
    }

    function cleanFormatting() {
        quill.removeFormat(0, quill.getLength());
    }

    function changeCase(type) {
        const range = quill.getSelection();
        if (range && range.length > 0) {
            const text = quill.getText(range.index, range.length);
            const newText = type === 'upper' ? text.toUpperCase() : text.toLowerCase();
            quill.deleteText(range.index, range.length);
            quill.insertText(range.index, newText);
        } else {
            const text = quill.getText();
            const newText = type === 'upper' ? text.toUpperCase() : text.toLowerCase();
            quill.setText(newText);
        }
    }

    function removeExtraSpaces() {
        const text = quill.getText();
        const cleaned = text.replace(/\s+/g, ' ').trim();
        quill.setText(cleaned);
    }
</script>

<?php require_once '../../../includes/footer.php'; ?>
