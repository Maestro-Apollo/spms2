<?php
session_start();


// $name = "'" . $_SESSION['name2'] . "'";
// echo $name;
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
            background-color: #274472 !important;
        }

        /* th,
    td {
        font-size: 10px;
    } */
    </style>
    <?php if (isset($_SESSION['admin2'])) { ?>
        <style>
            .bg_color {
                background-color: #3D5B59 !important;
            }
        </style>
    <?php } ?>
</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>

    <section>
        <div class="container bg-white pr-4 pl-4  log_section pb-5 pt-lg-4">
            <h4 class="font-weight-bold ">Landlord Information <p class="text-muted"></p>
            </h4>
            <form class="form-inline" id="myForm">
                <input class="form-control mr-sm-2" name="info" type="text" placeholder="Enter Building Name or Keyword" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" id="search">Search</button>
            </form>
            <div id="output2">

            </div>

        </div>

    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>
    <script src="js/datepicker.js"></script>


    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                responsive: false,
                "pageLength": 50,

            });
        });
        $('[data-toggle="datepicker"]').datepicker({
            autoClose: true,
            viewStart: 2,
            format: 'dd/mm/yyyy',

        });
    </script>
    <script>
        $(document).ready(function() {

            $('#myForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                if (formData != '') {
                    $.ajax({
                        type: "POST",
                        url: "ajax-landlord.php",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response) {
                                $('#output2').fadeIn().html(response);
                            } else {
                                $('#output2').fadeIn().html('No Data');

                            }
                        }
                    });
                }
                console.log(formData);

                this.reset();

            });
        })
    </script>
    <script>
        // $('#search').on('click', () => {
        //     // $('#view').load();
        //     $.ajax({
        //         type: "GET",
        //         url: "viewAjax.php",
        //         dataType: "text",
        //         success: function(response) {
        //             $('#view').html(response);
        //         }
        //     });
        // })

        setInterval(() => {
            $.ajax({
                type: "GET",
                url: "viewAjax.php",
                dataType: "text",
                success: function(response) {
                    if (response == '') {
                        $('#view').html(5);

                    } else {
                        $('#view').html(response);

                    }
                }
            });
        }, 1000);
    </script>

</body>

</html>