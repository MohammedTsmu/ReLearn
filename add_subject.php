<?php
session_start();

// Check if the user is logged in, if not then redirect them to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.html");
    exit;
}

include 'db.php'; // Include your database connection

// Function to add a subject along with the user's ID
function addSubject($name, $userId) {
    global $pdo;

    try {
        // Start transaction
        $pdo->beginTransaction();

        // Add subject to the 'subjects' table with the user_id
        $stmt = $pdo->prepare("INSERT INTO subjects (name, user_id) VALUES (:name, :user_id)");
        $stmt->execute(['name' => $name, 'user_id' => $userId]);
        $subjectId = $pdo->lastInsertId();

        // Calculate alert dates
        $alertDays = [1, 3, 6, 10];
        foreach ($alertDays as $days) {
            $alertDate = new DateTime("+$days days");
            $stmt = $pdo->prepare("INSERT INTO subject_alerts (subject_id, alert_date) VALUES (:subject_id, :alert_date)");
            $stmt->execute(['subject_id' => $subjectId, 'alert_date' => $alertDate->format('Y-m-d H:i:s')]);
        }

        // Log the addition in 'subject_history'
        $stmt = $pdo->prepare("INSERT INTO subject_history (subject_id, action) VALUES (:subject_id, 'added')");
        $stmt->execute(['subject_id' => $subjectId]);

        // Commit transaction
        $pdo->commit();

        echo json_encode(["success" => true, "message" => "Subject added successfully with alert dates."]);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
}

// Reading JSON POST data
$data = json_decode(file_get_contents('php://input'), true);

// Check if the name is provided
if(isset($data['name']) && !empty($_SESSION['id'])) {
    addSubject($data['name'], $_SESSION['id']); // Call the function with the subject name and user id
} else {
    echo json_encode(["success" => false, "message" => "Subject name not provided or user not identified."]);
}
?>
