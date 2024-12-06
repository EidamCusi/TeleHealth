<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'doctor') {
    header("Location: doctor_login.php");  // Redirect to login if not logged in as a doctor
    exit();
}

$conn = new mysqli("localhost", "root", "", "tele_health");
$username = $_SESSION['username'];

// Fetch messages for this doctor (this assumes you have a table for messages)
$query = $conn->prepare("SELECT * FROM messages WHERE doctor = ? ORDER BY date_sent DESC");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor Dashboard</title>
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
                <h1>Welcome, Dr. <?= htmlspecialchars($_SESSION['username']) ?></h1>
            </main>
            <a href="logout.php" class="logout-button">Logout</a>
        </nav>
    </header>

    <div class="dashboard-container">
        <h2>Messages from Students</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Student</th>
                    <th>Message</th>
                    <th>Respond</th>
                </tr>
                <?php while ($message = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($message['student']) ?></td>
                        <td><?= htmlspecialchars($message['message']) ?></td>
                        <td>
                            <a href="reply_message.php?id=<?= $message['id'] ?>">Reply</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No messages yet. Please check back later.</p>
        <?php endif; ?>
    </div>
</body>
</html>
