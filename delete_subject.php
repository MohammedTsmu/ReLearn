<?php
session_start();

// Check if the user is logged in, if not then redirect them to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit;
}

include 'db.php'; // Make sure this is the correct path to your database connection file
$data = json_decode(file_get_contents('php://input'), true);
$subjectId = $data['id'];

if (isset($subjectId)) {
    $stmt = $pdo->prepare("DELETE FROM subjects WHERE id = :id");
    $stmt->bindParam(':id', $subjectId, PDO::PARAM_INT);

    if($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Subject deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete subject."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Subject ID not provided."]);
}
?>