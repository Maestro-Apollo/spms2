<?php
session_start();
include('class/database.php');
class view extends database
{
    public function viewFunction()
    {
        $name = $_SESSION['name2'];
        $sql = "SELECT * from extra_view where username = '$name' AND DAY(created_at) = DAY(CURRENT_DATE()) AND MONTH(created_at) = MONTH(CURRENT_DATE())
        AND YEAR(created_at) = YEAR(CURRENT_DATE()) order by view_id DESC";
        $res = mysqli_query($this->link, $sql);
        $row = mysqli_fetch_assoc($res);
        $s = isset($row['admin_given']) ? $row['admin_given'] : 0;
        $l = isset($row['view_count']) ? $row['view_count'] : 0;

        $total = $s + (15 - $l);
        if ($total) {
            return $total;
        } else {
            return 0;
        }
        # code...
    }
}
$obj = new view;
echo $obj->viewFunction();
