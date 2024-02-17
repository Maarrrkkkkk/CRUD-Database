<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

// Set database credentials
$db_host = 'localhost';
$db_user = 'root';
$db_pass = ''; // Use a password if it's set for the root user
$db_name = 'myshop';

// Connect to database
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve order record to edit
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $sql = "SELECT orders.order_id, customers.customer_name, customers.customer_email, products.product_name, products.product_price 
            FROM orders 
            INNER JOIN customers ON orders.customer_id = customers.customer_id 
            INNER JOIN products ON orders.product_id = products.product_id
            WHERE orders.order_id = $order_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
} else {
    // If no order ID provided, redirect back to home.php
    header('Location: home.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    // Validate email
    if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format!";
    }

    // Validate product price
    if (!is_numeric($product_price)) {
        $error_message = "Product price must be a number!";
    }

    // Check if there are any errors
    if (isset($error_message)) {
        // Display error message
        echo $error_message;
    } else {
        // Retrieve customer ID and product ID
        $sql = "SELECT customer_id, product_id FROM orders WHERE order_id = $order_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $customer_id = $row['customer_id'];
        $product_id = $row['product_id'];
        
        // Update customer record
        $sql = "UPDATE customers SET customer_name='$customer_name', customer_email='$customer_email' WHERE customer_id=$customer_id";
        mysqli_query($conn, $sql);

        // Update product record
        $sql = "UPDATE products SET product_name='$product_name', product_price=$product_price WHERE product_id=$product_id";
        mysqli_query($conn, $sql);

        // Function to log an action in the audit trail
        function logAction($registerId, $action) {
          global $conn;
          $action = mysqli_real_escape_string($conn, $action);
        }

        // Log the "edit the record" action in the audit trail
        $action = "Updated the record with Customer ID: $order_id";
        if (isset($_SESSION['username'])) {
            $currentUsername = $_SESSION['username'];
            $sql = "SELECT id FROM register WHERE username = '$currentUsername'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $registerId = $row['id'];

            $action = mysqli_real_escape_string($conn, $action);
            $sql = "INSERT INTO logs (register_id, action_made, timestamp) VALUES ('$registerId', '$action', NOW())";
            if (!mysqli_query($conn, $sql)) {
                echo "Error logging action: " . mysqli_error($conn);
            }
        } else {
            echo "Error logging action: User not authenticated.";
        }

        // Redirect back to home.php
        header('Location: home.php');
        exit;
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="edit.css?v=<?php echo time ();?>">
    <title>Update record - My Shop</title>
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
<body class ="body">
    
    <form method="POST">
        <h2 id ="h2" >Edit Record</h2>
        <?php if (isset($error_message)): ?>
          <div class="alert alert-danger text-center" role="alert"><?php echo $error_message; ?></div>
          <?php endif; ?>
        <label>Customer name:</label><br>
        <input type="text" name="customer_name" value="<?php echo $row['customer_name']; ?>"><br>
        <label>Customer email:</label><br>
        <input type="text" name="customer_email" value="<?php echo $row['customer_email']; ?>"><br>
        <label>Product name:</label><br>
        <input type="text" name="product_name" value="<?php echo $row['product_name']; ?>"><br>
        <label>Product price:</label><br>
        <input type="text" name="product_price" value="<?php echo $row['product_price']; ?>"><br><br>
        <div class="button">
            <input type="submit" value="Update" id="updateButton" disabled>
            <button type="button" onclick="redirectToHome()">Cancel</button>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('input[type="text"]').on('input', function() {
      if ($(this).val().trim().length > 0) {
        $('#updateButton').prop('disabled', false);
      } else {
        $('#updateButton').prop('disabled', true);
      }
    });
  });
</script>

    </form>
    <script>
    function redirectToHome() {
    window.location = "home.php";
    }
    </script>
 </body>
</html>
