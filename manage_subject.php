<?php
session_start();

// Check if the user is logged in, if not then redirect them to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

include 'db.php'; // Include your database connection

include 'header.php';

// Function to edit a subject's name
function editSubject($subjectId, $newName) {
global $pdo;

try {
$stmt = $pdo->prepare("UPDATE subjects SET name = :name WHERE id = :id");
$stmt->execute(['name' => $newName, 'id' => $subjectId]);

$stmt = $pdo->prepare("INSERT INTO subject_history (subject_id, action) VALUES (:subject_id, 'edited')");
$stmt->execute(['subject_id' => $subjectId]);

return true; // Indicate success
} catch (Exception $e) {
return false; // Indicate failure
}
}

// Function to delete a subject
function deleteSubject($subjectId) {
global $pdo;
try {
$stmt = $pdo->prepare("DELETE FROM subjects WHERE id = :id");
$stmt->execute(['id' => $subjectId]);
return $stmt->rowCount() > 0; // Returns true if any rows were affected
} catch (Exception $e) {
// Optionally, log error details for troubleshooting
return false;
}
}


// Example usage
// editSubject(1, 'Physics');
// deleteSubject(2);
?>