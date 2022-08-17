<?php
session_start();
if (isset($_SESSION['name2'])) {
} else {
    header('location:login.php');
}
require './class/database.php';

class Property extends database
{
    public function showInfo()
    {
        $code = $_GET['code'];
        $sql = "SELECT * FROM `building_info` WHERE building_info.code = '$code'";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function showFacilties()
    {
        $code = $_GET['code'];
        $sql = "SELECT * FROM `building_info` LEFT JOIN facilties ON building_info.code = facilties.code WHERE building_info.code = '$code'";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function showLandlord_details()
    {
        $code = $_GET['code'];
        $sql = "SELECT * FROM `building_info` LEFT JOIN landlord_details ON building_info.code = landlord_details.code WHERE building_info.code = '$code'";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function showPhotos()
    {
        $code = $_GET['code'];
        $sql = "SELECT * FROM `building_info` LEFT JOIN photos ON building_info.code = photos.code WHERE building_info.code = '$code'";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function showPhotosRoom()
    {
        $code = $_GET['code'];
        $sql = "SELECT distinct photos.room_number FROM `building_info` LEFT JOIN photos ON building_info.code = photos.code WHERE building_info.code = '$code'";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function showTypes()
    {
        $code = $_GET['code'];
        $sql = "SELECT * FROM `building_info` LEFT JOIN types ON building_info.code = types.code WHERE building_info.code = '$code'";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function insertRoomImage($num)
    {
        $code = $_GET['code'];
        $number = $num;
        $sql = "SELECT * FROM `building_info` LEFT JOIN photos ON building_info.code = photos.code WHERE building_info.code = '$code' AND photos.room_number = $number";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function lastPerson()
    {
        $code = $_GET['code'];

        $sql = "SELECT * FROM `building_info` LEFT JOIN last_update ON building_info.code = last_update.code WHERE building_info.code = '$code'";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }

        # code...
    }
    public function displayRoom($room)
    {
        $code = $_GET['code'];
        $sql = "SELECT * from building_info where code = '$code' AND display_by = 'alp'";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            $alphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
            $room--;
            return $alphabet[$room];
        } else {
            return $room;
        }

        # code...
    }
}
$obj = new Property;
$objInfo = $obj->showInfo();
$objTypes = $obj->showTypes();
$objFacilties = $obj->showFacilties();
$objLandlord = $obj->showLandlord_details();
$objPhotos = $obj->showPhotos();
$objRoom = $obj->showPhotosRoom();
$objPerson = $obj->lastPerson();

$rowInfo = mysqli_fetch_assoc($objInfo);
$rowTypes = mysqli_fetch_assoc($objTypes);
$rowLandLord = mysqli_fetch_assoc($objLandlord);
$rowPerson = mysqli_fetch_assoc($objPerson);
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

        .img-cursor {
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="css/drag-drop-images.css">
</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>

    <section>
        <div class="container bg-white">

            <div class="row p-4">


                <!-- <form action="" method="post"> -->
                <div class="col-12">
                    <div class="d-flex">
                        <h4 class="font-weight-bold ">Code: <span class="text-secondary"><?php echo $rowInfo['code']; ?></span></h4>
                        <a href="edit-general-page.php?code=<?php echo $_GET['code']; ?>" class="btn log_btn float-right ml-5">Edit</a>
                    </div>
                    <div class="divider mb-5 mt-3"></div>

                    <h4 class="font-weight-bold">Building Info: <a href="./search-data.php?info=<?php echo $rowInfo['building']; ?>"><span class="text-info"><?php echo $rowInfo['building']; ?></span></a></h4>
                    <div class="divider mb-3"></div>
                    <div class="row">
                        <div class="col-6">
                            <h5 class="font-weight-bold">District: <span class="text-secondary"><?php echo $rowInfo['district']; ?></span></h5>
                        </div>
                        <div class="col-6">
                            <h5 class="font-weight-bold">Street: <a href="./search-data.php?info=<?php echo $rowInfo['street']; ?>"><span class="text-info"><?php echo $rowInfo['street']; ?></span></a></h5>
                        </div>
                        <div class="col-6">
                            <h5 class="font-weight-bold">Floor: <span class="text-secondary"><?php echo $rowInfo['floor']; ?></span></h5>
                        </div>
                        <div class="col-6">
                            <h5 class="font-weight-bold">Flat: <span class="text-secondary"><?php echo $rowInfo['flat']; ?></span></h5>
                        </div>
                        <div class="col-6">
                            <h5 class="font-weight-bold">Number of room(s): <span class="text-secondary"><?php echo $rowInfo['no_room']; ?></span></h5>
                        </div>

                        <div class="col-6">
                            <h5 class="font-weight-bold">Cargo Lift: <span class="text-secondary"><?php echo $rowInfo['cargo_lift']; ?></span></h5>
                        </div>

                        <div class="col-6">
                            <h5 class="font-weight-bold">Customer Lift: <span class="text-secondary"><?php echo $rowInfo['customer_lift']; ?></span></h5>
                        </div>
                        <div class="col-6">
                            <h5 class="font-weight-bold">24 hour: <span class="text-secondary"><?php echo $rowInfo['tf_hr']; ?></span></h5>
                        </div>
                        <div class="col-6">
                            <h5 class="font-weight-bold">Entry Password: <span class="text-secondary"><?php echo $rowInfo['enter_password']; ?></span></h5>
                        </div>
                        <!-- <div class="col-6">
                            <h5 class="font-weight-bold">Password: <span
                                    class="text-secondary"><?php echo $rowInfo['enter_password']; ?></span></h5>
                        </div> -->
                    </div>

                    <h4 class="font-weight-bold mt-3">Landlord Info</h4>
                    <div class="divider mb-3"></div>
                    <div class="row">
                        <div class="col-6">
                            <h5 class="font-weight-bold">Person in charge: <a href="./search-data.php?info=<?php echo $rowLandLord['in_charges']; ?>"><span class="text-info"><?php echo $rowLandLord['in_charges']; ?></span></a></h5>
                        </div>
                        <div class="col-6">
                            <h5 class="font-weight-bold">LandLord Name: <a href="./search-data.php?info=<?php echo $rowLandLord['landlord_name']; ?>"><span class="text-info"><?php echo $rowLandLord['landlord_name']; ?></span></a></h5>
                        </div>

                        <div class="col-6">
                            <h5 class="font-weight-bold">Telephone 1: <span class="text-info"><a href="./search-data.php?info=<?php echo $rowLandLord['tel1']; ?>"><?php echo $rowLandLord['tel1']; ?></a></span>
                            </h5>
                        </div>
                        <?php if ($rowLandLord['tel2'] !== '') { ?>
                            <div class="col-6">
                                <h5 class="font-weight-bold">Telephone 2: <span class="text-secondary"><?php echo $rowLandLord['tel2']; ?></span></h5>
                            </div>
                        <?php }
                        if ($rowLandLord['tel3'] !== '') { ?>
                            <div class="col-6">
                                <h5 class="font-weight-bold">Telephone 3: <span class="text-secondary"><?php echo $rowLandLord['tel3']; ?></span></h5>
                            </div>
                        <?php } ?>
                        <div class="col-6">
                            <h5 class="font-weight-bold">Bank: <span class="text-secondary"><?php echo $rowLandLord['bank']; ?></span></h5>
                        </div>
                        <div class="col-6">
                            <h5 class="font-weight-bold">Account: <span class="text-secondary"><?php echo $rowLandLord['bank_acc']; ?></span></h5>
                        </div>
                        <div class="col-6">
                            <h5 class="font-weight-bold">Remarks: <span class="text-secondary"><?php echo $rowLandLord['remarks']; ?></span></h5>
                        </div>

                    </div>
                    <h4 class="font-weight-bold mt-3">Last Seen By</h4>
                    <div class="divider mb-2"></div>
                    <h5 class="font-weight-bold">Username: <span class="text-secondary"><?php echo $rowPerson['username']; ?>
                            (<?php echo date("d-m-Y", strtotime($rowPerson['updated_at'])); ?>)</span></h5>
                    <h4 class="font-weight-bold mt-4">Facilities</h4>
                    <div class="divider mb-3"></div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <?php if ($objFacilties) { ?>
                            <?php while ($row = mysqli_fetch_assoc($objFacilties)) { ?>

                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" id="home-tab<?php echo $row['room_number']; ?>" data-toggle="tab" href="#home<?php echo $row['room_number']; ?>" role="tab" aria-controls="home<?php echo $row['room_number']; ?>" aria-selected="true">Room
                                        <?php echo $obj->displayRoom($row['room_number']); ?></a>
                                </li>



                            <?php } ?>
                        <?php } ?>
                    </ul>
                    <div class="tab-content mt-3" id="myTabContent">
                        <?php mysqli_data_seek($objFacilties, 0) ?>
                        <?php if ($objFacilties) { ?>
                            <?php while ($row = mysqli_fetch_assoc($objFacilties)) { ?>
                                <?php  ?>
                                <div class="tab-pane fade" id="home<?php echo $row['room_number']; ?>" role="tabpanel" aria-labelledby="home-tab<?php echo $row['room_number']; ?>">
                                    <div class="row">
                                        <p class="col-4 font-weight-bold">Gross Area: <?php echo $row['gross_area']; ?></p>
                                        <p class="col-4 font-weight-bold">Saleable Area: <?php echo $row['salesable_area']; ?>
                                        </p>
                                        <p class="col-4 font-weight-bold">Rent: <?php echo $row['rent']; ?></p>

                                        <p class="col-4 font-weight-bold">Windows: <?php echo $row['windows']; ?></p>
                                        <p class="col-4 font-weight-bold">Lavatory: <?php echo $row['lavatory']; ?></p>
                                        <p class="col-4 font-weight-bold">Shower: <?php echo $row['shower']; ?></p>
                                        <p class="col-4 font-weight-bold">Sink: <?php echo $row['sink']; ?></p>
                                        <p class="col-4 font-weight-bold">Wide door: <?php echo $row['wide_door']; ?></p>
                                        <p class="col-4 font-weight-bold">Brickes wall: <?php echo $row['brickes_wall']; ?></p>
                                        <p class="col-4 font-weight-bold">Separate room: <?php echo $row['seprate_room']; ?></p>
                                        <p class="col-4 font-weight-bold">Electronic keys:
                                            <?php echo $row['electronic_keys']; ?></p>
                                        <p class="col-4 font-weight-bold">Wifi: <?php echo $row['wifi']; ?></p>
                                        <p class="col-4 font-weight-bold">Remarks: <?php echo $row['remarks']; ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <h4 class="font-weight-bold mt-3">Photos</h4>
                    <div class="divider mb-3"></div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">

                        <?php if ($objRoom) {
                            $maxRooms = $rowInfo['no_room'];

                            for ($roomNum = 1; $roomNum <= $maxRooms; $roomNum++) { ?>

                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold  drag-drop-target" id="photo-tab<?php echo $roomNum; ?>" data-toggle="tab" href="#photo<?php echo $roomNum; ?>" role="tab" aria-controls="photo<?php echo $roomNum; ?>" aria-selected="true" data-roomnum="<?php echo $roomNum; ?>">Room
                                        <?php echo $obj->displayRoom($roomNum); ?></a>
                                </li>



                            <?php } ?>
                        <?php } ?>
                    </ul>
                    <div class="tab-content mt-3" id="myTabContent">
                        <?php mysqli_data_seek($objRoom, 0) ?>

                        <?php if ($objRoom) {
                            $maxRooms = $rowInfo['no_room'];
                        ?>
                            <?php for ($roomNum = 1; $roomNum <= $maxRooms; $roomNum++) { ?>
                                <div class="tab-pane fade" id="photo<?php echo $roomNum; ?>" role="tabpanel" aria-labelledby="photo-tab<?php echo $roomNum; ?>">
                                    <div class="row">
                                        <?php $photos = $obj->insertRoomImage($roomNum) ?>
                                        <?php if ($photos) { ?>
                                            <?php while ($all = mysqli_fetch_assoc($photos)) { ?>
                                                <div class="drag-drop-img-container">
                                                    <i class="fa fa-times close-image-icon" aria-hidden="true"></i>
                                                    <img src="files/<?php echo $all['image']; ?>" alt="proprty image" class="img-cursor drag-drop-img" data-roomnum="<?php echo $roomNum; ?>" draggable="true">
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>

                    </div>

                </div>
                <!-- </form> -->
            </div>

        </div>

    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>

    <script src="js/datepicker.js"></script>
    <script src="js/jquery.multifile.js"></script>
    <script src="js/jquery.multifile.preview.js"></script>
    <script src="js/change-image-room.js"></script>
    <script src="js/magnify-image.js"></script>
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