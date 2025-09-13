<?php
require_once __DIR__ . '/../connection.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - Landscaping</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Roboto', sans-serif; }
        body {
            background: linear-gradient(135deg, #a8e063, #56ab2f);
            display: flex; justify-content: center; align-items: center; min-height: 100vh;
        }
        .register-box {
            background: #fff; padding: 40px; border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            max-width: 450px; width: 100%;
            animation: fadeIn 0.6s ease-in-out;
        }
        @keyframes fadeIn { from {opacity: 0; transform: translateY(30px);} to {opacity: 1; transform: translateY(0);} }
        h2 { text-align: center; color: #2d572c; margin-bottom: 15px; }
        p.subtitle { text-align: center; color: #555; margin-bottom: 20px; font-size: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; color: #333; }
        input[type="text"], input[type="email"], input[type="password"], input[type="file"] {
            width: 100%; padding: 10px; margin-bottom: 15px;
            border: 1px solid #ccc; border-radius: 6px; outline: none; transition: border-color 0.3s;
        }
        input:focus { border-color: #56ab2f; }
        .btn {
            width: 100%; padding: 12px; border: none;
            background: #56ab2f; color: #fff; font-weight: bold;
            border-radius: 6px; cursor: pointer; transition: background 0.3s ease;
        }
        .btn:hover { background: #3f8c1f; }
        .login-link { text-align: center; margin-top: 10px; font-size: 14px; }
        .login-link a { color: #56ab2f; text-decoration: none; font-weight: 600; }
        .login-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Admin Registration</h2>
        <p class="subtitle">Create your admin account</p>

        <form action="" method="post" enctype="multipart/form-data">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Enter your username" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Enter your email" required>

            <label for="admin_image">Admin Image</label>
            <input type="file" name="admin_image" id="admin_image" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>

            <label for="conf_password">Confirm Password</label>
            <input type="password" name="conf_password" id="conf_password" placeholder="Confirm your password" required>

            <button type="submit" class="btn" name="admin_register">Register</button>

            <div class="login-link">
                Already have an account? <a href="admin_login.php">Login here</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
require_once __DIR__ . '/../connection.php'; // re-include to ensure $adminCollection exists

if (isset($_POST['admin_register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $conf_password = $_POST['conf_password'];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    $image = $_FILES['admin_image']['name'];
    $image_tmp = $_FILES['admin_image']['tmp_name'];

    // Check if user exists
    $existingAdmin = $adminCollection->findOne([
        '$or' => [
            ['admin_name' => $username],
            ['admin_email' => $email]
        ]
    ]);

    if ($existingAdmin) {
        echo "<script>alert('Username or Email already exists');</script>";
    } elseif ($password !== $conf_password) {
        echo "<script>alert('Passwords do not match');</script>";
    } else {
        // Upload image
        $imageDir = __DIR__ . "/admin_images/";
        if (!is_dir($imageDir)) {
            mkdir($imageDir, 0777, true);
        }
        $imagePath = $imageDir . $image;
        move_uploaded_file($image_tmp, $imagePath);

        // Insert into MongoDB
        $insertResult = $adminCollection->insertOne([
            'admin_name' => $username,
            'admin_email' => $email,
            'admin_image' => "admin_images/$image",
            'admin_password' => $hash_password,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);

        if ($insertResult->getInsertedCount() > 0) {
            echo "<script>alert('Admin registered successfully'); window.location='admin_login.php';</script>";
        } else {
            echo "<script>alert('Error occurred while registering');</script>";
        }
    }
}
?>
