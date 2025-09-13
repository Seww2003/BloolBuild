<?php require 'connection.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BloomBuild Gallery - Land</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Inline CSS for 3D Cards -->
    <style>
        /* 3D Cards Section */
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 50px;
            padding: 50px 0;
            background: #f8f9fa;
        }

        .card {
            --card-height: 300px;
            --card-width: calc(var(--card-height) * 1.5);
            width: var(--card-width);
            height: var(--card-height);
            position: relative;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            padding: 0 20px;
            perspective: 1500px;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .wrapper {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
            border-radius: 10px;
            transition: all 0.5s;
        }

        .cover-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .card:hover .wrapper {
            transform: perspective(900px) translateY(-5%) rotateX(20deg) translateZ(0);
            box-shadow: 2px 25px 35px rgba(0, 0, 0, 0.7);
        }

        .wrapper::before,
        .wrapper::after {
            content: "";
            position: absolute;
            left: 0;
            width: 100%;
            border-radius: 10px;
            transition: all 0.5s;
        }

        .wrapper::before {
            top: 0;
            height: 100%;
            background: linear-gradient(to top, transparent 40%, rgba(0, 0, 0, 0.5) 70%, rgba(0, 0, 0, 0.7) 100%);
        }

        .wrapper::after {
            bottom: 0;
            height: 80px;
            background: linear-gradient(to bottom, transparent 40%, rgba(0, 0, 0, 0.5) 70%, rgba(0, 0, 0, 0.7) 100%);
        }

        .card:hover .wrapper::after {
            height: 120px;
        }

        .title {
            width: 100%;
            transition: transform 0.5s;
        }

        .card:hover .title {
            transform: translate3d(0, -50px, 100px);
        }

        .character {
            width: 100%;
            position: absolute;
            opacity: 0;
            z-index: -1;
            transition: all 0.5s;
        }

        .card:hover .character {
            opacity: 1;
            transform: translate3d(0, -30%, 100px);
        }

        a.card-link {
            text-decoration: none;
        }
        {}
        .navbar img {
    max-height: 75px; /* Adjust this to match your navbar height */
    width: auto;
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    <div class="container-fluid bg-white sticky-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-2 py-lg-0">
                <a href="index.php" class="navbar-brand">
                    <img class="img-fluid" src="img/logoo.png" alt="Logo" /> <b> BloomBuild </b>
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
                                <a href="outdoor.php" class="dropdown-item">Outdoor</a>
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

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-2 text-dark mb-4 animated slideInDown">Land Gallery</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item text-dark" aria-current="page">Gallery</li>
                    <li class="breadcrumb-item text-dark" aria-current="page">Land</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- 3D Cards Section Start -->
    <div class="cards-container">
        <a href="#" class="card-link">
            <div class="card">
                <div class="wrapper">
                    <img src="img/coverland3D.jpeg" class="cover-image" />
                </div>
                <img src="img/title.png" class="title" />
                <img src="img/house3.jpg" class="character" />
            </div>
        </a>

        <a href="#" class="card-link">
            <div class="card">
                <div class="wrapper">
                    <img src="img/coverland3D.jpeg" class="cover-image" />
                </div>
                <img src="img/title.png" class="title" />
                <img src="img/house.png" class="character" />
            </div>
        </a>

        <a href="#" class="card-link">
            <div class="card">
                <div class="wrapper">
                    <img src="img/coverland3D.jpeg" class="cover-image" />
                </div>
                <img src="img/title.png" class="title" />
                <img src="img/house2.png" class="character" />
            </div>
        </a>
        <!-- Add more cards as needed -->
    </div>
    <!-- 3D Cards Section End -->

    <!-- Footer Start -->
    <?php include('includes/footer.php'); ?>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top">
        <i class="bi bi-arrow-up"></i>
    </a>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
</html>
