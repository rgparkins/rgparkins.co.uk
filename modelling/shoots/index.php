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
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            background: url('shoots/test-shoot/129B3115.JPG') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            color: #fff;
        }

        /* Dark overlay */
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

        .gallery-title {
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.6);
        }

        .card {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            color: #fff;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.4);
        }

        .card-img-top {
            width: 100%;
            height: auto;
            display: block;
        }

        .album-title {
            font-weight: 600;
            font-size: 1rem;
            margin: 0;
        }

        a.text-decoration-none {
            color: inherit;
        }

        a.text-decoration-none:hover {
            color: #ffd700;
        }

        /* Optional navbar styling */
        .navbar {
            background: rgba(0, 0, 0, 0.4);
        }

        .nav-link {
            color: #fff !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #ffd700 !important;
        }
    </style>
</head>
<body>

    <!-- Optional: Navbar -->
    <nav class="navbar navbar-expand-lg px-4">
        <div class="container-fluid justify-content-end">
            <a class="nav-link" href="/modelling/index.html">Home</a>
        </div>
    </nav>

    <div class="container py-5">
        <h1 class="text-center mb-5 display-5 fw-bold gallery-title">Shoots</h1>
        <div class="row g-4">
            <?php foreach ($directories as $dir): 
                $imgPath = getFirstImage($dir);
                if ($imgPath):
                    $link = basename($dir);
            ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <a href="viewer.php?dir=<?= urlencode($link) ?>" class="text-decoration-none">
                        <div class="card h-100 shadow">
                            <img src="thumbnail.php?src=<?= urlencode($imgPath) ?>" class="card-img-top" alt="<?= htmlspecialchars($link) ?>">
                            <div class="card-body text-center">
                                <p class="album-title"><?= htmlspecialchars($link) ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endif; endforeach; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
