<?php
require './class/database.php';
session_start();
class Property extends database
{
}
$obj = new Property;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>

    <style>
    body {
        font-family: 'Lato', sans-serif;

    }

    .navbar-brand {
        width: 7%;
    }

    .bg_color {
        background-color: #274472 !important;
    }

    .divider {
        background-color: #274472;
        height: 5px;
        width: 75%;
    }
    </style>
    <!-- <script src="https://kit.fontawesome.com/0c7895b5e7.js" crossorigin="anonymous"></script> -->
</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>

    <section>
        <div class="container bg-white">

            <form action="./search-result.php" method="post" class="p-3">
                <label for="" class="mt-3 font-weight-bold">Building Info</label>
                <input type="text" name="building" class="form-control " required>
                <div class="d-block">
                    <div class="float-left">
                        <p class="mt-3 mb-0 font-weight-bold ">Facilities <i class="fas fa-arrow-right"></i></p>

                    </div>
                    <div class="float-right">
                        <p class="mt-3 mb-0 font-weight-bold ">Include</p>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="include1" value="Yes" id="include1"
                                checked>
                            <label class="form-check-label" for="include1">Yes</label>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <br>
                <p class="mb-0">Gross Area</p>

                <div class="row">
                    <div class="col-6">
                        <input type="number" name="gross1" placeholder="From" class="form-control " autocomplete="off">

                    </div>
                    <div class="col-6">
                        <input type="number" name="gross2" placeholder="To" class="form-control " autocomplete="off">

                    </div>
                </div>
                <p class="mt-3 mb-0">Sailable Area</p>
                <div class="row">
                    <div class="col-6">
                        <input type="number" name="sailable1" placeholder="From" class="form-control "
                            autocomplete="off">

                    </div>
                    <div class="col-6">
                        <input type="number" name="sailable2" placeholder="To" class="form-control " autocomplete="off">

                    </div>
                </div>
                <p class="mt-3 mb-0">Price Range</p>
                <div class="row">
                    <div class="col-6">
                        <input type="number" name="price1" placeholder="From" class="form-control " autocomplete="off">

                    </div>
                    <div class="col-6">
                        <input type="number" name="price2" placeholder="To" class="form-control " autocomplete="off">

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="Cargo" value="Yes" id="Cargo" checked>
                            <label class="form-check-label" for="Cargo">Cargo Lift</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="Customer" value="Yes" id="Customer"
                                checked>
                            <label class="form-check-label" for="Customer">Customer Lift</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="hours" value="Yes" id="hours" checked>
                            <label class="form-check-label" for="hours">24 hours</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="Windows" value="Yes" id="Windows"
                                checked>
                            <label class="form-check-label" for="Windows">Windows</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="Lavatory" value="Yes" id="Lavatory"
                                checked>
                            <label class="form-check-label" for="Lavatory">Lavatory</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="Shower" value="Yes" id="Shower"
                                checked>
                            <label class="form-check-label" for="Shower">Shower</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="Sink" value="Yes" id="Sink" checked>
                            <label class="form-check-label" for="Sink">Sink</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" name="Door" value="Yes" class="form-check-input" id="Door" checked>
                            <label class="form-check-label" for="Door">Wide Door</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="Wall" value="Yes" id="Wall" checked>
                            <label class="form-check-label" for="Wall">Bricked Wall</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="SeparateRoom" name="SeparateRoom"
                                value="Yes" checked>
                            <label class="form-check-label" for="SeparateRoom">Separate room</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="Keys" value="Yes" id="Keys" checked>
                            <label class="form-check-label" for="Keys">Electronic Keys</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" name="Wifi" value="Yes" class="form-check-input" id="Wifi" checked>
                            <label class="form-check-label" for="Wifi">Wifi</label>
                        </div>
                    </div>
                </div>
                <div class="d-block">
                    <div class="float-left">
                        <p class="mt-3 mb-0 font-weight-bold ">Types <i class="fas fa-arrow-right"></i></p>

                    </div>
                    <div class="float-right">
                        <p class="mt-3 mb-0 font-weight-bold ">Include</p>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="include2" value="Yes" id="include2"
                                checked>
                            <label class="form-check-label" for="include2">Yes</label>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <br>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="individual" name="individual"
                                value="Yes" checked>
                            <label class="form-check-label" for="individual">Individual</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="Separate" value="Yes" id="seprate"
                                checked>
                            <label class="form-check-label" for="seprate">Separate</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="Studio" value="Yes" id="studio"
                                checked>
                            <label class="form-check-label" for="studio">Studio</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="Yoga" value="Yes" id="yoga" checked>
                            <label class="form-check-label" for="yoga">Yoga</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="Class2" value="Yes" id="class2"
                                checked>
                            <label class="form-check-label" for="class2">Class</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="overnight" name="Overnight" value="Yes"
                                checked>
                            <label class="form-check-label" for="overnight">Overnight</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="warehouse_office" name="Warehouse"
                                value="Yes" checked>
                            <label class="form-check-label" for="warehouse_office">Warehouse office</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="Beauty" value="Yes" id="beauty"
                                checked>
                            <label class="form-check-label" for="beauty">Beauty</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="upstair_shop" name="Shop" value="Yes"
                                checked>
                            <label class="form-check-label" for="upstair_shop">Upstairs shop</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="Band" value="Yes" id="band" checked>
                            <label class="form-check-label" for="band">Band</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="recording_room" name="Recording"
                                value="Yes" checked>
                            <label class="form-check-label" for="recording_room">Recording room</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="Piano" value="Yes" id="piano" checked>
                            <label class="form-check-label" for="piano">Piano</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="Painting" value="Yes" id="painting"
                                checked>
                            <label class="form-check-label" for="painting">Painting</label>
                        </div>
                    </div>

                </div>
                <input type="submit" value="Search" class="btn btn-block log_btn">

            </form>

        </div>

    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>

    <script src="js/datepicker.js"></script>
    <script src="js/jquery.multifile.js"></script>
    <script src="js/jquery.multifile.preview.js"></script>
    <!-- <script>
    $('.multifile').multifile();
    </script> -->




    <script>
    $('#myTab li:first-child a').tab('show')
    </script>
    <!-- <script>
    $(document).ready(function() {
        var i = 1;
        $('#add').click(function() {
            i++;
            $('#output3').prepend(
                '<div class="row" id="row' + i +
                '"><div class="col-10"><div class="custom-file mt-4"><input type="file" name="booking_file[]" class="custom-file-input" id="customFile' +
                i + '"><label class="custom-file-label" for="customFile' + i +
                '">Choose file</label></div></div><div class="col-2"><button type="button" name="remove" id="' +
                i +
                '" class="btn btn-danger mt-4 btn_remove"><i class="fas fa-minus"></i></button></div></div>'
            );

        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

    });
    </script> -->
</body>

</html>