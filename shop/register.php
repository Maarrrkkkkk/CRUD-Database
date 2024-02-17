<?php

// Define error message variable
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $username = $_POST["username"];
  $password = $_POST["password"];
  $confirm_password = $_POST["confirm_password"];
  $role = $_POST["role"]; // Retrieve the selected role

  // Check if password and confirm password match
  if ($password != $confirm_password) {
    $error_message = "Error: Passwords do not match!";
  } else {
    // Connect to the database
    $db_connection = mysqli_connect('localhost', 'root', '', 'myshop');

    // Check if connection is successful
    if (!$db_connection) {
      die("Database connection failed: " . mysqli_connect_error());
    }

    // Sanitize user input
    $username = mysqli_real_escape_string($db_connection, $username);

    // Check if username already exists in the database
    $query = "SELECT * FROM register WHERE username = ?";
    $stmt = mysqli_prepare($db_connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
      $error_message = "Error: Username already exists!";
    } else {
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      

      // Insert username and hashed password into the appropriate table using prepared statement
      $query = "INSERT INTO register (username, password, role) VALUES (?, ?, ?)";
      $stmt = mysqli_prepare($db_connection, $query);
      mysqli_stmt_bind_param($stmt, "sss", $username, $hashed_password, $role);
      $result = mysqli_stmt_execute($stmt);
      

      // Check if registration is successful
      if ($result) {
        echo "Registration successful!";
        // Redirect to index.php
        header("Location: index.php");
        exit;
      } else {
        $error_message = "Registration failed. Please try again.";
      }
    }

    // Close database connection
    mysqli_close($db_connection);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="register.css?v=<?php echo time ();?>">
  <title>Register Form</title>
</head>
<body class="body-bg">
  <!-- registration.php -->
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h2 id = "h2" >Sign Up</h2>
    <!-- Display error message if it exists -->
    <?php if (!empty($error_message)): ?>
      <div class="alert alert-danger text-center" role="alert"><?php echo $error_message; ?>
      </div>
    <?php endif; ?>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <label for="password" class="form-label">Password:</label>
    <div class="input-container">
      <input type="password" class="form-control" id="password" name="password" required>
      <span class="toggle-password input-icon" onclick="togglePassword()">
        <i class="fa fa-eye-slash"></i>
      </span>
    </div>
    <label for="confirm_password" class="form-label">Confirm Password:</label>
    <div class="input-container">
      <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
      <span class="toggle-password input-icon" onclick="toggleConfirmPassword()">
        <i class="fa fa-eye-slash"></i>
      </span>
    </div>
    <!-- Role selection input (e.g., dropdown menu or radio buttons) -->
    <label for="role">Role:</label>
    <select id="role" name="role">
      <option value="admin">Admin</option>
      <option value="user">User</option>
    </select>
    <div class="button">
      <input type="submit" value="ENTER">
      <a href="index.php" style="text-decoration:none;"><button type="button">CANCEL</button></a>
    </div>
  </form>
  <script>
    function togglePassword() {
      var passwordInput = document.getElementById("password");
      var passwordIcon = document.querySelector("#password + .input-icon i");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        passwordIcon.classList.remove("fa-eye-slash");
        passwordIcon.classList.add("fa-eye");
      } else {
        passwordInput.type = "password";
        passwordIcon.classList.remove("fa-eye");
        passwordIcon.classList.add("fa-eye-slash");
      }
    }

    function toggleConfirmPassword() {
      var confirmPasswordInput = document.getElementById("confirm_password");
      var confirmPasswordIcon = document.querySelector("#confirm_password + .input-icon i");

      if (confirmPasswordInput.type === "password") {
        confirmPasswordInput.type = "text";
        confirmPasswordIcon.classList.remove("fa-eye-slash");
        confirmPasswordIcon.classList.add("fa-eye");
      } else {
        confirmPasswordInput.type = "password";
        confirmPasswordIcon.classList.remove("fa-eye");
        confirmPasswordIcon.classList.add("fa-eye-slash");
      }
    }
  </script>
</body>
</html>


