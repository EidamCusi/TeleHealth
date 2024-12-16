// Simulating session-based login with localStorage and user management
// Replace this with API calls for real server-based implementations

const database = [
    { username: 'Dr. Alice', password: 'password123', role: 'doctor' },
    { username: 'Dr. Bob', password: 'password123', role: 'doctor' },
    { username: 'Dr. Charlie', password: 'password123', role: 'doctor' },
    { username: 'Student1', password: 'password123', role: 'student' }
];

// Login simulation
function login(username, password) {
    const user = database.find(
        (user) => user.username === username && user.password === password
    );
    if (user) {
        localStorage.setItem('loggedin', 'true');
        localStorage.setItem('username', user.username);
        localStorage.setItem('role', user.role);
        const redirectPage = user.role === 'doctor' ? 'doctor_dashboard.html' : 'student_dashboard.html';
        window.location.href = redirectPage;
    } else {
        alert('Invalid credentials.');
    }
}

// Logout simulation
function logout() {
    localStorage.removeItem('loggedin');
    localStorage.removeItem('username');
    localStorage.removeItem('role');
    window.location.href = 'index.html';
}

// Render Login Page if not logged in
if (!localStorage.getItem('loggedin') || localStorage.getItem('loggedin') !== 'true') {
    document.write(`
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Tele-Health - Login</title>
        <link rel="stylesheet" href="stylelogin.css"> 
    </head>
    <body>
        <video autoplay muted loop id="background-video">
            <source src="https://ub.edu.ph/ubbc/wp-content/uploads/2023/09/UB-Homepage-Video-w-text.mp4#t=0.01" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <header>
            <nav>
                <div class="nav-container">
                    <div class="logo">
                        <a href="index.html">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/f/f1/UBlogo.png" alt="Tele Health Logo">
                        </a>
                    </div>
                    <main>
                        <h1>Welcome to Tele-Health</h1>
                    </main>
                </div>
            </nav>
        </header>
        <form id="loginForm">
            <h2>Login</h2>
            <label>Username:</label>
            <input type="text" id="username" required>
            <label>Password:</label>
            <input type="password" id="password" required>
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="register.html">Register here</a></p>
        </form>
        <script>
            document.getElementById('loginForm').addEventListener('submit', function(event) {
                event.preventDefault();
                const username = document.getElementById('username').value;
                const password = document.getElementById('password').value;
                login(username, password);
            });
        </script>
    </body>
    </html>
    `);
} else {
    // Render Dashboard Page
    const username = localStorage.getItem('username') || 'Guest';
    document.write(`
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard - Tele-Health</title>
        <link rel="stylesheet" href="styledash.css">
    </head>
    <body>
        <div id="background-photo"></div>
        <header>
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6c/UB-Master-Logo.png" alt="Logo" class="logo">
            <nav>
                <a href="login.html">Home</a>
                <a href="about.html">About Us</a>
                <a href="consultation.html">Consultation</a>
                <a href="#" onclick="logout()" class="logout-button">Logout</a>
            </nav>
        </header>
        <div class="dashboard-container">
            <h2>Welcome to your Dashboard</h2>
            <p>Hello, ${username}! You are logged in.</p>
        </div>
        <div class="how-to-use-container">
            <h2>How to Use It</h2>
            <p><strong>Step 1:</strong> Login if you have an account; if not, you can register.</p>
            <p><strong>Step 2:</strong> After you login, you will see your dashboard and the navigation bar on the top of your screen.</p>
            <p><strong>Step 3:</strong> Click the consultation navigation.</p>
            <p><strong>Step 4:</strong> Click the doctor you want.</p>
            <p><strong>Step 5:</strong> The doctor's details will appear in the message box. You can type there what you feel.</p>
        </div>
    </body>
    </html>
    `);
}
