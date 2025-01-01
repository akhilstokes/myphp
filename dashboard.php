<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch expenses from the database
$sql = "SELECT * FROM expenses WHERE user_id = $user_id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker - Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard</h2>

        <!-- Add Expense Button -->
        <a href="add_expense.php" class="btn">Add Expense</a>

        <?php
        if ($result->num_rows > 0) {
            // Loop through the result set
            while ($row = $result->fetch_assoc()) {
                // Ensure that $row contains valid data and that the 'id' exists
                if (isset($row['id'])) {
                    echo '<div class="expense-item">';
                    echo '<p><strong>Title:</strong> ' . htmlspecialchars($row['title']) . '</p>';
                    echo '<p><strong>Amount:</strong> ' . htmlspecialchars($row['amount']) . '</p>';
                    echo '<p><strong>Date:</strong> ' . htmlspecialchars($row['date']) . '</p>';
                    echo '<a href="delete.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this expense?\')">Delete</a>';
                    echo ' | ';
                    echo '<a href="edit.php?id=' . $row['id'] . '">Edit</a>';
                    echo '</div>';
                } else {
                    echo "<p>Expense ID not found.</p>";
                }
            }
        } else {
            echo "<p>No expenses found.</p>";
        }

        // Logout functionality
        echo '<br><a href="logout.php">Logout</a>';
        ?>
    </div>
</body>
</html>

<style>
    /* Centered Form Container */
    /* Reset some basic styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
}

/* Main container */
.container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

/* Heading Style */
h2 {
    text-align: center;
    color: #2c3e50;
}

/* Expense Item Styles */
.expense-item {
    background-color: #ecf0f1;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 5px;
}

.expense-item p {
    margin: 5px 0;
}

.expense-item a {
    color: #2980b9;
    text-decoration: none;
}

.expense-item a:hover {
    text-decoration: underline;
}

/* Logout Link Style */
a {
    color: #e74c3c;
    font-weight: bold;
    text-decoration: none;
}

a:hover {
    color: #c0392b;
}
</style>