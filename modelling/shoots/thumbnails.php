<?php
if (!isset($_GET['src']) || !isset($_GET['w'])) {
    http_response_code(400);
    exit('Missing parameters');
}

$src = $_GET['src'];
$width = (int)$_GET['w'];

if (!file_exists($src)) {
    http_response_code(404);
    exit('Image not found');
}

$info = getimagesize($src);
$type = $info[2];

// Load image
switch ($type) {
    case IMAGETYPE_JPEG:
        $image = imagecreatefromjpeg($src);
        $exif = @exif_read_data($src);
        if ($exif && isset($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 3:
                    $image = imagerotate($image, 180, 0);
                    break;
                case 6:
                    $image = imagerotate($image, -90, 0);
                    break;
                case 8:
                    $image = imagerotate($image, 90, 0);
                    break;
                // other cases not needed for most uses
            }
        }
        break;
    case IMAGETYPE_PNG:
        $image = imagecreatefrompng($src);
        break;
    case IMAGETYPE_GIF:
        $image = imagecreatefromgif($src);
        break;
    case IMAGETYPE_WEBP:
        $image = imagecreatefromwebp($src);
        break;
    default:
        http_response_code(415);
        exit('Unsupported image type');
}

$origWidth = imagesx($image);
$origHeight = imagesy($image);
$newHeight = intval($origHeight * $width / $origWidth);

// Resize
$thumb = imagecreatetruecolor($width, $newHeight);
imagecopyresampled($thumb, $image, 0, 0, 0, 0, $width, $newHeight, $origWidth, $origHeight);

// Output
header('Content-Type: image/jpeg');
imagejpeg($thumb, null, 85);
imagedestroy($image);
imagedestroy($thumb);
?>