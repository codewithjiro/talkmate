<?php
session_start(); // Call session_start() only once at the beginning
include('db.php');

// Handle login form submission
if (isset($_POST['loginSubmit'])) {
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    // Query to fetch user details
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error); // Debug: Check if prepare failed
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Store user session data
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $user['name'];

            // Redirect to home page or dashboard
            header("Location: main.php");
            exit();
        } else {
            $loginError = "Invalid credentials. Please try again.";
        }
    } else {
        $loginError = "No user found with this email.";
    }
}

// Handle registration form submission
if (isset($_POST['registerSubmit'])) {
    $name = $_POST['registerName'];
    $email = $_POST['registerEmail'];
    $password = password_hash($_POST['registerPassword'], PASSWORD_DEFAULT); // Hash the password for storage

    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email); // "s" indicates string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email exists, show an error message
        $emailError = "Email is already registered. Please use a different email.";
    } else {
        // Handle file upload for profile picture
        if (isset($_FILES['profilePicture'])) {
            $profilePic = $_FILES['profilePicture'];
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . basename($profilePic['name']);
            
            if (move_uploaded_file($profilePic['tmp_name'], $uploadFile)) {
                // Insert new user into the database
                $sql = "INSERT INTO users (name, email, password, profile_picture) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $name, $email, $password, $uploadFile); // Bind parameters
                $stmt->execute();
                
                // Set success message using session
                $_SESSION['registrationSuccess'] = "You have successfully registered! Please log in.";
                
                // Redirect to login page or home page after successful registration
                header("Location: index.php");  // Adjust the URL accordingly
                exit();  // Stop further execution
            } else {
                $uploadError = "Failed to upload profile picture.";
            }
        }
    }
}

