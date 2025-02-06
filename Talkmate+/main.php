<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}

$user_email = $_SESSION['user_email'];
$sql = "SELECT name, profile_picture FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_name = $row['name'];
    $profile_picture = $row['profile_picture'] ? $row['profile_picture'] : 'default_profile_picture.jpg';
} else {
    echo "User not found!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jiro's App</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@1.14.0/dist/full.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <style>
      @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
      }
      .fade-in { animation: fadeIn 0.5s ease-out; }
      /* Optional: add a subtle neon glow effect to futuristic elements */
      .neon-glow {
        box-shadow: 0 0 10px rgba(219,39,119,0.6), 0 0 20px rgba(219,39,119,0.4);
      }
    </style>
  </head>
  <body class="bg-gradient-to-br from-purple-50 to-blue-50">
    <div class="min-h-screen flex flex-col">
      <header class="bg-gradient-to-r from-purple-600 to-blue-500 p-6 shadow-lg relative">
        <div class="text-center">
          <div class="space-y-5 fade-in">
            <div class="flex flex-col md:flex-row items-center justify-center md:space-x-6 space-y-4 md:space-y-0">
              <div class="relative w-24 h-24 rounded-full group">
                <div class="absolute -inset-1 rounded-full bg-gradient-to-r from-purple-500 via-pink-400 to-blue-400 animate-spin-slow blur-sm opacity-70 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative w-24 h-24 rounded-full bg-white/20 backdrop-blur-sm border-2 border-white/30 shadow-xl overflow-hidden">
                  <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300">
                </div>
              </div>
              <h1 class="text-5xl md:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-200 via-pink-200 to-blue-200 tracking-tighter">
                Hello, <?php echo $user_name; ?>!
              </h1>
            </div>
          </div>
          <p class="text-center text-xl md:text-2xl font-medium text-white/90 animate-float">
            <?php echo date("F j, Y"); ?>
          </p>
        </div>
        <div class="mt-6 flex flex-col items-center fade-in">
          <label for="voice-input" class="sr-only">Voice input</label>
          <div class="flex items-center w-full max-w-2xl px-4">
            <input type="text" id="voice-input" placeholder="Wanna say something?" class="w-full bg-white/90 text-gray-900 placeholder-gray-500 px-5 py-4 rounded-l-2xl text-lg shadow-lg focus:outline-none focus:ring-4 focus:ring-purple-500 transition-all duration-200" />
            <button id="speak-button" type="button" class="bg-purple-700 px-6 py-4 rounded-r-2xl text-white shadow-lg hover:bg-purple-800 transition-all transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-purple-500 focus:ring-offset-2" aria-label="Read text aloud">
              <i class="fas fa-volume-up text-2xl"></i>
            </button>
          </div>
        </div>
        <script>
          document.getElementById("speak-button").addEventListener("click", () => {
            const text = document.getElementById("voice-input").value;
            if (text.trim() !== "") {
              const speech = new SpeechSynthesisUtterance(text);
              speech.lang = "en-US";
              speech.rate = 1;
              speech.pitch = 1;
              window.speechSynthesis.speak(speech);
            }
          });
        </script>
        <div class="absolute top-6 right-6 md:top-4 md:right-4">
          <a href="logout.php" class="bg-red-600 text-white p-3 rounded-full hover:bg-red-700 transition-colors flex items-center justify-center shadow-md">
            <i class="fas fa-sign-out-alt text-2xl md:text-xl"></i>
          </a>
        </div>
      </header>
      <main class="flex-1 p-6 overflow-y-auto">
        <div class="flex flex-wrap justify-center gap-6 my-8 fade-in">
          <!-- TTS Card -->
          <div onclick="openModal()" class="cursor-pointer bg-gradient-to-br from-purple-100 via-pink-100 to-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-transform transform hover:scale-105 w-64 flex-shrink-0">
            <div class="flex flex-col items-center space-y-4">
              <i class="fas fa-volume-up text-purple-600 text-5xl"></i>
              <h2 class="font-semibold text-gray-700 text-center text-xl">Text-to-Speech (TTS)</h2>
            </div>
          </div>
          <?php include('tts.php'); ?>

   <!-- Modern Card Game Card -->
