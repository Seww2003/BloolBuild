<?php
session_start();
require '../connection.php'; // Make sure $db is connected to MongoDB

$designers = $db->designers->find([], ['sort' => ['created_at' => -1]]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin - Manage Designers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f5f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px 20px;
        }
        h2 {
            text-align: center;
            color: #21534c;
            margin-bottom: 40px;
            font-weight: bold;
        }
        .card {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border: none;
            border-radius: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .card-img-top {
            width: 100%;
            height: 240px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .btn-edit, .btn-delete {
            width: 48%;
            border-radius: 20px;
            font-weight: 500;
        }
        .btn-edit {
            background-color: #28a745;
            color: white;
        }
        .btn-edit:hover {
            background-color: #218838;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background-color: #bd2130;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🌿 Admin Panel - Designer Management</h2>
        <div class="row">
            <?php foreach ($designers as $designer): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <img src="../<?php echo htmlspecialchars($designer['image']); ?>" class="card-img-top" alt="Designer Image">
                        <div class="card-body">
                            <h5 class="card-title text-success"><?php echo htmlspecialchars($designer['name']); ?></h5>
                            <p class="card-text"><strong>Profession:</strong> <?php echo htmlspecialchars($designer['profession']); ?></p>
                            <p class="card-text"><strong>Address:</strong> <?php echo htmlspecialchars($designer['address']); ?></p>
                            <p class="card-text"><strong>Experience:</strong> <?php echo htmlspecialchars($designer['experience']); ?> years</p>
                        </div>
                        <div class="card-footer bg-white d-flex justify-content-between">
                            <a href="edit_designer.php?id=<?php echo $designer['_id']; ?>" class="btn btn-edit">✏ Edit</a>
                            <a href="delete_designer.php?id=<?php echo $designer['_id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this designer?');">🗑 Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
