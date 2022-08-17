<?php
session_start();
error_reporting(0);
include('./class/database.php');
require_once 'class/PhotoManager.php';
require_once 'class/SavePhotoManager.php';
require_once 'class/EditPhotoManager.php';

class Update extends database
{
    public function signInFunction()
    {
        if (isset($_POST['submit'])) {
            $code = addslashes(trim($_POST['code']));
            $code2 = addslashes(trim($_POST['code2']));
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

            $sql1 = "UPDATE `building_info` SET `code` = '$code', `district`='$district',`street`='$street',`building`='$building',`floor`='$floor',`flat`='$flat',`no_room`='$no_rooms',`enter_password`='$entry_password',`building_created_at`=CURRENT_TIMESTAMP,`block`='$block',`cargo_lift`='$cargo_lift',`customer_lift`='$customer_lift',`tf_hr`='$tf_hr',`display_by`='$display',`individual`='$individual',`separate`='$separate', `year` = '$year' WHERE `code` = '$code2' ";

            $res1 = mysqli_query($this->link, $sql1);
            $add = 1;

            $admin_comment = addslashes(trim($_POST['admin_comment']));
            $agent_comment = addslashes(trim($_POST['agent_comment']));

            if (isset($_SESSION['name2'])) {
                $AgentName = $_SESSION['name2'];
            } else {
                $AgentName = "Agent";
            }

            $sqlF = "SELECT * from comment where code = '$code' ";
            $resF = mysqli_query($this->link, $sqlF);
            if (mysqli_num_rows($resF) > 0) {
                $sqlComment = "UPDATE comment SET code = '$code', person_name = '$AgentName', admin_comment = '$admin_comment' , agent_comment = '$agent_comment', `date` = CURRENT_TIMESTAMP where code = '$code2'  ";
                mysqli_query($this->link, $sqlComment);
            } else {
                $sqlC = "INSERT INTO `comment` (`comment_id`, `code`, `admin_comment`, `agent_comment`, `person_name`, `date`) VALUES (NULL, '$code', '', '', '', current_timestamp())";
                mysqli_query($this->link, $sqlC);
                $sqlComment = "UPDATE comment SET code = '$code', person_name = '$AgentName', admin_comment = '$admin_comment' , agent_comment = '$agent_comment', `date` = CURRENT_TIMESTAMP where code = '$code2'  ";
                mysqli_query($this->link, $sqlComment);
            }





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


            $sql4 = "UPDATE `landlord_details` SET `code` = '$code', `landlord_name`='$landlord_name',`bank`='$bank',`bank_acc`='$bank_account',`remarks`='$remakeLand',`landlord_created_at`=CURRENT_TIMESTAMP,`contact1`='$contact1',`number1`='$number1',`contact2`='$contact2',`number2`='$number2',`contact3`='$contact3',`number3`='$number3' WHERE code = '$code2' ";

            $res4 = mysqli_query($this->link, $sql4);

            // $sql5 = "UPDATE `photos` SET `code` = '$code' WHERE code = '$code2' ";
            // mysqli_query($this->link, $sql5);

            $username = "boshing2021";

            $sqlUser = "INSERT INTO `last_update` (`update_id`, `username`, `code`, `updated_at`) VALUES (NULL, '$username', '$code', CURRENT_TIMESTAMP)";
            mysqli_query($this->link, $sqlUser);


            if (!empty($_POST['photo-session'])) {
                (new SavePhotoManager($_POST['photo-session'], $_POST['code']))->save();
            }


            if ($res1 && $res4) {
                header('location:general-page.php?code=' . $code);
            }
        }
    }
}
$obj = new Update;
$obj->signInFunction();