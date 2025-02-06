<!-- Card Game Modal -->
<div id="cardGameModal" class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center hidden z-50 transition-opacity duration-300">
  <div class="animate-scale-in bg-gradient-to-br from-pink-100 to-pink-50 p-8 rounded-3xl shadow-2xl max-w-2xl w-full mx-4 border border-pink-200 relative transform transition-all duration-300 translate-y-4">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-700 to-pink-900">
        Create a Sentence
      </h2>
      <button 
        onclick="closeCardGameModal()" 
        class="text-gray-900 hover:text-gray-700 transition-colors duration-200 p-3 hover:bg-gray-200 rounded-full focus:outline-none transform hover:scale-105"
        aria-label="Close"
      >
        <i class="fas fa-times text-xl"></i>
      </button>
    </div>

    <!-- Cards to select words -->
    <div id="cardContainer" class="grid grid-cols-4 gap-4 mb-6 overflow-hidden">
      <!-- Word Cards (Dynamic content, added with JavaScript) -->
      <!-- Example cards (you will have 50 in total) -->
     <div onclick="addWordToSentence('I')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-user text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">I</span>
</div>
<div onclick="addWordToSentence('You')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-user-friends text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">You</span>
</div>
<div onclick="addWordToSentence('Eat')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-utensils text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Eat</span>
</div>
<div onclick="addWordToSentence('Drink')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-mug-hot text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Drink</span>
</div>
<div onclick="addWordToSentence('Sleep')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-bed text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Sleep</span>
</div>
<div onclick="addWordToSentence('Help')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-hands-helping text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Help</span>
</div>
<div onclick="addWordToSentence('More')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-plus-circle text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">More</span>
</div>
<div onclick="addWordToSentence('Stop')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-stop text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Stop</span>
</div>
<div onclick="addWordToSentence('Yes')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-thumbs-up text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Yes</span>
</div>
<div onclick="addWordToSentence('No')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-thumbs-down text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">No</span>
</div>
<div onclick="addWordToSentence('Please')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-hand-paper text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Please</span>
</div>
<div onclick="addWordToSentence('Thank you')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-handshake text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Thank you</span>
</div>
<div onclick="addWordToSentence('Sorry')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-sad-tear text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Sorry</span>
</div>
<div onclick="addWordToSentence('Go')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-arrow-right text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Go</span>
</div>
<div onclick="addWordToSentence('Wait')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-hourglass-start text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Wait</span>
</div>
<div onclick="addWordToSentence('Friend')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-user-friends text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Friend</span>
</div>
<div onclick="addWordToSentence('Family')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-users text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Family</span>
</div>
<div onclick="addWordToSentence('Love')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-heart text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Love</span>
</div>
<div onclick="addWordToSentence('Play')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-gamepad text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Play</span>
</div>
<div onclick="addWordToSentence('Music')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-music text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Music</span>
</div>
<div onclick="addWordToSentence('Bathroom')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-restroom text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Bathroom</span>
</div>
<div onclick="addWordToSentence('Pain')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-heart-broken text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Pain</span>
</div>
<div onclick="addWordToSentence('Happy')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-smile text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Happy</span>
</div>
<div onclick="addWordToSentence('Sad')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-sad-cry text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Sad</span>
</div>
<div onclick="addWordToSentence('Yes please')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-check-circle text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Yes please</span>
</div>
<div onclick="addWordToSentence('No thanks')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-times-circle text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">No thanks</span>
</div>
<div onclick="addWordToSentence('Water')" class="word-card p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-pink-200 shadow-md hover:shadow-xl transition-transform transform hover:scale-105 cursor-pointer flex items-center justify-center space-x-3">
    <i class="fas fa-tint text-xl text-pink-700"></i>
    <span class="text-gray-900 font-bold text-lg">Water</span>
</div>

      <!-- Add other word cards in the same pattern -->
      <!-- ... -->
    </div>

    <!-- Navigation Controls at the Bottom -->
    <div class="flex justify-center gap-8 mt-6">
      <button onclick="showPreviousCards()" class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-lg p-3 rounded-full focus:outline-none shadow-lg transform transition-all duration-200 hover:bg-indigo-600">
        <i class="fas fa-chevron-left"></i> 
      </button>
      <button onclick="showNextCards()" class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-lg p-3 rounded-full focus:outline-none shadow-lg transform transition-all duration-200 hover:bg-indigo-600">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>

    <!-- Selected Words -->
    <div class="mb-6">
      <p class="font-semibold text-gray-700">Selected Sentence:</p>
      <div id="sentenceDisplay" class="flex gap-2 items-center bg-gray-100 p-4 rounded-xl text-gray-800">
        <!-- Dynamically populated sentence will appear here -->
      </div>
    </div>

    <!-- Speaker Icon -->
    <div class="flex justify-between items-center space-x-4">
      <button onclick="speakSentence()" class="p-3 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-xl focus:outline-none">
        <i class="fas fa-volume-up text-2xl"></i>
      </button>
      <button onclick="clearSentence()" class="px-8 py-3 rounded-xl text-white bg-gradient-to-r from-green-500 to-teal-600 font-medium shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-xl focus:outline-none">
        Clear Sentence
      </button>
    </div>

  </div>
</div>

<script>
let selectedWords = [];
let currentCardIndex = 0; // Initial index of the first set of cards
const totalCards = 50; // Total cards to display
const cardsPerView = 12; // 4 vertical * 3 horizontal = 12 cards per view

// Function to open the Card Game Modal
function openCardGameModal() {
  const modal = document.getElementById("cardGameModal");
  modal.classList.remove("hidden");
  setTimeout(() => {
    modal.classList.remove("opacity-0");
    modal.querySelector('.transform').classList.remove("translate-y-4");
  }, 10);
}

// Function to close the Card Game Modal
function closeCardGameModal() {
  const modal = document.getElementById("cardGameModal");
  modal.classList.add("opacity-0");
  modal.querySelector('.transform').classList.add("translate-y-4");
  setTimeout(() => modal.classList.add("hidden"), 300);
}

// Add word to sentence
function addWordToSentence(word) {
  if (!selectedWords.includes(word)) {
    selectedWords.push(word);
    updateSentenceDisplay();
  }
}

// Update sentence display
function updateSentenceDisplay() {
  const sentenceDisplay = document.getElementById("sentenceDisplay");
  sentenceDisplay.innerHTML = selectedWords.join(' ');
}

// Speak the sentence
function speakSentence() {
  const sentence = selectedWords.join(' ');
  if (sentence) {
    const speech = new SpeechSynthesisUtterance(sentence);
    window.speechSynthesis.speak(speech);
  } else {
    alert("Please select words to form a sentence.");
  }
}

// Clear sentence
function clearSentence() {
  selectedWords = [];
  updateSentenceDisplay();
}

// Show Next Cards
function showNextCards() {
  if (currentCardIndex < Math.floor(totalCards / cardsPerView) - 1) { // Navigate to the next set of cards
    currentCardIndex++;
    updateCardVisibility();
  }
}

// Show Previous Cards
function showPreviousCards() {
  if (currentCardIndex > 0) {
    currentCardIndex--;
    updateCardVisibility();
  }
}

// Update visibility of cards based on the current card index
function updateCardVisibility() {
  const cards = document.querySelectorAll('.word-card');
  cards.forEach((card, index) => {
    const cardIndex = Math.floor(index / cardsPerView); // Determine the set of cards (group of 12 cards per view)
    card.classList.toggle("hidden", cardIndex !== currentCardIndex); // Toggle visibility
  });
}

// Initial setup to display the first set of cards
updateCardVisibility();

</script>