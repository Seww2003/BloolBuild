<!-- designer.php -->
<?php include('connection.php'); include('includes/header.php'); include('includes/nav.php'); ?>

<h2>AI Landscaping Designer</h2>

<form id="genForm" enctype="multipart/form-data">
  <label>Upload your yard/garden photo:</label>
  <input type="file" name="image" accept="image/*" required>
  
  <label>Style prompt (ex: “tropical garden, curved stone path, palms”):</label>
  <input type="text" name="prompt" placeholder="tropical modern garden..." required>

  <label>Use selected plants from Catalog? (auto from localStorage)</label>
  <button type="button" id="loadSelected">Load Selected Plants</button>
  <input type="text" name="plants" id="plants" placeholder="Comma-separated plant names">

  <button type="submit">Generate</button>
</form>

<div id="preview"></div>

<script>
document.getElementById('loadSelected').onclick = ()=>{
  const arr = JSON.parse(localStorage.getItem('selectedPlants')||'[]');
  document.getElementById('plants').value = arr.join(', ');
};

document.getElementById('genForm').addEventListener('submit', async (e)=>{
  e.preventDefault();
  const fd = new FormData(e.target);
  const resp = await fetch('http://127.0.0.1:8000/generate', { method:'POST', body: fd });
  if(!resp.ok){ alert('AI error'); return; }
  const data = await resp.json(); // {output_url}
  document.getElementById('preview').innerHTML = `
    <h3>Result</h3>
    <img src="${data.output_url}" style="max-width:100%;border:1px solid #ccc"/>
    <p><a href="${data.output_url}" download>Download Image</a></p>
  `;
});
</script>

<?php include('includes/footer.php'); ?>
