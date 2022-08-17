<?php
session_start();
if (isset($_POST['submit'])) {
    $info = getimagesize($_FILES['image']['tmp_name']);
    $name = time() . '_' . $_FILES['image']['name'];

    $target = 'test_file/' . $name;

    if (isset($info['mime'])) {
        if ($info['mime'] == 'image/jpeg') {
            $img = imagecreatefromjpeg($_FILES['image']['tmp_name']);
        } elseif ($info['mime'] == 'image/png') {
            $img = imagecreatefrompng($_FILES['image']['tmp_name']);
        }
        if (isset($img)) {
            $output = 'test_file/' . $name . '.jpg';
            imagejpeg($img, $output, 10);
            echo "Processing Done";
        }
    } else {
        echo "Insert jpg, png";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <style>
    body {
        font-family: 'Lato', sans-serif;

    }

    table.dataTable {
        border-collapse: collapse !important;
    }

    .navbar-brand {
        width: 7%;
    }

    .bg_color {
        background-color: #116530 !important;
    }

    .mark {
        display: none;
    }


    @media (max-width: 575.98px) {

        th,
        td {
            font-size: 10px;
        }

        table {
            width: 10%;
        }
    }

    .hidden-class {
        display: none;
    }

    .show-class {
        color: red;
    }
    </style>

</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>

    <form action="" method="post" enctype="multipart/form-data">
        <section>
            <input type="file" name="image">
            <input type="submit" name="submit">
        </section>
    </form>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>
    <script src="js/datepicker.js"></script>


    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: false,
            dom: 'Bfrtip',
            "ordering": false,
            buttons: [{
                    extend: 'copy',
                    footer: true
                },
                {
                    extend: 'excel',
                    footer: true
                },

                {
                    extend: 'print',
                    footer: true
                }
            ],
            "pageLength": 50

        });
    });
    </script>
    <script>
    let changeBtn = document.getElementById('btn');
    changeBtn.addEventListener('click', () => {
        var elements = document.getElementsByClassName('show-class');
        for (var i in elements) {
            if (elements.hasOwnProperty(i)) {
                elements[i].className = 'hidden-class';
            }
        }
    })
    </script>

</body>

</html>