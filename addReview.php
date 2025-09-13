<?php
require 'connection.php';
session_start();

if (isset($_POST['submit_review'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $service = trim($_POST['service']);
    $message = trim($_POST['message']);
    $rating = intval($_POST['rating']);

    $collection = $db->reviews;

    try {
        $insert = $collection->insertOne([
            'name' => $name,
            'email' => $email,
            'service' => $service,
            'message' => $message,
            'rating' => $rating,
            'submitted_at' => new MongoDB\BSON\UTCDateTime()
        ]);

        if ($insert->getInsertedId()) {
            $success = "Thank you! Your review has been submitted.";
        } else {
            $error = "Oops! Something went wrong. Try again.";
        }

    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Submit Review - BloomBuild</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
/* Body & Background */
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #c9f0f3, #1e3c72);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Form Container */
.review-form-container {
    background: #fff;
    border-radius: 20px;
    padding: 40px;
    width: 100%;
    max-width: 600px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    animation: fadeIn 1s ease-in-out;
}

/* Heading */
.review-form-container h2 {
    color: #1e3c72;
    font-weight: 700;
    text-align: center;
    margin-bottom: 30px;
}

/* Form Inputs */
input.form-control, select.form-control, textarea.form-control {
    border-radius: 10px;
    padding: 12px;
    border: 1px solid #ccc;
    transition: all 0.3s ease;
}

input.form-control:focus, select.form-control:focus, textarea.form-control:focus {
    border-color: #1e3c72;
    box-shadow: 0 0 10px rgba(30, 60, 114, 0.3);
}

/* Submit Button */
button.btn-success {
    background: linear-gradient(45deg, #1e3c72, #2a5298);
    border: none;
    padding: 12px 25px;
    font-weight: 600;
    border-radius: 10px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

button.btn-success:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(30, 60, 114, 0.4);
}

/* Alerts */
.alert {
    border-radius: 10px;
    font-weight: 500;
    text-align: center;
    margin-bottom: 20px;
}

/* Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
</head>
<body>
<div class="review-form-container">
    <h2>Submit a Review</h2>

    <?php if(isset($success)) { echo '<div class="alert alert-success">'.$success.'</div>'; } ?>
    <?php if(isset($error)) { echo '<div class="alert alert-danger">'.$error.'</div>'; } ?>

    <form method="post" id="reviewForm">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Service Interested In</label>
            <select name="service" class="form-control" required>
                <option value="Garden Design">Garden Design</option>
                <option value="Outdoor Landscaping">Outdoor Landscaping</option>
                <option value="Indoor Plants">Indoor Plants</option>
                <option value="Custom Projects">Custom Projects</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Message / Feedback</label>
            <textarea name="message" class="form-control" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label>Rating (1-5)</label>
            <input type="number" name="rating" class="form-control" min="1" max="5" value="5">
        </div>

        <button type="submit" name="submit_review" class="btn btn-success w-100">Submit Review</button>
    </form>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Disable button after submit to prevent multiple clicks
document.getElementById('reviewForm').addEventListener('submit', function() {
    const btn = this.querySelector('button[type="submit"]');
    btn.innerText = 'Submitting...';
    btn.disabled = true;
});
</script>
</body>
</html>
