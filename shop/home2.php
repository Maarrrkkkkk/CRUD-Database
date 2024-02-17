<?php

// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "shop");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Read customers
$sql_customers = "SELECT * FROM customers";
$result_customers = $conn->query($sql_customers);
if (!$result_customers) {
    die('Error: ' . $conn->error);
}

// Read orders
$sql_orders = "SELECT orders.id, orders.order_date, customers.name AS customer_name FROM orders INNER JOIN customers ON orders.customer_id = customers.id";
$result_orders = $conn->query($sql_orders);
if (!$result_orders) {
    die('Error: ' . $conn->error);
}

// Read order items
$sql_order_items = "SELECT order_items.id, order_items.product_name, order_items.quantity, order_items.price, orders.order_date, customers.name AS customer_name FROM order_items INNER JOIN orders ON order_items.order_id = orders.id INNER JOIN customers ON orders.customer_id = customers.id";
$result_order_items = $conn->query($sql_order_items);
if (!$result_order_items) {
    die('Error: ' . $conn->error);
}

// Add order item
if (isset($_POST['add'])) {
    $order_id = $_POST['order_id'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $sql_add_item = "INSERT INTO order_items (order_id, product_name, quantity, price) VALUES ('$order_id', '$product_name', '$quantity', '$price')";
    if ($conn->query($sql_add_item) === TRUE) {
        echo "Order item added successfully";
    } else {
        echo "Error: " . $sql_add_item . "<br>" . $conn->error;
    }
}

// Edit order item
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $order_id = $_POST['order_id'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $sql_edit_item = "UPDATE order_items SET order_id='$order_id', product_name='$product_name', quantity='$quantity', price='$price' WHERE id='$id'";
    if ($conn->query($sql_edit_item) === TRUE) {
        echo "Order item updated successfully";
    } else {
        echo "Error: " . $sql_edit_item . "<br>" . $conn->error;
    }
}

// Delete order item
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql_delete_item = "DELETE FROM order_items WHERE id='$id'";
    if ($conn->query($sql_delete_item) === TRUE) {
        echo "Order item deleted successfully";
    } else {
        echo "Error: " . $sql_delete_item . "<br>" . $conn->error;
    }
}

?>