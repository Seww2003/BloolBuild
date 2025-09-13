<?php
require 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>About Us - BloomBuild Landscaping</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="landscaping, garden design, outdoor decor" name="keywords">
    <meta content="Discover more about BloomBuild, your partner in creative landscaping and sustainable outdoor solutions." name="description">

    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        .navbar img {
            max-height: 75px;
            width: auto;
        }
        .about-section {
            padding: 60px 0;
        }
        .about-img {
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .about-text h2 {
            font-weight: bold;
            color: #2d6a4f;
        }
        .about-text p {
            font-size: 1.1rem;
        }

        .page-header {
    position: relative;
    color: white;
    overflow: hidden;
    height: 400px; /* adjust height as needed */
}

.page-header::before {
    content: "";
    position: absolute;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    background-image: url('img/header.jpg'); /* your image */
    background-size: cover;
    background-position: center;
    filter: blur(5px);       /* only blur the image */
    z-index: 1;
}

.page-header .container {
    position: relative;
    z-index: 2;  /* text stays above blurred background */
}

    </style>
</head>

<body>
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>

    <div class="container-fluid bg-white sticky-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-2 py-lg-0">
                <a href="index.php" class="navbar-brand">
                    <img class="img-fluid" src="img/logoo.png" alt="Logo" /> <b> BloomBuild </b>
                </a>
                <button type="button" class="navbar-toggler ms-auto me-0" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Navbar Start -->
    <div class="container-fluid bg-white sticky-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-2 py-lg-0">
                <a href="index.php" class="navbar-brand">
                    <img class="img-fluid" src="img/logoo.png" alt="Logo" /> <b> BloomBuild </b>
                </a>
                <button
                    type="button"
                    class="navbar-toggler ms-auto me-0"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <a href="./plantcatalog/plantcatalog.php" class="nav-item nav-link">Plant Ctalog</a>
                        <a href="contact.php" class="nav-item nav-link">Contac us</a>
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
                    
                </div>
            </nav>
        </div>
    </div>

    <<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-2 text-dark mb-4 animated slideInDown">About Us</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item text-dark" aria-current="page">About</li>
            </ol>
        </nav>
    </div>
</div>



    <div class="container about-section">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                <img src="img/aboutus.jpg" class="img-fluid about-img" alt="About BloomBuild">
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                <div class="about-text">
                    <h2 class="mb-4">Creative Landscaping with Heart</h2>
                    <p>
                        BloomBuild is your trusted partner in transforming outdoor spaces into inspiring environments. Our team of landscaping professionals blends nature, design, and technology to create sustainable gardens and spaces.
                    </p>
                    <p>
                        Whether you're looking for urban greenery, residential gardens, or commercial landscaping, we offer tailored solutions that reflect your vision.
                    </p>
                    <ul class="list-unstyled mt-4">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i> Residential & Commercial Landscaping</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i> Indoor & Outdoor Plant Design</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i> Eco-friendly & Smart Garden Solutions</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>


    <div class="container-fluid bg-dark text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Our Office</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, Colombo, Sri Lanka</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+94 77 123 4567</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@teahouse.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="about.php">About Us</a>
                    <a class="btn btn-link" href="contact.php">Contact Us</a>
                    <a class="btn btn-link" href="index.php">Home</a>
                    <a class="btn btn-link" href="Land.php">Gallery</a>
                </div>
                <div class="col-lg-6 col-md-6">
                    <h4 class="text-light mb-4">Newsletter</h4>
                    <p>Stay updated with our latest offers, events, and news.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input
                            class="form-control border-0 w-100 py-3 ps-4 pe-5"
                            type="text"
                            placeholder="Your email"
                        />
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">
                            SignUp
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->
</body>

</html>
