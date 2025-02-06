<!-- TTS Modal -->
<div id="ttsModal" class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center hidden z-50 transition-opacity duration-300">
  <div class="animate-scale-in bg-gradient-to-br from-pink-100 to-pink-50 p-8 rounded-3xl shadow-2xl max-w-xl w-full mx-4 border border-pink-200 relative transform transition-all duration-300 translate-y-4">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-700 to-pink-900">
        Text-to-Speech
      </h2>
      <button 
        onclick="closeModal()" 
        class="text-gray-900 hover:text-gray-700 transition-colors duration-200 p-3 hover:bg-gray-200 rounded-full focus:outline-none transform hover:scale-105"
        aria-label="Close"
      >
        <i class="fas fa-times text-xl"></i>
      </button>
    </div>

    <!-- Input Box -->
    <textarea 
      id="ttsText" 
      class="w-full p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-300 transition-all duration-300 text-lg text-gray-900 placeholder-gray-500 resize-none shadow-sm focus:shadow-lg"
      rows="4"
      placeholder="Enter text to speak..."
    ></textarea>

    <!-- Voice Selection -->
    <div class="mt-6">
      <label for="voiceSelect" class="block text-gray-900 font-medium mb-2">Choose a Voice:</label>
      <select 
        id="voiceSelect" 
        class="w-full p-3 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-300 text-gray-900 shadow-sm transition-all duration-300 transform hover:scale-105"
      >
        <!-- Options will be populated dynamically -->
      </select>
    </div>

    <!-- Actions -->
    <div class="mt-8 flex justify-end space-x-4">
      <button 
        onclick="closeModal()" 
        class="px-6 py-2 rounded-xl font-medium text-gray-900 hover:text-gray-700 hover:bg-pink-200 transition-all duration-200 focus:outline-none transform hover:scale-105"
      >
        Cancel
      </button>
      <button 
        onclick="speakText()" 
        class="bg-gradient-to-r from-pink-400 to-pink-500 px-6 py-3 rounded-xl text-white font-medium hover:from-pink-500 hover:to-pink-600 transition-all duration-200 flex items-center space-x-2 shadow-lg hover:shadow-pink-300/50 focus:outline-none transform hover:scale-105"
        aria-label="Speak text"
      >
        <i class="fas fa-volume-up text-lg"></i>
        <span>Speak</span>
      </button>
    </div>
  </div>
</div>

<script>
  // Modal Animation Handling
  function openModal() {
    const modal = document.getElementById("ttsModal");
    modal.classList.remove("hidden");
    setTimeout(() => {
      modal.classList.remove("opacity-0");
      modal.querySelector('.transform').classList.remove("translate-y-4");
    }, 10);
    populateVoiceList(); // Populate voice options
  }

  function closeModal() {
    const modal = document.getElementById("ttsModal");
    modal.classList.add("opacity-0");
    modal.querySelector('.transform').classList.add("translate-y-4");
    setTimeout(() => modal.classList.add("hidden"), 300);
  }

  // Load Voices and Populate Dropdown
  let voicesReady = false;

  function loadVoices() {
    return new Promise(resolve => {
      if (speechSynthesis.getVoices().length) {
        resolve();
        return;
      }
      speechSynthesis.onvoiceschanged = resolve;
    });
  }

  async function populateVoiceList() {
    await loadVoices();
    const voices = speechSynthesis.getVoices();
    const voiceSelect = document.getElementById("voiceSelect");
    // Clear existing options before populating
    voiceSelect.innerHTML = '';
    voices.forEach(voice => {
      const option = document.createElement('option');
      option.textContent = `${voice.name} (${voice.lang})`;
      option.setAttribute('data-lang', voice.lang);
      option.setAttribute('data-name', voice.name);
      voiceSelect.appendChild(option);
    });
  }

  // TTS Functionality with Voice Selection
  async function speakText() {
    const text = document.getElementById("ttsText").value.trim();
    if (!text) {
      document.getElementById("ttsText").placeholder = "Please enter some text...";
      document.getElementById("ttsText").classList.add('animate-shake');
      setTimeout(() => document.getElementById("ttsText").classList.remove('animate-shake'), 500);
      return;
    }
    if (!voicesReady) {
      await loadVoices();
      voicesReady = true;
    }
    const utterance = new SpeechSynthesisUtterance(text);
    const voices = speechSynthesis.getVoices();
    const selectedVoiceOption = document.getElementById("voiceSelect").selectedOptions[0];
    const selectedVoiceName = selectedVoiceOption ? selectedVoiceOption.getAttribute('data-name') : null;
    // Find the selected voice or use the default
    const selectedVoice = voices.find(voice => voice.name === selectedVoiceName) || voices[0];
    utterance.voice = selectedVoice;
    utterance.lang = selectedVoice.lang || 'en-US';
    utterance.rate = 0.95;
    utterance.pitch = 1.1;
    utterance.volume = 1;
    speechSynthesis.speak(utterance);
  }

  // Close modal on ESC key press
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !document.getElementById("ttsModal").classList.contains("hidden")) {
      closeModal();
    }
  });
</script>

<style>
  @keyframes scale-in {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
  }
  @keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(5px); }
    75% { transform: translateX(-5px); }
  }
  .animate-scale-in {
    animation: scale-in 0.3s ease-out;
  }
  .animate-shake {
    animation: shake 0.3s ease-in-out;
  }
  /* Optional: Futuristic font is kept as Roboto for a modern look */
  body {
    font-family: 'Roboto', sans-serif;
  }
</style>
