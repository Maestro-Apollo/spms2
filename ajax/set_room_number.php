<?php
include '../include/auth.php';
include_once('../class/database.php');

if (!empty($_REQUEST['photo_id']) && isset($_REQUEST['room_number'])){
    $rn = mysqli_escape_string(database::conn(), $_REQUEST['room_number']);
    $id = mysqli_escape_string(database::conn(), $_REQUEST['photo_id']);
    $sql = "update photos set room_number = '$rn' where image_id = '$id'";
    $res = database::query($sql);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Room number not set']);
}