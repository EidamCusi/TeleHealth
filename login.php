<?php
session_start();
$conn = new mysqli("localhost", "root", "", "tele_health");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);  // Hashing the password

    $query = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $query->bind_param("ss", $username, $password);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;  // Store the username in session
        $_SESSION['role'] = $user['role'];  // Assuming role is stored in the DB (doctor or student)
        
        // Redirect doctor to their dashboard if they are one of the allowed doctors
        if (in_array($username, ['Dr. Alice', 'Dr. Bob', 'Dr. Charlie'])) {
            header("Location: doctor_dashboard.php");  // Redirect to doctor dashboard
        } else {
            header("Location: student_dashboard.php");  // Redirect to student dashboard
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tele Health - Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
    <style>
        /* Fullscreen fixed photo background */
        #background-photo {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://the-post-assets.sgp1.digitaloceanspaces.com/2021/07/University-of-Batangas.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -1;
        }

        /* General page styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: white;
            overflow-x: hidden;
        }

        header {
            position: relative;
            z-index: 1;
        }

        /* Adjusted Navigation Bar Styling */
        header nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
            padding: 0 20px;
            background-color: rgba(0, 0, 0, 0.7);
        }

        /* Logo Styling */
        header nav .logo img {
            width: 60px;
            height: auto;
        }

        /* Centered title */
        header nav h1 {
            color: white;
            font-weight: bold;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        /* Login form styling */
        .login-form {
            position: relative;
            z-index: 2;
            margin-top: 100px;
            text-align: center;
            padding: 30px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .login-form h2 {
            font-size: 2rem;
        }

        .login-form input {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            background-color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
        }

        .login-form button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1rem;
        }

        .login-form button:hover {
            background-color: #0056b3;
        }

        .login-form p {
            font-size: 1rem;
        }

        /* Contact Info Layout */
        .contact-info {
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            margin-top: 50px;
            text-align: center;
        }

        /* Contact Details */
        .contact-info .contact-details {
            display: flex;
            justify-content: center;
            gap: 30px;
            font-size: 1.2rem;
        }

        .contact-info .address {
            font-size: 1.2rem;
            margin-top: 20px;
            text-align: center;
        }

        

        /* Social Media Links */
        .social-media {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .social-media a {
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
        }

        .social-media a:hover {
            color: #007BFF;
        }
    </style>
</head>
<body>

    <!-- Fixed Background -->
    <div id="background-photo"></div>

    <header>
        <nav>
            <div class="logo">
                <a href="index.php">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/f1/UBlogo.png" alt="Tele Health Logo">
                </a>
            </div>
            <h1>Welcome to Tele Health</h1>
        </nav>
    </header>

    <!-- Login Form -->
    <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
    <div class="login-form">
        <form action="index.php" method="POST">
            <h2>Login</h2>
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </div>
    <?php endif; ?>

    <!-- Contact Info -->
    <div class="contact-info">
        <h3>Contact Information</h3>
        
        <div class="contact-details">
            <p>Email: contact@telehealth.com</p>
            <p>Phone: 123-456-7890</p>
        </div>
        
        <div class="address">
            <p>Address: 123 TeleHealth Lane, Health City, Country</p>
        </div>
        
        
        <div class="social-media">
            <a href="#" target="_blank">Facebook</a>
            <a href="#" target="_blank">Twitter</a>
            <a href="#" target="_blank">Instagram</a>
        </div>
    </div>

</body>
</html>
