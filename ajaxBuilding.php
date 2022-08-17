<?php
include('./config.php');
if ($con) {

    $user = trim($_POST['building']);

    if (isset($user)) {
        $output = '';
        $sql = "SELECT * from new_add where building_name like '%$user%' ";
        $res = mysqli_query($con, $sql);
        $output = '<ul class="list-group">';
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '<li class="list-group-item list-group-item-action list-group-item-dark">' . $row['building_name'] . '</li>';
            }
        } else {
            $output .= '<p class="text-danger text-center font-weight-bold">No Building found</p>';
        }
        $output .= '</ul>';
        echo $output;
    }
}