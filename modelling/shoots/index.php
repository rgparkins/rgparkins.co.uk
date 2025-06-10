<?php
$root = './'; // current folder
$directories = array_filter(glob($root . '/*'), 'is_dir');

function getFirstImage($dir) {
    $images = glob("$dir/*.{jpg,jpeg,png,gif,JPG}", GLOB_BRACE);
    return $images ? $images[0] : null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery Directory</title>
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
            font-size: 2.5rem;
            color: #222;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
            padding: 0;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            text-align: center;
            text-decoration: none;
            color: inherit;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
        }

        .card img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .caption {
            padding: 1rem;
            font-size: 1rem;
            font-weight: 500;
            background: #fafafa;
        }
    </style>
</head>
<body>
    <h1>Image Galleries</h1>
    <div class="gallery">
        <?php foreach ($directories as $dir): 
            $imgPath = getFirstImage($dir);
            if ($imgPath):
                $link = basename($dir);
        ?>
            <div class="item">
                <a href="viewer.php?dir=<?=$link?>">
                    <img src="thumbnail.php?src=<?= urlencode($imgPath) ?>" alt="<?= htmlspecialchars($link) ?>">
                </a>
                <div><?= htmlspecialchars($link) ?></div>
            </div>
        <?php endif; endforeach; ?>
    </div>
</body>
</html>
