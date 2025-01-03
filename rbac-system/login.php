<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user'] = $user;
            if ($user['role'] == 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: user.php');
            }
            exit();
        } else {
            echo '<script>alert("Password salah"); window.location = "login.php";</script>';
        }
    } else {
        echo '<script>alert("Username tidak ditemukan"); window.location = "login.php";</script>';
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <h1>Silakan masuk</h1>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit" name="btn_login">Login</button>
    </form>
</body>

</html>