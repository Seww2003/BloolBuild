<?php
session_start();
// After processing upload / AI generate
$_SESSION['generated_image'] = $newFile; // first generated image
header("Location: plantcatalog.php");
exit;

header("Location: plantcatalog.php?generate=1"); // <- important
exit;


// Ensure folders exist
if(!is_dir("uploads")) mkdir("uploads",0777,true);
if(!is_dir("downloads")) mkdir("downloads",0777,true);

if(isset($_FILES['photo']) && isset($_POST['prompt'])){
    $uploadFile = "uploads/" . basename($_FILES['photo']['name']);
    move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile);

    // Simulate AI generate by copying to downloads (or real API here)
    for($i=0;$i<1;$i++){
        $newFile = "downloads/generated_" . time() . "_$i.png";
        copy($uploadFile, $newFile);
    }

    // Redirect to plantcatalog.php with ?generate=1
    header("Location: plantcatalog.php?generate=1");
    exit;
}
?>
<?php

require '../connection.php'; // MongoDB connection

if(!is_dir("uploads")) mkdir("uploads",0777,true);
if(!is_dir("downloads")) mkdir("downloads",0777,true);

if(isset($_FILES['photo']) && isset($_POST['prompt'])){
    $uploadFile = "uploads/" . basename($_FILES['photo']['name']);
    move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile);

    $n = $_POST['n'] ?? 1;
    $generated_files = [];

    for($i=0; $i<$n; $i++){
        $newFile = "downloads/generated_" . time() . "_$i.png";
        copy($uploadFile, $newFile); // replace with real AI output
        $generated_files[] = $newFile;

        // Save to MongoDB
        $collection = $client->your_db_name->landscapes;
        $collection->insertOne([
            'filename' => basename($newFile),
            'filepath' => $newFile,
            'uploaded_at' => new MongoDB\BSON\UTCDateTime(),
            'prompt' => $_POST['prompt'],
            'variations' => (int)$n
        ]);
    }

    // Store first generated image in session for immediate display
    $_SESSION['generated_image'] = $generated_files[0];

    header("Location: plantcatalog.php");
    exit;
} else {
    echo "❌ Upload failed.";
}

