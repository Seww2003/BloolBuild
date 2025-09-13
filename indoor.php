<?php
require 'connection.php'; // MongoDB connection ($db variable)

$collection = $db->landscape_photos; // Collection name

// Handle upload form
if (isset($_POST['upload'])) {
    $desc = trim($_POST['description']);

    // ✅ consistent upload path for both admin and indoor.php
    $targetDir = "uploads/"; 
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = time() . "_" . basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $collection->insertOne([
            "image" => $targetFile,
            "description" => $desc,
            "created_at" => new MongoDB\BSON\UTCDateTime()
        ]);
        echo "<script>alert('Photo uploaded successfully!'); window.location='indoor.php';</script>";
    } else {
        echo "<script>alert('Error uploading file!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Indoor Gallery - BloomBuild</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="img/favicon.ico" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        .navbar img { max-height: 75px; width: auto; }
        .card-img-top { height: 200px; object-fit: cover; }
        .product-item img { height: 250px; object-fit: cover; width: 100%; }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    <div class="container-fluid bg-white sticky-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-2 py-lg-0">
                <a href="index.php" class="navbar-brand">
                    <img class="img-fluid" src="img/logoo.png" alt="Logo" /> <b>BloomBuild</b>
                </a>
                <button type="button" class="navbar-toggler ms-auto me-0" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <a href="./plantcatalog/plantcatalog.php" class="nav-item nav-link">Plant Catalog</a>
                        <a href="contact.php" class="nav-item nav-link">Contact Us</a>
                        <a href="about.php" class="nav-item nav-link">About</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Gallery</a>
                            <div class="dropdown-menu bg-light rounded-0 m-0">
                                <a href="Land.php" class="dropdown-item">Land</a>
                                <a href="Review.php" class="dropdown-item">Reviews</a>
                                <a href="indoor.php" class="dropdown-item">Indoor</a>
                            </div>
                        </div>
                        <a href="user_login.php" class="nav-item nav-link">Login</a>
                    </div>
                    <div class="border-start ps-4 d-none d-lg-block">
                        <button type="button" class="btn btn-sm p-0"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Page Header -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-2 text-dark mb-4 animated slideInDown">Indoor Gallery</h1>
        </div>
    </div>

    <!-- Upload Form -->
    <div class="container my-5">
        <h2 class="text-center text-primary">Upload Indoor Landscape Photo</h2>
        <form action="" method="POST" enctype="multipart/form-data" class="p-4 shadow rounded bg-light col-md-8 mx-auto">
            <div class="mb-3">
                <label class="form-label">Select Image</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" name="upload" class="btn btn-primary w-100">Upload</button>
        </form>
    </div>

    <!-- Photos Section -->
    <div class="container-fluid product py-5">
        <div class="container py-5">
            <div class="section-title text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="fs-5 fw-medium fst-italic text-primary">Our Indoor Landscapes</p>
                <h1 class="display-6">See how we transform interiors beautifully</h1>
            </div>
            <div class="owl-carousel product-carousel wow fadeInUp" data-wow-delay="0.5s">
                <?php
                $photos = $collection->find([], ['sort' => ['_id' => -1]]);
                foreach ($photos as $row) {
                    $img = $row['image'];
                    $desc = $row['description'];
                    echo "
                    <a href='#' class='d-block product-item rounded'>
                        <img src='$img' alt='Indoor Photo'>
                        <div class='bg-white shadow-sm text-center p-4 position-relative mt-n5 mx-4'>
                            <h4 class='text-primary'>Indoor Design</h4>
                            <span class='text-body'>$desc</span>
                        </div>
                    </a>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="container-fluid bg-dark footer py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5 text-white text-center">
            <p>&copy; BloomBuild. All Rights Reserved.</p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
