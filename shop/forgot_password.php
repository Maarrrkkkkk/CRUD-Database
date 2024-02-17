<?php
    // Check if the form has been submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Get the input values from the form
        $username = $_POST["username"];
        $new_password = $_POST["new_password"];

        // Connect to the database
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $dbname = "myshop";

        $conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Prepare and execute the update statement
        $stmt = $conn->prepare("UPDATE register SET password=? WHERE BINARY username=?");
        $stmt->bind_param("ss", $hashed_password, $username);
        $stmt->execute();

        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            $success = "Password updated successfully!";
        } else {
            $error = "Unable to update password. Remember your username!";
        }

        // Close the database connection
        $stmt->close();
        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="forgot_password.css?v=<?php echo time ();?>">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.min.js"></script>

</head>
<body class="body-bg">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="container py-5">
            <h2 class="mb-4">Forgot Password</h2>
            <?php if(isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

            <?php if(isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?>
            </div>
            <div class="mt-3">
                    <a href="index.php" class="btn btn-secondary">Log In Here</a>
                </div>
            <?php else: ?>
                <div class="mb-3 text-center d-flex justify-content-center">
                    <div>
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Enter your username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
                </div>
                    </div>
                    
                    <div class="mb-3 text-center d-flex justify-content-center">
        <div>
            <label for="new_password" class="form-label">New Password</label>
            <div class="position-relative">
                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter new password" required>
                <button type="button" class="toggle-password" onclick="togglePassword()">
                    <i class="fas fa-eye-slash" id="toggle_icon"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("new_password");
            var toggleIcon = document.getElementById("toggle_icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            }
        }
    </script>

                <div class="mt-3" style="display: flex; justify-content: center;">
                    <button type="submit" class="btn btn-primary">UPDATE</button>
                    <div style="width: 20px;"></div>
                    <a href="index.php" class="back-link"><button class="back-btn" type="button">BACK</button></a>
                </div>

            <?php endif; ?>
        </div>
    </form>
</body>
</html>






