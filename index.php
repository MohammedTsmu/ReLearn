<?php 
session_start();

// Check if the user is logged in, then redirect them to the welcome page directly
if (!isset($_SESSION["loggedin"])) {


include 'db.php'; // Include your database connection
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Reminder</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="media/studyReminderIcon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="media/studyReminderIcon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="media/studyReminderIcon.png">
    <link rel="shortcut icon" href="media/studyReminderIcon.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-config" content="media/studyReminderIcon.png">
</head>
<body>
    <!-- empty div to make the theme works -->
    <div id="subjectForm"></div>

    <div class="container">
        <select onchange="saveThemePreference(this.value)">
            <option value="system">Theme | System Default</option>
            <option value="light">Light</option>
            <option value="dark">Dark</option>
        </select>
        <h1>Study Reminder</h1>

        <!-- Toggling Forms for Login and Registration -->
        <div>
            <button onclick="showForm('login')">Login</button>
            <button onclick="showForm('register')">Register</button>
        </div>

        <div id="loginForm" style="display:none;">
            <h2>Login</h2>
            <form method="post" action="login.php">
                Username: <input type="text" name="username" required><br>
                Password: <input type="password" name="password" required><br>
                <button type="submit">Login</button>
            </form>
        </div>

        <div id="registerForm" style="display:none;">
            <h2>Register</h2>
            <form method="post" action="register.php">
                Username: <input type="text" name="username" required><br>
                Email: <input type="email" name="email" required><br>
                Password: <input type="password" name="password" required><br>
                <button type="submit">Register</button>
            </form>
        </div>

        <div id="subjectsContainer"></div>

        <footer>
            <p>Copyright &copy; Mohammed Q.Sattar Services</p>
        </footer>
    </div>

    <script src="script.js"></script>
    
    <script>
        function showForm(form) {
            document.getElementById('loginForm').style.display = form === 'login' ? 'block' : 'none';
            document.getElementById('registerForm').style.display = form === 'register' ? 'block' : 'none';
            document.getElementById('subjectForm').style.display = form === 'login' || form === 'register' ? 'none' : 'block';
        }
    </script>
</body>
</html>

<?php
}else{
    header("location: welcome.php");
    exit;
}
?>