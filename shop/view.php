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

// Fetch order record from database
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['order_id'])) {
    $order_id = mysqli_real_escape_string($conn, $_GET['order_id']);

    // Fetch order record
    $sql = "SELECT orders.order_id, customers.customer_name, customers.customer_email, products.product_name, products.product_price, orders.order_date 
        FROM orders 
        INNER JOIN customers ON orders.customer_id = customers.customer_id 
        INNER JOIN products ON orders.product_id = products.product_id 
        WHERE order_id = $order_id";
    $result = mysqli_query($conn, $sql);

    // Display Data
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $order_id = $row['order_id'];
        $customer_name = $row['customer_name'];
        $customer_email = $row['customer_email'];
        $product_name = $row['product_name'];
        $product_price = $row['product_price'];
        $order_date = $row['order_date'];

        
        // Function to log an action in the audit trail
        function logAction($registerId, $action) {
          global $conn;
          $action = mysqli_real_escape_string($conn, $action);
        }
        // Log the "view the record" action in the audit trail
        $action = "Viewed the record with Customer ID : $order_id";
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
        }
    } else {
        echo "Error fetching record: " . mysqli_error($conn);
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
	<link rel="stylesheet" href="view.css?v=<?php echo time ();?>">
	<title>View Order - My Shop</title>
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
<body class ="body-bg">

<h2 class="shadow">Data Record</h2>

<table>
	<tr>
		<th>Order ID:</th>
		<td><?php echo $order_id; ?></td>
	</tr>
	<tr>
		<th>Customer Name:</th>
		<td><?php echo $customer_name; ?></td>
	</tr>
	<tr>
    <th>Customer Email:</th>
    <td><?php echo $customer_email; ?></td>
</tr>

	
	<tr>
		<th>Product Name:</th>
		<td><?php echo $product_name; ?></td>
	</tr>
	<tr>
		<th>Product Price:</th>
		<td><?php echo $product_price; ?></td>
	</tr>
	<tr>
		<th>Order Date:</th>
		<td><?php echo $order_date; ?></td>
	</tr>
</table>
	 <div class ="gitna">
	 <a href="home.php"  class="button">Back to Homepage</a><br>
	 </div>

</body>
</html>