<?php
session_start();
$conn = new mysqli("localhost", "root", "", "tele_health");


if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: dashboard.php"); 
    exit();
}


$error_message = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $query->bind_param("ss", $username, $password);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Invalid username or password."; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tele-Health</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style1.css"> 
</head>
<body>
    <video autoplay muted loop id="background-video">
        <source src="https://ub.edu.ph/ubbc/wp-content/uploads/2023/09/UB-Homepage-Video-w-text.mp4#t=0.01" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <header>
        <div class="logo">
            <a href="index.php">
                <img src="https://upload.wikimedia.org/wikipedia/commons/f/f1/UBlogo.png" alt="Tele Health Logo">
            </a>
        </div>

        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <a href="logout.php" class="logout-button">Logout</a>
        <?php endif; ?>

            
    

    </header>
    <div class="message-container">
    <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
        <p class="message">You are not logged in. Please <a href="login.php" style="color: #007bff;">login</a> to access your account.</p>
    <?php endif; ?>
</div>





</body>
</html>


