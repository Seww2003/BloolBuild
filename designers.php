<?php
require 'connection.php'; // MongoDB connection
$designers = $db->designers->find([], ['sort' => ['created_at' => -1]]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Landscape Designers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .page-title {
            text-align: center;
            margin: 40px 0;
            color: #2c3e50;
            font-size: 2rem;
            font-weight: bold;
        }
        .designer-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            background: #fff;
        }
        .designer-card img {
            height: 220px;
            width: 100%;
            object-fit: cover;
        }
        .designer-card:hover {
            transform: translateY(-5px);
        }
        .designer-info {
            padding: 20px;
        }
        .designer-info h5 {
            color: #27ae60;
            margin-bottom: 8px;
        }
        .designer-info p {
            margin: 0;
            color: #555;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="page-title">Meet Our Landscape Designers</h2>
    <div class="row g-4">
        <?php foreach ($designers as $designer): ?>
            <div class="col-md-4 col-sm-6">
                <div class="designer-card">
                    <img src="<?php echo $designer['image']; ?>" alt="<?php echo $designer['name']; ?>">
                    <div class="designer-info">
                        <h5><?php echo $designer['name']; ?></h5>
                        <p><strong>Profession:</strong> <?php echo $designer['profession']; ?></p>
                        <p><strong>Address:</strong> <?php echo $designer['address']; ?></p>
                        <p><strong>Experience:</strong> <?php echo $designer['experience']; ?></p>
                        <!-- Fixed Hire button with proper PHP syntax -->
                        <h5 class="mb-3">
                            <a class="btn btn-primary rounded-pill py-3 px-5" 
                               href="hire.php?email=<?php echo urlencode($designer['email']); ?>">
                                Hire
                            </a>
                        </h5>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>