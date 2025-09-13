<?php
require 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>BloomBuild- Home</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />



    

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Spinner visible by default */
        #spinner {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1051;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: black;
            width: 100vw;
            height: 100vh;
            transition: opacity 0.3s ease;
        }
        #spinner.hide {
            opacity: 0;
            visibility: hidden;
        }
        .navbar img {
    max-height: 75px; /* Adjust this to match your navbar height */
    width: auto;
}

    </style>


    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Hide spinner after 3 seconds
        setTimeout(function() {
            const spinner = document.getElementById('spinner');
            if (spinner) {
                spinner.classList.add('hide');
                // Optional: remove from DOM after fade out
                setTimeout(() => spinner.style.display = 'none', 300);
            }
        }, 3000);
    </script>








    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Playfair+Display:wght@700;900&display=swap"
        rel="stylesheet"
    />

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
</head>

<body>
    <!-- Spinner Start -->
    <div
        id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center"
    >
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->

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

    <!-- Carousel Start -->
    <div
        id="header-carousel"
        class="carousel slide carousel-fade"
        data-bs-ride="carousel"
        data-bs-interval="5000"
    >
        <div class="carousel-inner">
            <div class="carousel-item active" style="height: 600px">
                <img class="w-100 h-100" src="img/slide2.jpg" alt="Carousel Image 1" style="object-fit: cover" />
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 900px">
                        <h5 class="text-white text-uppercase mb-3 animated slideInDown">Make Sure looking Luxcery</h5>
                        <h1 class="display-1 text-white mb-md-4 animated zoomIn">
                            For your Land
                        </h1>
                        <a href="plantcatalog.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft"
                            >Start Now</a
                        >
                        <a href="contact.php" class="btn btn-outline-light py-md-3 px-md-5 animated slideInRight"
                            >Contact Us</a
                        >
                    </div>
                </div>
            </div>
            <div class="carousel-item" style="height: 600px">
                <img class="w-100 h-100" src="img/slide3.jpg" alt="Carousel Image 2" style="object-fit: cover" />
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 900px">
                        <h5 class="text-white text-uppercase mb-3 animated slideInDown">
                            Discover New Things
                        </h5>
                        <h1 class="display-1 text-white mb-md-4 animated zoomIn">Deam Home Land</h1>
                        <a href="product.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft"
                            >Start Now</a
                        >
                        <a href="contact.php" class="btn btn-outline-light py-md-3 px-md-5 animated slideInRight"
                            >Contact Us</a
                        >
                    </div>
                </div>
            </div>
        </div>
        <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#header-carousel"
            data-bs-slide="prev"
        >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#header-carousel"
            data-bs-slide="next"
        >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- Carousel End -->

  <!-- Features Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4 justify-content-center text-center wow fadeInUp" data-wow-delay="0.1s">

            <!-- Landscape Design -->
            <div class="col-lg-4 col-md-6">
                <div class="bg-light rounded p-4">
                    <i class="fa fa-paint-brush fa-3x text-success mb-4"></i>
                    <br>
                 <h5 class="mb-3"><a class="btn btn-primary rounded-pill py-3 px-5 " href="designers.php">Landscape designers</a></h5>

                    <p>Browse profiles of professional designers and view their past landscaping projects.</p>
                </div>
            </div>

            <!-- Garden & Plant Catalog -->
            <div class="col-lg-4 col-md-6">
                <div class="bg-light rounded p-4">
                    <i class="fa fa-seedling fa-3x text-success mb-4"></i>
                    <h5 class="mb-3"><a class="btn btn-primary rounded-pill py-3 px-5 " href="./plantcatalog/plantcatalog.php">Plant & Garden Catalog</h5></a>
                    <p>Explore a variety of trees, shrubs, flowers, and garden accessories suitable for any space.</p>
                </div>
            </div>

            <!-- Maintenance & Services -->
            <div class="col-lg-4 col-md-6">
                <div class="bg-light rounded p-4">
                    <i class="fa fa-tools fa-3x text-success mb-4"></i>
                    <h5 class="mb-3"><a class="btn btn-primary rounded-pill py-3 px-5" href="./Lawn Care & Services/Lawn Care & Services.php">Lawn Care & Services</h5></a>
                    <p>Schedule lawn mowing, trimming, irrigation, and other landscape maintenance services.</p>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Features End -->

    
     <!-- Video Start -->
    <div class="container-fluid video my-5" >
        <div class="container">
            <div class="row g-0">
                <div class="col-lg-6 py-5 wow fadeIn" data-wow-delay="0.1s">
                    <div class="py-5">
                        <h1 class="display-6 mb-4">Landscaping is the art of <br> harmony and natural beauty</h1>
                        <h5 class="fw-normal lh-base fst-italic text-white mb-5">We create breathtaking landscapes that blend nature’s beauty with modern design, turning every outdoor space into a peaceful retreat</h5>
                        <div class="row g-4 mb-5">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 btn-lg-square bg-white text-primary rounded-circle me-3">
                                        <i class="fa fa-check"></i>
                                    </div>
                                    <span class="text-dark">Expert landscape design</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 btn-lg-square bg-white text-primary rounded-circle me-3">
                                        <i class="fa fa-check"></i>
                                    </div>
                                    <span class="text-dark">Garden maintenance </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 btn-lg-square bg-white text-primary rounded-circle me-3">
                                        <i class="fa fa-check"></i>
                                    </div>
                                    <span class="text-dark">Creative outdoor spaces</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 btn-lg-square bg-white text-primary rounded-circle me-3">
                                        <i class="fa fa-check"></i>
                                    </div>
                                    <span class="text-dark">Sustainable landscaping</span>
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-light rounded-pill py-3 px-5" href="">Explore More</a>
                    </div>
                </div>
                <!-- Play Button -->
