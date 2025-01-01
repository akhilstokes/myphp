<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful. <a href='index.php'>Login here</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<form method="POST" action="">
    <label>Username: </label><input type="text" name="username" required><br>
    <label>Email: </label><input type="email" name="email" required><br>
    <label>Password: </label><input type="password" name="password" required><br>
    <button type="submit">Register</button>
</form>
