<?php
session_start();
$conn = new mysqli("localhost", "root", "", "tele_health");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);  // Hashing the password

    // Query to check user credentials along with the role
    $query = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $query->bind_param("ss", $username, $password);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;  // Store the username in session
        $_SESSION['role'] = $user['role'];  // Store the role in session
        
        // Redirect based on role
        if ($user['role'] == 'doctor') {
            header("Location: doctor_dashboard.php");  // Redirect to doctor dashboard
        } elseif ($user['role'] == 'student') {
            header("Location: student_dashboard.php");  // Redirect to student dashboard
        } else {
            echo "Role not recognized.";
        }
        exit();
    } else {
        echo "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tele Health - Doctor Login</title>
    <link rel="stylesheet" href="style.css">
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
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/f1/UBlogo.png" alt="Tele Health Logo">
                </a>
            </div>
            
            <main>
                <h1>Welcome to Tele Health</h1>
            </main>
            
            <!-- Show logout button if logged in -->
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <a href="logout.php" class="logout-button">Logout</a>
            <?php endif; ?>
        </nav>
    </header>

    <!-- Form for login -->
    <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
        <div class="login-container">
            <h2>Login</h2>
            <form action="doctor_login.php" method="POST">
                <label>Username:</label>
                <input type="text" name="username" required>
                <label>Password:</label>
                <input type="password" name="password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>
