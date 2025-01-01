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

    // Fetch the expense details
    $sql = "SELECT * FROM expenses WHERE id = $expense_id AND user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $expense = $result->fetch_assoc();
    } else {
        echo "Expense not found or you don't have permission to edit it.";
        exit;
    }
} else {
    echo "No expense ID provided.";
    exit;
}

// Update the expense if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];

    // Update the expense in the database
    $sql = "UPDATE expenses SET title = ?, amount = ?, date = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssdii', $title, $amount, $date, $expense_id, $user_id);

    if ($stmt->execute()) {
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Error updating expense: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Expense</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Expense</h2>
        <form method="POST" action="">
            <label>Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($expense['title']); ?>" required>
            <label>Amount</label>
            <input type="number" name="amount" value="<?php echo htmlspecialchars($expense['amount']); ?>" required>
            <label>Date</label>
            <input type="date" name="date" value="<?php echo htmlspecialchars($expense['date']); ?>" required>
            <button type="submit">Update Expense</button>
        </form>
        <a href="dashboard.php">Cancel</a>
    </div>
</body>
</html>

<style>
    /* Edit Expense Form Styling */
.container {
    max-width: 500px;
    margin: 50px auto;
    background: #ffffff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

.container h2 {
    text-align: center;
    font-size: 24px;
    color: #354f52;
    margin-bottom: 25px;
}

.container label {
    font-size: 16px;
    font-weight: bold;
    color: #52796f;
}

.container input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    font-size: 16px;
    border-radius: 4px;
    border: 1px solid #cad2c5;
}

.container input:focus {
    border-color: #84a98c;
    outline: none;
}

.container button {
    width: 100%;
    padding: 12px;
    background-color: #84a98c;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
}

.container button:hover {
    background-color: #52796f;
}

.container p {
    text-align: center;
    margin-top: 20px;
}

.container a {
    color: #52796f;
    font-weight: bold;
    text-decoration: none;
}

.container a:hover {
    text-decoration: underline;
}
</style>