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


        // Fetch order records from database
        $sql = "SELECT orders.order_id, customers.customer_id, customers.customer_name, customers.customer_email, products.product_name 
        FROM orders 
        JOIN customers ON orders.customer_id = customers.customer_id 
        JOIN products ON orders.product_id = products.product_id";
        $result = mysqli_query($conn, $sql);

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="home.css?v=<?php echo time(); ?>">
	<title>My Dashboard - My Shop</title>

    <!--For Search Data -->
    <script>
    $(document).ready(function() {
        $("#myInput").on("keyup",function(){
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) >-1)
            });
        });
    });
</script>
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
<br><br><br>
<span id="static-text">My</span>
<span id="dynamic-text"></span>

<script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
<script>
  (function() {
    var staticText = document.getElementById("static-text");
    var dynamicText = document.getElementById("dynamic-text");

    var typed = new Typed(dynamicText, {
      strings: [
        "<span style='color: #0ef; text-decoration: underline;'>Clients List</span>"
      ],
      typeSpeed: 100,
      backSpeed: 100,
      backDelay: 1000,
      loop: true,
      cursorChar: '<span style="color: #0ef; text-shadow: 5px 5px 5px rgba(0,0,0,1);">|</span>', // Add text shadow to cursor
      onStart: function() {
        staticText.style.opacity = "1";
      },
      onReset: function() {
        staticText.style.opacity = "1";
      }
    });
  })();
</script>








<div class="container-fluid" style="padding-left: 8.5%; padding-right: 8.5%;">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="input-group mb-3">
                <input type="text" id="myInput" class="form-control" placeholder="Search...">
            </div>
        </div>
        <div class="col-12 col-md-6 text-md-end">
            <a class="btn btn-success" href="logs.php" role="button">View Logs</a>
            <a class="btn btn-primary" href="create.php" role="button">Add New Client</a>
            <a class="btn btn-dark" href="navigation.php" role="button">Back</a>
        </div>
    </div>
</div>


            <!-- Dashboard -->
            <table class="table table-striped table-hover table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>Customer Email</th>
            <th>Product Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="myTable">
        <!-- Get the data from the database and display -->
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['customer_id']; ?></td>
                <td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['customer_email']; ?></td>
                <td><?php echo $row['product_name']; ?></td>

                <td>
                    <div class="btn-group" role="group" aria-label="Actions">
                        <form method="GET" action="view.php">
                            <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                            <button type="submit" class="btn btn-success">View</button>
                        </form>
                        <form method="GET" action="edit.php">
                            <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                        <form method="POST" action="delete.php" onsubmit="return confirmDelete(event)">
                            <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                            <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>

                        <script>
                            function confirmDelete(event) {
                                event.preventDefault(); // Prevent form submission initially

                                Swal.fire({
                                    title: 'Confirm Deletion',
                                    text: 'Are you sure you want to delete this record?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Delete',
                                    cancelButtonText: 'Cancel'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        event.target.submit(); // Submit the form if confirmed
                                    }
                                });
                            }
                        </script>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php mysqli_close($conn); ?>
</body>
</html>
