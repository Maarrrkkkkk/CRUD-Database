<?php
session_start();

// Function to log an action in the audit trail
function logAction($registerId, $action)
{
    global $conn;
    $action = mysqli_real_escape_string($conn, $action);

    // Insert the log record with the given register_id
    $sql = "INSERT INTO logs (register_id, action_made, timestamp) VALUES ('$registerId', '$action', NOW())";
    if (!mysqli_query($conn, $sql)) {
        echo "Error logging action: " . mysqli_error($conn);
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username or password fields are empty
    if (empty($_POST["username"]) && empty($_POST["password"])) {
        $error = "Please enter your username and password.";
    } elseif (empty($_POST["username"])) {
        $error = "Please input the correct username.";
    } elseif (empty($_POST["password"])) {
        $error = "Please input the correct password.";
    } else {
        $conn = mysqli_connect("localhost", "root", "", "myshop");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);

        // Query the database to check if the entered username exists
        $query = "SELECT * FROM register WHERE BINARY username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            // Fetch the user's record from the database
            $row = mysqli_fetch_assoc($result);
            // Verify password using password_verify function
            if (password_verify($password, $row["password"])) {
                // Store user data in session variables
                $_SESSION["username"] = $row["username"];
                $_SESSION["user_id"] = $row["id"];

                // Log the login action in the audit trail
                $registerId = $row['id'];
                if (!isset($_SESSION['logged_in'])) {
                    logAction($registerId, "Logged in the system");
                    $_SESSION['logged_in'] = true;
                }
                
                // Redirect to home page or any other page after successful login
                header("Location: navigation.php");
                exit();
            } else {
                $error = "Invalid password. Please try again.";
            }
        } else {
            $error = "Invalid username. Please try again.";
        }

        // Close database connection
        mysqli_close($conn);
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="index.css?v=<?php echo time ();?>">
</head>

<body class ="body-bg">
<div class="container my-5">
    <form method="post">
        <h2>Please Login</h2>
        <?php
            if(isset($error)) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        ?>
        <div class="mb-3">
            <label for="username" class="form-label">User Name</label>
            <input type="text" class="form-control" id="username" name="username">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="position-relative">
                <input type="password" class="form-control" id="password" name="password">
                <button class="position-absolute" type="button" id="password-toggle" onclick="togglePassword()">
                    <i class="fa fa-eye-slash"></i>
                </button>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <a href="forgot_password.php">Forgot Password?</a>
            </div>

        </div>
        <div class="btn-group">
            <button type="submit" class="btn btn-primary">LOG IN</button>
            <button type="reset" class="btn btn-secondary">CANCEL</button>
        </div>
        <div>
    <p><br>Don't Have Account?</p>
    <a href="register.php" class="btn btn-link">Register Here!</a>
</div>


    </form>
</div>

<script>
   function togglePassword() {
  var passwordInput = document.getElementById("password");
  var passwordToggle = document.getElementById("password-toggle");

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    passwordToggle.innerHTML = '<i class="fa fa-eye"></i>';
  } else {
    passwordInput.type = "password";
    passwordToggle.innerHTML = '<i class="fa fa-eye-slash"></i>';
  }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
