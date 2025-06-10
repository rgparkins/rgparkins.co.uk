<?
$imageDir = $_GET['shoot'];
$thumbWidth = 150;

$images = glob($imageDir . '*.{JPG,jpg,jpeg,png,gif,webp}', GLOB_BRACE);

echo "<!DOCTYPE html>
<html>
<head>
    <title>rgparkins modelling</title>
    <style>
        body { font-family: sans-serif; background: #111; color: #eee; margin: 0; padding: 20px; }
        .gallery { display: flex; flex-wrap: wrap; gap: 10px; }
        .thumbnail img { border: 2px solid #333; border-radius: 4px; cursor: pointer; transition: 0.3s; }
        .thumbnail img:hover { border-color: #0ff; }
        .lightbox {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.9); align-items: center; justify-content: center;
        }
        .lightbox img { max-width: 90%; max-height: 90%; border: 4px solid white; border-radius: 8px; }
        .lightbox:target { display: flex; }
    </style>
</head>
<body>
    <h1>30/05/2025 - test shoot</h1>
    <div class='gallery'>";

foreach ($images as $image) {
    $encoded = urlencode($image);
    echo "<a class='thumbnail' href='#lightbox' data-img='{$image}'>
            <img src='thumbnails.php?src={$encoded}&w={$thumbWidth}' alt=''>
          </a>";
}

echo "</div>

<div id='lightbox' class='lightbox' onclick='this.style.display=\"none\"'>
    <img id='lightbox-img' src=''>
</div>

<script>
    document.querySelectorAll('.thumbnail').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('lightbox-img').src = this.getAttribute('data-img');
            document.getElementById('lightbox').style.display = 'flex';
        });
    });
</script>
</body>
</html>";
?>
