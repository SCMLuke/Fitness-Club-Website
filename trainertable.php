<?php
session_start();
$adminLoggedIn = isset($_SESSION["admin_id"]);
$memberLoggedIn = isset($_SESSION["user_id"]);
// Connect to the database.
$mysqli = require __DIR__ . "/database.php";

// Check the connection.
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Handle form submissions for updating user information.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input and update user information.
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $schedule = $_POST["schedule"];

    $sql_update = "UPDATE trainer SET name = ?, email = ?, schedule = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql_update);

    if ($stmt === false) {
        die("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("sssi", $name, $email, $schedule, $id);
    $stmt->execute();

    // Redirect to avoid form resubmission on page refresh.
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Handle delete requests.
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["action"]) && $_GET["action"] === "delete" && isset($_GET["id"])) {
    $idToDelete = $_GET["id"];

    $sql_delete = "DELETE FROM trainer WHERE id = ?";
    $stmt_delete = $mysqli->prepare($sql_delete);

    if ($stmt_delete === false) {
        die("SQL error: " . $mysqli->error);
    }

    $stmt_delete->bind_param("i", $idToDelete);
    $stmt_delete->execute();

    // Redirect to avoid form resubmission on page refresh.
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Retrieve all users from the 'trainer' table.
$sql_select = "SELECT * FROM trainer";
$result = $mysqli->query($sql_select);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Information</title>
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


<div class="tableDiv">
    <h1>Trainer Information</h1>

    <table class="table">
        <?php if ($adminLoggedIn): ?>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Schedule</th>
                <th>Action</th>
            </tr>
            <?php
            // Output data of each row.
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?= htmlspecialchars($row["id"]) ?></td>
                    <td><?= htmlspecialchars($row["name"]) ?></td>
                    <td><?= htmlspecialchars($row["email"]) ?></td>
                    <td><?= htmlspecialchars($row["schedule"]) ?></td>
                    <td>
                        <a class="tableButtons" href="?id=<?= $row["id"] ?>">Edit</a>
                        <a class="tableButtons" href="?action=delete&id=<?= $row["id"] ?>" onclick="return confirm('Are you sure you want to delete this trainer?')">Delete</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        <?php elseif(isset($memberLoggedIn)): ?>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Schedule</th>
            </tr>
            <?php
            // Output data of each row.
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?= htmlspecialchars($row["name"]) ?></td>
                    <td><?= htmlspecialchars($row["email"]) ?></td>
                    <td><?= htmlspecialchars($row["schedule"]) ?></td>
                </tr>
                <?php
            }
            ?>
        <?php endif; ?>
    </table>
</div>

<?php
// Display the form for updating user information based on the selected ID
if (isset($_GET["id"])) {
    $selectedId = $_GET["id"];

    $sql_select_trainer = "SELECT * FROM trainer WHERE id = ?";
    $stmt_trainer = $mysqli->prepare($sql_select_trainer);

    if ($stmt_trainer === false) {
        die("SQL error: " . $mysqli->error);
    }

    $stmt_trainer->bind_param("i", $selectedId);
    $stmt_trainer->execute();

    $trainer = $stmt_trainer->get_result()->fetch_assoc();
    ?>
        <div class="editInformation">
            <div class="editInformationForm">
                <h2>Edit Trainer Information</h2>
                <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                    <input type="hidden" name="id" value="<?= $trainer["id"] ?>">
                    <?php if ($adminLoggedIn): ?>

                        <div class="editElement">
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($trainer["name"]) ?>" required><br>
                        </div>
                        <div class="editElement">
                            <label for="email">Email:</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($trainer["email"]) ?>" required><br>
                        </div>
                        <div class="editElement">
                            <label for="schedule">Schedule</label>
                            <input type="text" name="schedule" value="<?= htmlspecialchars($trainer["schedule"]) ?>" required><br>
                        </div>

                    <?php endif; ?>

                    <input class="updateButton" type="submit" value="Update">

                </form>
            </div>
            <p><a href="index.php">Return to index</a></p>
        </div>
    <?php
}
?>



</body>
</html>
<?php
// Close the database connection
$mysqli->close();
?>
