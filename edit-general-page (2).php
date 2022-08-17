<?php
session_start();
if (isset($_SESSION['name2'])) {
} else {
    header('location:login.php');
}
include_once('class/database.php');

include('./updateInfo.php');
class ShowData extends database
{
    public function showBuildingInfo()
    {
        $code = $_GET['code'];
        $sql = "SELECT * from building_info where code = '$code' ";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function showFacilities()
    {
        $code = $_GET['code'];
        $sql = "SELECT * from facilties where code = '$code' ";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function showType()
    {
        $code = $_GET['code'];
        $sql = "SELECT * from types where code = '$code' ";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function showLandlord()
    {
        $code = $_GET['code'];
        $sql = "SELECT * from landlord_details where code = '$code' ";
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
    public function upload_new_photos($newName, $roomNum)
    {
        $code = $_GET['code'];

        // database upload image data
        $sqlFile = "INSERT INTO `photos` (`image_id`, `image`, `room_number`, `code`, `image_created_at`) VALUES (NULL, '$newName', '$roomNum', '$code', CURRENT_TIMESTAMP)";
        mysqli_query($this->link, $sqlFile);
    }
}
$obj = new ShowData;
$objInfo = $obj->showBuildingInfo();
$objFacilities = $obj->showFacilities();
$objTypes = $obj->showType();
$objLord = $obj->showLandlord();
$objPhotos = $obj->showPhotos();
$objRoom = $obj->showPhotosRoom();

$rowInfo = mysqli_fetch_assoc($objInfo);
$rowLord = mysqli_fetch_assoc($objLord);


header('Content-Type: text/html; charset=utf-8');

// Images are already uploaded and their data is stored in the user session
// here we will just move them to "/files" and rename them
foreach ($_SESSION["uploaded-images-data"] as $image) {
    $newName = date("d-m-Y") . '_' . date("h-i-sa") . '_' . '@' . substr($image["path"], 12); // gets rid of temp_photos/
    $roomNum = $image["roomnum"];
    if (file_exists($image["path"])) {
        // move the image
        rename($image["path"], "files/" . $newName);

        $obj->upload_new_photos($newName, $roomNum);
    }
}

// reset session images data
$_SESSION["uploaded-images-data"] = array();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <style>
        body {
            font-family: 'Lato', sans-serif;

        }

        .navbar-brand {
            width: 7%;
        }

        section {
            padding: 0px;
        }

        .table th {
            white-space: nowrap;
        }

        .bg_color {
            background-color: #274472 !important;
        }

        .sw.sw-justified>.nav .nav-link,
        .sw.sw-justified>.nav>li {
            background-color: #F8F8F8;
        }
    </style>
    <!-- <link rel="stylesheet" href="css/multi-form.css"> -->
    <link rel="stylesheet" href="css/smart_wizard_all.min.css">
    <link rel="stylesheet" href="css/drag-drop-images.css">
</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>

    <section>
        <div class="">

            <form id="form" method="post" enctype="multipart/form-data" data-parsley-validate onsubmit="return sendImagesToValidation(event);">


                <!-- <form action="" method="post"> -->
                <div class="mt-5">
                    <div class="container">
                        <!-- <?php if ($objSignIn == 'Added') { ?>
                        <div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Successfully Added!</strong>
                        </div>
                        <?php } ?> -->
                        <div id="smartwizard" class="bg-white">

                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-1">
                                        <strong>Building Info</strong>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-2">
                                        <strong>Facilities</strong>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-3">
                                        <strong>Types</strong>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-4">
                                        <strong>Landlord Details</strong>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-5">
                                        <strong>Photos</strong>
                                    </a>
                                </li>

                            </ul>

                            <div class="tab-content">
                                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                                    <h3>Building Info</h3>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" value="<?php echo $_GET['code']; ?>" placeholder="Code" name="code" required readonly>
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" value="<?php echo $rowInfo['district'] ?>" placeholder="District" name="district">
                                        </div>
                                    </div>


                                    <input type="text" class="form-control mt-3" placeholder="Street" name="street" value="<?php echo $rowInfo['street'] ?>">
                                    <input type="text" class="form-control mt-3" placeholder="Building" name="building" required autocomplete="on" value="<?php echo $rowInfo['building'] ?>" readonly>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Block" name="block" autocomplete="on" value="<?php echo $rowInfo['block'] ?>">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Floor" name="floor" autocomplete="on" value="<?php echo $rowInfo['floor'] ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Flat" name="flat" autocomplete="on" value="<?php echo $rowInfo['flat'] ?>">
                                        </div>
                                        <div class="col-6">
                                            <input type="number" class="form-control mt-3" placeholder="No of Rooms" name="no_rooms" id="no_rooms" required value="<?php echo $rowInfo['no_room'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-0">Room Display By</p>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline1" name="display" class="custom-control-input" value="alp" <?php echo (($rowInfo['display_by'] == 'alp') ? 'checked' : '') ?>>
                                            <label class="custom-control-label" for="customRadioInline1">A,B,C,D...</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline2" name="display" class="custom-control-input" value="num" <?php echo (($rowInfo['display_by'] == 'num') ? 'checked' : '') ?>>
                                            <label class="custom-control-label" for="customRadioInline2">1,2,3,4...</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Cargo Lift" name="cargo_lift" value="<?php echo $rowInfo['cargo_lift'] ?>">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Customer Lift" name="customer_lift" value="<?php echo $rowInfo['customer_lift'] ?>">
                                        </div>
                                        <div class="col-6 offset-3">
                                            <label for="" class="mt-3 text-center d-block">24 hour</label>
                                            <select id="" name="tf_hr" class="form-control">

                                                <option value="Yes" <?php echo (($rowInfo['tf_hr'] == 'Yes') ? 'checked' : '') ?>>Yes
                                                </option>
                                                <option value="No" <?php echo (($rowInfo['tf_hr'] == 'No') ? 'checked' : '') ?>>
                                                    No</option>
                                            </select>

                                        </div>
                                    </div>
                                    <input type="text" class="form-control mt-3" placeholder="Entry Password" name="entry_password" value="<?php echo $rowInfo['enter_password'] ?>">
                                    <!-- <button type="submit" name="submit"
                                        class="btn btn-block font-weight-bold log_btn btn-lg mt-4">SUBMIT</button> -->
                                </div>
                                <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                                    <h3>Facilities</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Room No</th>
                                                    <th scope="col">Gross Area</th>
                                                    <th scope="col">Salesable Area</th>
                                                    <th scope="col">Rent - 租</th>

                                                    <th scope="col"><label for="ckbCheckAllP1">Windows </label>
                                                        <input id="ckbCheckAllP1" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAllP2">Lavatory </label>
                                                        <input id="ckbCheckAllP2" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAllP3">Shower 淋浴 </label>
                                                        <input id="ckbCheckAllP3" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAllP4">Sink 下沉 </label>
                                                        <input id="ckbCheckAllP4" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAllP5">Wide door </label>
                                                        <input id="ckbCheckAllP5" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAllP6">Bricked wall </label>
                                                        <input id="ckbCheckAllP6" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAllP7">Seprate room </label>
                                                        <input id="ckbCheckAllP7" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAllP8">Electronic keys </label>
                                                        <input id="ckbCheckAllP8" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAllP9">Wifi 无线上网 </label>
                                                        <input id="ckbCheckAllP9" type="checkbox">
                                                    </th>
                                                    <th scope="col">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($objFacilities) { ?>
                                                    <?php while ($row = mysqli_fetch_assoc($objFacilities)) { ?>
                                                        <tr>
                                                            <th scope="row"><?php echo $row['room_number']; ?></th>
                                                            <input type="hidden" name="rn1" value="<?php echo $row['room_number'] ?>">
                                                            <td><input type="number" class="form-control" name="gross_area[]" value="<?php echo $row['gross_area']; ?>">
                                                            </td>
                                                            <td><input type="number" class="form-control" name="salesable_area[]" value="<?php echo $row['salesable_area']; ?>">
                                                            </td>
                                                            <td><input type="number" class="form-control" name="rent[]" value="<?php echo $row['rent']; ?>"></td>
                                                            <td><input type="checkbox" class="checkBoxClassP1" value="Yes" name="Windows[<?php echo $row['room_number']; ?>][]" <?php echo (($row['windows'] == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="checkbox" class="checkBoxClassP2" value="Yes" name="Lavatory[<?php echo $row['room_number']; ?>][]" <?php echo ((($row['lavatory']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="checkbox" class="checkBoxClassP3" value="Yes" name="Shower[<?php echo $row['room_number']; ?>][]" <?php echo ((($row['shower']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="checkbox" class="checkBoxClassP4" value="Yes" name="Sink[<?php echo $row['room_number']; ?>][]" <?php echo ((($row['sink']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="checkbox" class="checkBoxClassP5" value="Yes" name="Wide_door[<?php echo $row['room_number']; ?>][]" <?php echo ((($row['wide_door']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="checkbox" class="checkBoxClassP6" value="Yes" name="Brickes_wall[<?php echo $row['room_number']; ?>][]" <?php echo ((($row['brickes_wall']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="checkbox" class="checkBoxClassP7" value="Yes" name="Seprate_room[<?php echo $row['room_number']; ?>][]" <?php echo ((($row['seprate_room']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes
                                                            </td>
                                                            <td><input type="checkbox" class="checkBoxClassP8" value="Yes" name="Electronic_keys[<?php echo $row['room_number']; ?>][]" <?php echo ((($row['electronic_keys']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes
                                                            </td>
                                                            <td><input type="checkbox" class="checkBoxClassP9" value="Yes" name="Wifi[<?php echo $row['room_number']; ?>][]" <?php echo ((($row['wifi']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="text" class="form-control" name="Remarks[]" value="<?php echo $row['remarks']; ?>"></td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                                    <h3>Types</h3>

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Room No</th>
                                                    <th scope="col"><label for="ckbCheckAll1">Individual</label> <input id="ckbCheckAll1" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAll2">Seprate</label> <input id="ckbCheckAll2" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAll3">Studio</label> <input id="ckbCheckAll3" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAll4">Yoga</label> <input id="ckbCheckAll4" type="checkbox"></th>
                                                    <th scope="col"><label for="ckbCheckAll5">Class</label> <input id="ckbCheckAll5" type="checkbox"></th>
                                                    <th scope="col"><label for="ckbCheckAll6">Overnight</label> <input id="ckbCheckAll6" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAll7">Warehouse & office</label>
                                                        <input id="ckbCheckAll7" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAll8">Beauty</label> <input id="ckbCheckAll8" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAll9">Upstair shop </label>
                                                        <input id="ckbCheckAll9" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAll10">Band</label> <input id="ckbCheckAll10" type="checkbox"></th>
                                                    <th scope="col"><label for="ckbCheckAll11">Recording room</label>
                                                        <input id="ckbCheckAll11" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAll12">1 to 1 piano </label>
                                                        <input id="ckbCheckAll12" type="checkbox">
                                                    </th>
                                                    <th scope="col"><label for="ckbCheckAll13">Painting</label> <input id="ckbCheckAll13" type="checkbox">
                                                    </th>
                                                    <th scope="col">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php if ($objTypes) { ?>
                                                    <?php while ($row = mysqli_fetch_assoc($objTypes)) { ?>
                                                        <tr>
                                                            <th scope="row"><?php echo $row['types_room_no']; ?></th>
                                                            <input type="hidden" name="rn2[]" value="<?php echo $row['types_room_no']; ?>">
                                                            <input type="hidden" value="Yes" name="keyNumber[]" />
                                                            <td><input type="checkbox" class="checkBoxClass1" value="Yes" name="Individual[<?php echo $row['types_room_no']; ?>][]" <?php echo ((($row['individual']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="checkbox" class="checkBoxClass2" value="Yes" name="Seprate[<?php echo $row['types_room_no']; ?>][]" <?php echo ((($row['seprate']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes
                                                            </td>
                                                            <td><input type="checkbox" class="checkBoxClass3" value="Yes" name="Studio[<?php echo $row['types_room_no']; ?>][]" <?php echo ((($row['studio']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="checkbox" class="checkBoxClass4" value="Yes" name="Yoga[<?php echo $row['types_room_no']; ?>][]" <?php echo ((($row['yoga']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="checkbox" class="checkBoxClass5" value="Yes" name="Class[<?php echo $row['types_room_no']; ?>][]" <?php echo ((($row['class']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="checkbox" class="checkBoxClass6" value="Yes" name="Overnight[<?php echo $row['types_room_no']; ?>][]" <?php echo ((($row['overnight']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="checkbox" class="checkBoxClass7" value="Yes" name="Warehouse_office[<?php echo $row['types_room_no']; ?>][]" <?php echo ((($row['warehouse_office']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="checkbox" class="checkBoxClass8" value="Yes" name="Beauty[<?php echo $row['types_room_no']; ?>][]" <?php echo ((($row['beauty']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="checkbox" class="checkBoxClass9" value="Yes" name="Upstair_shop[<?php echo $row['types_room_no']; ?>][]" <?php echo ((($row['upstair_shop']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="checkbox" class="checkBoxClass10" value="Yes" name="Band[<?php echo $row['types_room_no']; ?>][]" <?php echo ((($row['band']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes
                                                            </td>
                                                            <td><input type="checkbox" class="checkBoxClass11" value="Yes" name="Recording_room[<?php echo $row['types_room_no']; ?>][]" <?php echo ((($row['recording_room']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes
                                                            </td>
                                                            <td><input type="checkbox" class="checkBoxClass12" value="Yes" name="piano[<?php echo $row['types_room_no']; ?>][]" <?php echo ((($row['piano']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="checkbox" class="checkBoxClass13" value="Yes" name="Painting[<?php echo $row['types_room_no']; ?>][]" <?php echo ((($row['painting']) == 'Yes') ? 'checked' : '') ?> />
                                                                Yes</td>
                                                            <td><input type="text" class="form-control" value="<?php echo $row['remarks']; ?>" name="Remarks[]">
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                                    <h3>Landlord Details</h3>

                                    <input type="text" class="form-control mt-3" placeholder="Who is in Charge?" name="charge" value="<?php echo $rowLord['in_charges']; ?>">
                                    <input type="tel" class="form-control mt-3" value="<?php echo $rowLord['tel1']; ?>" placeholder="Tel 1" name="tel1">
                                    <input type="tel" class="form-control mt-3" placeholder="Tel 2" name="tel2" value="<?php echo $rowLord['tel2']; ?>">
                                    <input type="tel" class="form-control mt-3" placeholder="Tel 3" name="tel3" value="<?php echo $rowLord['tel3']; ?>">
                                    <input type="text" class="form-control mt-3" placeholder="Landlord Name" name="landlord_name" value="<?php echo $rowLord['landlord_name']; ?>">
                                    <input type="text" class="form-control mt-3" placeholder="Bank" name="bank" value="<?php echo $rowLord['bank']; ?>">
                                    <input type="text" class="form-control mt-3" placeholder="Bank account" name="bank_account" value="<?php echo $rowLord['bank_acc']; ?>">
                                    <input type="text" class="form-control mt-3" placeholder="Remake" name="remake" value="<?php echo $rowLord['remarks']; ?>">
                                </div>
                                <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                                    <h3>Photos</h3>

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Room No</th>
                                                    <th scope="col">Photos</th>

                                                </tr>
                                            </thead>
                                            <tbody id="tb3">

                                                <div id="output3"></div>

                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-block font-weight-bold log_btn btn-lg mt-4">UPDATE</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- </form> -->
            </form>

        </div>

    </section>



    <?php include('layout/script.php') ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="js/datepicker.js"></script>
    <script src="js/jquery.multifile.js"></script>
    <script src="js/jquery.multifile.preview.js"></script>
    <!-- <script>
    $('.multifile').multifile();
    </script> -->
    <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
    <script src="js/jquery.smartWizard.min.js"></script>
    <script>
        $(document).ready(function() {
            <?php
            if ($objRoom)
                $maxRooms = $rowInfo['no_room'];
            ?>

            $('#tb1').empty();
            $('#tb2').empty();
            $('#tb3').empty();
            let string = '';
            let string2 = '';
            let string3 = '';
            // $('#output').html(myCode);

            <?php
            for ($roomNum = 1; $roomNum <= $maxRooms; $roomNum++) {
            ?>

                string3 += (`<tr>
                                                    <th scope="row"><?php echo $roomNum; ?></th>

                                                    <td id="images-input-<?php echo $roomNum; ?>-cell" class="images-input-cell" data-roomnum="<?php echo $roomNum; ?>">
                                                    <label for="images-input-<?php echo $roomNum; ?>" class="tb3-images-input-label">
                                                    <i class="fa fa-cloud-upload"></i> Upload images
                                                    </label>
                                                    <input id="images-input-<?php echo $roomNum; ?>" class="tb3-images-input" type="file" name="item[image<?php echo $roomNum; ?>][]" multiple>
                                                    `);
                string3 += (`
                        <?php
                        $photos = $obj->insertRoomImage($roomNum);
                        if ($photos) {
                            while ($all = mysqli_fetch_assoc($photos)) { ?>
                        <img draggable="true" class="tb3-image server-photo" src="files/<?php echo $all["image"]; ?>" alt="" data-roomnum="<?php echo $roomNum; ?>">
                        <?php } ?>
                        <?php } ?>

                        </td></tr>`);
            <?php } ?>
            $('#tb1').append(string);
            $('#tb2').append(string2);
            $('#tb3').append(string3);

        });
    </script>

    <script>
        $(document).ready(function() {
            for (let i = 1; i <= 13; i++) {
                $('#ckbCheckAll' + i).click(function() {
                    $('.checkBoxClass' + i).prop('checked', $(this).prop('checked'));
                });
            }

        });
        $(document).ready(function() {
            for (let i = 1; i <= 9; i++) {
                $('#ckbCheckAllP' + i).click(function() {
                    $('.checkBoxClassP' + i).prop('checked', $(this).prop('checked'));
                });
            }

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('Finish')
                .addClass('btn btn-info')
                .on('click', function() {
                    alert('Finish Clicked');
                });
            var btnCancel = $('<button></button>').text('Cancel')
                .addClass('btn btn-danger')
                .on('click', function() {
                    $('#smartwizard').smartWizard("reset");
                });

            // Step show event
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
                $("#prev-btn").removeClass('disabled');
                $("#next-btn").removeClass('disabled');
                if (stepPosition === 'first') {
                    $("#prev-btn").addClass('disabled');
                } else if (stepPosition === 'last') {
                    $("#next-btn").addClass('disabled');
                } else {
                    $("#prev-btn").removeClass('disabled');
                    $("#next-btn").removeClass('disabled');
                }
            });

            // Smart Wizard
            $('#smartwizard').smartWizard({
                selected: 0,
                theme: 'arrows', // default, arrows, dots, progress
                // darkMode: true,
                transition: {
                    animation: 'slide-horizontal', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
                },
                toolbarSettings: {
                    toolbarPosition: 'bottom', // both bottom
                    // toolbarExtraButtons: [btnFinish, btnCancel]
                },
                anchorSettings: {
                    anchorClickable: true, // Enable/Disable anchor navigation
                    enableAllAnchors: true, // Activates all anchors clickable all times
                    markDoneStep: true, // add done css
                    markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                    removeDoneStepOnNavigateBack: false, // While navigate back done step after active step will be cleared
                    enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
                },
            });

            // External Button Events
            $("#reset-btn").on("click", function() {
                // Reset wizard
                $('#smartwizard').smartWizard("reset");
                return true;
            });

            $("#prev-btn").on("click", function() {
                // Navigate previous
                $('#smartwizard').smartWizard("prev");
                return true;
            });

            $("#next-btn").on("click", function() {
                // Navigate next
                $('#smartwizard').smartWizard("next");
                return true;
            });


            // Demo Button Events
            $("#got_to_step").on("change", function() {
                // Go to step
                var step_index = $(this).val() - 1;
                $('#smartwizard').smartWizard("goToStep", step_index);
                return true;
            });


            $("#dark_mode").on("click", function() {
                // Change dark mode
                var options = {
                    darkMode: $(this).prop("checked")
                };

                $('#smartwizard').smartWizard("setOptions", options);
                return true;
            });

            $("#is_justified").on("click", function() {
                // Change Justify
                var options = {
                    justified: $(this).prop("checked")
                };

                $('#smartwizard').smartWizard("setOptions", options);
                return true;
            });

            $("#animation").on("change", function() {
                // Change theme
                var options = {
                    transition: {
                        animation: $(this).val()
                    },
                };
                $('#smartwizard').smartWizard("setOptions", options);
                return true;
            });

            $("#theme_selector").on("change", function() {
                // Change theme
                var options = {
                    theme: $(this).val()
                };
                $('#smartwizard').smartWizard("setOptions", options);
                return true;
            });

        });
    </script>

    <script src="js/drag-drop-images-edit.js"></script>
    <script src="js/validate-uploaded-images.js"></script>



</body>

</html>