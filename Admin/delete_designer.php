<?php
require '../connection.php';
use MongoDB\BSON\ObjectId;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $db->designers->deleteOne(['_id' => new ObjectId($id)]);
    echo "<script>alert('Designer deleted successfully'); window.location='admin_designers.php';</script>";
}
?>