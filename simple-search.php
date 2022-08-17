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
                            <th>Contact 1</th>
                            <th>Number 1</th>
                            <th>Contact 2</th>
                            <th>Number 2</th>
                            <th>Contact 3</th>
                            <th>Number 3</th>
                            <th>Landlord Name</th>
                            <th>Bank</th>
                            <th>Bank acc</th>
                            <th>Remarks</th>
                            <th>District</th>
                            <th>Street</th>
                            <th>Building</th>
                            <th>Floor</th>
                            <th>Flat</th>
                            <th>No room</th>
                            <th>Block</th>
                            <th>Cargo Lift</th>
                            <th>Customer Lift</th>
                            <th>24 Hr</th>

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
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script>

    </script>
    <script>
        var userDataTable = $('#userTable').DataTable({
            'processing': true,
            'serverSide': true,
            'columnDefs': [{
                orderable: false,
                targets: 0
            }],
            'serverMethod': 'post',
            "pageLength": 10,
            'ajax': {
                'url': 'ajax-search-data.php',
                data: function(reqParam) {
                    // to see exactly what is being sent
                    console.log(reqParam);
                    return reqParam;
                },
                dataFilter: function(response) {
                    // this to see what exactly is being sent back
                    console.log(response);
                    return response
                },
                error: function(error) {
                    // to see what the error is
                    console.log(error);
                }
            },
            'columns': [{
                data: 'code'
            }, {
                data: 'contact1'
            }, {
                data: 'number1'
            }, {
                data: 'contact2'
            }, {
                data: 'number2'
            }, {
                data: 'contact3'
            }, {
                data: 'number3'
            }, {
                data: 'landlord_name'
            }, {
                data: 'bank'
            }, {
                data: 'bank_acc'
            }, {
                data: 'remarks'
            }, {
                data: 'district'
            }, {
                data: 'street'
            }, {
                data: 'building'
            }, {
                data: 'floor'
            }, {
                data: 'flat'
            }, {
                data: 'no_room'
            }, {
                data: 'block'
            }, {
                data: 'cargo_lift'
            }, {
                data: 'customer_lift'
            }, {
                data: 'tf_hr'
            }, ]
        });
    </script>

</body>

</html>