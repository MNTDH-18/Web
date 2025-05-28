<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Wizarding World</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
</head>

<body>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <p>You have entered the magical realm of the Wizarding World.</p>
        <div class="btn-group">
            <a href="spells.php" class="btn">Manage Spells</a>
            <a href="items.php" class="btn">View Magical Items</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>
    </div>
</body>

</html>