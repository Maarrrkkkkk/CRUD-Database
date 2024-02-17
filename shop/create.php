<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

// Connect to the database
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'myshop';
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize error message and form data
$error_message = '';
$customer_name = '';
$customer_email = '';
$product_name = '';
$product_price = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $order_date = date('Y-m-d H:i:s');

    // Initialize error message
    $error_message = '';

    // Validate email
    if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format!";
    } else {
        // Check if email already exists
        $query = "SELECT * FROM customers WHERE customer_email = '$customer_email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $error_message = "Email already exists!";
        }
    }

    // Validate product price
    if (!is_numeric($product_price)) {
        $error_message = "Product price must be a number!";
    }

    // Add new Record
    if (empty($error_message)) {
        // Insert customer record
        $sql = "INSERT INTO customers (customer_name, customer_email) VALUES ('$customer_name', '$customer_email')";
        mysqli_query($conn, $sql);

        // Get last inserted customer ID
        $customer_id = mysqli_insert_id($conn);

        // Insert product record
        $sql = "INSERT INTO products (product_name, product_price) VALUES ('$product_name', '$product_price')";
        mysqli_query($conn, $sql);

        // Get last inserted product ID
        $product_id = mysqli_insert_id($conn);

        // Insert order record
        $sql = "INSERT INTO orders (customer_id, product_id, order_date) VALUES ('$customer_id', '$product_id', CURRENT_TIMESTAMP)";
        mysqli_query($conn, $sql);

        // Function to log an action in the audit trail
        function logAction($registerId, $action) {
            global $conn;
            $action = mysqli_real_escape_string($conn, $action);
          }
          
        // Log the "added new record" action in the audit trail
        $action = "Added new record with Customer ID: $customer_id";
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

        // Redirect to home.php
        header('Location: home.php');
        exit;
    }
}

mysqli_close($conn);
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="create.css?v=<?php echo time(); ?>">
    <title>Create New Record - MyShop CRUD</title>
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
    
<form method="POST">
    <h2 id="h2">Create New Record</h2>
    <?php if (!empty($error_message)): ?>
    <div class="alert alert-danger text-center" role="alert"><?php echo $error_message; ?></div>
        <?php endif; ?>
    <label>Customer name:</label><br>
    <input type="text" name="customer_name" value="<?php echo isset($_POST['customer_name']) ? $_POST['customer_name'] : ''; ?>" required><br>
    <label>Customer email:</label><br>
    <input type="text" name="customer_email" value="<?php echo isset($_POST['customer_email']) ? $_POST['customer_email'] : ''; ?>" required><br>
    <label>Product name:</label><br>
    <input type="text" name="product_name" value="<?php echo isset($_POST['product_name']) ? $_POST['product_name'] : ''; ?>" required><br>
    <label>Product price:</label><br>
    <input type="text" name="product_price" value="<?php echo isset($_POST['product_price']) ? $_POST['product_price'] : ''; ?>" required><br><br>
    <div class="button">
        <input type="submit" value="Submit">
        <button type="button" onclick="redirectToHome()">Cancel</button>
    </div>
</form>

<script>
    function redirectToHome() {
        window.location = "home.php";
    }
</script>
</body>
</html>


