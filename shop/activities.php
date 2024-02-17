<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    // ...
    
    // Log user activity
    $activity = "Deleted client with order ID $order_id";
    $sql = "INSERT INTO user_activities (user_id, activity) VALUES ($user_id, '$activity')";
    mysqli_query($conn, $sql);
}

// ...

// Log user activity
$activity = "Viewed clients list";
$sql = "INSERT INTO user_activities (user_id, activity) VALUES ($user_id, '$activity')";
mysqli_query($conn, $sql);
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

// Fetch user activities from database
$sql = "SELECT user_activities.*, users.username
        FROM user_activities 
        JOIN users ON user_activities.user_id = users.id
        ORDER BY user_activities.created_at DESC";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>User Activities - My Shop</title>
</head>
<body>

    <h2>User Activities</h2>

    <table class="table table-striped table-hover table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>User</th>
                <th>Activity</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['activity']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php mysqli_close($conn); ?>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>User Activities</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
    <h2>User Activities</h2>
php
Copy code
<?php
// connect to MySQL database
$conn = mysqli_connect('localhost', 'username', 'password', 'database_name');

// check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// query to retrieve user activities from the database
$sql = "SELECT * FROM user_activities ORDER BY created_at DESC";

// execute query and get result
$result = mysqli_query($conn, $sql);
?>

<table class="table table-striped table-hover table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>User</th>
            <th>Activity</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['activity']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php mysqli_close($conn); ?>
</body>
</html>