// Show success message (for registration)
if (isset($_SESSION['registrationSuccess'])) { ?>
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl w-11/12 sm:w-3/4 md:w-1/3 max-h-[50vh] h-auto overflow-auto">
            <div class="text-center">
                <i class="fas fa-check-circle text-green-600 text-4xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-800">Registration Successful!</h3>
                <p class="text-gray-600 mt-2"><?php echo $_SESSION['registrationSuccess']; ?></p>
                <button id="closeSuccessModal" class="bg-blue-600 text-white px-6 py-3 rounded-full w-full mt-4 hover:bg-blue-700 transition duration-300">
                    Close
                </button>
            </div>
        </div>
    </div>
    <?php unset($_SESSION['registrationSuccess']); ?> <!-- Clear success message after display -->
<?php }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TalkMate+</title>
    <link
      href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
  </head>

  <!-- Custom Animations -->
  <style>
    @keyframes bounce-horizontal {
      0%,
      100% {
        transform: translateX(0);
      }
      50% {
        transform: translateX(10px);
      }
    }
    @keyframes float {
      0%,
      100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-20px);
      }
    }
    @keyframes float-delay {
      0%,
      100% {
        transform: translateY(-10px);
      }
      50% {
        transform: translateY(10px);
      }
    }
    @keyframes underline {
      0% {
        width: 0;
      }
      100% {
        width: 100%;
      }
    }
    .animate-float {
      animation: float 6s ease-in-out infinite;
    }
    .animate-float-delay {
      animation: float-delay 8s ease-in-out infinite;
    }
    .animate-underline {
      animation: underline 1.5s ease-out forwards;
    }
    .animate-fade-in {
      opacity: 0;
      animation: fadeIn 1s ease-in forwards;
    }
    @keyframes fadeIn {
      to {
        opacity: 1;
      }
    }
  </style>

  <body class="bg-gray-100 font-sans">
    <!-- Navbar -->
    <nav
      class="bg-gradient-to-r from-blue-600 to-purple-600 p-4 shadow-2xl fixed w-full top-0 z-50"
    >
      <div class="container mx-auto flex justify-between items-center">
        <!-- Logo with Modern Design -->
        <a
          href="#"
          class="text-white text-3xl font-bold flex items-center space-x-1 hover:scale-110 transition-all duration-300"
        >
          <span
            class="text-4xl text-blue-200 hover:text-blue-400 transition-colors duration-300"
            >T</span
          >
          <span
            class="text-4xl text-purple-200 hover:text-purple-400 transition-colors duration-300"
            >alk</span
          >
          <span
            class="text-4xl text-blue-200 hover:text-blue-400 transition-colors duration-300"
            >M</span
          >
          <span
            class="text-4xl text-purple-200 hover:text-purple-400 transition-colors duration-300"
            >ate</span
          >
          <span
            class="text-4xl text-blue-200 hover:text-blue-400 transition-colors duration-300"
            >+</span
          >
        </a>

        <!-- Hamburger Menu for Mobile -->
        <button id="menuButton" class="text-white md:hidden focus:outline-none">
          <i
            class="fas fa-bars text-2xl hover:text-blue-200 transition duration-300"
          ></i>
        </button>

        <!-- Nav Links -->
        <ul id="navMenu" class="hidden md:flex space-x-6 items-center">
          <li>
            <a
              href="#home"
              class="text-white hover:text-blue-200 transition duration-300 flex items-center"
            >
              <i class="fas fa-home mr-2"></i>Home
            </a>
          </li>
          <li>
            <a
              href="#about"
              class="text-white hover:text-blue-200 transition duration-300 flex items-center"
            >
              <i class="fas fa-info-circle mr-2"></i>About
            </a>
          </li>
          <li>
            <a
              href="#faqs"
              class="text-white hover:text-blue-200 transition duration-300 flex items-center"
            >
              <i class="fas fa-question-circle mr-2"></i>FAQs
            </a>
          </li>
          <li>
            <a
              href="#contact"
              class="text-white hover:text-blue-200 transition duration-300 flex items-center"
            >
              <i class="fas fa-envelope mr-2"></i>Contact
            </a>
          </li>
          <li>
            <button
              id="loginButton"
              class="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-100 hover:text-blue-700 transition duration-300 flex items-center shadow-lg hover:shadow-xl"
            >
              <i class="fas fa-sign-in-alt mr-2"></i>Login
            </button>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Mobile Menu (Hidden by Default) -->
    <div
      id="mobileMenu"
      class="md:hidden fixed top-16 w-full bg-gradient-to-r from-blue-600 to-purple-600 shadow-lg z-40 hidden"
    >
      <ul class="flex flex-col space-y-4 p-4">
        <li>
          <a
            href="#home"
            class="text-white hover:text-blue-200 transition duration-300 flex items-center"
          >
            <i class="fas fa-home mr-2"></i>Home
          </a>
        </li>
        <li>
          <a
            href="#about"
            class="text-white hover:text-blue-200 transition duration-300 flex items-center"
          >
            <i class="fas fa-info-circle mr-2"></i>About
          </a>
        </li>
        <li>
          <a
            href="#faqs"
            class="text-white hover:text-blue-200 transition duration-300 flex items-center"
          >
            <i class="fas fa-question-circle mr-2"></i>FAQs
          </a>
        </li>
        <li>
          <a
            href="#contact"
            class="text-white hover:text-blue-200 transition duration-300 flex items-center"
          >
            <i class="fas fa-envelope mr-2"></i>Contact
          </a>
        </li>
        <li>
          <button
            id="mobileLoginButton"
            class="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-100 hover:text-blue-700 transition duration-300 flex items-center w-full justify-center shadow-lg hover:shadow-xl"
          >
            <i class="fas fa-sign-in-alt mr-2"></i>Login
          </button>
        </li>
      </ul>
    </div>

