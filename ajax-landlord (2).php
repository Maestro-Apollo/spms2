<?php
session_start();
date_default_timezone_set("Asia/Hong_Kong");

include('./class/database.php');
class Landlord extends database
{
        public function landFunction()
        {
                $info = addslashes(trim($_POST['info']));
                $searchQuery1 = " (building_info.code like '%" . $info . "%' or 
        building_info.district like '%" . $info . "%' or 
        building_info.street like '%" . $info . "%' or 
        building_info.building like '%" . $info . "%' or 
        building_info.floor like '%" . $info . "%' or 
        building_info.flat like '%" . $info . "%' )";



                $sql = "SELECT * from building_info LEFT JOIN landlord_details ON building_info.code = landlord_details.code where $searchQuery1 ";
                $res = mysqli_query($this->link, $sql);
                $text  = '';
                if (mysqli_num_rows($res) > 0) {
                        $row = mysqli_fetch_assoc($res);
                        $name = $_SESSION['name2'];
                        $code = $row['code'];
                        $sqlUpdate = "UPDATE last_update SET username = '$name', updated_at = CURRENT_TIMESTAMP where code = '$code' ";
                        mysqli_query($this->link, $sqlUpdate);

                        $sqlFind = "SELECT * from extra_view where username = '$name' AND DAY(created_at) = DAY(CURRENT_DATE()) AND MONTH(created_at) = MONTH(CURRENT_DATE())
            AND YEAR(created_at) = YEAR(CURRENT_DATE()) order by view_id DESC";
                        $resFind = mysqli_query($this->link, $sqlFind);
                        if (mysqli_num_rows($resFind) <= 10) {

                                $rowFind = mysqli_fetch_assoc($resFind);
                                $count = (isset($rowFind['view_count'])) ? $rowFind['view_count'] : 0;
                                $count++;

                                $sqlView = "INSERT INTO `extra_view` (`view_id`, `username`, `code`, `view_count`, `admin_given`, `created_at`) VALUES (NULL, '$name', '$code', $count, 0, CURRENT_TIMESTAMP)";
                                mysqli_query($this->link, $sqlView);
                        }



                        $text = '<h4 class="font-weight-bold mt-4">Enterance Code: <span class="text-secondary">' . $row['enter_password'] . '</span></h4>
            <h4 class="font-weight-bold text-info">Landlord Details</h4>
            <ul class="list-group">
                <li class="list-group-item list-group-item-success font-weight-bold">In Charge: <span
                        class="text-secondary">' . $row['in_charges'] . '</span>
                </li>
                <li class="list-group-item list-group-item-success font-weight-bold">Telephone: <span
                        class="text-secondary">' . $row['tel1'] . '</span>
                </li>
                <li class="list-group-item list-group-item-success font-weight-bold">Landlord name: <span
                        class="text-secondary">' . $row['landlord_name'] . '</span>
                </li>
                <li class="list-group-item list-group-item-success font-weight-bold">Bank: <span
                        class="text-secondary">' . $row['bank'] . '</span>
                </li>
                <li class="list-group-item list-group-item-success font-weight-bold">Bank: <span
                        class="text-secondary">' . $row['bank'] . '</span>
                </li>
                <li class="list-group-item list-group-item-success font-weight-bold">Bank Acc: <span
                        class="text-secondary">' . $row['bank_acc'] . '</span>
                </li>
                <li class="list-group-item list-group-item-success font-weight-bold">Code: <span
                        class="text-secondary">' . $row['code'] . '</span>
                </li>
                <li class="list-group-item list-group-item-success font-weight-bold">Remark: <span
                        class="text-secondary">' . $row['remarks'] . '</span>
                </li>
              

            </ul>';

                        return $text;
                } else {
                        return false;
                }
        }
}
$obj = new Landlord;
echo $obj->landFunction();
