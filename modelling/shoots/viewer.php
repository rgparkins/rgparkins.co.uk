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
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            background: url('shoots/test-shoot/129B3115.JPG') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.6);
            z-index: -1;
        }

        .container {
            z-index: 2;
        }

        h1 {
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
            margin-top: 2rem;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.5);
        }

        .card-glass {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.2s ease;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .card-glass:hover {
            transform: scale(1.03);
        }

        .card-glass img {
            width: 100%;
            height: auto;
            display: block;
        }

        .back-link {
            text-align: center;
            margin: 3rem 0 2rem;
        }

        .back-link a {
            color: #ffd700;
            font-weight: 600;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
            color: #f5c400;
        }
    </style>
</head>
<body>

    <div class="container py-4">
        <h1><?= htmlspecialchars($dir) ?> Gallery</h1>

        <div class="row g-4 mt-4">
            <?php foreach ($images as $image): 
                $relativePath = $dir . '/' . basename($image);
            ?>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="<?= htmlspecialchars($relativePath) ?>" class="glightbox text-decoration-none" data-gallery="gallery" data-title="<?= htmlspecialchars(basename($image)) ?>">
                    <div class="card-glass">
                        <img src="thumbnails.php?src=<?= urlencode($relativePath) ?>" alt="<?= htmlspecialchars(basename($image)) ?>">
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="back-link">
            <a href="index.php">&larr; Back to Directory List</a>
        </div>
    </div>

    <!-- Lightbox & Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        const lightbox = GLightbox({
            selector: '.glightbox'
        });
    </script>
</body>
</html>
