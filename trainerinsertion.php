<?php

// Hardcoded values for testing purposes. Added upon starting the 'index' page for the first time.
$name = "Todd Trainer";
$email = "todd@example.com";
$password = "samplepassword123";
$schedule = "9-5";

$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Check if data has already been inserted into the database. Check if the row count equals 0.
$mysqli = require __DIR__ . "/database.php";
$sql_check = "SELECT COUNT(*) as count FROM trainer";
$result = $mysqli->query($sql_check);

$row = $result->fetch_assoc();
$count = $row["count"];

// If the row count does equal 0, add the admin account to the database.
if ($count == 0) {
    // Inserting new records into the database.
    $mysqli = require __DIR__ . "/database.php";
    $sql = "INSERT INTO trainer (name, email, password_hash, schedule) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("ssss", $name, $email, $password_hash, $schedule);

    $stmt->execute();
}

?>