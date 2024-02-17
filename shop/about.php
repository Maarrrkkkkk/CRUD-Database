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
    <title>About Us</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="about.css?v=<?php echo time(); ?>">
  </head>
  
  <!-- Add the audio element without autoplay attribute -->
<audio id="background-music" loop>
  <source src="Im a Rider.mp3" type="audio/mpeg">
</audio>

<script>
  // Get the audio element
  var backgroundMusic = document.getElementById("background-music");

  // Function to handle the play/pause state from other pages
  function handlePlayPauseState() {
    var isPlaying = sessionStorage.getItem("isPlaying") === "true";
    if (isPlaying) {
      backgroundMusic.play();
    } else {
      backgroundMusic.pause();
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
  <body class="body-bg">
    <h1 class="fade-in">About<span>Us!</span></h1>
    <p class="fade-in">Welcome to Car Recordings! Our mission is to provide car enthusiasts with a platform to share and discover unique car recordings from around the world.</p><br><br>
    <div class="button-container">
      <a href="navigation.php">
        <button type="button">Back to Menu</button>
      </a>
    </div>
  </body>
</html>


