<?php
require 'connection.php'; // MongoDB connection

$success = false; // <-- add this here
$errors = [];     // optional: initialize errors too

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... your existing POST handling code
}



require 'connection.php'; // MongoDB connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $success = false;
    
    // Get form data
    $designer_email = $_POST['designer_email'] ?? '';
    $full_name = $_POST['full_name'] ?? '';
    $address = $_POST['address'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $purpose = $_POST['purpose'] ?? '';
    $description = $_POST['description'] ?? '';
    
    // Validate required fields
    if (empty($full_name)) $errors[] = "Full name is required";
    if (empty($address)) $errors[] = "Address is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($contact_number)) $errors[] = "Contact number is required";
    if (empty($designer_email)) $errors[] = "Designer selection is required";
    
    // Validate email format
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Handle file upload
    $uploaded_file = null;
    if (isset($_FILES['design_image']) && $_FILES['design_image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $file_type = $_FILES['design_image']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            $max_size = 5 * 1024 * 1024; // 5MB
            if ($_FILES['design_image']['size'] <= $max_size) {
                // Read file content for email attachment
                $file_path = $_FILES['design_image']['tmp_name'];
                $file_content = file_get_contents($file_path);
                $file_name = $_FILES['design_image']['name'];
                $uploaded_file = [
                    'content' => $file_content,
                    'name' => $file_name,
                    'type' => $file_type
                ];
            } else {
                $errors[] = "Image size must be less than 5MB";
            }
        } else {
            $errors[] = "Only JPG, PNG, GIF, and WEBP images are allowed";
        }
    }
    
    // If no errors, send email
    if (empty($errors)) {
        // Email headers
        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        
        // Create a boundary for the email
        $boundary = md5(time());
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"\r\n";
        
        // Email subject
        $subject = "New Hiring Request: " . $full_name;
        
        // Email body
        $body = "--" . $boundary . "\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        
        $body .= "You have received a new hiring request:\r\n\r\n";
        $body .= "Client Name: " . $full_name . "\r\n";
        $body .= "Client Address: " . $address . "\r\n";
        $body .= "Client Email: " . $email . "\r\n";
        $body .= "Contact Number: " . $contact_number . "\r\n";
        $body .= "Purpose: " . $purpose . "\r\n";
        $body .= "Description: " . $description . "\r\n";
        
        // Add attachment if exists
        if ($uploaded_file) {
            $body .= "\r\n--" . $boundary . "\r\n";
            $body .= "Content-Type: " . $uploaded_file['type'] . "; name=\"" . $uploaded_file['name'] . "\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n";
            $body .= "Content-Disposition: attachment; filename=\"" . $uploaded_file['name'] . "\"\r\n\r\n";
            $body .= chunk_split(base64_encode($uploaded_file['content'])) . "\r\n";
        }
        
        $body .= "--" . $boundary . "--";
        
        // Send email
        if (mail($designer_email, $subject, $body, $headers)) {
            $success = true;
        } else {
            $errors[] = "Failed to send email. Please try again later.";
        }
    }
}

// Get designer email from query parameter
$designer_email = $_GET['email'] ?? '';
// Fetch designer details for display
if (!empty($designer_email)) {
    $designer = $db->designers->findOne(['email' => $designer_email]);
} else {
    $designer = null;
}