<div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
    <div class="h-100 d-flex align-items-center justify-content-center" style="min-height: 300px;">
        <button type="button" class="btn-play" data-bs-toggle="modal" data-bs-target="#videoModal">
            <span></span>
        </button>
    </div>
</div>

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-body p-0">
                <video id="landscapeVideo" class="w-100" controls>
                    <source src="img/ai landscape .mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>

                </div>
            </div>
        </div>
    </div>
    <!-- Video End -->

    <!-- Products Preview Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div
                class="section-title text-center mx-auto wow fadeInUp"
                data-wow-delay="0.1s"
                style="max-width: 600px"
            >
                <p class="fs-5 fw-medium fst-italic text-primary">Our Services </p>
                <h1 class="display-6">Explore Our Best Landscaping designs </h1>
            </div>
            <div class="row g-4">
                <!-- You can replace static content with dynamic PHP fetching from your DB here -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="product-item position-relative bg-light rounded overflow-hidden">
                        <img class="img-fluid w-100" src="img/best01.jpg" alt="Product 1" />
                        <div class="text-center p-4">
                            <h5 class="mb-3">Yard</h5>
                            <p class="mb-0">Refreshing and rich in lawn.</p>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="product-item position-relative bg-light rounded overflow-hidden">
                        <img class="img-fluid w-100" src="img/best03.jpg" alt="Product 2" />
                        <div class="text-center p-4">
                            <h5 class="mb-3">Outdoor</h5>
                            <p class="mb-0"> perfect for any time of day.</p>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="product-item position-relative bg-light rounded overflow-hidden">
                        <img class="img-fluid w-100" src="img/best02.jpg" alt="Product 3" />
                        <div class="text-center p-4">
                            <h5 class="mb-3">Garden</h5>
                            <p class="mb-0">Natural looking and calming.</p>
                          
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="./plantcatalog/plantcatalog.php" class="btn btn-primary rounded-pill py-3 px-5">Make MY One</a>
            </div>
        </div>
    </div>
    <!-- Products Preview End -->

    <!-- Footer Start -->
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

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"
        ><i class="bi bi-arrow-up"></i
    ></a>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
        // Hide spinner after page load
        window.onload = function () {
            const spinner = document.getElementById('spinner');
            if (spinner) {
                spinner.classList.remove('show');
                spinner.style.display = 'none';
            }
        };
    </script>
</body>

</html>
