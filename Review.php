<?php
require 'connection.php';
session_start();

// Check if form submitted
if (isset($_POST['submit_quote'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $service = trim($_POST['service']);
    $message = trim($_POST['message']);
    $rating = intval($_POST['rating']);

    $collection = $db->quotes; // MongoDB collection

    $insert = $collection->insertOne([
        'name' => $name,
        'email' => $email,
        'service' => $service,
        'message' => $message,
        'rating' => $rating,
        'submitted_at' => new MongoDB\BSON\UTCDateTime()
    ]);

    if ($insert->getInsertedId()) {
        $success = "Thank you! Your request has been submitted successfully.";
    } else {
        $error = "Oops! Something went wrong. Try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Request a Quote & Review - BloomBuild Landscaping</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font & Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">

<!-- Custom CSS -->
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #d4f1f4, #1e3c72);
    min-height: 100vh;
}
.navbar img { max-height: 75px; width: auto; }

/* Quote Form Styles */
.quote-form-container {
    background: #fff;
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 600px;
    margin: 50px auto;
}
h2 { color: #1e3c72; font-weight: 700; margin-bottom: 30px; text-align: center; }
.form-label { font-weight: 600; color: #333; }
input.form-control, select.form-control, textarea.form-control {
    border-radius: 10px;
    padding: 12px;
    border: 1px solid #ccc;
    transition: all 0.3s ease;
}
input.form-control:focus, select.form-control:focus, textarea.form-control:focus {
    border-color: #1e3c72;
    box-shadow: 0 0 8px rgba(30, 60, 114, 0.3);
}
button.btn-success {
    background: linear-gradient(45deg, #1e3c72, #2a5298);
    border: none;
    padding: 12px 25px;
    font-weight: 600;
    border-radius: 10px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
button.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(30, 60, 114, 0.4);
}
.alert { border-radius: 10px; font-weight: 500; text-align: center; }
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
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="./plantcatalog/plantcatalog.php" class="nav-item nav-link">Plant Catalog</a>
                    <a href="contact.php" class="nav-item nav-link">Contact Us</a>
                    <a href="about.php" class="nav-item nav-link">About</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Gallery</a>
                        <div class="dropdown-menu bg-light rounded-0 m-0">
                            <a href="Land.php" class="dropdown-item active">Land</a>
                            <a href="Review.php" class="dropdown-item">Reviews</a>
                            <a href="indoor.php" class="dropdown-item">Indoor</a>
                            <a href="outdoor.php" class="dropdown-item">Outdoor</a>
                        </div>
                    </div>
                    <a href="user_login.php" class="nav-item nav-link">Login</a>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->

<<!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-2 text-dark mb-4 animated slideInDown">Land Reviews & Requests</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item text-dark" aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
<!-- Quote / Review Form Start -->
<div class="quote-form-container">
    <h2>Request a Quote & Leave Feedback</h2>

    <?php if(isset($success)) { echo '<div class="alert alert-success">'.$success.'</div>'; } ?>
    <?php if(isset($error)) { echo '<div class="alert alert-danger">'.$error.'</div>'; } ?>

    <form method="post" id="quoteForm">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Service Interested In</label>
            <select name="service" class="form-control" required>
                <option value="Garden Design">Garden Design</option>
                <option value="Outdoor Landscaping">Outdoor Landscaping</option>
                <option value="Indoor Plants">Indoor Plants</option>
                <option value="Custom Projects">Custom Projects</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Message / Feedback</label>
            <textarea name="message" class="form-control" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Rating (1-5)</label>
            <input type="number" name="rating" class="form-control" min="1" max="5" value="5">
        </div>

        <button type="submit" name="submit_quote" class="btn btn-success w-100">Submit</button>
    </form>
</div>
<!-- Quote / Review Form End -->

<!-- Footer Start -->
<?php include('includes/footer.php'); ?>
<!-- Footer End -->

<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top">
    <i class="bi bi-arrow-up"></i>
</a>

<!-- JS Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
const form = document.getElementById('quoteForm');
form.addEventListener('submit', function() {
    const btn = form.querySelector('button[type="submit"]');
    btn.innerText = 'Submitting...';
    btn.disabled = true;
});
</script>
</body>
</html>
