<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$success = '';
$error = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];

    // Add
    if (isset($_POST['add_spell'])) {
        $spell_name = $_POST['spell_name'];
        $description = $_POST['description'];

        $stmt = $conn->prepare("INSERT INTO spells (user_id, spell_name, description) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $spell_name, $description);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Spell added successfully!";
        } else {
            $_SESSION['error'] = "Failed to add the spell.";
        }
        header("Location: spells.php");
        exit;
    }

    // Update
    if (isset($_POST['update_spell']) && isset($_POST['spell_id'])) {
        $spell_id = $_POST['spell_id'];
        $spell_name = $_POST['spell_name'];
        $description = $_POST['description'];

        $stmt = $conn->prepare("UPDATE spells SET spell_name = ?, description = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssii", $spell_name, $description, $spell_id, $user_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Spell updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update the spell.";
        }
        header("Location: spells.php");
        exit;
    }
}

// Delete
if (isset($_GET['delete_id'])) {
    $spell_id = $_GET['delete_id'];

    $stmt = $conn->prepare("DELETE FROM spells WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $spell_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Spell deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete the spell.";
    }
    header("Location: spells.php");
    exit;
}

// Fetch spells from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM spells WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$spells = $result->fetch_all(MYSQLI_ASSOC);


if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spells - Wizarding World</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
</head>

<body>
    <div class="container">
        <h1>Your Magical Spells</h1>

        <!-- Success and Error Messages -->
        <?php if (!empty($success)): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <!-- Add Spell Form -->
        <form method="POST" class="form-container">
            <label for="spell_name">Spell Name:</label>
            <input type="text" id="spell_name" name="spell_name" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            <button type="submit" name="add_spell" class="btn">Add Spell</button>
        </form>

        <!-- Display Spells -->
        <h2>Spell Directory</h2>
        <?php if (!empty($spells)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Spell Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($spells as $spell): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($spell['spell_name']); ?></td>
                            <td><?php echo htmlspecialchars($spell['description']); ?></td>
                            <td>
                                <button class="btn edit-btn" data-id="<?php echo $spell['id']; ?>"
                                    data-name="<?php echo htmlspecialchars($spell['spell_name']); ?>"
                                    data-description="<?php echo htmlspecialchars($spell['description']); ?>">
                                    Edit
                                </button>
                                <a href="?delete_id=<?php echo $spell['id']; ?>" class="btn">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No spells found. Add your first spell above!</p>
        <?php endif; ?>
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>

    <!-- Modal for Updating a Spell -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Update Spell</h2>
            <form method="POST">
                <input type="hidden" id="spell_id" name="spell_id">
                <label for="update_spell_name">Spell Name:</label>
                <input type="text" id="update_spell_name" name="spell_name" required>
                <label for="update_description">Description:</label>
                <textarea id="update_description" name="description" required></textarea>
                <button type="submit" name="update_spell" class="btn">Update Spell</button>
            </form>
        </div>
    </div>

    <script>
        // Modal functionality for editing
        const modal = document.getElementById('updateModal');
        const closeModal = document.querySelector('.close');
        const editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const description = button.getAttribute('data-description');

                document.getElementById('spell_id').value = id;
                document.getElementById('update_spell_name').value = name;
                document.getElementById('update_description').value = description;

                modal.style.display = 'block';
            });
        });

        closeModal.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>
</body>

</html>