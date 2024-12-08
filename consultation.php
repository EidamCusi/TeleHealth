<?php
$conn = new mysqli("localhost", "root", "", "tele_health");
$result = $conn->query("SELECT * FROM doctors");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tele Health - Consultation</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Background image styling */
        body {
            background: url("https://ub.edu.ph/ubbc/wp-content/uploads/2023/08/CNM-1-scaled.jpg") no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            font-family: Arial, sans-serif;
            color: white; /* Ensure text is visible on the background */
        }

        /* Styling for the available doctors section */
        .doctor-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }

        /* Each doctor's card container */
        .doctor-card {
            background-color: white; /* Set background color to white */
            padding: 15px 20px;
            border-radius: 8px;
            width: 250px; /* Fixed width for each card */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            font-size: 1.1rem;
            text-align: center;
            display: flex;
            justify-content: center;  /* Center content horizontally */
            align-items: center;      /* Center content vertically */
            height: 150px;            /* Set a fixed height for consistent layout */
            flex-direction: column;  /* Stack elements vertically */
        }

        /* Make cards responsive on small screens */
        @media (max-width: 768px) {
            .doctor-card {
                width: 100%; /* Full width for smaller screens */
            }
        }

        /* Styling for the doctor's name */
        .doctor-card h3 {
            color: maroon; /* Set the doctor's name color to maroon */
            margin-bottom: 10px; /* Add space below the doctor's name */
        }

        /* Styling for the 'Available' text color */
        .doctor-card span {
            color: maroon; /* Change the text color to maroon */
            font-weight: bold; /* Optional: Make the text bold */
        }

        /* Styling for the h2 element */
        h2 {
            color: maroon; /* Set the h2 color to maroon */
            text-align: center; /* Center align the text */
        }
    </style>
</head>
<body>

    <!-- Header with navigation bar -->
    <header>
        <nav>
            <!-- Logo -->
            <div class="logo">
                <a href="dashboard.php">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/f1/UBlogo.png" alt="Tele Health Logo"> <!-- Replace with your logo -->
                </a>
            </div>

            <!-- Navigation links -->
            <a href="dashboard.php">Home</a>
            <a href="about.php">About Us</a>
            <a href="consultation.php" class="active">Consultation</a>
        </nav>
    </header>

    <!-- Main content -->
    <h2>Consultation with Doctors</h2>

    <div class="doctor-container">
        <?php while ($doctor = $result->fetch_assoc()): ?>
            <div class="doctor-card">
                <h3><?php echo $doctor['name']; ?></h3>
                
                <span>Available</span>
            </div>
        <?php endwhile; ?>
    </div>

</body>
</html>
