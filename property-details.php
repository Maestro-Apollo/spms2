<?php
session_start();
error_reporting(0);
if (isset($_SESSION['name2']) || isset($_SESSION['admin2'])) {
} else {
    header('location:login.php');
}
include_once('class/database.php');
require_once 'class/PhotoManager.php';
require_once 'class/SavePhotoManager.php';
class signInUp extends database
{
    protected $link;

    public function signInFunction()
    {
        if (isset($_POST['submit'])) {
            $code = addslashes(trim($_POST['code']));
            $district = addslashes(trim($_POST['district']));
            $street = addslashes(trim($_POST['street']));
            $building = addslashes(trim($_POST['building']));
            $floor = addslashes(trim($_POST['floor']));
            $block = addslashes(trim($_POST['block']));
            $flat = addslashes(trim($_POST['flat']));
            $no_rooms = addslashes(trim($_POST['no_rooms']));
            $cargo_lift = addslashes(trim($_POST['cargo_lift']));
            $customer_lift = addslashes(trim($_POST['customer_lift']));
            $tf_hr = addslashes(trim($_POST['tf_hr']));
            $entry_password = addslashes(trim($_POST['entry_password']));
            $display = addslashes(trim($_POST['display']));
            $year = addslashes(trim($_POST['year']));
            $individual = (isset($_POST['individual'])) ? addslashes(trim($_POST['individual'])) : 'No';
            $separate = (isset($_POST['separate'])) ? addslashes(trim($_POST['separate'])) : 'No';

            $sqlFind = "SELECT * from building_info where code = '$code' ";
            $resFind = mysqli_query($this->link, $sqlFind);
            if (mysqli_num_rows($resFind) > 0) {
                return 'Taken';
            }

            $sql1 = "INSERT INTO `building_info` (`building_id`, `code`, `district`, `street`, `building`, `floor`, `flat`, `no_room`, `enter_password`, `building_created_at`, `block`, `cargo_lift`, `customer_lift`, `tf_hr`, `display_by`, `individual`, `separate`, `year`) VALUES (NULL, '$code', '$district', '$street', '$building', '$floor', '$flat', '$no_rooms', '$entry_password', current_timestamp(), '$block', '$cargo_lift', '$customer_lift', '$tf_hr', '$display', '$individual', '$separate','$year')";

            $res1 = mysqli_query($this->link, $sql1);
            $add = 1;




            $contact1 = (isset($_POST['contact1'])) ? addslashes(trim($_POST['contact1'])) : '';
            $number1 = (isset($_POST['number1'])) ? addslashes(trim($_POST['number1'])) : '';
            $contact2 = (isset($_POST['contact2'])) ? addslashes(trim($_POST['contact2'])) : '';
            $number2 = (isset($_POST['number2'])) ? addslashes(trim($_POST['number2'])) : '';
            $contact3 = (isset($_POST['contact3'])) ? addslashes(trim($_POST['contact3'])) : '';
            $number3 = (isset($_POST['number3'])) ? addslashes(trim($_POST['number3'])) : '';

            $landlord_name = addslashes(trim($_POST['landlord_name']));
            $bank = addslashes(trim($_POST['bank']));
            $bank_account = addslashes(trim($_POST['bank_account']));
            $remakeLand = addslashes(trim($_POST['remark']));


            $sql4 = "INSERT INTO `landlord_details` (`landlord_id`, `landlord_name`, `bank`, `bank_acc`, `remarks`, `code`, `landlord_created_at`, `contact1`, `number1`, `contact2`, `number2`, `contact3`, `number3`) VALUES (NULL, '$landlord_name', '$bank', '$bank_account', '$remakeLand', '$code', current_timestamp(), '$contact1', '$number1', '$contact2', '$number2', '$contact3', '$number3')";

            $res4 = mysqli_query($this->link, $sql4);

            if (isset($_SESSION['name2'])) {
                $username = $_SESSION['name2'];
            } else {
                $username = 'Agent';
            }


            $sqlUser = "INSERT INTO `last_update` (`update_id`, `username`, `code`, `updated_at`) VALUES (NULL, '$username', '$code', CURRENT_TIMESTAMP)";
            mysqli_query($this->link, $sqlUser);

            $admin_comment = addslashes(trim($_POST['admin_comment']));
            $agent_comment = addslashes(trim($_POST['agent_comment']));

            $sqlComment = "INSERT INTO `comment` (`comment_id`, `code`, `admin_comment`, `agent_comment`, `person_name`, `date`) VALUES (NULL, '$code', '$admin_comment', '$agent_comment', '$username', current_timestamp())";
            mysqli_query($this->link, $sqlComment);


            // echo count($_FILES['images']['name']);
            function orientation($orientation)
            {
                foreach ($orientation as $key => $value) {
                    if (strtolower($key) == 'orientation') {
                        return $value;
                    }
                }
            }

            function orientationFlag($flag)
            {
                switch ($flag) {
                    case 1:
                        return 0;
                    case 8:
                        return 90;
                    case 3:
                        return 180;
                    case 6:
                        return 270;

                    default:
                        # code...
                        break;
                }
            }

            (new SavePhotoManager($_POST['photo-session'], $code))->save();

            if ($res1 && $res4) {
                return "Added";
            }
        }
    }
}
$obj = new signInUp;
$objSignIn = $obj->signInFunction();

