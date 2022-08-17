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


            <!-- <h4 class="font-weight-bold pt-5 text-center">Booking History</h4> -->
            <!-- <form action="">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="name" data-toggle="datepicker" class="form-control mt-4 p-4  bg-light"
                            placeholder="From Date" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" data-toggle="datepicker" name="name" class="form-control mt-4 p-4  bg-light"
                            placeholder="To Date" required>
                    </div>
                    <div class="col-md-4">
                        <select name="" class="form-control mt-4  bg-light" id="">
                            <option value="">Choose an option</option>
                            <option value="">Done</option>
                            <option value="">Incomplete</option>
                        </select>
                    </div>
                </div>
                <button name="signup" type="submit" class="btn font-weight-bold log_btn mt-4">Calculate</button>
            </form> -->


            <h4 class="font-weight-bold pt-5 text-center">Building Info</h4>
            <div class="table-responsive">

                <table id="userTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>District</th>
                            <th>Street</th>
                            <th>Building</th>
                            <th>Action</th>


                        </tr>
                    </thead>


                </table>
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
        var userDataTable = $('#userTable').DataTable({
            'processing': true,
            'serverSide': true,
            'columnDefs': [{
                orderable: false,
                targets: 0
            }],
            'serverMethod': 'post',
            "pageLength": 50,
            'ajax': {
                'url': 'ajax-property-list.php'
            },
            'columns': [{
                data: 'code'
            }, {
                data: 'district'
            }, {
                data: 'street'
            }, {
                data: 'building'
            }, {
                data: 'action'
            }, ]
        });
        $('#userTable').on('click', '.deleteUser', function() {
            var id = $(this).data('id');

            var deleteConfirm = confirm("Are you sure?");
            if (deleteConfirm == true) {
                // AJAX request
                $.ajax({
                    url: 'ajax-property-list.php',
                    type: 'post',
                    data: {
                        request: 4,
                        id: id
                    },
                    success: function(response) {

                        if (response == 1) {
                            alert("Record deleted.");

                            // Reload DataTable
                            userDataTable.ajax.reload();
                        } else {
                            alert("Invalid ID.");
                        }

                    }
                });
            }

        });
    </script>

</body>

</html>