<div onclick="openCardGameModal()" class="cursor-pointer bg-gradient-to-br from-purple-100 via-pink-100 to-white p-8 rounded-3xl shadow-lg hover:shadow-xl transition-transform transform hover:scale-105 w-64 flex-shrink-0">
  <div class="flex flex-col items-center space-y-4">
    <i class="fas fa-gamepad text-purple-600 text-6xl"></i>
    <h2 class="font-bold text-gray-700 text-2xl">Card Game</h2>
  </div>
</div>
<?php include('cardgame.php'); ?>


          <!-- Favorites Card -->
          <div class="bg-gradient-to-br from-purple-100 via-pink-100 to-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-transform transform hover:scale-105 w-64 flex-shrink-0">
            <div class="flex flex-col items-center space-y-4">
              <i class="fas fa-star text-yellow-500 text-5xl"></i>
              <h2 class="font-semibold text-gray-700 text-center text-xl">Favorites</h2>
            </div>
          </div>
          <!-- Personalized Card -->
          <div class="bg-gradient-to-br from-purple-100 via-pink-100 to-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-transform transform hover:scale-105 w-64 flex-shrink-0">
            <div class="flex flex-col items-center space-y-4">
              <i class="fas fa-user-cog text-green-600 text-5xl"></i>
              <h2 class="font-semibold text-gray-700 text-center text-xl">Personalized</h2>
            </div>
          </div>
          <!-- Emotion-Based Buttons Card -->
          <div class="bg-white p-8 rounded-2xl shadow-lg mt-8 fade-in">
            <h2 class="font-semibold text-gray-700 text-center text-3xl mb-8">Emotion-Based Buttons</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              <!-- Conversation Card -->
              <div class="bg-gray-100 p-6 rounded-2xl hover:shadow-md transition-shadow">
                <h3 class="font-semibold text-gray-600 text-center text-xl mb-6">Conversation</h3>
                <div class="grid grid-cols-2 gap-4">
                  <button class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-transform transform hover:scale-105 flex items-center justify-center shadow-md">
                    <i class="fas fa-hands-helping mr-2"></i>Help
                  </button>
                  <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-transform transform hover:scale-105 flex items-center justify-center shadow-md">
                    <i class="fas fa-handshake mr-2"></i>Hello
                  </button>
                  <button class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-transform transform hover:scale-105 flex items-center justify-center shadow-md">
                    <i class="fas fa-sad-tear mr-2"></i>Sorry
                  </button>
                  <button class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-transform transform hover:scale-105 flex items-center justify-center shadow-md">
                    <i class="fas fa-comment-dots mr-2"></i>Chat
                  </button>
                </div>
              </div>
              <!-- Feelings Card -->
              <div class="bg-gray-100 p-6 rounded-2xl hover:shadow-md transition-shadow">
                <h3 class="font-semibold text-gray-600 text-center text-xl mb-6">Feelings</h3>
                <div class="grid grid-cols-2 gap-4">
                  <button class="bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600 transition-transform transform hover:scale-105 flex items-center justify-center shadow-md">
                    <i class="fas fa-smile-beam mr-2"></i>Happy
                  </button>
                  <button class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-transform transform hover:scale-105 flex items-center justify-center shadow-md">
                    <i class="fas fa-surprise mr-2"></i>Surprise
                  </button>
                  <button class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105 flex items-center justify-center shadow-md">
                    <i class="fas fa-sad-cry mr-2"></i>Sadness
                  </button>
                  <button class="bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700 transition-transform transform hover:scale-105 flex items-center justify-center shadow-md">
                    <i class="fas fa-heart mr-2"></i>Love
                  </button>
                </div>
              </div>
              <!-- Action Card -->
              <div class="bg-gray-100 p-6 rounded-2xl hover:shadow-md transition-shadow">
                <h3 class="font-semibold text-gray-600 text-center text-xl mb-6">Actions</h3>
                <div class="grid grid-cols-2 gap-4">
                  <button class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-transform transform hover:scale-105 flex items-center justify-center shadow-md">
                    <i class="fas fa-play mr-2"></i>Play
                  </button>
                  <button class="bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600 transition-transform transform hover:scale-105 flex items-center justify-center shadow-md">
                    <i class="fas fa-pause mr-2"></i>Pause
                  </button>
                  <button class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-transform transform hover:scale-105 flex items-center justify-center shadow-md">
                    <i class="fas fa-check mr-2"></i>Accept
                  </button>
                  <button class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition-transform transform hover:scale-105 flex items-center justify-center shadow-md">
                    <i class="fas fa-times mr-2"></i>Decline
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>
