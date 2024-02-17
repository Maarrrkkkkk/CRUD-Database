<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

// Set database credentials
$db_host = 'localhost';
$db_user = 'root';
$db_pass = ''; 
$db_name = 'myshop';

// Connect to database
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to log an action in the audit trail
function logAction($registerId, $action) {
    global $conn;
    $action = mysqli_real_escape_string($conn, $action);

    // Insert the log record with the given register_id
    $sql = "INSERT INTO logs (register_id, action_made, timestamp) VALUES ('$registerId', '$action', NOW())";
    if (!mysqli_query($conn, $sql)) {
        echo "Error logging action: " . mysqli_error($conn);
    }
}

// Retrieve the current username
$currentUsername = ""; // Initialize variable
if (isset($_SESSION['username'])) {
    $currentUsername = $_SESSION['username']; // Assuming you have stored the current username in a session variable
}

// Fetch register record from database
$sql = "SELECT id, username FROM register WHERE username = '$currentUsername'";
$result = mysqli_query($conn, $sql);

// Check if the user exists in the register table
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $registerId = $row['id'];

    // Log the logout action in the audit trail
    logAction($registerId, "Logged out from the system");
    session_destroy();
    header("Location: index.php");
    exit;
} else {
    header("Location: index.php");
    exit;
}
?>
