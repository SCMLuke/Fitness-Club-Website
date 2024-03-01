<?php

// Hardcoded values for testing purposes. Added upon starting the 'index' page for the first time.
$name = "Admin";
$email = "admin@example.com";
$password = "samplepassword123";

$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Check if data has already been inserted into the database. Check if the row count equals 0.
$mysqli = require __DIR__ . "/database.php";
$sql_check = "SELECT COUNT(*) as count FROM admin";
$result = $mysqli->query($sql_check);

$row = $result->fetch_assoc();
$count = $row["count"];

// If the row count does equal 0, add the admin account to the database.
if ($count == 0) {
    // Inserting new records into the database.
    $mysqli = require __DIR__ . "/database.php";
    $sql = "INSERT INTO admin (name, email, password_hash) VALUES (?, ?, ?)";
    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("sss", $name, $email, $password_hash);

    $stmt->execute();
}

?>