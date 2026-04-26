<?php
require_once '../../../includes/header.php';
$tool = get_current_tool_info($_SERVER['REQUEST_URI']);
?>

<!-- html2pdf library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<!-- Tool Header -->
<section class="pt-12 pb-8 bg-slate-50 dark:bg-gray-950 transition-colors no-print">
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
                <button onclick="downloadPDF()" class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-bold shadow-lg shadow-indigo-600/20 hover:scale-105 active:scale-95 transition-all flex items-center gap-2">
                    <i data-lucide="download" class="w-5 h-5"></i>
                    <span>Download PDF</span>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Tool Area -->
<section class="pb-24 bg-slate-50 dark:bg-gray-950 transition-colors no-print">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            
            <!-- Editor Sidebar -->
            <div class="space-y-8 h-[800px] overflow-y-auto pr-4 scrollbar-hide">
                
                <!-- Personal Info -->
                <div class="bg-white dark:bg-gray-900 rounded-3xl p-8 border border-slate-200 dark:border-gray-800 shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-indigo-500 mb-6">Personal Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Full Name</label>
                            <input type="text" data-field="name" placeholder="John Doe" class="resume-input w-full px-4 py-3 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-indigo-500 rounded-xl outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Email Address</label>
                            <input type="email" data-field="email" placeholder="john@example.com" class="resume-input w-full px-4 py-3 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-indigo-500 rounded-xl outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Phone Number</label>
                            <input type="text" data-field="phone" placeholder="+91 98765 43210" class="resume-input w-full px-4 py-3 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-indigo-500 rounded-xl outline-none transition-all">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Location</label>
                            <input type="text" data-field="location" placeholder="Mumbai, India" class="resume-input w-full px-4 py-3 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-indigo-500 rounded-xl outline-none transition-all">
                        </div>
                    </div>
                </div>

                <!-- Professional Summary -->
                <div class="bg-white dark:bg-gray-900 rounded-3xl p-8 border border-slate-200 dark:border-gray-800 shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-indigo-500 mb-6">Professional Summary</h3>
                    <textarea data-field="summary" rows="4" placeholder="Briefly describe your career goals and achievements..." class="resume-input w-full px-4 py-3 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-indigo-500 rounded-xl outline-none transition-all resize-none"></textarea>
                </div>

                <!-- Experience -->
                <div class="bg-white dark:bg-gray-900 rounded-3xl p-8 border border-slate-200 dark:border-gray-800 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xs font-black uppercase tracking-widest text-indigo-500">Work Experience</h3>
                        <button onclick="addItem('experience')" class="text-[10px] font-black uppercase bg-indigo-500/10 text-indigo-500 px-3 py-1 rounded-full hover:bg-indigo-500 hover:text-white transition-all">+ Add</button>
                    </div>
                    <div id="experience-inputs" class="space-y-6">
                        <!-- Experience Items -->
                    </div>
                </div>

                <!-- Education -->
                <div class="bg-white dark:bg-gray-900 rounded-3xl p-8 border border-slate-200 dark:border-gray-800 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xs font-black uppercase tracking-widest text-indigo-500">Education</h3>
                        <button onclick="addItem('education')" class="text-[10px] font-black uppercase bg-indigo-500/10 text-indigo-500 px-3 py-1 rounded-full hover:bg-indigo-500 hover:text-white transition-all">+ Add</button>
                    </div>
                    <div id="education-inputs" class="space-y-6">
                        <!-- Education Items -->
                    </div>
                </div>

                <!-- Skills -->
                <div class="bg-white dark:bg-gray-900 rounded-3xl p-8 border border-slate-200 dark:border-gray-800 shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-indigo-500 mb-6">Skills (Comma Separated)</h3>
                    <input type="text" id="skills-input" placeholder="JavaScript, Python, Project Management, SEO" class="w-full px-4 py-3 bg-slate-50 dark:bg-gray-800 border-2 border-transparent focus:border-indigo-500 rounded-xl outline-none transition-all">
                </div>

            </div>

            <!-- Preview Sidebar -->
            <div class="sticky top-12">
                <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden min-h-[800px] border border-slate-200 flex flex-col p-12 text-slate-900" id="resume-preview">
                    
                    <!-- Preview Header -->
                    <div class="border-b-2 border-slate-900 pb-8 mb-8">
                        <h2 id="prev-name" class="text-4xl font-black uppercase tracking-tighter mb-2">Your Name</h2>
                        <div class="flex flex-wrap gap-x-6 gap-y-1 text-sm font-bold text-slate-500 uppercase tracking-widest">
                            <span id="prev-email">email@example.com</span>
                            <span id="prev-phone">+91 00000 00000</span>
                            <span id="prev-location">City, Country</span>
                        </div>
                    </div>

                    <!-- Preview Summary -->
                    <div class="mb-8">
                        <h4 class="text-xs font-black uppercase tracking-widest bg-slate-900 dark:bg-slate-100 dark:text-slate-900 text-white px-4 py-1.5 inline-block mb-4 transition-colors">Summary</h4>
                        <p id="prev-summary" class="text-sm leading-relaxed text-slate-700">Highly motivated professional seeking new opportunities...</p>
                    </div>

                    <!-- Preview Experience -->
                    <div class="mb-8">
                        <h4 class="text-xs font-black uppercase tracking-widest bg-slate-900 dark:bg-slate-100 dark:text-slate-900 text-white px-4 py-1.5 inline-block mb-4 transition-colors">Experience</h4>
                        <div id="prev-experience" class="space-y-6">
                            <!-- Items -->
                        </div>
                    </div>

                    <!-- Preview Education -->
                    <div class="mb-8">
                        <h4 class="text-xs font-black uppercase tracking-widest bg-slate-900 dark:bg-slate-100 dark:text-slate-900 text-white px-4 py-1.5 inline-block mb-4 transition-colors">Education</h4>
                        <div id="prev-education" class="space-y-4">
                            <!-- Items -->
                        </div>
                    </div>

                    <!-- Preview Skills -->
                    <div>
                        <h4 class="text-xs font-black uppercase tracking-widest bg-slate-900 dark:bg-slate-100 dark:text-slate-900 text-white px-4 py-1.5 inline-block mb-4 transition-colors">Skills</h4>
                        <div id="prev-skills" class="flex flex-wrap gap-2">
                            <!-- Items -->
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- SEO Content -->
        <div class="mt-20 prose prose-slate dark:prose-invert max-w-none">
            <div class="p-8 md:p-12 rounded-[3rem] bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
                <div class="relative z-10">
                    <?php echo $tool['seo_text']; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @media print {
        .no-print, header, footer { display: none !important; }
        body { background: white !important; margin: 0; padding: 0; }
        #resume-preview {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            min-height: auto !important;
            width: 100% !important;
            display: block !important;
        }
        .max-w-7xl { max-width: none !important; }
        .lg\:grid-cols-2 { grid-template-columns: 1fr !important; }
    }
    
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
    const inputs = document.querySelectorAll('.resume-input');
    const skillsInput = document.getElementById('skills-input');
    
    const fieldsMap = {
        name: 'prev-name',
        email: 'prev-email',
        phone: 'prev-phone',
        location: 'prev-location',
        summary: 'prev-summary'
    };

    function updateFields() {
        inputs.forEach(input => {
            const field = input.dataset.field;
            const prevId = fieldsMap[field];
            if (prevId) {
                document.getElementById(prevId).textContent = input.value || input.placeholder;
            }
        });
    }

    inputs.forEach(input => input.addEventListener('input', updateFields));

    skillsInput.addEventListener('input', () => {
        const skills = skillsInput.value.split(',').map(s => s.trim()).filter(s => s);
        const prevSkills = document.getElementById('prev-skills');
        prevSkills.innerHTML = skills.map(s => `<span class="bg-slate-200 dark:bg-slate-800 px-3 py-1 rounded-md text-xs font-bold text-slate-900 dark:text-slate-100">${s}</span>`).join('');
    });

    const collections = {
        experience: [],
        education: []
    };

    function addItem(type, existingData = null) {
        const id = existingData ? existingData.id : Date.now();
        const item = existingData || { id };
        
        if (!existingData) {
            collections[type].push(item);
        }
        
        const container = document.getElementById(`${type}-inputs`);
        const itemHtml = `
            <div id="item-${id}" class="p-4 bg-slate-50 dark:bg-gray-800 rounded-2xl relative border border-transparent hover:border-indigo-500/20 transition-all">
                <button onclick="removeItem('${type}', ${id})" class="absolute top-2 right-2 text-rose-500 hover:scale-110 transition-transform"><i data-lucide="x-circle" class="w-4 h-4"></i></button>
                <div class="grid grid-cols-2 gap-3">
                    <input type="text" placeholder="${type === 'experience' ? 'Job Title' : 'Degree/Course'}" value="${item.title || ''}" oninput="updateItem('${type}', ${id}, 'title', this.value)" class="col-span-2 px-3 py-2 rounded-lg border dark:bg-gray-900 dark:border-gray-700 outline-none text-sm font-bold">
                    <input type="text" placeholder="${type === 'experience' ? 'Company' : 'Institution'}" value="${item.sub || ''}" oninput="updateItem('${type}', ${id}, 'sub', this.value)" class="px-3 py-2 rounded-lg border dark:bg-gray-900 dark:border-gray-700 outline-none text-xs">
                    <input type="text" placeholder="Dates (e.g. 2021 - Present)" value="${item.date || ''}" oninput="updateItem('${type}', ${id}, 'date', this.value)" class="px-3 py-2 rounded-lg border dark:bg-gray-900 dark:border-gray-700 outline-none text-xs">
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', itemHtml);
        lucide.createIcons();
        if (!existingData) saveToStorage();
    }

    function removeItem(type, id) {
        collections[type] = collections[type].filter(i => i.id !== id);
        document.getElementById(`item-${id}`).remove();
        renderPreview(type);
        saveToStorage();
    }

    function updateItem(type, id, field, val) {
        const item = collections[type].find(i => i.id === id);
        if (item) {
            item[field] = val;
            renderPreview(type);
            saveToStorage();
        }
    }

    function renderPreview(type) {
        const prev = document.getElementById(`prev-${type}`);
        prev.innerHTML = collections[type].map(item => `
            <div>
                <div class="flex justify-between items-start mb-1">
                    <h5 class="font-black text-sm uppercase">${item.title || 'Untitled'}</h5>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">${item.date || ''}</span>
                </div>
                <p class="text-xs font-bold text-indigo-600 uppercase tracking-widest">${item.sub || ''}</p>
            </div>
        `).join('');
    }

    function downloadPDF() {
        const element = document.getElementById('resume-preview');
        const name = document.querySelector('[data-field="name"]').value || 'Resume';
        
        // Prepare options
        const opt = {
            margin:       0,
            filename:     `${name.replace(/\s+/g, '_')}_Resume.pdf`,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { 
                scale: 2,
                useCORS: true,
                letterRendering: true,
                backgroundColor: '#ffffff'
            },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };

        // Add a temporary class to fix padding/styles for capture if needed
        element.style.borderRadius = '0';
        element.style.boxShadow = 'none';
        element.style.border = 'none';

        html2pdf().set(opt).from(element).save().then(() => {
            // Restore styles
            element.style.borderRadius = '2.5rem';
            element.style.boxShadow = '';
            element.style.border = '';
        });
    }

    // Storage Logic
    const STORAGE_KEY = 'bulktools_resume_data';
    const EXPIRY_TIME = 24 * 60 * 60 * 1000; // 24 hours

    function saveToStorage() {
        const data = {
            fields: {},
            experience: collections.experience,
            education: collections.education,
            skills: skillsInput.value,
            timestamp: Date.now()
        };
        
        inputs.forEach(input => {
            data.fields[input.dataset.field] = input.value;
        });
        
        localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
    }

    function loadFromStorage() {
        const raw = localStorage.getItem(STORAGE_KEY);
        if (!raw) return false;
        
        const data = JSON.parse(raw);
        if (Date.now() - data.timestamp > EXPIRY_TIME) {
            localStorage.removeItem(STORAGE_KEY);
            return false;
        }

        // Load fields
        inputs.forEach(input => {
            if (data.fields[input.dataset.field]) {
                input.value = data.fields[input.dataset.field];
            }
        });

        // Load collections
        collections.experience = data.experience || [];
        collections.education = data.education || [];
        
        // Render editors
        document.getElementById('experience-inputs').innerHTML = '';
        document.getElementById('education-inputs').innerHTML = '';
        collections.experience.forEach(item => addItem('experience', item));
        collections.education.forEach(item => addItem('education', item));

        // Load skills
        skillsInput.value = data.skills || '';
        
        // Sync everything
        updateFields();
        renderPreview('experience');
        renderPreview('education');
        skillsInput.dispatchEvent(new Event('input'));
        
        return true;
    }

    // Auto-save triggers
    inputs.forEach(input => input.addEventListener('input', saveToStorage));
    skillsInput.addEventListener('input', saveToStorage);

    // Initialize
    window.addEventListener('DOMContentLoaded', () => {
        if (!loadFromStorage()) {
            addItem('experience');
            addItem('education');
        }
    });
</script>

<?php require_once '../../../includes/footer.php'; ?>
