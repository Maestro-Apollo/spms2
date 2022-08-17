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
            <h4 class="font-weight-bold ">View Permission
            </h4>
            <form action="" id="viewForm" class="form-group">
                <div id="viewAdd"></div>
                <div class="row">
                    <div class="col-6">
                        <input type="text" name="agent_name" placeholder="Agent Name" id="agent_name" class="form-control">
                        <div id="outputAgent"></div>
                    </div>
                    <div class="col-6">
                        <input type="number" placeholder="Add View" name="view_number" id="view_number" class="form-control">
                    </div>
                </div>
                <input type="submit" class="btn log_btn mt-2" value="Add">
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
            $('#agent_name').keyup(function() {
                let agent_name = $(this).val();
                if (agent_name != '') {
                    $.ajax({
                        type: "POST",
                        url: "ajaxAgent.php",
                        data: {
                            agent_name: agent_name
                        },
                        dataType: "text",
                        success: function(data) {
                            $('#outputAgent').fadeIn();
                            $('#outputAgent').html(data);
                        }
                    });
                } else {
                    $('#outputAgent').fadeOut();
                    $('#outputAgent').html("");
                }

            });
            $('#outputAgent').parent().on('click', 'li', function() {
                $('#agent_name').val($(this).text());
                $('#outputAgent').fadeOut();
            });

        });
    </script>

    <script>
        $(document).ready(function() {

            $('#viewForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "ajax-view.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        $('#viewAdd').fadeIn().html(response);
                    }
                });
                this.reset();

            });
        })
    </script>

</body>

</html>