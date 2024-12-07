<?php
session_start();
$conn = new mysqli("localhost", "root", "", "tele_health");

// Variable to store error message
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);  // Hashing the password

    $query = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $query->bind_param("ss", $username, $password);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;  // Store the username in session
        header("Location: dashboard.php");
        exit();
    } else {
        // Set error message if credentials are incorrect
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tele Health - Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
</head>
<body>
    <video autoplay muted loop id="background-video">
        <source src="https://ub.edu.ph/ubbc/wp-content/uploads/2023/09/UB-Homepage-Video-w-text.mp4#t=0.01" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    
    <header>
        
        <nav class="<?= isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? 'logged-in' : '' ?>">
            <div class="logo">
                <a href="index.php">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/f1/UBlogo.png" alt="Tele Health Logo"> <!-- Change to your logo's path -->
                </a>
            </div>
            
            
            
            <!-- Show logout button if logged in -->
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <a href="logout.php" class="logout-button">Logout</a>
            <?php endif; ?>
        </nav>
    </header>

    <!-- Form for login -->
    <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
    <form action="index.php" method="POST">
        <h2>Login</h2>
        <label>Username:</label>
        <input type="text" name="username" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>

        <!-- Display error message if credentials are incorrect -->
        <?php if ($error_message != ""): ?>
            <div id="error-modal" class="modal">
                <div class="modal-content">
                    <span class="close-btn">&times;</span>
                    <p><?php echo $error_message; ?></p>
                </div>
            </div>
        <?php endif; ?>

        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </form>
    <?php endif; ?>

    <script>
        // JavaScript to handle modal display
        const modal = document.getElementById("error-modal");
        const closeBtn = document.querySelector(".close-btn");

        if (modal) {
            modal.style.display = "block"; // Show the modal

            closeBtn.onclick = function() {
                modal.style.display = "none"; // Close the modal when close button is clicked
            }

            // Close the modal if clicked outside the modal content
            window.onclick = function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
