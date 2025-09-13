<?php
session_start();
require '../connection.php';

if (isset($_POST['add_designer'])) {
    $name = $_POST['name'];
    $profession = $_POST['profession'];
    $address = $_POST['address'];
    $experience = $_POST['experience'];
    $email = $_POST['email'];
    $imageName = $_FILES['image']['name'];
    $imagePath = "designer_images/" . basename($imageName);

    if (!is_dir("../designer_images")) {
        mkdir("../designer_images", 0777, true);
    }

    move_uploaded_file($_FILES['image']['tmp_name'], "../" . $imagePath);

    $db->designers->insertOne([
        'name' => $name,
        'profession' => $profession,
        'address' => $address,
        'experience' => $experience,
        'email' => $email,
        'image' => $imagePath,
        'created_at' => new MongoDB\BSON\UTCDateTime()
    ]);

    echo "<script>
        document.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('toast');
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 4000);
        });
    </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Designer</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #e0f2f1, #c8e6c9);
            background-attachment: fixed;
            position: relative;
            overflow: hidden;
        }
        /* subtle floating leaves effect */
        body::before, body::after {
            content: "🌿";
            font-size: 80px;
            position: absolute;
            opacity: 0.08;
            animation: float 12s infinite linear;
        }
        body::before { top: 10%; left: 5%; }
        body::after { bottom: 10%; right: 5%; animation-duration: 18s; }

        @keyframes float {
            from { transform: translateY(0) rotate(0deg); }
            to { transform: translateY(40px) rotate(360deg); }
        }

        .form-container {
            background: rgba(255,255,255,0.9);
            border-radius: 25px;
            padding: 40px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            animation: fadeInUp 1s ease;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        h2 {
            text-align: center;
            font-weight: 700;
            margin-bottom: 25px;
            color: #2d6a4f;
        }
        .form-control {
            border: 2px solid #a5d6a7;
            color: #2d3436;
            border-radius: 12px;
            padding: 12px;
            transition: all 0.3s ease;
        }
        .form-control::placeholder {
            color: #9e9e9e;
        }
        .form-control:focus {
            border-color: #66bb6a;
            box-shadow: 0 0 8px rgba(102,187,106,0.6);
            outline: none;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(90deg, #43a047, #66bb6a);
            color: #fff;
            font-weight: 600;
            font-size: 17px;
            transition: all 0.3s ease;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            background: linear-gradient(90deg, #2e7d32, #43a047);
            box-shadow: 0 6px 18px rgba(0,0,0,0.2);
        }
        .preview {
            margin: 15px 0;
            text-align: center;
        }
        .preview img {
            max-width: 140px;
            border-radius: 15px;
            border: 3px solid #66bb6a;
            box-shadow: 0 6px 15px rgba(0,0,0,0.25);
        }
        /* Toast Notification */
        #toast {
            visibility: hidden;
            min-width: 260px;
            background: #4caf50;
            color: #fff;
            text-align: center;
            border-radius: 10px;
            padding: 14px;
            position: fixed;
            left: 50%;
            bottom: 30px;
            font-weight: 600;
            transform: translateX(-50%);
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.5s, bottom 0.5s;
        }
        #toast.show {
            visibility: visible;
            opacity: 1;
            bottom: 50px;
        }
    </style>
</head>
<body>
    <div class="form-container">
                <a href="admin_dashboard.php" class="btn btn-secondary btn-back">← Back to Dashboard</a>

        <h2>🌱 Add New Designer</h2>
        <form method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
            <input type="text" name="name" placeholder="Full Name" class="form-control mb-3" required>
            <input type="text" name="profession" placeholder="Profession" class="form-control mb-3" required>
            <input type="text" name="address" placeholder="Address" class="form-control mb-3" required>
            <input type="text" name="experience" placeholder="Experience" class="form-control mb-3" required>
            <input type="email" name="email" placeholder="Email Address" class="form-control mb-3" required>
            
            <input type="file" name="image" class="form-control mb-3" accept="image/*" onchange="previewImage(event)" required>
            
            <div class="preview">
                <img id="preview" src="#" alt="Image Preview" style="display:none;">
            </div>
            
            <button type="submit" name="add_designer" 
        style="
            background: linear-gradient(90deg, #6CC24A, #3B873E);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
            max-width: 200px;
        ">
    Add Designer
</button>

 <button type="button" onclick="location.href='admin_dashboard.php';" 
        style="
            background: linear-gradient(90deg, #3B873E, #6CC24A);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
            max-width: 200px;
        ">
    Home
</button>





</form>
    </div>

    <!-- Toast -->
    <div id="toast">🌿 Designer Added Successfully!</div>

    <script>
        // Image Preview
        function previewImage(event) {
            const preview = document.getElementById('preview');
            preview.style.display = "block";
            preview.src = URL.createObjectURL(event.target.files[0]);
        }

        // Form validation
        function validateForm() {
            const email = document.querySelector('input[name="email"]').value;
            if (!email.includes("@")) {
                alert("⚠️ Please enter a valid email address.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
