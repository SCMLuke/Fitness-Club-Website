<?php

// Name validation.
if (empty($_POST["name"])) {
    die("Name is required!");
}

// Email validation.
if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Please enter a valid email!");
}

// Password validation.
if (strlen($_POST["password"]) < 8) {   // Check if password is less than 8 characters.
    die("Password must be at least 8 characters!");
}
if ( ! preg_match("/[a-z]/i", $_POST["password"])) {    // Check if password contains a letter.
    die("Password must contain at least one letter!");
}
if ( ! preg_match("/[0-9]/", $_POST["password"])) {    // Check if password contains a number.
    die("Password must contain at least one number!");
}
if ($_POST["password"] !== $_POST["password_confirmation"]) {   // Check if passwords match.
    die("Passwords must match!");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);   // Encrypting the password to make it safer.

// Inserting new records into the database.
$mysqli = require __DIR__ . "/database.php";  // Require database.php to run.
$sql = "INSERT INTO user (name, email, password_hash) VALUES (?, ?, ?)";    // SQL statement for inserting new users into the database with sample values to start.
$stmt = $mysqli->stmt_init();   // New prepared statement for above execution.
if ( ! $stmt->prepare($sql)) {    // Prepare the statement, and check if connection to database is true.
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss", $_POST["name"], $_POST["email"], $password_hash);  // Get the parameters of the form to replace the placeholders in the above statement. The 3 's' are the 3 strings (username, password, email).

if ($stmt->execute()) {    // Execute the above statement, adding the user data to the database. Gives error if finding a matching email in the database.
    header("Location: index.php");
    exit;
}  else {
    if ($mysqli->errno === 1062) {  // Validate that an original email was submitted.
        die("Email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}

?>
