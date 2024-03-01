<?php
require_once 'admininsertion.php';
require_once 'trainerinsertion.php';
session_start();

// This decides which type of person is logged in for the index page.
if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

} elseif (isset($_SESSION["admin_id"])) {

    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM admin WHERE id = {$_SESSION["admin_id"]}";
    $result = $mysqli->query($sql);
    $admin = $result->fetch_assoc();

} elseif (isset($_SESSION["trainer_id"])) {

    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM trainer WHERE id = {$_SESSION["trainer_id"]}";
    $result = $mysqli->query($sql);
    $trainer = $result->fetch_assoc();

}
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar">
    <div>
        <h1 class="name">Fitness Club</h1>
    </div>
    <div class="links">
        <a href="homepage.html">Homepage</a>
        <a href="index.php">Login</a>
        <a href="newmember.html">Signup</a>
    </div>
</nav>

<div class="loginCard">
    <h1>Log In</h1>
    <?php if (isset($user)): ?>

        <div class="loggedIn">
            <p>Hello <?= htmlspecialchars($user["name"])?></p>
            <p><a href="trainertable.php">View Trainer Info</a></p>
            <p><a href="logout.php">Log Out</a></p>
        </div>

    <?php elseif(isset($trainer)): ?>

        <div class="loggedIn">
            <p>Hello <?= htmlspecialchars($trainer["name"])?></p>
            <p><a href="membertable.php">Edit Members</a></p>
            <p><a href="logout.php">Log Out</a></p>
        </div>

    <?php elseif(isset($admin)): ?>

        <div class="loggedIn">
            <p>Hello <?= htmlspecialchars($admin["name"])?>. Please select an option below:</p>
            <p><a href="newmember.html">Add New Member</a></p>
            <p><a href="membertable.php">Edit Members</a></p>
            <p><a href="newtrainer.html">Add New Trainer</a></p>
            <p><a href="trainertable.php">Edit Trainers</a></p>
            <p><a href="logout.php">Log Out</a></p>
        </div>

    <?php else: ?>

    <div class="login">
        <h1>Please select a sign in method:</h1>
        <p><a href="memberlogin.php">Member Log In</a></p>
        <p><a href="trainerlogin.php">Trainer Log In</a></p>
        <p><a href="adminlogin.php">Admin Log In</a></p>
        <p>Not a member? <a href="newmember.html">Click here to sign up</a></p>
    </div>
        <!--    <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>  -->

    <?php endif; ?>
</div>

</body>
</html>