<!-- Modal HTML Code for Login and Registration -->
<div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white p-6 md:p-8 rounded-2xl w-11/12 sm:w-3/4 md:w-1/3 max-h-[70vh] h-auto overflow-auto relative shadow-2xl">
        <!-- Close Button -->
        <button id="closeModal" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800">
            <i class="fas fa-times text-2xl"></i>
        </button>

        <!-- Welcome Header -->
        <div class="text-center mb-6">
            <i class="fas fa-comments text-5xl text-blue-600 mb-4"></i>
            <h2 class="text-2xl font-bold text-gray-800">Welcome to TalkMate+</h2>
            <p class="text-gray-600 mt-2">Your gateway to better communication.</p>
        </div>

        <!-- Login Form -->
        <form id="loginForm" method="POST" class="mb-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-sign-in-alt text-blue-600 mr-2"></i>Login
            </h3>
            <div class="mb-4">
                <label for="loginEmail" class="block text-gray-700 mb-2">Email</label>
                <input type="email" id="loginEmail" name="loginEmail" placeholder="Enter your email"
                    class="w-full p-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" />
            </div>
            <div class="mb-4">
                <label for="loginPassword" class="block text-gray-700 mb-2">Password</label>
                <input type="password" id="loginPassword" name="loginPassword" placeholder="Enter your password"
                    class="w-full p-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" />
            </div>
            <button type="submit" name="loginSubmit"
                class="bg-blue-600 text-white px-6 py-3 rounded-full w-full hover:bg-blue-700 transition duration-300 flex items-center justify-center">
                <i class="fas fa-sign-in-alt mr-2"></i>Login
            </button>
            <?php if (isset($loginError)) { echo "<p class='text-red-500 mt-2'>$loginError</p>"; } ?>
        </form>

        <!-- Register Form (Initially Hidden) -->
        <form id="registerForm" class="hidden mb-4 max-h-[50vh] overflow-auto" method="POST" enctype="multipart/form-data">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-user-plus text-blue-600 mr-2"></i>Register
            </h3>

            <!-- Name Input -->
            <div class="mb-3">
                <label for="registerName" class="block text-gray-700 mb-2">Name</label>
                <input type="text" id="registerName" name="registerName" placeholder="Enter your name"
                    class="w-full p-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" />
            </div>

            <!-- Email Input -->
            <div class="mb-3">
                <label for="registerEmail" class="block text-gray-700 mb-2">Email</label>
                <input type="email" id="registerEmail" name="registerEmail" placeholder="Enter your email"
                    class="w-full p-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" />
            </div>

            <!-- Password Input -->
            <div class="mb-3">
                <label for="registerPassword" class="block text-gray-700 mb-2">Password</label>
                <input type="password" id="registerPassword" name="registerPassword" placeholder="Enter your password"
                    class="w-full p-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200" />
            </div>

            <!-- Profile Picture Upload -->
            <div class="mb-3">
                <label for="profilePicture" class="block text-gray-700 mb-2">Profile Picture</label>
                <input type="file" id="profilePicture" name="profilePicture" accept="image/*"
                    class="w-full p-2 border border-gray-300 rounded-lg" />
                <div class="mt-2 text-center">
                    <img id="previewImage" class="w-24 h-24 rounded-full mx-auto hidden" />
                </div>
            </div>

            <!-- Register Button -->
            <button type="submit" name="registerSubmit"
                class="bg-blue-600 text-white px-6 py-3 rounded-full w-full hover:bg-blue-700 transition duration-300 flex items-center justify-center">
                <i class="fas fa-user-plus mr-2"></i>Register
            </button>
            <?php if (isset($uploadError)) { echo "<p class='text-red-500 mt-2'>$uploadError</p>"; } ?>
        </form>

        <!-- Toggle between Login and Register -->
        <p class="text-center text-gray-600 mt-4">
            <span id="toggleRegister" class="text-blue-600 cursor-pointer hover:underline">
                <i class="fas fa-user-plus mr-1"></i>Create an account
            </span>
            <span id="toggleLogin" class="text-blue-600 cursor-pointer hover:underline hidden">
                <i class="fas fa-sign-in-alt mr-1"></i>Already have an account? Login
            </span>
        </p>
    </div>
</div>

<script>
    // Close success modal
    document.getElementById('closeSuccessModal').addEventListener('click', function() {
        document.getElementById('successModal').style.display = 'none';
    });