$photoManager = new PhotoManager();
$photoManager->new_session();

header('Content-Type: text/html; charset=utf-8');

// echo floor(microtime(true) * 1000);
// echo '<br>';
// echo floor(microtime(true) * 1000 + 1);
// echo date("d/m/Y h:i:s a", time() + 30);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
            background-color: #dc3545 !important;
        }

        .list-group {
            height: 300px;
            background-color: skyblue;
            /* position: absolute;
        z-index: 1;
        padding: 0px;
        left: 0;
        right: 0; */


            /* width: 200px; */
            overflow-y: scroll;
        }

        .sw.sw-justified>.nav .nav-link,
        .sw.sw-justified>.nav>li {
            background-color: #F8F8F8;
        }

        .sw-theme-arrows>.nav .nav-link.done {
            color: #fff;
            border-color: gray !important;
            background: gray !important;
            cursor: pointer;
        }
    </style>
    <?php if (isset($_SESSION['admin2'])) { ?>
        <style>
            .bg_color {
                background-color: #3D5B59 !important;
            }
        </style>
    <?php } ?>
    <!-- <link rel="stylesheet" href="css/multi-form.css"> -->
    <link rel="stylesheet" href="css/smart_wizard_all.min.css">
    <?php echo $photoManager->render_css() ?>
