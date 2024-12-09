<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $user_name = $_POST['user_name'];
    $problem_description = $_POST['problem_description'];

    $conn = new mysqli("localhost", "root", "", "tele_health");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO consultations (doctor_id, user_name, problem_description) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $doctor_id, $user_name, $problem_description);

    if ($stmt->execute()) {
        header("Location: consultation.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
