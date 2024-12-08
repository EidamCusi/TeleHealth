<?php
$conn = new mysqli("localhost", "root", "", "tele_health");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        header("Location: reset_password.php?email=$email");
    } else {
        echo "Email not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="forgot_password.php" method="POST">
        <h2>Forgot Password</h2>
        <label>Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
