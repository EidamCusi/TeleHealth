<?php
$conn = new mysqli("localhost", "root", "", "tele_health");

if (isset($_GET['id'])) {
    $doctor_id = $_GET['id'];
    $result = $conn->query("SELECT * FROM doctors WHERE id = $doctor_id");
    $doctor = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $user_id = 1; // Assuming the logged-in user ID is 1 for this example
    $message = $_POST['message'];
    $sender = 'user'; // For simplicity, this assumes the user sends the message

    $conn->query("INSERT INTO messages (doctor_id, user_id, message, sender) 
                  VALUES ($doctor_id, $user_id, '$message', '$sender')");
}

// Fetch the conversation
$messages = $conn->query("SELECT * FROM messages WHERE doctor_id = $doctor_id ORDER BY timestamp ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation with Dr. <?php echo $doctor['name']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <a href="consultation.php">Back to Consultation</a>
        </nav>
    </header>

    <main>
        <h2>Consultation with Dr. <?php echo $doctor['name']; ?></h2>

        <!-- Display messages -->
        <div class="conversation">
            <?php while ($message = $messages->fetch_assoc()) { ?>
                <div class="message <?php echo $message['sender']; ?>">
                    <p><?php echo $message['message']; ?></p>
                    <small><?php echo $message['timestamp']; ?></small>
                </div>
            <?php } ?>
        </div>

        <!-- Send message form -->
        <form action="doctor.php?id=<?php echo $doctor['id']; ?>" method="POST">
            <textarea name="message" rows="4" placeholder="Type your message..." required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </main>
</body>
</html>