</script>

    <!-- Home Section -->
    <section
      id="home"
      class="relative h-screen flex items-center justify-center text-white overflow-hidden mt-16 bg-gradient-to-r from-blue-600 to-purple-600"
    >
      <!-- Semi-Purple Overlay -->
      <div class="absolute inset-0 bg-purple-800 opacity-50 z-0"></div>

      <!-- Animated Background Shapes -->
      <div class="absolute inset-0 z-10">
        <div
          class="shape-1 absolute w-64 h-64 bg-purple-400 rounded-full opacity-20 top-0 left-0 transform -translate-x-1/2 -translate-y-1/2 animate-float"
        ></div>
        <div
          class="shape-2 absolute w-48 h-48 bg-blue-400 rounded-full opacity-20 bottom-0 right-0 transform translate-x-1/2 translate-y-1/2 animate-float-delay"
        ></div>
      </div>

      <!-- Content -->
      <div class="container mx-auto text-center relative z-20 animate-fade-in">
        <!-- Modern Title -->
        <h1
          class="text-5xl md:text-7xl font-extrabold mb-6 font-poppins bg-clip-text text-transparent bg-gradient-to-r from-white to-blue-100"
        >
          Welcome to <span class="text-purple-200">TalkMate+</span>
        </h1>

        <!-- Subtitle with a modern twist -->
        <p
          class="text-xl md:text-2xl mb-10 font-light max-w-2xl mx-auto leading-relaxed"
        >
          Empowering
          <span class="font-semibold text-purple-200"
            >non-verbal individuals</span
          >
          and <span class="font-semibold text-blue-200">children</span> with
          emotion-based communication tools.
        </p>

        <!-- Call-to-Action Button -->
        <a
          href="#about"
          class="inline-flex items-center justify-center bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-blue-100 transition duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl"
        >
          Learn More
          <svg
            class="w-5 h-5 ml-2 animate-bounce-horizontal"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M19 14l-7 7m0 0l-7-7m7 7V3"
            ></path>
          </svg>
        </a>
      </div>
    </section>

    <script>
      const navbar = document.querySelector("nav");
      const homeSection = document.getElementById("home");

      // Set margin-top of home section to navbar height
      homeSection.style.marginTop = `${navbar.offsetHeight}px`;
    </script>

    <!-- Modern Features Section -->
    <section
      class="py-20 bg-gradient-to-b from-blue-50 to-indigo-100 relative overflow-hidden"
    >
      <!-- Animated Background Shapes -->
      <div class="absolute inset-0 z-0">
        <div
          class="shape-animation-1 absolute w-64 h-64 bg-gradient-to-r from-blue-200 to-indigo-200 rounded-full opacity-20 animate-float"
        ></div>
        <div
          class="shape-animation-2 absolute w-48 h-48 bg-gradient-to-r from-purple-200 to-pink-200 rounded-full opacity-20 animate-float-delay"
        ></div>
        <div
          class="shape-animation-3 absolute w-32 h-32 bg-gradient-to-r from-green-200 to-teal-200 rounded-full opacity-20 animate-float"
        ></div>
      </div>

      <div class="container mx-auto px-4 text-center relative z-10">
        <h2
          class="text-5xl font-bold text-gray-900 mb-20 relative inline-block"
        >
          Our <span class="text-indigo-500">Features</span>
          <span
            class="absolute bottom-[-8px] left-1/2 transform -translate-x-1/2 w-24 h-1.5 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full animate-underline"
          ></span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Emotion-Based Buttons -->
          <div
            class="p-8 bg-gradient-to-r from-blue-100 to-indigo-100 backdrop-blur-sm rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 animate-fade-in"
          >
            <div
              class="inline-flex items-center justify-center w-16 h-16 mb-6 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full"
            >
              <i class="fas fa-smile text-3xl text-white"></i>
            </div>
            <h3 class="text-2xl font-semibold text-gray-900 mb-4">
              Emotion-Based Buttons
            </h3>
            <p class="text-gray-600 leading-relaxed">
              Express emotions easily with intuitive and interactive buttons
              designed for seamless communication.
            </p>
          </div>
          <!-- Text-to-Speech -->
          <div
            class="p-8 bg-gradient-to-r from-purple-100 to-pink-100 backdrop-blur-sm rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 animate-fade-in"
          >
            <div
              class="inline-flex items-center justify-center w-16 h-16 mb-6 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full"
            >
              <i class="fas fa-volume-up text-3xl text-white"></i>
            </div>
            <h3 class="text-2xl font-semibold text-gray-900 mb-4">
              Text-to-Speech
            </h3>
            <p class="text-gray-600 leading-relaxed">
              Convert text into natural-sounding speech to enhance accessibility
              and communication.
            </p>
          </div>
          <!-- Personalized Card Game -->
          <div
            class="p-8 bg-gradient-to-r from-green-100 to-teal-100 backdrop-blur-sm rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 animate-fade-in"
          >
            <div
              class="inline-flex items-center justify-center w-16 h-16 mb-6 bg-gradient-to-r from-green-500 to-teal-500 rounded-full"
            >
              <i class="fas fa-gamepad text-3xl text-white"></i>
            </div>
            <h3 class="text-2xl font-semibold text-gray-900 mb-4">
              Personalized Card Game
            </h3>
            <p class="text-gray-600 leading-relaxed">
              Engage in a fun, educational card game tailored to your
              preferences and learning style.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Modern About Section with Sleek Gradient Background and Animated Shapes -->
    <section
      id="about"
      class="relative py-24 bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 overflow-hidden"
    >
      <!-- Floating Shapes with Subtle Animation -->
      <div
        class="absolute top-20 left-20 w-20 h-20 bg-blue-200 rounded-full opacity-20 animate-float"
      ></div>
      <div
        class="absolute bottom-20 right-20 w-28 h-28 bg-purple-200 rounded-full opacity-20 animate-float-delay"
      ></div>
      <div
        class="absolute top-1/2 left-1/3 w-16 h-16 bg-pink-200 rounded-full opacity-20 animate-spin-slow"
      ></div>
      <div
        class="absolute top-1/4 right-1/4 w-12 h-12 bg-indigo-200 rounded-full opacity-20 animate-float"
      ></div>

      <div class="container mx-auto px-4 text-center relative z-10">
        <h2 class="text-5xl font-bold text-gray-900 mb-8 relative inline-block">
          About
          <span
            class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-500"
            >TalkMate+</span
          >
          <span
            class="absolute bottom-[-8px] left-1/2 transform -translate-x-1/2 w-32 h-1.5 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full animate-underline"
          ></span>
        </h2>

        <p
          class="text-gray-700 text-lg max-w-2xl mx-auto leading-relaxed animate-fade-in"
        >
          TalkMate+ is designed to help non-verbal individuals and children
          communicate effectively using
          <span class="font-semibold text-blue-500">emotion-based buttons</span
          >,
          <span class="font-semibold text-green-500"
            >text-to-speech technology</span
          >, and
          <span class="font-semibold text-pink-500"
            >personalized card games</span
          >. Our mission is to make communication accessible, intuitive, and fun
          for everyone.
        </p>
        <div class="mt-12 flex justify-center space-x-6">
          <a
            href="#features"
            class="px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
          >
            Explore Features
          </a>
          <a
            href="#contact"
            class="px-8 py-3 bg-transparent border-2 border-blue-500 text-blue-500 font-semibold rounded-lg hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-500 hover:text-white hover:border-transparent transition-all duration-300 transform hover:scale-105"
          >
            Get Started
          </a>
        </div>
      </div>
    </section>

    <!-- FAQs Section -->
    <section id="faqs" class="py-20 relative overflow-hidden">
      <!-- Modern Gradient Background -->
      <div
        class="absolute inset-0 bg-gradient-to-br from-blue-100 via-purple-50 to-pink-50 transform skew-y-[-3deg] origin-top-left -z-10"
      ></div>

      <!-- Wave Shape Background -->
      <div
        class="absolute bottom-0 left-0 w-full overflow-hidden transform rotate-180 -z-20"
      >
        <svg
          class="w-full h-24"
          viewBox="0 0 1200 120"
          preserveAspectRatio="none"
        >
          <path
            d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
            class="fill-current text-blue-100 opacity-70"
          ></path>
        </svg>
      </div>

      <!-- Container -->
      <div class="container mx-auto text-center px-4">
        <h2
          class="text-3xl font-bold text-gray-800 mb-12 relative inline-block"
        >
          Frequently <span class="text-indigo-500">Asked Questions</span>
          <span
            class="absolute bottom-[-8px] left-1/2 transform -translate-x-1/2 w-24 h-1.5 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full animate-underline"
          ></span>
        </h2>

        <div class="text-left max-w-2xl mx-auto relative z-10">
          <!-- FAQ Item 1 -->
          <div
            class="faq-item mb-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300"
          >
            <div
              class="flex justify-between items-center cursor-pointer p-6"
              onclick="toggleFAQ(1)"
            >
              <h3 class="text-xl font-semibold text-gray-800">
                What is TalkMate+?
              </h3>
              <span
                class="text-gray-600 transition-transform duration-300 transform"
                id="icon-1"
              >
                <!-- Font Awesome Icon -->
                <i class="fas fa-chevron-down"></i>
              </span>
            </div>
            <p class="text-gray-600 mt-2 px-6 pb-6 hidden" id="answer-1">
              TalkMate+ is a communication tool designed for non-verbal
              individuals and children, featuring emotion-based buttons,
              text-to-speech, and card games.
            </p>
          </div>

          <!-- FAQ Item 2 -->
          <div
            class="faq-item mb-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300"
          >
            <div
              class="flex justify-between items-center cursor-pointer p-6"
              onclick="toggleFAQ(2)"
            >
              <h3 class="text-xl font-semibold text-gray-800">
                How does it work?
              </h3>
              <span
                class="text-gray-600 transition-transform duration-300 transform"
                id="icon-2"
              >
                <!-- Font Awesome Icon -->
                <i class="fas fa-chevron-down"></i>
              </span>
            </div>
            <p class="text-gray-600 mt-2 px-6 pb-6 hidden" id="answer-2">
              Users can select emotion-based buttons to express themselves, use
              text-to-speech to communicate, and play personalized card games
              for engagement.
            </p>
          </div>

          <!-- FAQ Item 3 -->
          <div
            class="faq-item mb-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300"
          >
            <div
              class="flex justify-between items-center cursor-pointer p-6"
              onclick="toggleFAQ(3)"
            >
              <h3 class="text-xl font-semibold text-gray-800">
                Is TalkMate+ mobile-friendly?
              </h3>
              <span
                class="text-gray-600 transition-transform duration-300 transform"
                id="icon-3"
              >
                <!-- Font Awesome Icon -->
                <i class="fas fa-chevron-down"></i>
              </span>
            </div>
            <p class="text-gray-600 mt-2 px-6 pb-6 hidden" id="answer-3">
              Yes, TalkMate+ is fully responsive and optimized for mobile
              devices, ensuring a seamless experience across all screen sizes.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section
      id="contact"
      class="py-20 bg-gradient-to-r from-pink-50 via-purple-50 to-indigo-50"
    >
      <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">
          <h2
            class="text-5xl font-bold text-gray-900 mb-16 relative inline-block"
          >
            Contact <span class="text-indigo-500">Us</span>
            <span
              class="absolute bottom-[-8px] left-1/2 transform -translate-x-1/2 w-24 h-1.5 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full animate-underline"
            ></span>
          </h2>

          <p class="text-gray-600 text-lg leading-relaxed max-w-3xl mx-auto">
            Have any questions or need assistance? We're here to help. Reach out
            to us using the form below, and we'll respond promptly.
          </p>
        </div>

        <!-- Form and Map Container -->
        <div
          class="max-w-6xl mx-auto bg-white rounded-xl shadow-2xl overflow-hidden"
        >
          <div class="grid grid-cols-1 md:grid-cols-2">
            <!-- Contact Form -->
            <div class="p-10 bg-gradient-to-br from-pink-50 to-purple-50">
              <h3 class="text-3xl font-semibold text-gray-800 mb-6">
                We'd Love to Hear From You!
              </h3>
              <p class="text-gray-600 mb-8">
                Fill out the form below and let us know how we can assist you.
                We're always here to help!
              </p>
              <form>
                <div class="mb-6">
                  <label for="name" class="text-gray-700 font-medium block mb-2"
                    >Your Name</label
                  >
                  <input
                    id="name"
                    type="text"
                    placeholder="Enter your full name"
                    class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-300 shadow-sm hover:shadow-md"
                  />
                </div>
                <div class="mb-6">
                  <label
                    for="email"
                    class="text-gray-700 font-medium block mb-2"
                    >Your Email</label
                  >
                  <input
                    id="email"
                    type="email"
                    placeholder="Enter your email address"
                    class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-300 shadow-sm hover:shadow-md"
                  />
                </div>
                <div class="mb-8">
                  <label
                    for="message"
                    class="text-gray-700 font-medium block mb-2"
                    >Your Message</label
                  >
                  <textarea
                    id="message"
                    placeholder="Tell us more..."
                    class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-300 shadow-sm hover:shadow-md"
                    rows="5"
                  ></textarea>
                </div>
                <button
                  type="submit"
                  class="w-full bg-gradient-to-r from-blue-600 to-teal-600 text-white px-6 py-4 rounded-lg hover:from-blue-700 hover:to-teal-700 transition duration-300 transform hover:scale-105 shadow-lg"
                >
                  Send Message
                </button>
              </form>
            </div>
            <!-- Google Maps Integration -->
            <div class="p-10 bg-gradient-to-br from-teal-50 to-blue-50">
              <h3 class="text-3xl font-semibold text-gray-800 mb-6">
                Our Location
              </h3>
              <p class="text-gray-600 mb-8">
                Find us using the map below. Feel free to visit us, or reach out
                for more details.
              </p>
              <div
                class="relative w-full overflow-hidden rounded-lg shadow-lg"
                style="padding-top: 56.25%"
              >
                <iframe
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3852.1676703958556!2d120.76672407444254!3d15.094084985452879!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396fba8a871ef9d%3A0xcf10e5f6f2a968cc!2sHoly%20Cross%20College%20-%20Pampanga!5e0!3m2!1sen!2sph!4v1738123307123!5m2!1sen!2sph"
                  class="absolute top-0 left-0 w-full h-full border-0"
                  allowfullscreen=""
                  loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer
      class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-12"
    >
      <div class="container mx-auto px-6 text-center">
        <!-- Back to Top Button -->
        <button
          onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
          class="bg-white text-blue-600 hover:bg-blue-100 rounded-full p-3 mb-8 shadow-lg transition-all duration-300 transform hover:scale-110"
        >
          <i class="fas fa-arrow-up"></i>
        </button>

        <!-- Footer Content -->
        <p class="text-lg font-light mb-4">
          &copy; 2025 TalkMate+. All rights reserved.
        </p>
        <div class="flex justify-center space-x-6">
          <a
            href="#"
            class="text-white hover:text-blue-200 transition-all duration-300 transform hover:scale-125"
          >
            <i class="fab fa-facebook text-2xl"></i>
          </a>
          <a
            href="#"
            class="text-white hover:text-blue-200 transition-all duration-300 transform hover:scale-125"
          >
            <i class="fab fa-twitter text-2xl"></i>
          </a>
          <a
            href="#"
            class="text-white hover:text-blue-200 transition-all duration-300 transform hover:scale-125"
          >
            <i class="fab fa-instagram text-2xl"></i>
          </a>
          <a
            href="#"
            class="text-white hover:text-blue-200 transition-all duration-300 transform hover:scale-125"
          >
            <i class="fab fa-linkedin text-2xl"></i>
          </a>
        </div>

        <!-- Additional Links -->
        <div class="mt-8 space-x-4 text-sm">
          <a href="#" class="text-white hover:text-blue-200">Privacy Policy</a>
          <a href="#" class="text-white hover:text-blue-200"
            >Terms of Service</a
          >
          <a href="#" class="text-white hover:text-blue-200">Contact Us</a>
        </div>
      </div>
    </footer>

    <!-- JavaScript for Mobile Menu -->
    <script>
      const menuButton = document.getElementById("menuButton");
      const navMenu = document.getElementById("navMenu");

      menuButton.addEventListener("click", () => {
        navMenu.classList.toggle("hidden");
      });
    </script>

    <!-- JavaScript for Modal -->
    <script>
      const loginButton = document.getElementById("loginButton");
      const loginModal = document.getElementById("loginModal");
      const closeModal = document.getElementById("closeModal");
      const toggleRegister = document.getElementById("toggleRegister");
      const toggleLogin = document.getElementById("toggleLogin");
      const loginForm = document.getElementById("loginForm");
      const registerForm = document.getElementById("registerForm");

      // Open Modal
      loginButton.addEventListener("click", () => {
        loginModal.classList.remove("hidden");
        loginModal.classList.add("flex");
      });

      // Close Modal
      closeModal.addEventListener("click", () => {
        loginModal.classList.add("hidden");
        loginModal.classList.remove("flex");
      });

      // Toggle between Login and Register
      toggleRegister.addEventListener("click", () => {
        loginForm.classList.add("hidden");
        registerForm.classList.remove("hidden");
        toggleRegister.classList.add("hidden");
        toggleLogin.classList.remove("hidden");
      });

      toggleLogin.addEventListener("click", () => {
        registerForm.classList.add("hidden");
        loginForm.classList.remove("hidden");
        toggleLogin.classList.add("hidden");
        toggleRegister.classList.remove("hidden");
      });
      function toggleFAQ(id) {
        const answer = document.getElementById(`answer-${id}`);
        const icon = document.getElementById(`icon-${id}`);
        answer.classList.toggle("hidden");
        icon.classList.toggle("rotate-180");
      }
    </script>
  </body>
</html>