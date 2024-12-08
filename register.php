<?php
session_start();
$conn = new mysqli("localhost", "root", "", "tele_health");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $email = $password = "";
$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hash the password using MD5

    // Check if the username or email already exists
    $check_user = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $check_user->bind_param("ss", $username, $email);
    $check_user->execute();
    $result = $check_user->get_result();

    if ($result->num_rows > 0) {
        $error = "Username or email is already taken. Please choose another one.";
    } else {
        // Insert new user data into the database
        $query = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $query->bind_param("sss", $username, $email, $password);

        if ($query->execute()) {
            $success = "Registration successful! You can now <a href='login.php'>log in</a>.";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tele Health - Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <video autoplay muted loop id="background-video">
        <source src="https://ub.edu.ph/ubbc/wp-content/uploads/2023/09/UB-Homepage-Video-w-text.mp4#t=0.01" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <header>
        <nav>
        <main>
                <h1>Welcome to Tele Health</h1>
            </main>
        </nav>
    </header>
    <form action="register.php" method="POST">
        <h2>Register</h2>
        <label>Username:</label>
        <input type="text" name="username" required value="<?php echo isset($username) ? $username : ''; ?>">

        <label>Email:</label>
        <input type="email" name="email" required value="<?php echo isset($email) ? $email : ''; ?>">

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Register</button>

        <div class="message">
            <?php
            if (!empty($error)) {
                echo "<p class='error'>$error</p>";
            }

            if (!empty($success)) {
                echo "<p class='success'>$success</p>";
            }
            ?>
        </div>
    </form>
</body>
</html>