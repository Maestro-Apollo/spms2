<?php
$original = './IMG_20220621_210115.jpg';
$exif_data  = exif_read_data($original);
$org = orientation($exif_data);
$deg = orientationFlag($org);

// print '<pre>';
// print_r($exif_data);
// print '</pre>';

function orientation($orientation)
{
    foreach ($orientation as $key => $value) {
        if (strtolower($key) == 'orientation') {
            return $value;
        }
    }
}

function orientationFlag($flag)
{
    switch ($flag) {
        case 1:
            return 0;
        case 8:
            return 90;
        case 3:
            return 180;
        case 6:
            return 270;

        default:
            # code...
            break;
    }
}

print '<pre>';
print_r($deg);
print '</pre>';