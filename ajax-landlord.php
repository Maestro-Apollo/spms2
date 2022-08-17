<?php
session_start();
date_default_timezone_set("Asia/Hong_Kong");

include('./class/database.php');
class Landlord extends database
{
        public function landFunction()
        {
                $info = addslashes(trim($_POST['info']));

                if ($info != '') {
                        $sql = "SELECT * from building_info where building_info.building like '%" . $info . "%' or building_info.floor like '%" . $info . "%' or building_info.code like '%" . $info . "%';";
                        $res = mysqli_query($this->link, $sql);
                        $text = '';
                        $text .= '<nav aria-label="breadcrumb">
                ';
                        if (mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                        $text .= '<ol class="breadcrumb"><a href="general-page.php?code=' . $row['code'] . '"><li class="breadcrumb-item"><b> Building: </b>' . $row['building'] . '</a></li>
                                <li class="breadcrumb-item"> Floor: ' . $row['floor'] . '</li>
                                <li class="breadcrumb-item active" aria-current="page">Flat: ' . $row['flat'] . '</li><li class="breadcrumb-item active" aria-current="page">Block: ' . $row['block'] . '</li></ol>';
                                }
                        }
                        $text .= '
                </nav>';
                        return $text;
                }
        }
}
$obj = new Landlord;
echo $obj->landFunction();