<?php
session_start();

if (!isset($_SESSION["username"])) {
  header("Location: index.php");
  exit;
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="navigation.css?v=<?php echo time(); ?>">
  </head>
  <body>
    


  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <a class="navbar-brand" href="#"><i class="fa-solid fa-code"></i> <span class="text-cyan">WEB</span> <span class="text-red">BEGINNER</span></a>
  <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <script>
  document.addEventListener("DOMContentLoaded", function() {
    var toggler = document.querySelector(".custom-toggler");
    toggler.addEventListener("click", function() {
      this.classList.toggle("navbar-toggler-x");
    });
  });
</script>


  <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
  <ul class="navbar-nav slide-in" style="margin-right: 1in;">
      <!-- Add the button element -->
        <button id="play-pause-button" onclick="handleButtonClick()">
          <i id="play-pause-icon" class="fas fa-play"></i>
        </button>

      <!-- Add the audio element without autoplay attribute -->
        <audio id="background-music" loop>
          <source src="Im a Rider.mp3" type="audio/mpeg">
        </audio>

<script>
  // Get the audio element
  var backgroundMusic = document.getElementById("background-music");
  // Get the button element
  var playPauseButton = document.getElementById("play-pause-button");
  // Get the play-pause icon element
  var playPauseIcon = document.getElementById("play-pause-icon");

  // Function to handle the play/pause state from other pages
  function handlePlayPauseState() {
    var isPlaying = sessionStorage.getItem("isPlaying") === "true";
    if (isPlaying) {
      backgroundMusic.play();
      playPauseIcon.classList.remove("fa-play");
      playPauseIcon.classList.add("fa-pause");
    } else {
      backgroundMusic.pause();
      playPauseIcon.classList.remove("fa-pause");
      playPauseIcon.classList.add("fa-play");
    }
  }

  // Function to handle button clicks
  function handleButtonClick() {
    if (backgroundMusic.paused) {
      backgroundMusic.play();
      sessionStorage.setItem("isPlaying", "true");
      playPauseIcon.classList.remove("fa-play");
      playPauseIcon.classList.add("fa-pause");
    } else {
      backgroundMusic.pause();
      sessionStorage.setItem("isPlaying", "false");
      playPauseIcon.classList.remove("fa-pause");
      playPauseIcon.classList.add("fa-play");
    }
  }

  // Save the current time in sessionStorage when navigating away
  window.addEventListener("beforeunload", function() {
    sessionStorage.setItem("musicPosition", backgroundMusic.currentTime);
  });

  // Check if the playback position is stored in sessionStorage
  if (sessionStorage.getItem("musicPosition")) {
    // Restore the playback position from sessionStorage
    backgroundMusic.currentTime = parseFloat(sessionStorage.getItem("musicPosition"));
  }

  // Call the function to handle initial play/pause state
  handlePlayPauseState();
</script>


      <li class="nav-item">
        <a class="nav-link" href="navigation.php">HOME</a>
      </li>
    <li class="nav-item">
      <a class="nav-link" href="about.php" style="margin-right: 5px;">ABOUT</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="home.php" style="margin-right: 5px;">DASHBOARD PANEL</a>
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="logout.php">LOGOUT</a>
    </li>
  </ul>
</div>

</nav>

<div id="image-slider" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#image-slider" data-slide-to="0" class="active"></li>
    <li data-target="#image-slider" data-slide-to="1"></li>
    <li data-target="#image-slider" data-slide-to="2"></li>
    <li data-target="#image-slider" data-slide-to="3"></li>
    <li data-target="#image-slider" data-slide-to="4"></li>
  </ul>

  <!-- Slides -->
  <div class="carousel-inner" style="height:100%;">
    <div class="carousel-item active">
      <img src="image8.jpeg" alt="First slide" style="object-fit: cover; width: 100%; height: 100vh;">
    </div>
    <div class="carousel-item">
      <img src="image9.jpeg" alt="Second slide" style="object-fit: cover; width: 100%; height: 100vh;">
    </div>
    <div class="carousel-item">
      <img src="image10.jpeg" alt="Third slide" style="object-fit: cover; width: 100%; height: 100vh;">
    </div>
    <div class="carousel-item">
      <img src="image12.jpeg" alt="Fourth slide" style="object-fit: cover; width: 100%; height: 100vh;">
    </div>
    <div class="carousel-item">
      <img src="image14.jpeg" alt="Fourth slide" style="object-fit: cover; width: 100%; height: 100vh;">
    </div>
  </div>

        <!-- Left and right controls -->
          <a class="carousel-control-prev" href="#image-slider" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </a>
          <a class="carousel-control-next" href="#image-slider" data-slide="next">
            <span class="carousel-control-next-icon"></span>
          </a>
  </div>  
          <script>
            $(document).ready(function(){
              $('.carousel').carousel({
                interval: 3000, //changes the speed to every 3 seconds
              });
            });
            
            $(document).ready(function(){
              $('.dropdown-toggle').dropdown();
            });
            
            $(document).ready(function(){
              $('.navbar-toggler').click(function(){
                $('.navbar-toggler-icon').toggleClass('animate-icon');
              });
            });
          </script>
            <footer>
              <div class="footer-content">
                <span>© 2023 Mark Anthony - All Rights Reserved</span>
                <hr class="line"><br>
                <ul class="socials">
                  <a target="_blank" href="https://www.facebook.com/markanthony.aguirre.501"><i class="fab fa-facebook-square"></i></a>
                  <a href="#"><i class="fab fa-instagram-square"></i></a>
                  <a href="#"><i class="fab fa-twitter-square"></i></a>
                  <a href="#"><i class="fab fa-tiktok"></i></a>
                </ul>
              </div>
            </footer>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  </body>
</html>
