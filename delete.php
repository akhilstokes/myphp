<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

if (isset($_GET['id'])) {
    $expense_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Validate the expense belongs to the user
    $sql = "SELECT * FROM expenses WHERE id = $expense_id AND user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Delete the expense
        $sql = "DELETE FROM expenses WHERE id = $expense_id AND user_id = $user_id";
        if ($conn->query($sql) === TRUE) {
            header('Location: dashboard.php');
            exit;
        } else {
            echo "Error deleting expense: " . $conn->error;
        }
    } else {
        echo "Expense not found or you don't have permission to delete it.";
    }
} else {
    echo "No expense ID provided.";
}
?>
<style>
    /* Delete Button Styling */
.delete-button {
    color: #e63946; /* Red color for the delete button */
    font-weight: bold;
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 4px;
    background-color: #f8d7da;
    border: 1px solid #e63946;
    transition: background-color 0.3s;
}

.delete-button:hover {
    background-color: #e63946;
    color: white;
}
</style>