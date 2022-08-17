<?php
include('./config.php');
if ($con) {

    $user = trim($_POST['agent_name']);

    if (isset($user)) {
        $output = '';
        $sql = "SELECT * from extra_view where username like '%$user%' group by username";
        $res = mysqli_query($con, $sql);
        $output = '<ul class="list-group">';
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '<li class="list-group-item list-group-item-action list-group-item-dark">' . $row['username'] . '</li>';
            }
        } else {
            $output .= '<p class="text-danger text-center font-weight-bold">No username found</p>';
        }
        $output .= '</ul>';
        echo $output;
    }
}