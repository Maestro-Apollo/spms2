<?php
include 'include/auth.php';
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
        $sql = "SELECT * from photos where code = '$code' ";
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
    public function showComment()
    {
        $code = $_GET['code'];

        $sql = "SELECT * FROM `comment` WHERE code = '$code'";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }

        # code...
    }

    public function checkPerson()
    {
        if (isset($_SESSION['name2'])) {
            $name = $_SESSION['name2'];
            $code = $_GET['code'];
            $sqlUpdate = "UPDATE last_update SET username = '$name', updated_at = CURRENT_TIMESTAMP where code = '$code' ";
            mysqli_query($this->link, $sqlUpdate);

            $sqlFind = "SELECT * from extra_view where username = '$name' AND DAY(created_at) = DAY(CURRENT_DATE()) AND MONTH(created_at) = MONTH(CURRENT_DATE())
        AND YEAR(created_at) = YEAR(CURRENT_DATE()) order by view_id DESC";
            $resFind = mysqli_query($this->link, $sqlFind);
            $rowFind = mysqli_fetch_assoc($resFind);
            $number1 = (isset($rowFind['view_count'])) ? $rowFind['view_count'] : 0;
            $number2 = (isset($rowFind['admin_given'])) ? $rowFind['admin_given'] : 0;

            if ($number1 <= (15 + $number2)) {

                $sqlCheck = "SELECT * from extra_view where username = '$name' AND code = '$code' AND DAY(created_at) = DAY(CURRENT_DATE()) AND MONTH(created_at) = MONTH(CURRENT_DATE())
                AND YEAR(created_at) = YEAR(CURRENT_DATE()) order by view_id DESC";
                $resCheck = mysqli_query($this->link, $sqlCheck);
                if (mysqli_num_rows($resCheck) > 0) {
                    return;
                }


                $count = (isset($rowFind['view_count'])) ? $rowFind['view_count'] : 0;
                $admin_count = (isset($rowFind['admin_given'])) ? $rowFind['admin_given'] : 0;
                $count++;

                $sqlView = "INSERT INTO `extra_view` (`view_id`, `username`, `code`, `view_count`, `admin_given`, `created_at`) VALUES (NULL, '$name', '$code', $count, $admin_count, CURRENT_TIMESTAMP)";
                mysqli_query($this->link, $sqlView);
            } else {
                header('location:search-landlord.php');
            }
        }
        # code...
    }
}
$obj = new Property;
$objInfo = $obj->showInfo();
$objLandlord = $obj->showLandlord_details();
$objPhotos = $obj->showPhotos();
$objPerson = $obj->lastPerson();
$objCheck = $obj->checkPerson();
$objComment = $obj->showComment();

