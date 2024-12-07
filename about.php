<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Tele Health</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your external stylesheet -->
</head>
<body>

    <!-- Background video -->
    <video autoplay muted loop id="background-video">
        <source src="https://ub.edu.ph/ubbc/wp-content/uploads/2023/09/UB-Homepage-Video-w-text.mp4#t=0.01" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Header with navigation bar -->
    <header>
        <nav>
            <div class="logo">
                <a href="index.php">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/f1/UBlogo.png" alt="Tele Health Logo"> <!-- Replace with your logo -->
                </a>
            </div>

            <!-- Navigation links -->
            <a href="index.php">Home</a>
            <a href="about.php" class="active">About Us</a>
            <a href="consultation.php">Consultation</a>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <a href="logout.php" class="logout-button">Logout</a>
            <?php endif; ?>
        </nav>
    </header>

    <!-- Main content for the About Us section -->
    <section class="about">
        <div class="about-text-container">
            <h2>About Tele Health System</h2>
            <p>
                Tele Health is a comprehensive digital platform designed to enhance healthcare accessibility and efficiency.
                It provides patients with remote consultations, easy access to medical records, and a variety of health services
                through video calls, chat, and more. Our goal is to connect patients with healthcare professionals to improve
                healthcare delivery, making it more convenient and efficient.
            </p>
            <p>
                Our system includes a secure and encrypted communications, and the ability to book
                consultations, request prescriptions, and follow up on treatments—all from the comfort of your home.
            </p>
        </div>
    </section>

</body>
</html>
