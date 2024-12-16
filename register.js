// Simulating user registration and login with localStorage for Tele-Health
// Replace this with API calls for real server-based implementations

const database = JSON.parse(localStorage.getItem('database')) || [];

// Registration Simulation
function register(username, email, password) {
    const existingUser = database.find(user => user.username === username || user.email === email);
    if (existingUser) {
        alert('Username or email is already taken. Please choose another one.');
    } else {
        const newUser = { username, email, password: md5(password), role: 'student' };
        database.push(newUser);
        localStorage.setItem('database', JSON.stringify(database));
        alert('Registration successful! You can now log in.');
        window.location.href = 'login.html';
    }
}

// Render Registration Page
if (!localStorage.getItem('loggedin') || localStorage.getItem('loggedin') !== 'true') {
    document.write(`
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Tele Health - Register</title>
        <link rel="stylesheet" href="styleregister.css">
    </head>
    <body>
        <video autoplay muted loop id="background-video">
            <source src="https://ub.edu.ph/ubbc/wp-content/uploads/2023/09/UB-Homepage-Video-w-text.mp4#t=0.01" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <header>
            <nav>
                <main>
                    <h1>Welcome to Tele Health</h1>
                </main>
            </nav>
        </header>
        <form id="registerForm">
            <h2>Register</h2>
            <label>Username:</label>
            <input type="text" id="username" required>

            <label>Email:</label>
            <input type="email" id="email" required>

            <label>Password:</label>
            <input type="password" id="password" required>

            <button type="submit">Register</button>

            <p>Already have an account? <a href="login.html">Back to Login</a></p>
        </form>
        <script>
            document.getElementById('registerForm').addEventListener('submit', function(event) {
                event.preventDefault();
                const username = document.getElementById('username').value;
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                register(username, email, password);
            });
        </script>
    </body>
    </html>
    `);
} else {
    // Redirect to Dashboard if already logged in
    window.location.href = 'dashboard.html';
}