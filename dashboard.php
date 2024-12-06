<?php
session_start();

// Check if the user is logged in, if not, redirect them to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];  // Retrieve the username
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Tele Health</title>
    <link rel="stylesheet" href="style.css">
       
</head>
<body>
    <!-- Photo background -->
    <div id="background-photo"></div>

    <header>
        <nav>
            <a href="index.php">Home</a>
            <a href="about.php">About Us</a>
            <a href="consultation.php">Consultation</a>
        </nav>
    </header>

    <div class="dashboard-container">
        <h2>Welcome to your Dashboard</h2>
        <p>Hello, <?php echo htmlspecialchars($username); ?>! You are logged in.</p>
    </div>
</body>
</html>
