<?php
require '../connection.php'; 
$collection = $db->landscape_photos;

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $photo = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    if ($photo) {
        if (file_exists("../" . $photo['image'])) {
            unlink("../" . $photo['image']); // consistent delete
        }
        $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        echo "<script>alert('Photo deleted successfully!'); window.location='admin_land.php';</script>";
    }
}

// Handle update
if (isset($_POST['update'])) {
    $id = $_POST['photo_id'];
    $newDesc = trim($_POST['description']);
    $updateData = ["description" => $newDesc];

    if (!empty($_FILES["new_image"]["name"])) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $fileName = time() . "_" . basename($_FILES["new_image"]["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $targetFile)) {
            $relativePath = "uploads/" . $fileName;

            // Remove old image
            $old = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if ($old && file_exists("../" . $old['image'])) unlink("../" . $old['image']);

            $updateData["image"] = $relativePath;
        }
    }

    $collection->updateOne(
        ["_id" => new MongoDB\BSON\ObjectId($id)],
        ['$set' => $updateData]
    );

    echo "<script>alert('Photo updated successfully!'); window.location='admin_land.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin - Manage Landscape Photos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body { background: #f4f7f9; }
        table img { border-radius: 8px; transition: transform 0.3s; }
        table img:hover { transform: scale(1.05); }
        .action-btns a, .action-btns button { margin: 2px; }
    </style>
</head>
<body>
<div class="container my-5">
    <h2 class="text-center text-primary mb-4">🌿 Manage Landscape Photos</h2>
    <table class="table table-bordered text-center table-striped align-middle bg-white shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Image</th>
                <th>Description</th>
                <th>Uploaded At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $photos = $collection->find([], ['sort' => ['_id' => -1]]);
            foreach ($photos as $row):
                $id = (string)$row['_id'];
                $img = "../" . $row['image'];
                $desc = $row['description'];
                $date = $row['created_at']->toDateTime()->format('Y-m-d H:i:s');
            ?>
            <tr>
                <td><img src="<?php echo $img; ?>" width="150" height="100" style="object-fit:cover;"></td>
                <td><?php echo $desc; ?></td>
                <td><?php echo $date; ?></td>
                <td class="action-btns">
                    <a href="admin_land.php?delete=<?php echo $id; ?>" 
                       onclick="return confirm('Delete this photo?')" 
                       class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $id; ?>">
                        <i class="fa fa-edit"></i> Update
                    </button>
                </td>
            </tr>

            <!-- Update Modal -->
            <div class="modal fade" id="updateModal<?php echo $id; ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="POST" enctype="multipart/form-data">
                    <div class="modal-header bg-warning text-white">
                      <h5 class="modal-title">Update Photo</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="photo_id" value="<?php echo $id; ?>">
                      <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" required><?php echo $desc; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label>Replace Image (optional)</label>
                        <input type="file" name="new_image" class="form-control">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" name="update" class="btn btn-success">Save Changes</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
