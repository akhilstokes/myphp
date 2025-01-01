<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header('Location: dashboard.php');
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found.";
    }
}
?>
<form method="POST" action="" class="container">
    <h2>Login</h2>
    <label>Username</label>
    <input type="text" name="username" required>
    <label>Password</label>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
</form>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Centered Form Container */
        .container {
            max-width: 400px;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        /* Form Title */
        .container h2 {
            text-align: center;
            font-size: 24px;
            color: #354f52;
            margin-bottom: 20px;
        }

        /* Input Fields */
        .container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            border: 1px solid #cad2c5;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        .container input:focus {
            border-color: #84a98c;
            outline: none;
        }

        /* Submit Button */
        .container button {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            background-color: #84a98c;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .container button:hover {
            background-color: #52796f;
        }

        /* Links */
        .container p {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #2f3e46;
        }

        .container a {
            color: #52796f;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s;
        }

        .container a:hover {
            color: #354f52;
        }

        /* Alert Styling (if required) */
        .alert {
            padding: 10px;
            background-color: #e63946;
            color: white;
            text-align: center;
            margin-bottom: 10px;
            border-radius: 5px;
        }
    </style>
