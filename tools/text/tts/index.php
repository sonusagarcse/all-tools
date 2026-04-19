<?php
require_once '../../../includes/header.php';
?>

<div class="max-w-4xl mx-auto px-4 py-6 md:py-12">
    <!-- Tool Header -->
    <div class="text-center mb-8 md:mb-12">
        <div class="inline-flex items-center justify-center w-12 h-12 md:w-16 md:h-16 rounded-2xl bg-violet-600/10 text-violet-600 mb-4">
            <i data-lucide="mic" class="w-6 h-6 md:w-8 md:h-8"></i>
        </div>
        <h1 class="text-2xl md:text-4xl font-heading font-bold mb-3 px-2">Text to Speech Generator</h1>
        <p class="text-sm md:text-base text-slate-600 dark:text-gray-400 max-w-2xl mx-auto px-4">
            Convert your written content into natural-sounding voice audio. Perfect for creators, developers, and accessibility testing.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Input Area -->
        <div class="lg:col-span-12">
            <div class="glass rounded-[2rem] p-6 md:p-8 shadow-xl border border-slate-200 dark:border-gray-800">
                <textarea id="tts-input" placeholder="Type or paste your text here..." class="w-full h-48 md:h-64 px-6 py-5 rounded-3xl border border-slate-100 dark:border-gray-800 bg-white dark:bg-gray-900 text-lg text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-violet-500 outline-none transition-all resize-none mb-8"></textarea>
                
                <!-- Controls Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Voice Selector -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Select Voice</label>
                        <select id="voice-select" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-950 text-sm focus:ring-2 focus:ring-violet-500 outline-none cursor-pointer"></select>
                    </div>

                    <!-- Speed Control -->
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Rate (Speed)</label>
                            <span class="text-xs font-bold text-violet-600" id="rate-val">1.0x</span>
                        </div>
                        <input type="range" id="rate" min="0.5" max="2" value="1" step="0.1" class="w-full h-1.5 bg-slate-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-violet-600">
                    </div>

                    <!-- Pitch Control -->
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pitch</label>
                            <span class="text-xs font-bold text-violet-600" id="pitch-val">1.0</span>
                        </div>
                        <input type="range" id="pitch" min="0" max="2" value="1" step="0.1" class="w-full h-1.5 bg-slate-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-violet-600">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col md:flex-row gap-4">
                    <button id="speak-btn" onclick="speakText()" class="flex-1 py-4 bg-violet-600 hover:bg-violet-700 text-white font-black text-lg rounded-2xl transition-all active:scale-[0.98] shadow-xl shadow-violet-500/20 flex items-center justify-center gap-3">
                        <i data-lucide="play-circle" class="w-6 h-6"></i>
                        Speak Text
                    </button>
                    <button onclick="downloadAudio()" class="flex-1 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-lg rounded-2xl transition-all active:scale-[0.98] shadow-xl shadow-emerald-500/20 flex items-center justify-center gap-3">
                        <i data-lucide="download" class="w-6 h-6"></i>
                        Download MP3
                    </button>
                    <button onclick="stopSpeech()" class="px-8 py-4 bg-slate-100 dark:bg-gray-800 text-slate-600 dark:text-slate-300 font-bold rounded-2xl hover:bg-slate-200 transition-all flex items-center justify-center gap-2">
                        <i data-lucide="square" class="w-5 h-5"></i> Stop
                    </button>
                    <button onclick="clearText()" class="px-8 py-4 border-2 border-slate-100 dark:border-gray-800 text-slate-400 font-bold rounded-2xl hover:bg-slate-50 dark:hover:bg-gray-800/50 transition-all">
                        Clear
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- SEO Section -->
    <div class="mt-16 prose prose-slate dark:prose-invert max-w-none">
        <div class="p-8 rounded-[2rem] bg-violet-50/50 dark:bg-violet-900/10 border border-violet-100 dark:border-violet-900/30">
            <?php echo $current_tool['seo_text']; ?>
        </div>
    </div>
</div>

<script>
const synth = window.speechSynthesis;
const voiceSelect = document.querySelector('#voice-select');
const rateInput = document.querySelector('#rate');
const pitchInput = document.querySelector('#pitch');
const rateVal = document.querySelector('#rate-val');
const pitchVal = document.querySelector('#pitch-val');

let voices = [];

function populateVoiceList() {
    voices = synth.getVoices();
    voiceSelect.innerHTML = '';
    voices.forEach((voice, i) => {
        const option = document.createElement('option');
        option.textContent = `${voice.name} (${voice.lang})`;
        if (voice.default) option.textContent += ' -- DEFAULT';
        option.setAttribute('data-lang', voice.lang);
        option.setAttribute('data-name', voice.name);
        voiceSelect.appendChild(option);
    });
}

populateVoiceList();
if (speechSynthesis.onvoiceschanged !== undefined) {
    speechSynthesis.onvoiceschanged = populateVoiceList;
}

rateInput.addEventListener('input', () => rateVal.innerText = rateInput.value + 'x');
pitchInput.addEventListener('input', () => pitchVal.innerText = pitchInput.value);

function speakText() {
    if (synth.speaking) {
        console.error('speechSynthesis.speaking');
        return;
    }
    const text = document.getElementById('tts-input').value;
    if (text !== '') {
        const utterThis = new SpeechSynthesisUtterance(text);
        const selectedOption = voiceSelect.selectedOptions[0].getAttribute('data-name');
        voices.forEach((voice) => {
            if (voice.name === selectedOption) {
                utterThis.voice = voice;
            }
        });
        utterThis.rate = rateInput.value;
        utterThis.pitch = pitchInput.value;
        synth.speak(utterThis);
    }
}

function stopSpeech() {
    synth.cancel();
}

function downloadAudio() {
    const text = document.getElementById('tts-input').value.trim();
    if (!text) return alert("Please enter some text to download.");

    if (text.length > 200) {
        if (!confirm("Note: Public high-quality TTS downloads are optimized for snippets up to 200 characters. Longer text might be truncated. Do you want to continue?")) {
            return;
        }
    }

    const voiceOption = voiceSelect.selectedOptions[0];
    const lang = voiceOption.getAttribute('data-lang').split('-')[0]; // Extract 'en' from 'en-US'
    
    // Redirect to download proxy
    window.location.href = `download.php?text=${encodeURIComponent(text)}&lang=${lang}`;
}

function clearText() {
    document.getElementById('tts-input').value = '';
    stopSpeech();
}
</script>

<?php require_once '../../../includes/footer.php'; ?>
