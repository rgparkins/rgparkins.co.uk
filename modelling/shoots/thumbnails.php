<?php
if (!isset($_GET['src'])) {
    http_response_code(400);
    exit('Missing image source');
}

$imagePath = urldecode($_GET['src']);
$fullPath = realpath($imagePath);

// Security: ensure file is within allowed directory
$baseDir = realpath(__DIR__);
if (strpos($fullPath, $baseDir) !== 0 || !file_exists($fullPath)) {
    http_response_code(403);
    exit('Access denied');
}

$ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
if (!in_array($ext, ['jpg', 'jpeg'])) {
    http_response_code(415);
    exit('Unsupported image format');
}

// Load and rotate image if needed
$img = imagecreatefromjpeg($fullPath);
$exif = @exif_read_data($fullPath);
$orientation = $exif['Orientation'] ?? 1;

switch ($orientation) {
    case 3: $img = imagerotate($img, 180, 0); break;
    case 6: $img = imagerotate($img, -90, 0); break;
    case 8: $img = imagerotate($img, 90, 0); break;
}

// Resize
$maxWidth = 300;
$width = imagesx($img);
$height = imagesy($img);
$ratio = $maxWidth / $width;

$newWidth = $maxWidth;
$newHeight = intval($height * $ratio);

$thumb = imagecreatetruecolor($newWidth, $newHeight);
imagecopyresampled($thumb, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

header('Content-Type: image/jpeg');
imagejpeg($thumb, null, 85);

imagedestroy($img);
imagedestroy($thumb);
?>
