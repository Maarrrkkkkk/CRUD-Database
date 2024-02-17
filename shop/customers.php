<?php

// Read customers
$sql_customers = "SELECT * FROM customers";
$result_customers = $conn->query($sql_customers);

// Read orders
$sql_orders = "SELECT orders.id, orders.order_date, customers.name AS customer_name FROM orders INNER JOIN customers ON orders.customer_id = customers.id";
$result_orders = $conn->query($sql_orders);

// Read order items
$sql_order_items = "SELECT order_items.id, order_items.product_name, order_items.quantity, order_items.price, orders.order_date, customers.name AS customer_name FROM order_items INNER JOIN orders ON order_items.order_id = orders.id INNER JOIN customers ON orders.customer_id = customers.id";
$result_order_items = $conn->query($sql_order_items);
?>

<?php

// Display customers
echo '<h2>Customers</h2>';
echo '<table>';
echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr>';

while ($row = $result_customers->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>' . $row['email'] . '</td>';
    echo '<td>';
    echo '<form method="post" action="edit_customer.php"><input type="hidden" name="id" value="' . $row['id'] . '"><button type="submit">Edit</button></form>';
    echo '<form method="post"><input type="hidden" name="id" value="' . $row['id'] . '"><button type="submit" name="delete">Delete</button></form>';
    echo '</td>';
    echo '</tr>';
}

echo '</table>';

// Display orders
echo '<h2>Orders</h2>';
echo '<table>';
echo '<tr><th>ID</th><th>Customer</th><th>Date</th></tr>';

while ($row = $result_orders->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['customer_name'] . '</td>';
    echo '<td>' . $row['order_date'] . '</td>';
    echo '</tr>';
}

echo '</table>';

// Display order items
echo '<h2>Order Items</h2>';
echo '<table>';
echo '<tr><th>ID</th><th>Order Date</th><th>Customer</th><th>Product Name</th><th>Quantity</th><th>Price</th></tr>';

while ($row = $result_order_items->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['order_date'] . '</td>';
    echo '<td>' . $row['customer_name'] . '</td>';
    echo '<td>' . $row['product_name'] . '</td>';
    echo '<td>' . $row['quantity'] . '</td>';
    echo '<td>' . $row['price'] . '</td>';
    echo '</tr>';
}

echo '</table>';
