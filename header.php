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