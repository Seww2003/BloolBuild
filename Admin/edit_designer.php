<?php
session_start();
require '../connection.php';
use MongoDB\BSON\ObjectId;

$id = $_GET['id'];
$designer = $db->designers->findOne(['_id' => new ObjectId($id)]);

if (isset($_POST['update_designer'])) {
    $name = $_POST['name'];
    $profession = $_POST['profession'];
    $address = $_POST['address'];
    $experience = $_POST['experience'];

    $updateData = [
        'name' => $name,
        'profession' => $profession,
        'address' => $address,
        'experience' => $experience,
    ];

    if (!empty($_FILES['image']['name'])) {
        $imageName = $_FILES['image']['name'];
        $imagePath = "designer_images/" . basename($imageName);
        move_uploaded_file($_FILES['image']['tmp_name'], "../" . $imagePath);
        $updateData['image'] = $imagePath;
    }

    $db->designers->updateOne(['_id' => new ObjectId($id)], ['$set' => $updateData]);

    echo "<script>alert('✅ Designer updated successfully!'); window.location='admin_designers.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Designer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #c8e6c9, #e0f2f1);
            font-family: 'Segoe UI', sans-serif;
        }
        .card-custom {
            max-width: 650px;
            margin: 60px auto;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 40px;
            background-color: #fff;
        }
        .card-title {
            font-weight: 700;
            color: #2e7d32;
        }
        .form-label {
            font-weight: 500;
            color: #555;
        }
        .btn-save {
            background-color: #43a047;
            color: #fff;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-save:hover {
            background-color: #2e7d32;
        }
        .preview-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin: auto;
            display: block;
            border: 4px solid #a5d6a7;
        }
        .img-upload-label {
            display: block;
            cursor: pointer;
            text-align: center;
            margin-top: 10px;
            color: #388e3c;
        }
    </style>
</head>
<body>

<div class="card card-custom">
    <h2 class="card-title text-center mb-4">🖊 Update Designer Profile</h2>
    <form method="POST" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to update?');">
        <div class="mb-3 text-center">
            <?php if (!empty($designer['image'])): ?>
                <img src="../<?php echo htmlspecialchars($designer['image']); ?>" alt="Designer Image" class="preview-img">
            <?php else: ?>
                <img src="../assets/img/default-profile.png" alt="Default" class="preview-img">
            <?php endif; ?>
            <label class="img-upload-label">
                Change Image
                <input type="file" name="image" class="form-control mt-2" style="max-width: 300px; margin: auto;">
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($designer['name']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Profession</label>
            <input type="text" name="profession" value="<?php echo htmlspecialchars($designer['profession']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($designer['address']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Experience (Years)</label>
            <input type="number" name="experience" value="<?php echo htmlspecialchars($designer['experience']); ?>" class="form-control" required>
        </div>
        <button type="submit" name="update_designer" class="btn btn-save w-100 mt-3">💾 Save Changes</button>
    </form>
</div>

</body>
</html>
