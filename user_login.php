<?php
require 'connection.php';
@session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landscaping - User Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Roboto', sans-serif; }
        body { background-color: rgba(110, 243, 121, 0.95); height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-container { background-color: rgba(162, 247, 166, 0.95); padding: 2.5rem; border-radius: 15px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2); width: 100%; max-width: 400px; }
        .login-container h2 { text-align: center; margin-bottom: 25px; color: #2c3e50; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; }
        .form-group input { width: 100%; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid #ccc; outline: none; transition: 0.3s ease; }
        .form-group input:focus { border-color: #27ae60; }
        .btn { width: 100%; padding: 0.75rem; background: #0a853dff; border: none; color: white; border-radius: 8px; font-size: 16px; font-weight: bold; transition: background 0.3s; cursor: pointer; }
        .btn:hover { background: #219150; }
        .extra-links { text-align: center; margin-top: 15px; }
        .extra-links a { color: #27ae60; text-decoration: none; }
        .extra-links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="login-container">
    <h2><i class="fas fa-leaf"></i> Login</h2>
    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="user_username" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="user_password" required>
        </div>
        <button type="submit" class="btn" name="user_login">Login</button>
        <div class="extra-links">
            <p><a href="#">Forgot Password?</a></p>
            <p>Don't have an account? <a href="user_registration.php">Register here</a></p>
        </div>
    </form>
</div>
</body>
</html>

<?php
if (isset($_POST['user_login'])) {
    $username = trim($_POST['user_username']);
    $password = trim($_POST['user_password']);

    $user = $db->user_table->findOne(['username' => $username]);

    if ($user) {
        if (password_verify($password, $user['user_password'])) {
            $_SESSION['username'] = $username;
            echo "<script>alert('Login Successful!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Invalid Password');</script>";
        }
    } else {
        echo "<script>alert('Username not found');</script>";
    }
}
?>
