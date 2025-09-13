<?php
require 'connection.php';
@session_start();

if (isset($_POST['register_user'])) {
    $username = trim($_POST['user_username']);
    $email = trim($_POST['user_email']);
    $password = trim($_POST['user_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "<script>alert('All fields are required');</script>";
    } elseif ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match');</script>";
    } else {
        // Check if username exists
        $existingUser = $db->user_table->findOne(['username' => $username]);
        if ($existingUser) {
            echo "<script>alert('Username already taken');</script>";
        } else {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $db->user_table->insertOne([
                'username' => $username,
                'email' => $email,
                'user_password' => $hashedPassword
            ]);
            echo "<script>alert('Registration successful!'); window.location='user_login.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        body {
            background: linear-gradient(to right, #4CAF50, #2E7D32);
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .register-card {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-in-out;
            width: 100%;
            max-width: 400px;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .register-card h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #2E7D32;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
        }
        .btn-custom {
            background: #2E7D32;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            width: 100%;
            transition: background 0.3s ease-in-out;
        }
        .btn-custom:hover {
            background: #1B5E20;
        }
        .extra-links {
            text-align: center;
            margin-top: 15px;
        }
        .extra-links a {
            text-decoration: none;
            color: #2E7D32;
        }
        .extra-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="register-card">
    <h2><i class="fas fa-user-plus"></i> Register</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="user_username" class="form-label">Username</label>
            <input type="text" class="form-control" name="user_username" id="user_username" placeholder="Enter username" required>
        </div>
        <div class="mb-3">
            <label for="user_email" class="form-label">Email</label>
            <input type="email" class="form-control" name="user_email" id="user_email" placeholder="Enter email" required>
        </div>
        <div class="mb-3">
            <label for="user_password" class="form-label">Password</label>
            <input type="password" class="form-control" name="user_password" id="user_password" placeholder="Enter password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm password" required>
        </div>
        <button type="submit" class="btn-custom" name="register_user">Register</button>
        <div class="extra-links">
            <p class="mt-3">Already have an account? <a href="user_login.php">Login here</a></p>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
