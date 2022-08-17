<?php
include('./config.php');
if ($con) {

    $user = trim($_POST['code']);

    if (isset($user)) {
        $output = '';
        $sql = "SELECT * from building_info where code = '$user' ";
        $res = mysqli_query($con, $sql);
        // $output = '<ul class="list-group">';
        if (mysqli_num_rows($res) > 0) {
            $output .= '<p class="text-danger mb-0">Not Available</p>';
        } else {
            $output .= '<p class="text-success mb-0">Available</p>';
        }
        // $output .= '</ul>';
        echo $output;
    }
}