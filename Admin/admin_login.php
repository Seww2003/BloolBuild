<?php
require __DIR__ . '/../vendor/autoload.php'; // Composer autoload for MongoDB

try {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $db = $client->landscaping; // your database name
    $adminCollection = $db->admins; // admin collection name
    $userCollection = $db->users;  // user collection
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Landscaping</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body {
            background: linear-gradient(135deg, #a8e063, #56ab2f);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            animation: fadeIn 0.8s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #2d572c;
        }
        p.subtitle {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            color: #555;
        }
        label {
            font-weight: bold;
            margin-bottom: 6px;
            display: block;
            color: #333;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 15px;
            transition: border-color 0.3s ease;
        }
        input:focus {
            border-color: #56ab2f;
            outline: none;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background: #56ab2f;
            border: none;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s ease;
        }
        .btn:hover {
            background: #3f8c1f;
        }
        .links {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }
        .links a {
            color: #56ab2f;
            text-decoration: none;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Admin Login</h2>
    <p class="subtitle">Login to your Landscaping Dashboard</p>
    <form action="" method="POST">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>

        <button type="submit" name="admin_login" class="btn">Login</button>

        <div class="links">
            <p><a href="#">Forgot Password?</a></p>
            <p>Don't have an account? <a href="admin_registration.php">Register</a></p>
        </div>
    </form>
</div>

</body>
</html>

<?php
require '../connection.php';


if (isset($_POST['admin_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $admin = $adminCollection->findOne(['admin_name' => $username]);

    if ($admin && password_verify($password, $admin['admin_password'])) {
        $_SESSION['admin_username'] = $username;
        echo "<script>alert('Login Successful'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Invalid Username or Password');</script>";
    }
}
?>

