<?php
include('./config.php');
if ($con) {

    $user = trim($_POST['address']);

    if (isset($user)) {
        $output = '';
        $sql = "SELECT * from all_address where `address` like '%$user%' ";
        $res = mysqli_query($con, $sql);
        $output = '<ul class="list-group">';
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '<li class="list-group-item list-group-item-action list-group-item-dark">' . $row['address'] . '</li>';
            }
        } else {
            $output .= '<p class="text-danger text-center font-weight-bold">No Address found</p>';
        }
        $output .= '</ul>';
        echo $output;
    }
}