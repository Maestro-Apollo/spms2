<?php
include('./config.php');
if ($con) {

    $user = trim($_POST['text1']);

    if (isset($user)) {
        $output = array();
        $sql = "SELECT * from new_add where building_name = '$user' ";
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            array_push($output, $row['address_chinese']);
            array_push($output, $row['year']);
        }
        echo json_encode($row, JSON_UNESCAPED_UNICODE);
    }
}