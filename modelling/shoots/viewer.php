<?php
$dir = isset($_GET['dir']) ? basename($_GET['dir']) : '';
$targetDir = realpath(__DIR__ . '/' . $dir);

// Security check
if (!$dir || !is_dir($targetDir) || strpos($targetDir, __DIR__) !== 0) {
    http_response_code(404);
    echo "Invalid directory.";
    exit;
}

$images = glob($targetDir . "/*.{jpg,jpeg,png,gif,JPG}", GLOB_BRACE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery – <?= htmlspecialchars($dir) ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f7f9fc;
            margin: 0;
            padding: 2rem;
            color: #333;
        }

        h1 {
            text-align: center;
            font-size: 2.2rem;
            color: #222;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .card img:hover {
            transform: scale(1.03);
        }

        .back {
            text-align: center;
            margin-top: 2rem;
        }

        .back a {
            color: #0066cc;
            text-decoration: none;
            font-weight: bold;
        }

        .back a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1><?= htmlspecialchars($dir) ?> Gallery</h1>

<div class="grid">
<?php foreach ($images as $image): 
    $relativePath = $dir . '/' . basename($image);
?>
    <div class="card">
        <a href="<?= htmlspecialchars($relativePath) ?>" data-lightbox="gallery" data-title="<?= htmlspecialchars(basename($image)) ?>">
            <img src="thumbnails.php?src=<?= urlencode($relativePath) ?>" alt="">
        </a>
    </div>
<?php endforeach; ?>
</div>

<div class="back">
    <a href="index.php">&larr; Back to Directory List</a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
</body>
</html>