// If no designer found with that email, redirect back
if (!$designer && empty($_POST)) {
    header('Location: designers.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hire a Landscape Designer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            padding-top: 20px;
            padding-bottom: 50px;
        }
        .page-title {
            text-align: center;
            margin: 40px 0;
            color: #2c3e50;
            font-size: 2rem;
            font-weight: bold;
        }
        .form-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        .designer-info {
            background: #e8f5e9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .btn-custom {
            background-color: #27ae60;
            border-color: #27ae60;
            color: white;
            padding: 10px 25px;
            font-weight: 600;
        }
        .btn-custom:hover {
            background-color: #219653;
            border-color: #219653;
            color: white;
        }
        .alert {
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="page-title">Hire a Landscape Designer</h2>
            
            <?php if ($success): ?>
                <div class="alert alert-success text-center">
                    <h4 class="alert-heading">Success!</h4>
                    <p>Your request has been sent successfully to the designer. They will contact you shortly.</p>
                    <a href="designers.php" class="btn btn-success">Back to Designers</a>
                </div>
            <?php else: ?>
                <?php if ($designer): ?>
                    <div class="designer-info">
                        <h4>You're hiring: <?php echo htmlspecialchars($designer['name']); ?></h4>
                        <p class="mb-1"><strong>Profession:</strong> <?php echo htmlspecialchars($designer['profession']); ?></p>
                        <p class="mb-1"><strong>Experience:</strong> <?php echo htmlspecialchars($designer['experience']); ?></p>
                        <p class="mb-0"><strong>Email:</strong> <?php echo htmlspecialchars($designer['email']); ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <h5>Please fix the following errors:</h5>
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="form-container">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="designer_email" value="<?php echo htmlspecialchars($designer_email); ?>">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" 
                                           value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address *</label>
                                    <textarea class="form-control" id="address" name="address" rows="2" required><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_number" class="form-label">Contact Number *</label>
                                    <input type="tel" class="form-control" id="contact_number" name="contact_number" 
                                           value="<?php echo isset($_POST['contact_number']) ? htmlspecialchars($_POST['contact_number']) : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="purpose" class="form-label">Purpose of Hiring</label>
                            <select class="form-select" id="purpose" name="purpose">
                                <option value="">Select a purpose</option>
                                <option value="Residential Garden" <?php echo (isset($_POST['purpose']) && $_POST['purpose'] == 'Residential Garden') ? 'selected' : ''; ?>>Residential Garden</option>
                                <option value="Commercial Landscape" <?php echo (isset($_POST['purpose']) && $_POST['purpose'] == 'Commercial Landscape') ? 'selected' : ''; ?>>Commercial Landscape</option>
                                <option value="Park Design" <?php echo (isset($_POST['purpose']) && $_POST['purpose'] == 'Park Design') ? 'selected' : ''; ?>>Park Design</option>
                                <option value="Other" <?php echo (isset($_POST['purpose']) && $_POST['purpose'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Project Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label for="design_image" class="form-label">Upload Preferred Landscape Design Image (Optional)</label>
                            <input type="file" class="form-control" id="design_image" name="design_image" accept="image/jpeg,image/png,image/gif,image/webp">
                            <div class="form-text">Max file size: 5MB. Accepted formats: JPG, PNG, GIF, WEBP.</div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-custom btn-lg">Submit Request</button>
                            <a href="designers.php" class="btn btn-secondary btn-lg ms-2">Cancel</a>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php

require 'connection.php'; // your MongoDB connection

if(isset($_POST['hire'])){
    // Get designer data
    $designer_id = $_POST['designer_id'];
    $designer_name = $_POST['designer_name'];
    $price = $_POST['price'];

    // Get client info from session
    $client_id = $_SESSION['client_id'];
    $client_name = $_SESSION['client_name'];

    // Prepare order document
    $order = [
        'client_id' => $client_id,
        'client_name' => $client_name,
        'designer_id' => $designer_id,
        'designer_name' => $designer_name,
        'price' => (float)$price,
        'order_date' => new MongoDB\BSON\UTCDateTime()
    ];

    // Insert into orders collection
    $insertResult = $db->orders->insertOne($order);

    if($insertResult->getInsertedCount() > 0){
        header("Location: thankyou.php");
        exit();
    } else {
        echo "Error saving order.";
    }
}
?>
<?php
require 'connection.php'; // MongoDB connection


$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $success = false;
    
    // Get form data
    $designer_email = $_POST['designer_email'] ?? '';
    $full_name = $_POST['full_name'] ?? '';
    $address = $_POST['address'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $purpose = $_POST['purpose'] ?? '';
    $description = $_POST['description'] ?? '';
    
    // Validate required fields
    if (empty($full_name)) $errors[] = "Full name is required";
    if (empty($address)) $errors[] = "Address is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($contact_number)) $errors[] = "Contact number is required";
    if (empty($designer_email)) $errors[] = "Designer selection is required";
    
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // Handle file upload (optional)
    $uploaded_file = null;
    if (isset($_FILES['design_image']) && $_FILES['design_image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $file_type = $_FILES['design_image']['type'];
        if (in_array($file_type, $allowed_types)) {
            $max_size = 5 * 1024 * 1024; // 5MB
            if ($_FILES['design_image']['size'] <= $max_size) {
                $file_path = $_FILES['design_image']['tmp_name'];
                $file_content = file_get_contents($file_path);
                $file_name = $_FILES['design_image']['name'];
                $uploaded_file = [
                    'content' => $file_content,
                    'name' => $file_name,
                    'type' => $file_type
                ];
            } else {
                $errors[] = "Image size must be less than 5MB";
            }
        } else {
            $errors[] = "Only JPG, PNG, GIF, and WEBP images are allowed";
        }
    }

    // If no errors, proceed
    if (empty($errors)) {

        // --- 1. Send Email to Designer ---
        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $boundary = md5(time());
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"\r\n";

        $subject = "New Hiring Request: " . $full_name;

        $body = "--" . $boundary . "\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $body .= "You have received a new hiring request:\r\n\r\n";
        $body .= "Client Name: " . $full_name . "\r\n";
        $body .= "Client Address: " . $address . "\r\n";
        $body .= "Client Email: " . $email . "\r\n";
        $body .= "Contact Number: " . $contact_number . "\r\n";
        $body .= "Purpose: " . $purpose . "\r\n";
        $body .= "Description: " . $description . "\r\n";

        if ($uploaded_file) {
            $body .= "\r\n--" . $boundary . "\r\n";
            $body .= "Content-Type: " . $uploaded_file['type'] . "; name=\"" . $uploaded_file['name'] . "\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n";
            $body .= "Content-Disposition: attachment; filename=\"" . $uploaded_file['name'] . "\"\r\n\r\n";
            $body .= chunk_split(base64_encode($uploaded_file['content'])) . "\r\n";
        }
        $body .= "--" . $boundary . "--";

        if (mail($designer_email, $subject, $body, $headers)) {
            $success = true;
        } else {
            $errors[] = "Failed to send email. Please try again later.";
        }

        // --- 2. Save Request to Orders Collection ---
        // Get client info from session if available
        $client_id = $_SESSION['client_id'] ?? null;
        $client_name = $_SESSION['client_name'] ?? $full_name;

        // Get designer info from DB
        $designer = $db->designers->findOne(['email' => $designer_email]);
        $designer_id = $designer['_id'] ?? null;
        $designer_name = $designer['name'] ?? '';

        $order = [
            'client_id' => $client_id,
            'client_name' => $client_name,
            'designer_id' => $designer_id,
            'designer_name' => $designer_name,
            'client_email' => $email,
            'client_address' => $address,
            'contact_number' => $contact_number,
            'purpose' => $purpose,
            'description' => $description,
            'order_date' => new MongoDB\BSON\UTCDateTime(),
        ];

        $insertResult = $db->orders->insertOne($order);

        if(!$insertResult->getInsertedCount()) {
            $errors[] = "Failed to save order to database.";
            $success = false;
        }
    }
}
?>

