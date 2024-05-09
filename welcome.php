<?php
session_start();

// Check if the user is logged in, if not then redirect them to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('location: index.php');
    exit;
}

include 'header.php'; // include header.php
include 'db.php'; // Include database connection


// Fetch only the subjects that belong to the logged-in user and match the search term
$userId = $_SESSION['id'];

// Fetch all subjects for the logged-in user
$stmt = $pdo->prepare("SELECT * FROM subjects WHERE user_id = ?");
$stmt->execute([$userId]);
$subjects = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>This is your dashboard.</p>

        <!-- Add Subject Form -->
        <form id="subjectForm" method="post" action="add_subject.php">
            <input type="text" id="subjectName" name="subjectName" placeholder="Enter subject name" required>
            <button type="submit">Add Subject</button>
        </form>

        <!-- Display user-specific data -->
        <div id="subjectsContainer">
            <h2>Your Subjects</h2>
            <ul>
                <?php foreach ($subjects as $subject): ?>
                <li id="subject-<?php echo $subject['id']; ?>">
                    <?php echo htmlspecialchars($subject['name']); ?>
                    <button onclick="editSubject(<?php echo $subject['id']; ?>)">Edit</button>
                    <button onclick="deleteSubject(<?php echo $subject['id']; ?>)">Delete</button>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <a class=".btn" href="logout.php">Logout</a>
    </div>

    <script src="script.js"></script>
</body>

</html>