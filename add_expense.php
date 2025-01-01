<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $user_id = $_SESSION['user_id'];

    // Insert expense into the database
    $sql = "INSERT INTO expenses (title, amount, date, user_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sdsi', $title, $amount, $date, $user_id);

    if ($stmt->execute()) {
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Error adding expense: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Expense</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Add Expense</h2>
        <form method="POST" action="">
            <label>Title</label>
            <input type="text" name="title" required>
            <label>Amount</label>
            <input type="number" name="amount" required>
            <label>Date</label>
            <input type="date" name="date" required>
            <button type="submit">Add Expense</button>
        </form>
        <br>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
