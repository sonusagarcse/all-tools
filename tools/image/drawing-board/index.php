<?php
require_once '../../../includes/header.php';
$tool = get_current_tool_info($_SERVER['REQUEST_URI']);
?>

<!-- Fabric.js CDN -->
<script src="https://unpkg.com/fabric@5.3.0/dist/fabric.min.js"></script>

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
                        <a href="<?php echo SITE_URL; ?>#image" class="hover:text-white">Image Tools</a>
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
                    <i data-lucide="lock" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">100% Client Side</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-slate-50 dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Drawing App Main Container -->
        <div id="drawing-app-container" class="bg-slate-50 dark:bg-gray-950 p-0 transition-all rounded-3xl">
            
            <!-- Controls Bar -->
            <div class="mb-6 flex flex-wrap items-center justify-between gap-4 bg-white/80 dark:bg-gray-900/50 p-4 rounded-2xl border border-slate-200 dark:border-gray-800 shadow-sm backdrop-blur-md transition-colors">
                <div class="flex items-center gap-2">
                    <button onclick="undo()" id="undo-btn" class="p-2.5 rounded-xl bg-slate-100 dark:bg-gray-800 text-slate-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-white hover:bg-slate-200 dark:hover:bg-gray-700 transition-all disabled:opacity-30" title="Undo (Ctrl+Z)">
                        <i data-lucide="undo" class="w-5 h-5"></i>
                    </button>
                    <button onclick="redo()" id="redo-btn" class="p-2.5 rounded-xl bg-slate-100 dark:bg-gray-800 text-slate-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-white hover:bg-slate-200 dark:hover:bg-gray-700 transition-all disabled:opacity-30" title="Redo (Ctrl+Y)">
                        <i data-lucide="redo" class="w-5 h-5"></i>
                    </button>
                    <div class="w-px h-6 bg-slate-200 dark:bg-gray-800 mx-2"></div>
                    <button onclick="toggleFullScreen()" class="p-2.5 rounded-xl bg-slate-100 dark:bg-gray-800 text-slate-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-white hover:bg-slate-200 dark:hover:bg-gray-700 transition-all" title="Toggle Fullscreen">
                        <i data-lucide="maximize" id="fs-icon" class="w-5 h-5"></i>
                    </button>
                    <button onclick="clearCanvas()" class="p-2.5 rounded-xl bg-red-500/10 text-red-500 dark:text-red-400 hover:bg-red-500 hover:text-white transition-all" title="Clear Canvas">
                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                    </button>
                </div>

            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-2 mr-4">
                    <span class="text-xs font-bold text-slate-500 dark:text-gray-500 uppercase tracking-widest">Zoom</span>
                    <button onclick="zoomOut()" class="p-1.5 text-slate-400 hover:text-indigo-600 dark:hover:text-white transition-colors"><i data-lucide="minus-circle" class="w-4 h-4"></i></button>
                    <span id="zoom-level" class="text-sm font-mono text-indigo-600 dark:text-indigo-400 w-12 text-center">100%</span>
                    <button onclick="zoomIn()" class="p-1.5 text-slate-400 hover:text-indigo-600 dark:hover:text-white transition-colors"><i data-lucide="plus-circle" class="w-4 h-4"></i></button>
                </div>
                <button onclick="downloadPNG()" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-500/25 flex items-center gap-2">
                    <i data-lucide="download" class="w-5 h-5"></i> Download PNG
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[auto_1fr_300px] gap-6 items-start">
            
            <!-- Sidebar: Tools -->
            <div class="flex lg:flex-col flex-wrap gap-2 bg-white dark:bg-gray-900 p-3 rounded-2xl border border-slate-200 dark:border-gray-800 sticky top-24 z-10 shadow-sm transition-colors">
                <button data-tool="select" onclick="setActiveTool('select')" class="tool-btn p-3 rounded-xl transition-all hover:bg-gray-800 text-gray-400 active" title="Select (V)">
                    <i data-lucide="mouse-pointer-2" class="w-6 h-6"></i>
                </button>
                <button data-tool="pencil" onclick="setActiveTool('pencil')" class="tool-btn p-3 rounded-xl transition-all hover:bg-gray-800 text-gray-400" title="Pencil (P)">
                    <i data-lucide="pencil" class="w-6 h-6"></i>
                </button>
                <button data-tool="eraser" onclick="setActiveTool('eraser')" class="tool-btn p-3 rounded-xl transition-all hover:bg-gray-800 text-gray-400" title="Eraser (E)">
                    <i data-lucide="eraser" class="w-6 h-6"></i>
                </button>
                <div class="w-full h-px bg-gray-800 my-1 hidden lg:block"></div>
                <button data-tool="line" onclick="setActiveTool('line')" class="tool-btn p-3 rounded-xl transition-all hover:bg-gray-800 text-gray-400" title="Line (L)">
                    <i data-lucide="minus" class="w-6 h-6"></i>
                </button>
                <button data-tool="arrow" onclick="setActiveTool('arrow')" class="tool-btn p-3 rounded-xl transition-all hover:bg-gray-800 text-gray-400" title="Arrow (A)">
                    <i data-lucide="move-up-right" class="w-6 h-6"></i>
                </button>
                <button data-tool="rect" onclick="setActiveTool('rect')" class="tool-btn p-3 rounded-xl transition-all hover:bg-gray-800 text-gray-400" title="Rectangle (R)">
                    <i data-lucide="square" class="w-6 h-6"></i>
                </button>
                <button data-tool="circle" onclick="setActiveTool('circle')" class="tool-btn p-3 rounded-xl transition-all hover:bg-gray-800 text-gray-400" title="Circle (C)">
                    <i data-lucide="circle" class="w-6 h-6"></i>
                </button>
                <button data-tool="triangle" onclick="setActiveTool('triangle')" class="tool-btn p-3 rounded-xl transition-all hover:bg-gray-800 text-gray-400" title="Triangle (T)">
                    <i data-lucide="triangle" class="w-6 h-6"></i>
                </button>
                <div class="w-full h-px bg-slate-200 dark:bg-gray-800 my-1 hidden lg:block"></div>
                <button data-tool="text" onclick="setActiveTool('text')" class="tool-btn p-3 rounded-xl transition-all hover:bg-slate-100 dark:hover:bg-gray-800 text-slate-400 dark:text-gray-400" title="Text (X)">
                    <i data-lucide="type" class="w-6 h-6"></i>
                </button>
            </div>

            <!-- Canvas Container -->
            <div id="canvas-wrapper" class="relative bg-white dark:bg-gray-900 rounded-3xl border border-slate-200 dark:border-gray-800 shadow-xl overflow-hidden min-h-[600px] flex items-center justify-center transition-colors">
                <!-- Transparent grid background -->
                <div class="absolute inset-0 opacity-[0.05] dark:opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(#6366f1 1px, transparent 1px); background-size: 20px 20px;"></div>
                <canvas id="main-canvas"></canvas>
            </div>

            <!-- Sidebar: Properties -->
            <div class="space-y-6 bg-white dark:bg-gray-900 p-6 rounded-3xl border border-slate-200 dark:border-gray-800 transition-colors">
                
                <!-- Stroke Settings -->
                <div class="space-y-4">
                    <h3 class="text-xs font-bold text-slate-500 dark:text-gray-500 uppercase tracking-widest">Stroke & Color</h3>
                    
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-600 dark:text-gray-400">Stroke Color</label>
                        <div class="flex gap-2 flex-wrap">
                            <input type="color" id="stroke-color" value="#6366f1" onchange="updateProperties()" class="w-10 h-10 rounded-lg bg-slate-100 dark:bg-gray-800 border-none cursor-pointer">
                            <div class="flex gap-1">
                                <?php foreach(['#6366f1', '#ef4444', '#10b981', '#f59e0b', '#ffffff', '#000000'] as $c): ?>
                                    <button onclick="setColor('stroke', '<?php echo $c; ?>')" class="w-6 h-6 rounded-full border border-gray-700" style="background-color: <?php echo $c; ?>"></button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-600 dark:text-gray-400">Fill Color</label>
                        <div class="flex gap-2 flex-wrap">
                            <div class="relative group">
                                <input type="color" id="fill-color" value="transparent" onchange="updateProperties()" class="w-10 h-10 rounded-lg bg-slate-100 dark:bg-gray-800 border-none cursor-pointer">
                                <button onclick="setColor('fill', 'transparent')" class="absolute -top-1 -right-1 p-0.5 bg-red-500 text-white rounded-full"><i data-lucide="x" class="w-3 h-3"></i></button>
                            </div>
                            <div class="flex gap-1">
                                <?php foreach(['#6366f1', '#ef4444', '#10b981', '#f59e0b', '#ffffff', 'transparent'] as $c): ?>
                                    <button onclick="setColor('fill', '<?php echo $c; ?>')" class="w-6 h-6 rounded-full border border-gray-700 <?php echo $c === 'transparent' ? "bg-[url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAYAAACp8Z5+AAAAAXNSR0IArs4c6QAAACdJREFUGFdjZEADJmBhYGBkYARigBAbG7AyMDAyMDIwMDAyMDAyMDAyGDAyMDAyGDAyMDAyGDAyGDAyMDAyGDAyMDAyGDAyGDAyMDAyGDAyGDAyGDAyGDAyGDAyGDAyGDAyGDAyGDAyGDAyGDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyGDAyMDAyGDAyMDAyGDAyMDAyGDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyXDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyGDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyMDAyXDAyMDAyMDAyMDAyMDAyMDA=')]" : ''; ?>" style="background-color: <?php echo $c; ?>"></button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <label class="text-sm font-medium text-slate-600 dark:text-gray-400">Stroke Width</label>
                            <span id="width-val" class="text-xs font-mono text-indigo-600 dark:text-indigo-400">4px</span>
                        </div>
                        <input type="range" id="stroke-width" min="1" max="50" value="4" oninput="updateProperties()" class="w-full h-1.5 bg-slate-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-indigo-500">
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <label class="text-sm font-medium text-slate-600 dark:text-gray-400">Opacity</label>
                            <span id="opacity-val" class="text-xs font-mono text-indigo-600 dark:text-indigo-400">100%</span>
                        </div>
                        <input type="range" id="opacity" min="10" max="100" value="100" oninput="updateProperties()" class="w-full h-1.5 bg-slate-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-indigo-500">
                    </div>
                </div>

                <div class="w-full h-px bg-slate-200 dark:bg-gray-800"></div>

                <!-- Text Settings -->
                <div id="text-settings" class="space-y-4 opacity-50 pointer-events-none transition-all">
                    <h3 class="text-xs font-bold text-slate-500 dark:text-gray-500 uppercase tracking-widest">Text Properties</h3>
                    
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-600 dark:text-gray-400">Font Family</label>
                        <select id="font-family" onchange="updateProperties()" class="w-full bg-slate-50 dark:bg-gray-800 border border-slate-200 dark:border-gray-700 text-slate-900 dark:text-gray-100 text-sm py-2 px-3 rounded-xl focus:ring-indigo-500">
                            <option value="Inter">Inter (Sans)</option>
                            <option value="Space Grotesk">Space Grotesk</option>
                            <option value="serif">Serif</option>
                            <option value="monospace">Monospace</option>
                            <option value="cursive">Cursive</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button onclick="toggleTextStyle('bold')" class="flex-1 py-2 rounded-xl bg-slate-100 dark:bg-gray-800 text-slate-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-white transition-all" id="btn-bold"><b>B</b></button>
                        <button onclick="toggleTextStyle('italic')" class="flex-1 py-2 rounded-xl bg-slate-100 dark:bg-gray-800 text-slate-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-white transition-all" id="btn-italic"><i>I</i></button>
                    </div>
                </div>

                <div class="w-full h-px bg-slate-200 dark:bg-gray-800"></div>

                <!-- Hints -->
                <div class="bg-indigo-500/5 dark:bg-indigo-500/10 border border-indigo-500/10 dark:border-indigo-500/20 p-4 rounded-2xl">
                    <h4 class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mb-2 flex items-center gap-1">
                        <i data-lucide="info" class="w-3 h-3"></i> Quick Tips
                    </h4>
                    <ul class="text-[11px] text-slate-500 dark:text-gray-400 space-y-1 leading-relaxed">
                        <li>• <b>Space + Drag</b> to pan around</li>
                        <li>• <b>Del</b> to delete selected object</li>
                        <li>• <b>Ctrl + Scroll</b> to zoom</li>
                        <li>• <b>Double Click</b> text to edit</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .tool-btn.active {
        background-color: #4f46e5;
        color: white;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
    }
    .canvas-container {
        margin: 0 auto !important;
    }
    canvas {
        border-radius: 0.5rem;
    }
    
    /* Fullscreen Specifics */
    #drawing-app-container:fullscreen {
        padding: 0;
        width: 100vw;
        height: 100vh;
        overflow: hidden;
        position: relative;
        background-color: #030712; /* Fallback for dark */
    }
    html:not(.dark) #drawing-app-container:fullscreen {
        background-color: #f8fafc;
    }

    #drawing-app-container:fullscreen #canvas-wrapper {
        position: absolute;
        inset: 0;
        z-index: 1;
        border: none;
        border-radius: 0;
    }

    /* Common Floating Panel Style */
    #drawing-app-container:fullscreen .mb-6,
    #drawing-app-container:fullscreen .lg\:flex-col,
    #drawing-app-container:fullscreen .space-y-6 {
        position: absolute;
        z-index: 50;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(17, 24, 39, 0.8);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
    }

    /* Light Mode Overrides for Fullscreen Panels */
    html:not(.dark) #drawing-app-container:fullscreen .mb-6,
    html:not(.dark) #drawing-app-container:fullscreen .lg\:flex-col,
    html:not(.dark) #drawing-app-container:fullscreen .space-y-6 {
        background: rgba(255, 255, 255, 0.85);
        border-color: rgba(0, 0, 0, 0.08);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.15);
    }

    #drawing-app-container:fullscreen .mb-6 { /* Top bar */
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: auto;
        min-width: 400px;
    }
    #drawing-app-container:fullscreen .lg\:flex-col { /* Left tools */
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
    }
    #drawing-app-container:fullscreen .space-y-6 { /* Right props */
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        max-height: 80vh;
        overflow-y: auto;
    }
    
    /* Ensure icons/text are visible in light mode fullscreen */
    html:not(.dark) #drawing-app-container:fullscreen .text-gray-400 {
        color: #475569 !important; /* slate-600ish */
    }
    html:not(.dark) #drawing-app-container:fullscreen .bg-gray-800 {
        background-color: #f1f5f9 !important;
    }
    html:not(.dark) #drawing-app-container:fullscreen .bg-gray-900 {
        background-color: #ffffff !important;
    }
