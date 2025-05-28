<?php
session_start();
include 'db_config.php';

// Fetch items from the database
$sql = "SELECT * FROM items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items - Wizarding World</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
</head>

<body>
    <div class="container">
        <h1>Magical Items</h1>
        <div class="item-grid">
            <?php
            if ($result->num_rows > 0) {
                while ($item = $result->fetch_assoc()) {
                    // Construct the correct image path
                    $imagePath = "./images/" . $item['image_url']; // Ensure filename only stored in DB
            
                    // Check if file exists before displaying
                    if (!file_exists($imagePath)) {
                        $imagePath = "./images/default.jpg"; // Fallback image
                    }

                    echo "
                    <div class='item-card'>
                        <img src='{$imagePath}' alt='{$item['item_name']}' class='item-image'>
                        <h2>{$item['item_name']}</h2>
                        <p>{$item['description']}</p>
                    </div>
                    ";
                }
            } else {
                echo "<p>No magical items found!</p>";
            }
            ?>
        </div>
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>

</html>