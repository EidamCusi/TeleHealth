<?php
session_start();
$conn = new mysqli("localhost", "root", "", "tele_health");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);  

    $query = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $query->bind_param("ss", $username, $password);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        
        $user = $result->fetch_assoc();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;  
        $_SESSION['role'] = $user['role'];  
        
       
        if (in_array($username, ['Dr. Alice', 'Dr. Bob', 'Dr. Charlie'])) {
            header("Location: doctor_dashboard.php");  
        } else {
            header("Location: student_dashboard.php");  
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
    <title>Tele-Health - Login</title>
    <link rel="stylesheet" href="stylelogin.css"> 
    
</head>
<body>
    <video autoplay muted loop id="background-video">
        <source src="https://ub.edu.ph/ubbc/wp-content/uploads/2023/09/UB-Homepage-Video-w-text.mp4#t=0.01" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    
    <header>
        <nav class="<?= isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? 'logged-in' : '' ?>">
            <div class="nav-container">
                
                <div class="logo">
                    <a href="index.php">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/f/f1/UBlogo.png" alt="Tele Health Logo">
                    </a>
                </div>
                
                <main>
                    <h1>Welcome to Tele-Health</h1>
                </main>
                
                
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <a href="logout.php" class="logout-button">Logout</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    
    <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
    <form action="index.php" method="POST">
        <h2>Login</h2>
        <label>Username:</label>
        <input type="text" name="username" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </form>
    <?php endif; ?>

    
    <div class="how-to-use-container">
        <h2>How to Use It</h2>
        <p><strong>Step 1:</strong> Login if you have an account; if not, you can register.</p>
        <p><strong>Step 2:</strong> After you login, you will see your dashboard and the navigation bar on the top of your screen.</p>
        <p><strong>Step 3:</strong> Click the consultation navigation.</p>
        <p><strong>Step 4:</strong> Click the doctor you want.</p>
        <p><strong>Step 5:</strong> The doctor's details will appear in the message box. You can type there what you feel.</p>
    </div>
</body>
</html>
