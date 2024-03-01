<?php
// This code is for validating if the information entered is correct or not.
$valid = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {    // If statement to check if the login button was clicked.

    $mysqli = require  __DIR__ . "/database.php"; // Require connection to database.

    $sql = sprintf("SELECT * FROM admin WHERE email = '%s'",
        $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);
    $admin = $result->fetch_assoc();

    if ($admin) {
        if (password_verify($_POST["password"], $admin["password_hash"])) {   // Check if password information matches.
            session_start();     // Starts a session to store user data for the time.
            session_regenerate_id();     // Protection against a session fixation attack.
            $_SESSION["admin_id"] = $admin["id"];
            header("Location: index.php");   // Redirect to the index / main page.
            exit;
        }
    }
    $valid = true;
}
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>login</title>
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

<!--Calling the valid variable above to check if to show text saying invalid variable.-->
<?php if ($valid): ?>
<em>Invalid Login</em>
<?php endif; ?>

<div class="loginPageDiv">
    <form class="loginPage" method ="post">
        <h1>Admin Login</h1>
        <label for="email">email</label>
        <input type="email" name="email" id="email">

        <label for="password">password</label>
        <input type="password" name="password" id="password">

        <button>Log in</button>
        <p><a href="index.php">Return to index</a></p>
    </form>
</div>

</body>
</html>