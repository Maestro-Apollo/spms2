<?php
require_once __DIR__.'/../class/ImageTool.php';
require_once __DIR__.'/../class/database.php';

error_reporting(E_ALL);
ini_set('display_errors', TRUE);

$imagesDir = __DIR__.'/../images/';
$wm = __DIR__.'/../static/watermark.png';
$src = $imagesDir.'test/62e78dc11b81c0.96516147.jpg';
$dst = $imagesDir.'test.jpg';

$photos = database::query("SELECT * from photos where image_watermark is null");
while ($photo = mysqli_fetch_assoc($photos)){
    echo $photo['image_id'].'-'.$photo['code'].".";
    $src = $imagesDir . $photo['image'];
    if (file_exists($src)){
        $dst = substr_replace( $photo['image'], '_'.uniqid().'.', strrpos($photo['image'], '.'), 1);
        if (ImageTool::watermark([
            'input' => $src,
            'output' => $imagesDir . $dst,
            'watermark' => $wm,
            'repeat' => true,
            'position' => 'center',
            'opacity' => 20,
        ])){
            database::query("update photos set image_watermark = '$dst' where image_id = {$photo['image_id']}");
            print_r(mysqli_error(database::conn()));
        } else {
            echo 'Wa error! '.print_r(ImageTool::errors());
        }
    }

}
