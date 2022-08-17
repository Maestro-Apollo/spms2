<?php
include 'include/auth.php';
require_once 'class/PhotoManager.php';
require_once 'class/SavePhotoManager.php';
require_once 'class/EditPhotoManager.php';
$pm = new PhotoManager();
$session = $pm->new_session('share');
if (!empty($_COOKIE['share-list'])){
    $list = json_decode($_COOKIE['share-list'], true);
    foreach ($list as $file){
        $pm->files[] = [
            'name' => $file,
            'file' => $file,
        ];
    }
}
$pm->save_session();
$hash = explode('/', $session)[1];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    include('layout/style.php');
    echo $pm->render_css();
    ?>
    <link rel="stylesheet" href="./magnify/magnific-popup.css">
    <style>
        .filepond--drop-label {
            display: none;
        }
    </style>
</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>
    <?php include('layout/script.php') ?>
    <section>
        <a class="btn btn-block font-weight-bold log_btn btn-lg mt-4" href="whatsapp://send?text=https://<?php echo $_SERVER['HTTP_HOST'].SUBFOLDER ?>/s.php?s=<?php echo $hash ?>"
           onclick="Cookies.set('share-list', JSON.stringify([]));">Share</a>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php
                    echo $pm->render_input();
                    echo $pm->render_scripts();
                    ?>
                </div>
            </div>
        </div>
    </section>
    <section>
        <a class="btn btn-block font-weight-bold log_btn btn-lg mt-4" href="whatsapp://send?text=https://<?php echo $_SERVER['HTTP_HOST'].SUBFOLDER ?>/s.php?s=<?php echo $hash ?>"
        onclick="Cookies.set('share-list', JSON.stringify([]));">Share</a>
    </section>

</body>

</html>