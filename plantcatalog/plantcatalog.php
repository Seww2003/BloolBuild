<?php
session_start();
require '../connection.php'; // MongoDB connection
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Plant Catalog + AI Generator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:"Segoe UI",Arial,sans-serif;background:#f5f7fb;color:#333;line-height:1.6;display:flex}

    /* Sidebar */
    .sidebar{
      width:230px;
      background:#8CB34A;
      color:#fff;
      height:100vh;
      position:fixed;
      top:0;left:0;
      padding:20px 0;
      box-shadow:2px 0 10px rgba(0,0,0,.1);
    }
    .sidebar .logo{
      display:flex;align-items:center;gap:10px;
      font-weight:bold;font-size:20px;
      padding:0 20px;margin-bottom:30px;
    }
    .sidebar .logo img{width:40px;height:auto}
    .sidebar a{
      display:block;
      padding:12px 20px;
      color:#fff;
      text-decoration:none;
      transition:.3s;
      font-size:15px;
    }
    .sidebar a:hover,
    .sidebar a.active{background: #319613ff;;border-radius:8px}

    /* Page content */
    .content{
      margin-left:230px;
      flex:1;
      padding:20px;
    }

    header{background:#8CB34A;color:#fff;padding:20px;text-align:center;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.2);margin-bottom:20px}
    header h1{font-size:26px;margin:0}

    /* Filter form */
    form.filters{display:flex;flex-wrap:wrap;gap:12px;background:#fff;padding:15px;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,.05);margin-bottom:25px}
    form.filters input, form.filters select{padding:10px;border:1px solid #ccc;border-radius:8px;flex:1;min-width:150px;font-size:14px}
    form.filters button{padding:10px 18px;background:#8CB34A;color:#fff;border:none;border-radius:8px;cursor:pointer;transition:.3s}
    form.filters button:hover{background:#21867a}

    /* Upload box */
    .box{background:#fff;padding:24px;border-radius:16px;box-shadow:0 6px 20px rgba(0,0,0,.1);margin-bottom:30px;animation:fadeIn .8s ease}
    .box h2{margin-bottom:12px;color:#8CB34A}
    .box input[type="file"], .box input[type="text"], .box select{width:100%;padding:10px;margin:8px 0;border:1px solid #ccc;border-radius:8px}
    .box button{margin-top:10px;padding:12px 20px;background:#e76f51;color:#fff;font-weight:bold;border:none;border-radius:10px;cursor:pointer;transition:.3s}
    .box button:hover{background:#d65c3b}

    /* Gallery */
    .gallery{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-top:18px}
    .thumb{position:relative;overflow:hidden;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.1);transition:.3s}
    .thumb img{width:100%;display:block;transition:.4s}
    .thumb:hover img{transform:scale(1.05)}
    .thumb a.download-btn{position:absolute;bottom:8px;right:8px;background:rgba(0,0,0,.6);color:#fff;padding:6px 12px;border-radius:6px;font-size:12px;text-decoration:none;opacity:0;transition:.3s}
    .thumb:hover a.download-btn{opacity:1}

    @keyframes fadeIn{from{opacity:0;transform:translateY(15px)}to{opacity:1;transform:translateY(0)}}
  </style>
</head>
<body>

<div class="sidebar">
  <div class="logo">
    
    BloomBuild
  </div>
  <a href="../index.php">🏠 Home</a>
  <a href="./plantcatalog/plantcatalog.php"  class="active">🌱 Plant Catalog</a>
  <a href="../contact.php">📧 Contact Us</a>
  <a href="../about.php">ℹ️ About</a>
  <a href="../Land.php">🖼️ Gallery </a>

  <a href="../user_login.php">👤 Login</a>
</div>

<div class="content">
  <header>
    <h1>🌿 Plant Catalog & AI Landscape Generator</h1>
  </header>

  <h2>Plant Catalog Filters</h2>
  <form method="get" class="filters">
    <input type="text" name="q" placeholder="🔍 Search name or tag" />
    <select name="type">
      <option value="">All Types</option>
      <option>Shrub</option><option>Tree</option><option>Flower</option><option>Grass</option>
    </select>
    <select name="sun">
      <option value="">Any Sun</option>
      <option>Full Sun</option><option>Partial Shade</option><option>Full Shade</option>
    </select>
    <button type="submit">Apply Filters</button>
  </form>

  <div class="box">
    <h2>Upload a Photo (Room / Garden / Empty Space)</h2>
    <form action="process.php" method="post" enctype="multipart/form-data">
      <input type="file" name="photo" accept="image/*" required>
      <label>Prompt (e.g. "lush tropical garden with stone path, morning light")</label>
      <input type="text" name="prompt" value="Add a tasteful landscaped garden with plants and stepping stones" />
      <label>Variations</label>
      <select name="n">
        <option value="3">3</option>
        <option value="4" selected>4</option>
      </select>
      <button type="submit"> Generate</button>
    </form>
  </div>

  <h2>Previously Generated Landscapes</h2>
<div class="gallery">
  <?php
  // Display images from example_generated folder
  $files = glob('example_generated/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
  rsort($files);
  foreach(array_slice($files,0,12) as $f){
    echo '<div class="thumb">
            <img src="'.$f.'" alt="">
            <a href="'.$f.'" download class="download-btn">⬇ Download</a>
          </div>';
  }
  
// Fetch generated images from MongoDB
$collection = $client->your_db_name->landscapes;
$cursor = $collection->find([], ['sort'=>['_id'=>-1], 'limit'=>12]);

foreach($cursor as $doc){
    echo '<div class="thumb">
            <img src="'.$doc['filepath'].'" alt="">
            <a href="'.$doc['filepath'].'" download class="download-btn">⬇ Download</a>
          </div>';
}
?>
 
</div>

</div>
  </div>
</div>

</body>
</html>