</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>
    <!-- <a href="https://api.whatsapp.com/send?text=www.google.com" data-action="share/whatsapp/share">Share via Whatsapp
        web</a> -->

    <section>
        <div class="">
            <form id="form" method="post" enctype="multipart/form-data" data-parsley-validate>


                <!-- <form action="" method="post"> -->
                <div class="mt-5">
                    <div class="container">
                        <?php if ($objSignIn == 'Added') { ?>
                            <div class="alert alert-success alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Successfully Added!</strong>
                            </div>
                        <?php } ?>
                        <?php if ($objSignIn == 'Taken') { ?>
                            <div class="alert alert-danger alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Code is Taken!</strong>
                            </div>
                        <?php } ?>
                        <div id="smartwizard" class="bg-white">

                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-1">
                                        <strong>Building Info</strong>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="#step-4">
                                        <strong>Landlord Details</strong>
                                    </a>
                                </li>


                            </ul>

                            <div class="tab-content">
                                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                                    <h3>Building Info</h3>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Code" id="code" name="code" required>
                                            <div id="outputC"></div>
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="District" name="district">
                                        </div>
                                    </div>

                                    <div>
                                        <input type="text" id="building" class="form-control mt-3" placeholder="Building name" name="building" autocomplete="off" required>
                                        <div id="outputB" class=""></div>
                                    </div>
                                    <div>
                                        <input type="text" id="address" class="form-control mt-3" placeholder="Address" name="street">
                                    </div>
                                    <div>
                                        <input type="text" id="year" class="form-control mt-3" placeholder="Year" name="year">
                                    </div>


                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Block" name="block" autocomplete="off">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Floor" name="floor" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Flat" name="flat" autocomplete="off">
                                        </div>
                                        <div class="col-6">
                                            <input type="number" class="form-control mt-3" placeholder="No of Rooms" name="no_rooms" id="no_rooms">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-0">Room Display By</p>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline1" name="display" class="custom-control-input" value="alp">
                                            <label class="custom-control-label" for="customRadioInline1">A,B,C,D...</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline2" name="display" class="custom-control-input" value="num" checked>
                                            <label class="custom-control-label" for="customRadioInline2">1,2,3,4...</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Cargo Lift" name="cargo_lift">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Customer Lift" name="customer_lift">
                                        </div>
                                        <div class="col-6">
                                            <label for="" class="mt-3 text-center d-block">24 hour</label>
                                            <select id="" name="tf_hr" class="form-control">

                                                <option value="Yes" selected>Yes</option>
                                                <option value="No">No</option>
                                            </select>

                                        </div>
                                        <div class="col-6 mt-4">
                                            <div class="form-group form-check">
                                                <input type="checkbox" class="form-check-input" name="individual" value="Yes" id="exampleCheck1">
                                                <label class="form-check-label" for="exampleCheck1">Individual</label>
                                            </div>
                                            <div class="form-group form-check">
                                                <input type="checkbox" class="form-check-input" name="separate" value="Yes" id="exampleCheck2">
                                                <label class="form-check-label" for="exampleCheck2">Separate</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <input type="text" class="form-control mt-3" placeholder="Entry Password" name="entry_password">
                                        </div>
                                        <?php if (isset($_SESSION['admin2'])) { ?>
                                            <div class="col-12 mt-2">
                                                <textarea name="admin_comment" class="form-control" id="" cols="30" rows="3" placeholder="Admin Comment"></textarea>
                                            </div>
                                        <?php } ?>
                                        <?php if (isset($_SESSION['name2'])) { ?>
                                            <div class="col-12 mt-2">
                                                <textarea name="agent_comment" class="form-control" id="" cols="30" rows="3" placeholder="Agent Comment"></textarea>
                                            </div>
                                        <?php } ?>
                                        <div class="col-12 mt-4">
                                            <button type="submit" name="submit" class="btn btn-block font-weight-bold log_btn btn-lg mt-4">SUBMIT</button>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <?php echo $photoManager->render_input(); ?>
                                        </div>

                                    </div>

                                    <button type="submit" name="submit" class="btn btn-block font-weight-bold log_btn btn-lg mt-4">SUBMIT</button>
                                </div>


                                <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                                    <h3>Landlord Details</h3>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Contact 1" name="contact1">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Number 1" name="number1">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Contact 2" name="contact2">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Number 2" name="number2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Contact 3" name="contact3">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control mt-3" placeholder="Number 3" name="number3">
                                        </div>
                                    </div>
                                    <input type="text" class="form-control mt-3" placeholder="Landlord Name" name="landlord_name">
                                    <input type="text" class="form-control mt-3" placeholder="Bank" name="bank">
                                    <input type="text" class="form-control mt-3" placeholder="Bank account" name="bank_account">
                                    <textarea name="remark" class="form-control mt-3" placeholder="Remark" id="" cols="30" rows="5"></textarea>
                                    <button type="submit" name="submit" class="btn btn-block font-weight-bold log_btn btn-lg mt-4">SUBMIT</button>
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

    <?php echo $photoManager->render_scripts() ?>

    <script>
        $(document).ready(function() {
            var i = 1;

            $('#add').click(function() {
                i++;
                $('#tbody').prepend(
                    '<tr id="row' + i +
                    '"><td><input type="text" class="form-control" name="contact[]" ></td><td><input type="text" class="form-control" name="pnumber[]" ></td><td><button type="button" name="remove" id="' +
                    i +
                    '" class="btn btn-danger btn_remove"><i class="fas fa-trash-alt"></i></button></td></tr>'
                );


            });


            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });

        });
    </script>

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
            $('#no_rooms').on('input', function() {

                let myCode = $('#no_rooms').val();
                $('#tb1').empty();
                $('#tb2').empty();
                $('#tb3').empty();
                let string = '';
                let string2 = '';
                let string3 = '';
                // $('#output').html(myCode);

                for (let i = 1; i <= myCode; i++) {
                    string += (`<tr id="d1"><th scope="row">${i}</th>
                                                    <td><input type="number" class="form-control" name="gross_area[]">
                                                    </td>
                                                    <td><input type="number" class="form-control" name="salesable_area[]">
                                                    </td>
                                                    <td><input type="number" class="form-control" name="rent[]"></td>
                                                    <td><input type="checkbox" class="checkBoxClassP1" value="Yes" name="Windows[${i}][]" /> Yes</td>
                                                    <td><input type="checkbox" class="checkBoxClassP2" value="Yes" name="Lavatory[${i}][]" /> Yes</td>
                                                    <td><input type="checkbox" class="checkBoxClassP3" value="Yes" name="Shower[${i}][]" /> Yes</td>
                                                    <td><input type="checkbox" class="checkBoxClassP4" value="Yes" name="Sink[${i}][]" /> Yes</td>
                                                    <td><input type="checkbox" class="checkBoxClassP5" value="Yes" name="Wide_door[${i}][]" /> Yes</td>
                                                    <td><input type="checkbox" class="checkBoxClassP6" value="Yes" name="Brickes_wall[${i}][]" /> Yes</td>
                                                    <td><input type="checkbox" class="checkBoxClassP7" value="Yes" name="Seprate_room[${i}][]" /> Yes
                                                    </td>
                                                    <td><input type="checkbox" class="checkBoxClassP8" value="Yes" name="Electronic_keys[${i}][]" /> Yes
                                                    </td>
                                                    <td><input type="checkbox" class="checkBoxClassP9" value="Yes" name="Wifi[${i}][]" /> Yes</td>
                                                    <td><input type="text" class="form-control" name="Remarks[]"></td>
                                                </tr>`);

                    string2 += (`<tr>
                                                    <th scope="row">${i}</th>
<input type="hidden" value="Yes" name="keyNumber[]" />
                                                    <td><input type="checkbox" class="checkBoxClass1" value="Yes" name="Individual[${i}][]" /> Yes</td>
                                                    <td><input type="checkbox" class="checkBoxClass2" value="Yes" name="Seprate[${i}][]" /> Yes
                                                    </td>
                                                    <td><input type="checkbox" class="checkBoxClass3" value="Yes" name="Studio[${i}][]" /> Yes</td>
                                                    <td><input type="checkbox" class="checkBoxClass4" value="Yes" name="Yoga[${i}][]" /> Yes</td>
                                                    <td><input type="checkbox" class="checkBoxClass5" value="Yes" name="Class[${i}][]" /> Yes</td>
                                                    <td><input type="checkbox" class="checkBoxClass6" value="Yes" name="Overnight[${i}][]" /> Yes</td>
                                                    <td><input type="checkbox" class="checkBoxClass7" value="Yes" name="Warehouse_office[${i}][]" /> Yes</td>
                                                    <td><input type="checkbox" class="checkBoxClass8" value="Yes" name="Beauty[${i}][]" /> Yes</td>
                                                    <td><input type="checkbox" class="checkBoxClass9" value="Yes" name="Upstair_shop[${i}][]" /> Yes</td>
                                                    <td><input type="checkbox" class="checkBoxClass10" value="Yes" name="Band[${i}][]" /> Yes
                                                    </td>
                                                    <td><input type="checkbox" class="checkBoxClass11" value="Yes" name="Recording_room[${i}][]" /> Yes
                                                    </td>
                                                    <td><input type="checkbox" class="checkBoxClass12" value="Yes" name="piano[${i}][]" /> Yes</td>
                                                    <td><input type="checkbox" class="checkBoxClass13" value="Yes" name="Painting[${i}][]" /> Yes</td>
                                                    <td><input type="text" class="form-control" name="Remarks[]"></td>
                                                </tr>`);

                    string3 += (`<tr>
                                                    <th scope="row">${i}</th>

                                                    <td id="images-input-${i}-cell" class="images-input-cell" data-roomnum="${i}">
                                                    <label for="images-input-${i}" class="tb3-images-input-label">
                                                    <i class="fa fa-cloud-upload"></i> Upload images
                                                    </label>
                                                    <input id="images-input-${i}" class="tb3-images-input" type="file" name="item[image${i}][]" multiple>
                                                    </td>

                                                </tr>`);
                }
                $('#tb1').append(string);
                $('#tb2').append(string2);
                $('#tb3').append(string3);
                // a hidden input for the images uploading response submitted with the form
                // $('#tb3').append(
                //     `<input type="hidden" name="uploaded-images-data" id="uploaded-images-data" value="">`
                // );
            })

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
                // autoAdjustHeight: false,
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

    <script>
        $(document).ready(function() {
            $('#building').keyup(function() {
                let building = $(this).val();
                if (building != '') {
                    $.ajax({
                        type: "POST",
                        url: "ajaxBuilding.php",
                        data: {
                            building: building
                        },
                        dataType: "text",
                        success: function(data) {
                            $('#outputB').fadeIn();
                            $('#outputB').html(data);
                        }
                    });
                } else {
                    $('#outputB').fadeOut();
                    $('#outputB').html("");
                }

            });
            $('#outputB').parent().on('click', 'li', function() {
                $('#building').val($(this).text());
                let text1 = $(this).text();
                $.ajax({
                    type: "POST",
                    url: "ajaxNewLocations.php",
                    data: {
                        text1: text1
                    },
                    dataType: "text",
                    success: function(data) {
                        data = JSON.parse(data);
                        console.log(data.address_chinese);
                        console.log(data.year);
                        $('#address').val(data.address_chinese);
                        $('#year').val(data.year);
                    }
                });
                $('#outputB').fadeOut();
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#code').keyup(function() {
                let code = $(this).val();
                if (code != '') {
                    $.ajax({
                        type: "POST",
                        url: "ajaxCode.php",
                        data: {
                            code: code
                        },
                        dataType: "text",
                        success: function(data) {
                            $('#outputC').fadeIn();
                            $('#outputC').html(data);
                        }
                    });
                } else {
                    $('#outputC').fadeOut();
                    $('#outputC').html("");
                }

            });
            $('#outputC').parent().on('click', 'li', function() {
                $('#code').val($(this).text());
                $('#outputC').fadeOut();
            });

        });
    </script>


</body>

</html>