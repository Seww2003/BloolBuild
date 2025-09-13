<?php
session_start();
require '../connection.php'; // MongoDB connection

// Simulate admin session
if(!isset($_SESSION['admin'])){
    $_SESSION['admin'] = 'AdminUser';
}

$collection = $db->instructions;
$msg = '';

// Upload PDF
if(isset($_POST['upload_pdf'])){
    $title = trim($_POST['title']);
    $file = $_FILES['pdf_file'];

    if($file['error'] === 0){
        // Ensure uploads folder exists
        $uploadDir = '../uploads/';
        if(!is_dir($uploadDir)){
            mkdir($uploadDir, 0777, true);
        }

        // Sanitize filename
        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file['name']);
        $target = $uploadDir . $filename;

        if(move_uploaded_file($file['tmp_name'], $target)){
            $collection->insertOne([
                'title' => $title,
                'file_path' => 'uploads/'.$filename,
                'uploaded_by' => $_SESSION['admin'],
                'created_at' => new MongoDB\BSON\UTCDateTime()
            ]);
            $msg = "PDF uploaded successfully!";
        } else {
            $msg = "Failed to upload PDF. Check folder permissions!";
        }
    } else {
        $msg = "No file selected or file upload error.";
    }
}

// Delete PDF
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $pdf = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    if($pdf){
        if(file_exists('../'.$pdf['file_path'])) unlink('../'.$pdf['file_path']);
        $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        $msg = "PDF deleted successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Instructions</title>
<style>
body { font-family:'Segoe UI', sans-serif; background:#f4f7fa; margin:0; padding:0; }
.container { max-width:900px; margin:40px auto; padding:20px; background:#fff; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
h2,h3 { text-align:center; color:#333; }
form { display:flex; flex-wrap:wrap; gap:15px; justify-content:center; margin-bottom:30px; }
form input[type="text"], form input[type="file"] { padding:10px; border-radius:8px; border:1px solid #ccc; }
form button { padding:10px 20px; border:none; background:#28a745; color:white; border-radius:8px; cursor:pointer; transition:0.3s; }
form button:hover { background:#218838; }
.msg { text-align:center; padding:10px; margin-bottom:20px; color:#155724; background:#d4edda; border:1px solid #c3e6cb; border-radius:8px; }
table { width:100%; border-collapse:collapse; margin-top:20px; }
table th, table td { padding:12px 15px; text-align:left; }
table th { background:#007bff; color:white; border-radius:8px; }
table tr:nth-child(even) { background:#f2f2f2; }
a.view-btn, a.delete-btn { padding:6px 12px; border-radius:8px; color:white; text-decoration:none; margin-right:5px; font-size:0.9em; }
a.view-btn { background:#17a2b8; }
a.view-btn:hover { background:#138496; }
a.delete-btn { background:#dc3545; }
a.delete-btn:hover { background:#c82333; }
</style>
</head>
<body>
<div class="container">
    <h2>Manage Instructions</h2>
    <?php if($msg) echo "<div class='msg'>$msg</div>"; ?>

    <form method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Instruction Title" required>
        <input type="file" name="pdf_file" accept="application/pdf" required>
        <button type="submit" name="upload_pdf">Upload PDF</button>
    </form>

    <h3>Uploaded PDFs</h3>
    <table>
        <tr><th>Title</th><th>Actions</th></tr>
        <?php
        $allPDFs = $collection->find();
        foreach($allPDFs as $pdf){
            echo "<tr>
                <td>".htmlspecialchars($pdf['title'])."</td>
                <td>
                    <a class='view-btn' href='../".$pdf['file_path']."' target='_blank'>View</a>
                    <a class='delete-btn' href='?delete=".$pdf['_id']."' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
