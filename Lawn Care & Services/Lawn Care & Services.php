<?php
require '../connection.php';
$collection = $db->instructions;
$allPDFs = $collection->find();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lawn Care & Services Instructions</title>
<style>
body { font-family:'Segoe UI', sans-serif; background:#f4f7fa; margin:0; padding:0; }
.container { max-width:1200px; margin:40px auto; padding:20px; }
h2 { text-align:center; color:#333; margin-bottom:30px; }
.card-grid { display:flex; flex-wrap:wrap; gap:20px; justify-content:center; }
.card { background:#fff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); width:260px; padding:20px; text-align:center; transition:0.3s; }
.card:hover { transform:translateY(-5px); box-shadow:0 8px 20px rgba(0,0,0,0.15); }
.card h4 { font-size:1.1em; margin-bottom:15px; color:#007bff; }
.card a { display:inline-block; margin:8px 0; padding:10px 15px; border-radius:8px; text-decoration:none; font-size:0.95em; transition:0.3s; }
.view-btn { background:#17a2b8; color:#fff; }
.view-btn:hover { background:#138496; }
.download-btn { background:#28a745; color:#fff; }
.download-btn:hover { background:#218838; }
</style>
</head>
<body>
<div class="container">
    <h2>Lawn Care & Services Instructions</h2>
    <div class="card-grid">
        <?php foreach($allPDFs as $pdf): ?>
            <div class="card">
                <h4><?= htmlspecialchars($pdf['title']); ?></h4>
                <a class="view-btn" href="/BloomBuild/<?= htmlspecialchars($pdf['file_path']); ?>" target="_blank">View PDF</a>
                <a class="download-btn" href="/BloomBuild/<?= htmlspecialchars($pdf['file_path']); ?>" download>Download PDF</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