$rowInfo = mysqli_fetch_assoc($objInfo);
$rowLandLord = mysqli_fetch_assoc($objLandlord);
$rowPerson = mysqli_fetch_assoc($objPerson);
if (is_object($objComment)) {
    $rowComment = mysqli_fetch_assoc($objComment);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>
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
        <div class="container bg-white">

            <div class="row">


                <!-- <form action="" method="post"> -->
                <div class="col-12">
                    <div class="d-flex">
                        <h6 class="font-weight-bold ">Code: <span class="text-primary"><input type="text"
                                    value="<?php echo $rowInfo['code']; ?>" class=""></span></h6>

                        <a href="./property-details-edit.php?code=<?php echo $rowInfo['code']; ?>"
                            class="btn btn-sm ml-5 log_btn">Edit</a>

                    </div>
                    <div class="divider mt-2 mb-2"></div>

                    <h6 class="font-weight-bold">Building Info: <span
                            class="text-primary"><?php echo $rowInfo['building']; ?></span></h6>
                    <div class="divider mb-3"></div>
                    <div class="row">
                        <div class="col-6">
                            <p class="font-weight-bold">District: <span
                                    class="text-primary"><?php echo $rowInfo['district']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Address: <span
                                    class="text-primary"><?php echo $rowInfo['street']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Year: <span
                                    class="text-primary"><?php echo $rowInfo['year']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Floor: <span
                                    class="text-primary"><?php echo $rowInfo['floor']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Flat: <span
                                    class="text-primary"><?php echo $rowInfo['flat']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Number of room(s): <span
                                    class="text-primary"><?php echo $rowInfo['no_room']; ?></span></p>
                        </div>

                        <div class="col-6">
                            <p class="font-weight-bold">Cargo Lift: <span
                                    class="text-primary"><?php echo $rowInfo['cargo_lift']; ?></span></p>
                        </div>

                        <div class="col-6">
                            <p class="font-weight-bold">Customer Lift: <span
                                    class="text-primary"><?php echo $rowInfo['customer_lift']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">24 hour: <span
                                    class="text-primary"><?php echo $rowInfo['tf_hr']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Entry Password: <span
                                    class="text-danger"><?php echo $rowInfo['enter_password']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Block: <span
                                    class="text-primary"><?php echo $rowInfo['block']; ?></span></p>
                        </div>
                        <!-- <div class="col-6">
                            <p class="font-weight-bold">Password: <span
                                    class="text-primary"><?php echo $rowInfo['enter_password']; ?></span></p>
                        </div> -->
                    </div>

                    <h6 class="font-weight-bold mt-2">Landlord Info</h6>
                    <div class="divider mb-2"></div>
                    <div class="row">

                        <div class="col-12">
                            <p class="font-weight-bold">LandLord Name: <span
                                    class="text-primary"><?php echo $rowLandLord['landlord_name']; ?></span>
                            </p>
                        </div>


                        <div class="col-6">
                            <p class="font-weight-bold">Contact 1: <span
                                    class="text-primary"><?php echo $rowLandLord['contact1']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Number 1: <span
                                    class="text-primary"><?php echo $rowLandLord['number1']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Contact 2: <span
                                    class="text-primary"><?php echo $rowLandLord['contact2']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Number 2: <span
                                    class="text-primary"><?php echo $rowLandLord['number2']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Contact 3: <span
                                    class="text-primary"><?php echo $rowLandLord['contact3']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Number 3: <span
                                    class="text-primary"><?php echo $rowLandLord['number3']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Individual: <span
                                    class="text-primary"><?php echo $rowLandLord['individual']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Separate: <span
                                    class="text-primary"><?php echo $rowLandLord['separate']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Bank: <span
                                    class="text-primary"><?php echo $rowLandLord['bank']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Account: <span
                                    class="text-primary"><?php echo $rowLandLord['bank_acc']; ?></span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Remarks: <span
                                    class="text-primary"><?php echo $rowLandLord['remarks']; ?></span></p>
                        </div>

                    </div>
                    <div class="">
                        <div class="row">
                            <div class="col-12">
                                <p class="font-weight-bold mt-2">Admin Comment</p>
                                <div class="divider mb-2"></div>
                                <p class="font-weight-bold text-primary"><?php echo $rowComment['admin_comment']; ?></p>
                            </div>
                            <div class="col-12">
                                <p class="font-weight-bold mt-2"><?php echo $rowComment['person_name'] ?> Comment
                                    (<?php echo date("d-m-Y", strtotime($rowComment['date'])) ?>)
                                </p>
                                <div class="divider mb-2"></div>
                                <p class="font-weight-bold text-primary"><?php echo $rowComment['agent_comment']; ?></p>
                            </div>
                        </div>
                    </div>
                    <!-- <h6 class="font-weight-bold mt-2">Last Seen By</h6> -->
                    <!-- <div class="divider mb-2"></div> -->
                    <p class="font-weight-bold">Username: <span
                            class="text-primary"><?php echo $rowPerson['username']; ?>
                            (<?php echo date("d-m-Y", strtotime($rowPerson['updated_at'])); ?>)</span></p>


                    <h6 class="font-weight-bold mt-2">Photos</h6>
                    <div class="divider mb-2"></div>
                    <div class="popup-gallery">
                        <div class="row">
                            <?php if ($objPhotos) { ?>
                            <?php while ($row = mysqli_fetch_assoc($objPhotos)) {
                                    $image = !empty($row['image_watermark']) ? $row['image_watermark'] : $row['image'];
                                ?>
                            <div class="col-4 mt-3 mb-3">
                                <input type="checkbox" data-share="<?php echo $image; ?>" class="share" />
                                <input type="input" data-photo-id="<?php echo $row['image_id']; ?>"
                                    value="<?php echo $row['room_number']; ?>" class="room-num"
                                    placeholder="Room number" />
                                <a href="./images/<?php echo $image; ?>" title="<?php echo $row['code']; ?>">
                                    <img class="img-fluid fix-img shadow" src="./images/<?php echo $image; ?>"
                                        alt=""></a>

                            </div>
                            <?php } ?>
                            <?php } ?>
                        </div>
                    </div>



                </div>
                <!-- </form> -->
            </div>

        </div>

    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>

    <script src="js/datepicker.js"></script>

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
    $('.popup-gallery input.room-num').on('keyup', function() {
        $.post('./ajax/set_room_number.php', {
            photo_id: $(this).data('photo-id'),
            room_number: $(this).val()
        })
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