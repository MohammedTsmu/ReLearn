<?php
include 'db.php';  // This assumes your db.php file is setting up the PDO connection properly.

session_start();

// Check if the user is logged in, then redirect them to the welcome page directly
if (!isset($_SESSION["loggedin"])) {
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = trim($_POST['username']);  // Directly getting input and trimming any whitespace.
        $password = trim($_POST['password']);
        
        // Using prepared statements to prevent SQL injection.
        $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Password is correct, start a new session
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $username;
                
                // Redirect user to welcome page or some main page of your app
                header("location: welcome.php");
                exit;
        } else {
            // Password is not valid, display a generic error message
            echo "Invalid password.";
            echo '</br> <a href="index.php">Try again!</a>';
        }
    } else {
        // Username doesn't exist, display a generic error message
        echo "Invalid username.";
        echo '</br> <a href="index.php">Try again!</a>';
        exit;
    }
}

}else{
    header("location: welcome.html");
    exit;
}
?>
