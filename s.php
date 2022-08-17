<?php
require_once 'main_config.php';
$files = json_decode(file_get_contents(ROOT.'/images/share/'.$_GET['s'].'/session.json'), true);

?>
<html>
<head>
    <title>Photos</title>
    <?php include('layout/style.php'); ?>
</head>
<body>
<section>
    <div class="container">
        <div class="popup-gallery">
            <div class="row">
                <?php foreach ($files as $file) { ?>
                    <div class="col-4 mt-3 mb-3">
                        <a href="./images/<?php echo $file['file']; ?>">
                            <img class="img-fluid fix-img shadow" src="./images/<?php echo $file['file']; ?>" alt=""></a>

                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php include('layout/script.php') ?>
<script src="./magnify/jquery.magnific-popup.min.js"></script>
<script>
    $(document).ready(function() {
        $('.popup-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                titleSrc: function(item) {
                    return item.el.attr('title');
                }
            }
        });
    });
</script>
</body>
</html>