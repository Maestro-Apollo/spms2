<?php
include('class/database.php');
class View extends database
{
    public function viewShow()
    {
        $name = addslashes(trim($_POST['agent_name']));
        $view = addslashes(trim($_POST['view_number']));

        $sql = "SELECT * from extra_view where username = '$name' order by view_id DESC";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $id = $row['view_id'];

            $sqlUpdate = "UPDATE extra_view SET admin_given = '$view' WHERE view_id = '$id' ";
            $resUpdate = mysqli_query($this->link, $sqlUpdate);
            if ($resUpdate) {
                return '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Successfully Added!</strong>
              </div>';
            } else {
                return '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Not Added!</strong>
              </div>';
            }
        }
        # code...
    }
}
$obj = new View;
echo $obj->viewShow();