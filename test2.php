<?php

if (isset($_POST['submit'])) {
    $szFiles = sizeof($_FILES['item']['name']['image2']);

    echo $szFiles;



    for ($i = 0; $i < $szFiles; $i++) {
        $file_name   = $_FILES['item']['name']['image2'][$i];
        if ($_FILES['item']['name']['image2'][$i] == '') {
            echo 'empty';
        }
        echo $file_name . '<br>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="item[image2][]" multiple>

        <input type="submit" name="submit">
    </form>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- <script>
    $(document).ready(function() {
        $('#code').on('input', function() {
            let myCode = $('#code').val();
            $('#output').empty();

            let string = '';
            for (let i = 1; i <= myCode; i++) {
                string += `${i}<br>`;
            }
            $('#output').append(string);
        });
    });
    </script> -->
</body>

</html>