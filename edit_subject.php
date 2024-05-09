<?php
session_start();

// Check if the user is logged in, if not then redirect them to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.html");
    exit;
}

include 'db.php'; // Include your database connection
include 'manage_subject.php'; // Ensure this file is included

$data = json_decode(file_get_contents('php://input'), true);
$subjectId = $data['id'];
$newName = $data['name'];

$result = editSubject($subjectId, $newName); // Call the function with the subject ID and new name

if ($result) {
    echo json_encode(["success" => true, "message" => "Subject updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update subject."]);
}