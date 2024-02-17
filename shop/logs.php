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

// Retrieve the current username
$currentUsername = ""; // Initialize variable
if (isset($_SESSION['username'])) {
    $currentUsername = $_SESSION['username']; 
}


// Fetch register record from database
$sql = "SELECT id, username FROM register WHERE username = '$currentUsername'";
$result = mysqli_query($conn, $sql);

// Check if the user exists in the register table
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $registerId = $row['id'];

    // Check if the user is logging in
    if (!isset($_SESSION['logged_in'])) {
        // Log the login action in the audit trail
        logAction($registerId, "Logged in the system");
        $_SESSION['logged_in'] = true;
    }


            // Fetch all audit trail records from the logs table
if ($registerId === "current id") {
    $sql = "SELECT l.id, l.timestamp, r.role, r.username, l.action_made
        FROM logs l
        INNER JOIN register r ON l.register_id = r.id
        WHERE l.register_id = '$registerId'
        ORDER BY l.timestamp ASC";
} else {
    $sql = "SELECT l.id, l.timestamp, r.role, r.username, l.action_made
        FROM logs l
        INNER JOIN register r ON l.register_id = r.id
        ORDER BY l.timestamp ASC";
}
$auditResult = mysqli_query($conn, $sql);





    ?>


    <!-- Add the audio element without autoplay attribute -->
    <audio id="background-music" loop>
        <source src="Im a Rider.mp3" type="audio/mpeg">
    </audio>

    <script>
        // Get the audio element
        var backgroundMusic = document.getElementById("background-music");
        // Get the button element
        var playPauseButton = document.getElementById("play-pause-button");
        // Get the play-pause icon element
        var playPauseIcon = document.getElementById("play-pause-icon");

        // Function to handle the play/pause state from other pages
        function handlePlayPauseState() {
            var isPlaying = sessionStorage.getItem("isPlaying") === "true";
            if (isPlaying) {
                backgroundMusic.play();
                playPauseIcon.classList.remove("fa-play");
                playPauseIcon.classList.add("fa-pause");
            } else {
                backgroundMusic.pause();
                playPauseIcon.classList.remove("fa-pause");
                playPauseIcon.classList.add("fa-play");
            }
        }

        // Function to handle button clicks
        function handleButtonClick() {
            if (backgroundMusic.paused) {
                backgroundMusic.play();
                sessionStorage.setItem("isPlaying", "true");
                playPauseIcon.classList.remove("fa-play");
                playPauseIcon.classList.add("fa-pause");
            } else {
                backgroundMusic.pause();
                sessionStorage.setItem("isPlaying", "false");
                playPauseIcon.classList.remove("fa-pause");
                playPauseIcon.classList.add("fa-play");
            }
        }

        // Save the current time in sessionStorage when navigating away
        window.addEventListener("beforeunload", function () {
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
    <!DOCTYPE html>
    <html>

    <head>
        <title>Audit Trail Logs</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="logs.css?v=<?php echo time(); ?>">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.min.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Audit Trail Logs</h5>
                    <br>
                    <a href="home.php" class="button">Back to Homepage</a>
                    <?php
                    $logsPerPage = 10; // Number of logs to display per page
                
                    // Check if a page number is specified in the URL
                    $currentPage = isset($_GET['page']) ? max(1, $_GET['page']) : 1;

                    // Calculate the starting index and limit for retrieving logs from the database
                    if ($currentPage > 1) {
                        $startIndex = ($currentPage - 1) * $logsPerPage;
                    } else {
                        $startIndex = 0;
                    }
                    $query = "SELECT * FROM logs LIMIT $logsPerPage OFFSET $startIndex";
                    $auditResult = mysqli_query($conn, $query);


                    if (mysqli_num_rows($auditResult) > 0) {
                        $totalLogs = mysqli_num_rows($auditResult);
                        $totalPages = ceil($totalLogs / $logsPerPage);
                        ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role</th>
                                    <th>Username</th>
                                    <th>Action</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
        $count = $startIndex + 1;
        while ($auditRow = mysqli_fetch_assoc($auditResult)) {
            $id = $auditRow['id'];
            $action = $auditRow['action_made'];
            $timestamp = $auditRow['timestamp'];

            // Retrieve the username and role from the register table based on register_id
            $registerId = $auditRow['register_id'];
            $userInfoQuery = "SELECT username, role FROM register WHERE id = '$registerId'";
            $userInfoResult = mysqli_query($conn, $userInfoQuery);
            $userInfoRow = mysqli_fetch_assoc($userInfoResult);
            $username = $userInfoRow['username'] ?? '';
            $role = $userInfoRow['role'] ?? '';

            ?>
            <tr>
                <td>
                    <?php echo $count; ?>
                </td>
                <td>
                    <?php echo $role; ?>
                </td>
                <td>
                    <?php echo $username; ?>
                </td>
                <td>
                    <?php echo $action; ?>
                </td>
                <td>
                    <?php echo $timestamp; ?>
                </td>
            </tr>
            <?php
            $count++;
        }
        ?>
                            </tbody>
                        </table>

                        <nav aria-label="Pagination">
                            <ul class="pagination">
                                <?php if ($currentPage > 1) { ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>">Back</a>
                                    </li>
                                <?php } ?>

                                <li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    <?php } else { ?>
                        <p>No audit trail logs found.</p>
                    <?php } ?>
                </div>
            </div>
        </div>

    </body>

    </html>

    <?php
} else {
    echo "User not found in the register table.";
}

mysqli_close($conn);
?>