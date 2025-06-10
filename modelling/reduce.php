<?php
function correctOrientation($image, $imagePath) {
    if (!function_exists('exif_read_data')) return $image;

    $exif = @exif_read_data($imagePath);
    if (!$exif || !isset($exif['Orientation'])) return $image;

    $orientation = $exif['Orientation'];

    switch ($orientation) {
        case 2: // flipped horizontally
            imageflip($image, IMG_FLIP_HORIZONTAL);
            break;
        case 3: // rotated 180
            $image = imagerotate($image, 180, 0);
            break;
        case 4: // flipped vertically
            imageflip($image, IMG_FLIP_VERTICAL);
            break;
        case 5: // vertical flip + rotate 90 CW
            imageflip($image, IMG_FLIP_VERTICAL);
            $image = imagerotate($image, -90, 0);
            break;
        case 6: // rotated 90 CW
            $image = imagerotate($image, -90, 0);
            break;
        case 7: // horizontal flip + rotate 90 CW
            imageflip($image, IMG_FLIP_HORIZONTAL);
            $image = imagerotate($image, -90, 0);
            break;
        case 8: // rotated 90 CCW
            $image = imagerotate($image, 90, 0);
            break;
    }

    return $image;
}

$directory = 'shoots/test-shoot';
$scale = 0.9;

$images = glob($directory . "/*.{jpg,jpeg,png,JPG,JPEG,PNG}", GLOB_BRACE);

foreach ($images as $imagePath) {
    $info = pathinfo($imagePath);

    if (strpos($info['filename'], '_reduced') !== false) continue;

    $ext = strtolower($info['extension']);
    $newName = $info['dirname'] . '/' . $info['filename'] . '_reduced.' . $ext;

    switch ($ext) {
        case 'jpg':
        case 'jpeg':
            $src = imagecreatefromjpeg($imagePath);
            $src = correctOrientation($src, $imagePath);
            break;
        case 'png':
            $src = imagecreatefrompng($imagePath);
            break;
        default:
            echo "Unsupported format: $imagePath\n";
            continue 2;
    }

    $width = imagesx($src);
    $height = imagesy($src);
    $newWidth = (int)($width * $scale);
    $newHeight = (int)($height * $scale);

    $dst = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    switch ($ext) {
        case 'jpg':
        case 'jpeg':
            imagejpeg($dst, $newName, 85);
            break;
        case 'png':
            imagepng($dst, $newName);
            break;
    }

    imagedestroy($src);
    imagedestroy($dst);

    echo "Reduced (with orientation): $imagePath → $newName\n";
}
?>