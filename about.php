<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Tele Health</title>
    <link rel="stylesheet" href="styleab.css">
</head>
<body>

   
    <video autoplay muted loop id="background-video">
        <source src="https://ub.edu.ph/ubbc/wp-content/uploads/2023/09/UB-Homepage-Video-w-text.mp4#t=0.01" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    
    <header>
        <nav>
            <a href="login.php">Home</a>
            <a href="about.php" class="active">About Us</a>
            <a href="consultation.php">Consultation</a>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <a href="logout.php" class="logout-button">Logout</a>
            <?php endif; ?>
        </nav>
    </header>

    
    <section class="about">
        <div class="about-text-container">
            <h2>About Tele-Health System</h2>
            <p>
                Tele Health is a comprehensive digital platform designed to enhance healthcare accessibility and efficiency.
                It provides patients with a consultations, easy access to use , and a variety of health services
                through sending a message. Our goal is to connect patients with healthcare professionals to improve
                healthcare delivery, making it more convenient and efficient.
            </p>
            <p>
                Our system is secured and safe, and the ability to send a message in the 
                consultations, treatments—all from the comfort of your home.
            </p>
        </div>
    </section>

</body>
</html>
