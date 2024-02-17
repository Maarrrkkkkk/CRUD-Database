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

// Connect to the database
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check the connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);
    
    // Delete records from Database
    $sql = "DELETE o, p, c FROM orders o 
            INNER JOIN (SELECT order_id, product_id FROM orders WHERE order_id = $order_id) oi ON o.order_id = oi.order_id 
            INNER JOIN products p ON oi.product_id = p.product_id 
            INNER JOIN (SELECT customer_id FROM customers WHERE customer_id = $customer_id) ci ON o.customer_id = ci.customer_id
            INNER JOIN customers c ON ci.customer_id = c.customer_id";

    if (mysqli_query($conn, $sql)) {
        // Log the "deleted the record" action in the audit trail
        $action = "Deleted record with Customer ID: $order_id";
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
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
$result = mysqli_query($conn, $sql);

?>