</style>

<script>
    let canvas;
    let currentTool = 'select';
    let undoStack = [];
    let redoStack = [];
    let isDrawing = false;
    let selection;

    // Initialize Canvas
    window.onload = function() {
        initCanvas();
        setupKeyListeners();
        
        // Load saved data if exists
        loadFromLocalStorage();
        
        // Initial state for undo if not loaded from storage
        if(undoStack.length === 0) saveState();
    };

    function initCanvas() {
        const wrapper = document.getElementById('canvas-wrapper');
        const width = wrapper.clientWidth - 40;
        const height = 800;

        canvas = new fabric.Canvas('main-canvas', {
            width: width,
            height: height,
            backgroundColor: '#ffffff',
            isDrawingMode: false,
            fireRightClick: true,
            stopContextMenu: true
        });

        // Event: Object modification/addition
        canvas.on('object:added', () => { if(!isDrawing) saveState(); });
        canvas.on('object:modified', () => saveState());
        canvas.on('path:created', () => saveState());

        // Selection handling
        canvas.on('selection:created', onSelection);
        canvas.on('selection:updated', onSelection);
        canvas.on('selection:cleared', onSelectionCleared);

        // Drawing events for shapes
        let shape, startX, startY;
        
        canvas.on('mouse:down', function(o) {
            if (currentTool === 'select' || canvas.isDrawingMode) return;
            
            isDrawing = true;
            let pointer = canvas.getPointer(o.e);
            startX = pointer.x;
            startY = pointer.y;

            const stroke = document.getElementById('stroke-color').value;
            const fill = document.getElementById('fill-color').value;
            const strokeWidth = parseInt(document.getElementById('stroke-width').value);
            const opacity = parseInt(document.getElementById('opacity').value) / 100;

            switch(currentTool) {
                case 'line':
                    shape = new fabric.Line([startX, startY, startX, startY], {
                        stroke: stroke,
                        strokeWidth: strokeWidth,
                        opacity: opacity,
                        selectable: true,
                    });
                    break;
                case 'arrow':
                    // We'll manage arrows manually on mouse:up/move
                    shape = new fabric.Line([startX, startY, startX, startY], {
                        stroke: stroke,
                        strokeWidth: strokeWidth,
                        opacity: opacity,
                        selectable: true,
                    });
                    break;
                case 'rect':
                    shape = new fabric.Rect({
                        left: startX,
                        top: startY,
                        width: 0,
                        height: 0,
                        fill: fill,
                        stroke: stroke,
                        strokeWidth: strokeWidth,
                        opacity: opacity,
                    });
                    break;
                case 'circle':
                    shape = new fabric.Circle({
                        left: startX,
                        top: startY,
                        radius: 0,
                        fill: fill,
                        stroke: stroke,
                        strokeWidth: strokeWidth,
                        opacity: opacity,
                    });
                    break;
                case 'triangle':
                    shape = new fabric.Triangle({
                        left: startX,
                        top: startY,
                        width: 0,
                        height: 0,
                        fill: fill,
                        stroke: stroke,
                        strokeWidth: strokeWidth,
                        opacity: opacity,
                    });
                    break;
                case 'text':
                    let text = new fabric.IText('Double click to edit', {
                        left: startX,
                        top: startY,
                        fontFamily: document.getElementById('font-family').value,
                        fontSize: 24,
                        fill: stroke,
                        opacity: opacity
                    });
                    canvas.add(text);
                    text.enterEditing();
                    setActiveTool('select');
                    isDrawing = false;
                    return;
            }
            
            if (shape) canvas.add(shape);
        });

        canvas.on('mouse:move', function(o) {
            if (!isDrawing) return;
            let pointer = canvas.getPointer(o.e);

            switch(currentTool) {
                case 'line':
                case 'arrow':
                    shape.set({ x2: pointer.x, y2: pointer.y });
                    break;
                case 'rect':
                case 'triangle':
                    shape.set({
                        width: Math.abs(startX - pointer.x),
                        height: Math.abs(startY - pointer.y),
                        left: startX > pointer.x ? pointer.x : startX,
                        top: startY > pointer.y ? pointer.y : startY
                    });
                    break;
                case 'circle':
                    let radius = Math.sqrt(Math.pow(startX - pointer.x, 2) + Math.pow(startY - pointer.y, 2)) / 2;
                    shape.set({
                        radius: radius,
                        left: startX > pointer.x ? pointer.x : startX,
                        top: startY > pointer.y ? pointer.y : startY
                    });
                    break;
            }
            canvas.renderAll();
        });

        canvas.on('mouse:up', function() {
            if (isDrawing && currentTool === 'arrow') {
                const stroke = document.getElementById('stroke-color').value;
                const strokeWidth = parseInt(document.getElementById('stroke-width').value);
                const opacity = parseInt(document.getElementById('opacity').value) / 100;

                // Create Arrow Head
                let headLength = 15 + strokeWidth;
                let angle = Math.atan2(shape.y2 - shape.y1, shape.x2 - shape.x1);
                
                let head1 = new fabric.Line([shape.x2, shape.y2, shape.x2 - headLength * Math.cos(angle - Math.PI / 6), shape.y2 - headLength * Math.sin(angle - Math.PI / 6)], {
                    stroke: stroke, strokeWidth: strokeWidth, opacity: opacity
                });
                let head2 = new fabric.Line([shape.x2, shape.y2, shape.x2 - headLength * Math.cos(angle + Math.PI / 6), shape.y2 - headLength * Math.sin(angle + Math.PI / 6)], {
                    stroke: stroke, strokeWidth: strokeWidth, opacity: opacity
                });

                let arrow = new fabric.Group([shape, head1, head2], {
                    selectable: true,
                    stroke: stroke,
                    opacity: opacity
                });
                
                canvas.remove(shape);
                canvas.add(arrow);
                canvas.renderAll();
            }
            isDrawing = false;
        });
        
        // Panning with space
        let isPanning = false;
        canvas.on('mouse:down:before', function(opt) {
            if (opt.e.altKey || (opt.e.type === 'mousedown' && opt.e.button === 1) || isSpacePressed) {
                isPanning = true;
                canvas.selection = false;
            }
        });
        canvas.on('mouse:move', opt => {
            if (isPanning) {
                let e = opt.e;
                let vpt = canvas.viewportTransform;
                vpt[4] += e.movementX;
                vpt[5] += e.movementY;
                canvas.requestRenderAll();
            }
        });
        canvas.on('mouse:up', () => {
             isPanning = false;
             canvas.selection = true;
        });

        // Custom Eraser implementation using Fabric logic
        // (Fabric 5+ has a built-in EraserBrush but let's use globalCompositeOperation for cross-version or simplicity)
    }

    function setActiveTool(tool) {
        currentTool = tool;
        
        // Reset modes
        canvas.isDrawingMode = false;
        canvas.selection = (tool === 'select');
        canvas.defaultCursor = tool === 'select' ? 'default' : 'crosshair';

        // Set pencil/eraser brush
        if (tool === 'pencil') {
            canvas.isDrawingMode = true;
            canvas.freeDrawingBrush = new fabric.PencilBrush(canvas);
            updateProperties();
        } else if (tool === 'eraser') {
            canvas.isDrawingMode = true;
            // Simplified eraser: just white pencil for now or real eraser if using latest fabric
            canvas.freeDrawingBrush = new fabric.PencilBrush(canvas);
            canvas.freeDrawingBrush.color = '#ffffff'; 
            canvas.freeDrawingBrush.width = parseInt(document.getElementById('stroke-width').value) * 2;
        }

        // UI Update
        document.querySelectorAll('.tool-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.tool === tool) btn.classList.add('active');
        });
    }

    function onSelection(e) {
        const obj = e.selected[0];
        if (!obj) return;

        // Update UI properties to match object
        if (obj.stroke) document.getElementById('stroke-color').value = obj.stroke;
        if (obj.fill && obj.fill !== 'transparent' && typeof obj.fill === 'string') {
            document.getElementById('fill-color').value = obj.fill;
        }
        if (obj.strokeWidth) document.getElementById('stroke-width').value = obj.strokeWidth;
        if (obj.opacity) document.getElementById('opacity').value = obj.opacity * 100;
        
        if (obj.type === 'i-text') {
            document.getElementById('text-settings').classList.remove('opacity-50', 'pointer-events-none');
            document.getElementById('font-family').value = obj.fontFamily;
        } else {
            document.getElementById('text-settings').classList.add('opacity-50', 'pointer-events-none');
        }
        
        updateDisplayValues();
    }

    function onSelectionCleared() {
        document.getElementById('text-settings').classList.add('opacity-50', 'pointer-events-none');
    }

    function updateProperties() {
        const stroke = document.getElementById('stroke-color').value;
        const fill = document.getElementById('fill-color').value;
        const width = parseInt(document.getElementById('stroke-width').value);
        const opacity = parseInt(document.getElementById('opacity').value) / 100;
        
        updateDisplayValues();

        // If something selected, apply props
        let activeObjects = canvas.getActiveObjects();
        if (activeObjects.length) {
            activeObjects.forEach(obj => {
                if (obj.type === 'i-text') {
                    obj.set({ fill: stroke, opacity: opacity, fontFamily: document.getElementById('font-family').value });
                } else if (obj.type === 'path') {
                    obj.set({ stroke: stroke, opacity: opacity, strokeWidth: width });
                } else {
                    obj.set({ stroke: stroke, fill: fill, strokeWidth: width, opacity: opacity });
                }
            });
            canvas.renderAll();
            saveState();
        }

        // Update brush props
        if (canvas.isDrawingMode && currentTool === 'pencil') {
            canvas.freeDrawingBrush.color = stroke;
            canvas.freeDrawingBrush.width = width;
            canvas.freeDrawingBrush.opacity = opacity;
        } else if (canvas.isDrawingMode && currentTool === 'eraser') {
            canvas.freeDrawingBrush.width = width * 2;
        }
    }

    function updateDisplayValues() {
        document.getElementById('width-val').textContent = document.getElementById('stroke-width').value + 'px';
        document.getElementById('opacity-val').textContent = document.getElementById('opacity').value + '%';
    }

    function setColor(type, color) {
        const input = document.getElementById(type + '-color');
        input.value = color;
        updateProperties();
    }

    function toggleTextStyle(style) {
        let active = canvas.getActiveObject();
        if(!active || active.type !== 'i-text') return;
        
        if(style === 'bold') {
            active.set('fontWeight', active.fontWeight === 'bold' ? 'normal' : 'bold');
        } else {
            active.set('fontStyle', active.fontStyle === 'italic' ? 'normal' : 'italic');
        }
        canvas.renderAll();
        saveState();
    }

    // Canvas Actions
    function clearCanvas() {
        if(confirm('Are you sure you want to clear the entire board?')) {
            canvas.clear();
            canvas.backgroundColor = '#ffffff';
            canvas.renderAll();
            saveState();
        }
    }

    function downloadPNG() {
        const dataURL = canvas.toDataURL({
            format: 'png',
            quality: 1,
            multiplier: 2 // High Res
        });
        const link = document.createElement('a');
        link.download = 'bulktools-drawing.png';
        link.href = dataURL;
        link.click();
    }

    // Undo/Redo & Auto-save System
    function saveState() {
        const jsonData = JSON.stringify(canvas);
        undoStack.push(jsonData);
        redoStack = []; // Clear redo on new action
        updateUndoButtons();

        // Auto-save to localStorage
        const storageData = {
            timestamp: Date.now(),
            canvas: jsonData
        };
        localStorage.setItem('bulktools_drawing_data', JSON.stringify(storageData));
    }

    function loadFromLocalStorage() {
        const saved = localStorage.getItem('bulktools_drawing_data');
        if (!saved) return;

        try {
            const parsed = JSON.parse(saved);
            const now = Date.now();
            const oneDay = 24 * 60 * 60 * 1000;

            if (now - parsed.timestamp < oneDay) {
                canvas.loadFromJSON(parsed.canvas, () => {
                   canvas.renderAll();
                   // Ensure the undo stack starts with this loaded state
                   undoStack = [parsed.canvas];
                   updateUndoButtons();
                });
            } else {
                localStorage.removeItem('bulktools_drawing_data');
            }
        } catch (e) {
            console.error("Failed to load saved drawing", e);
        }
    }

    function undo() {
        if(undoStack.length <= 1) return;
        redoStack.push(undoStack.pop());
        const state = undoStack[undoStack.length - 1];
        canvas.loadFromJSON(state, canvas.renderAll.bind(canvas));
        updateUndoButtons();
    }

    function redo() {
        if(redoStack.length === 0) return;
        const state = redoStack.pop();
        undoStack.push(state);
        canvas.loadFromJSON(state, canvas.renderAll.bind(canvas));
        updateUndoButtons();
    }

    function updateUndoButtons() {
        document.getElementById('undo-btn').disabled = undoStack.length <= 1;
        document.getElementById('redo-btn').disabled = redoStack.length === 0;
    }

    // Zoom Functions
    function zoomIn() { changeZoom(1.1); }
    function zoomOut() { changeZoom(0.9); }
    function changeZoom(factor) {
        let zoom = canvas.getZoom() * factor;
        if (zoom > 20) zoom = 20;
        if (zoom < 0.01) zoom = 0.01;
        canvas.setZoom(zoom);
        document.getElementById('zoom-level').textContent = Math.round(zoom * 100) + '%';
    }

    // Key Handlers
    let isSpacePressed = false;
    function setupKeyListeners() {
        window.addEventListener('keydown', e => {
            if (e.key === ' ' && !canvas.isDrawingMode) { e.preventDefault(); isSpacePressed = true; canvas.defaultCursor = 'grab'; }
            if (e.key === 'Delete' || e.key === 'Backspace') {
                if(!canvas.getActiveObject()?.isEditing) {
                    canvas.remove(...canvas.getActiveObjects());
                    canvas.discardActiveObject().renderAll();
                    saveState();
                }
            }
            if (e.ctrlKey && e.key === 'z') { undo(); e.preventDefault(); }
            if (e.ctrlKey && e.key === 'y') { redo(); e.preventDefault(); }
            
            // Tool Shortcuts
            if(!canvas.getActiveObject()?.isEditing) {
                switch(e.key.toLowerCase()) {
                    case 'v': setActiveTool('select'); break;
                    case 'p': setActiveTool('pencil'); break;
                    case 'e': setActiveTool('eraser'); break;
                    case 'l': setActiveTool('line'); break;
                    case 'r': setActiveTool('rect'); break;
                    case 'c': setActiveTool('circle'); break;
                    case 'x': setActiveTool('text'); break;
                }
            }
        });
        window.addEventListener('keyup', e => {
            if (e.key === ' ') { isSpacePressed = false; canvas.defaultCursor = currentTool === 'select' ? 'default' : 'crosshair'; }
        });
        
        // Mouse Wheel Zoom
        canvas.on('mouse:wheel', function(opt) {
            var delta = opt.e.deltaY;
            var zoom = canvas.getZoom();
            zoom *= 0.999 ** delta;
            if (zoom > 20) zoom = 20;
            if (zoom < 0.01) zoom = 0.01;
            canvas.zoomToPoint({ x: opt.e.offsetX, y: opt.e.offsetY }, zoom);
            opt.e.preventDefault();
            opt.e.stopPropagation();
            document.getElementById('zoom-level').textContent = Math.round(zoom * 100) + '%';
        });
    }

    // Resize Handler
    window.addEventListener('resize', handleResize);
    
    // Explicit Fullscreen Change Listener
    document.addEventListener('fullscreenchange', () => {
        handleResize();
        const doc = window.document;
        if (!doc.fullscreenElement) {
            document.getElementById('fs-icon').setAttribute('data-lucide', 'maximize');
        } else {
            document.getElementById('fs-icon').setAttribute('data-lucide', 'minimize');
        }
        lucide.createIcons();
    });

    function handleResize() {
        if (!canvas) return;
        const wrapper = document.getElementById('canvas-wrapper');
        const container = document.getElementById('drawing-app-container');
        
        if (document.fullscreenElement) {
            canvas.setDimensions({
                width: window.innerWidth,
                height: window.innerHeight
            });
        } else {
            const width = wrapper.clientWidth - 40;
            canvas.setDimensions({
                width: width,
                height: 800
            });
        }
        canvas.renderAll();
    }

    function toggleFullScreen() {
        const docEl = document.getElementById('drawing-app-container');
        if (!document.fullscreenElement) {
            docEl.requestFullscreen();
        } else {
            document.exitFullscreen();
        }
    }

</script>

<?php require_once '../../../includes/footer.php'; ?>
