<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'doctor') {
    header("Location: doctor_login.php");  
    exit();
}

$conn = new mysqli("localhost", "root", "", "tele_health");
$message_id = $_GET['id'];  


$query = $conn->prepare("SELECT * FROM messages WHERE id = ?");
$query->bind_param("i", $message_id);
$query->execute();
$result = $query->get_result();
$message = $result->fetch_assoc();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reply = $_POST['reply'];

    
    $reply_query = $conn->prepare("INSERT INTO replies (message_id, doctor, reply) VALUES (?, ?, ?)");
    $reply_query->bind_param("iss", $message_id, $_SESSION['username'], $reply);
    $reply_query->execute();

    
    header("Location: doctor_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reply to Message</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="<?= isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? 'logged-in' : '' ?>">
            <div class="logo">
                <a href="index.php">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/f1/UBlogo.png" alt="Tele Health Logo">
                </a>
            </div>
            <main>
                <h1>Reply to Message from Student</h1>
            </main>
            <a href="logout.php" class="logout-button">Logout</a>
        </nav>
    </header>

    <div class="reply-container">
        <h2>Message from: <?= htmlspecialchars($message['student']) ?></h2>
        <p><strong>Message:</strong> <?= htmlspecialchars($message['message']) ?></p>

        <form action="reply_message.php?id=<?= $message_id ?>" method="POST">
            <label for="reply">Your Reply:</label>
            <textarea name="reply" required></textarea>
            <button type="submit">Send Reply</button>
        </form>
    </div>
</body>
</html>
