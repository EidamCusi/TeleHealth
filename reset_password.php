<?php
$conn = new mysqli("localhost", "root", "", "tele_health");
$email = $_GET['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = md5($_POST['new_password']);

    $query = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $query->bind_param("ss", $new_password, $email);
    if ($query->execute()) {
        echo "Password reset successfully.";
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="reset_password.php?email=<?php echo $email; ?>" method="POST">
        <h2>Reset Password</h2>
        <label>New Password:</label>
        <input type="password" name="new_password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
