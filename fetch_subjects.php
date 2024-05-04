<?php
session_start();
include 'db.php'; // Include your database connection

// Function to fetch subjects with their alert dates
function fetchSubjects() {
    global $pdo;
    $subjects = [];

    // Fetch subjects belonging to the logged-in user
    $userId = $_SESSION['id'];
    $stmt = $pdo->prepare("SELECT s.id, s.name, GROUP_CONCAT(sa.alert_date ORDER BY sa.alert_date ASC) AS alert_dates 
                           FROM subjects s 
                           LEFT JOIN subject_alerts sa ON s.id = sa.subject_id 
                           WHERE s.user_id = :userId 
                           GROUP BY s.id, s.name");
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $subject = $row;
        $subject['alerts'] = explode(',', $row['alert_dates']);
        unset($subject['alert_dates']);
        $subjects[] = $subject;
    }

    echo json_encode($subjects);
}

fetchSubjects();
?>
