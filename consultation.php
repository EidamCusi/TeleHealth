<?php
$conn = new mysqli("localhost", "root", "", "tele_health");
$result = $conn->query("SELECT * FROM doctors");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $user_message = $_POST['message'];

    
    $stmt = $conn->prepare("INSERT INTO messages (doctor_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $doctor_id, $user_message);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Message sent successfully!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tele-Health - Consultation</title>
    <link rel="stylesheet" href="stylecon.css">
</head>
<body>

    
    <header>
    <nav class="nav">
    
    <a href="dashboard.php">Home</a>
    <a href="about.php">About Us</a>
    <a href="consultation.php" class="active">Consultation</a>
</nav>
    </header>

    
    <main>
        <h2>Available Doctors</h2>
        <div class="doctor-container">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <?php if ($row['availability']) { ?> 
                    <div class="doctor-card" onclick="showModal(this, '<?php echo $row['name']; ?>', <?php echo $row['id']; ?>)">
                        <h3><?php echo $row['name']; ?></h3>
                        <span class="availability">Available</span>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

        
        <div class="message-reassurance">
            <p>Whatever you put here will not be seen by others, your information is safe here. Be comfortable with what you say.</p>
        </div>
    </main>

    
    <div id="doctorModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Doctor Selected:</h3>
            <p id="doctorName"></p>
            
            <form method="POST">
                <input type="hidden" id="doctorId" name="doctor_id">
                <textarea name="message" placeholder="Put how you feel if something hurts in the body..." rows="5" required></textarea><br>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </div>

    
    <script>
        function showModal(element, doctorName, doctorId) {
            
            document.getElementById('doctorName').textContent = doctorName;

            
            document.getElementById('doctorId').value = doctorId;

            
            const doctorCards = document.querySelectorAll('.doctor-card h3');
            doctorCards.forEach(card => card.style.color = "green"); 
            element.querySelector('h3').style.color = "maroon"; 

            
            document.getElementById('doctorModal').style.display = "flex";
        }

        function closeModal() {
            document.getElementById('doctorModal').style.display = "none";
        }

        
        window.onclick = function(event) {
            if (event.target == document.getElementById('doctorModal')) {
                closeModal();
            }
        }
    </script>

</body>
</html>
