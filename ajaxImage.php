<?php
session_start();

include 'config.php';

$request = 1;
if (isset($_POST['request'])) {
    $request = $_POST['request'];
}

// DataTable data
if ($request == 1) {
    ## Read value
    $draw = $_POST['draw'];
    $row = $_POST['start'];
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = ' image_created_at'; // Column name
    $columnSortOrder = ' DESC'; // asc or desc

    $searchValue = mysqli_escape_string($con, $_POST['search']['value']); // Search value
    $code = $_POST['code'];
    ## Search 
    $searchQuery = " ";
    if ($searchValue != '') {
        $searchQuery = " and (image like '%" . $searchValue . "%')  ";
    }

    ## Total number of records without filtering
    $sel = mysqli_query($con, "select count(*) as allcount from photos where code ='$code'");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($con, "select count(*) as allcount from photos WHERE code='$code'" . $searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "select * from photos WHERE code ='$code'" . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

    while ($row = mysqli_fetch_assoc($empRecords)) {

        // Update Button


        // Delete Button
        $deleteButton = "<button class='btn btn-sm btn-danger deleteUser' data-id='" . $row['image_id'] . "'>Delete</button>";

        $action = $deleteButton;

        $img = '<img src="./test_file/' . $row['image'] . '" class="img-fluid">';


        $data[] = array(

            "image" => $img,
            "action" => $action
        );
    }

    ## Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );

    echo json_encode($response);
    exit;
}
if ($request == 4) {
    $id = 0;

    if (isset($_POST['id'])) {
        $id = mysqli_escape_string($con, $_POST['id']);
    }

    // Check id
    $record = mysqli_query($con, "SELECT image_id FROM photos WHERE image_id=" . $id);
    if (mysqli_num_rows($record) > 0) {

        mysqli_query($con, "DELETE FROM photos WHERE image_id=" . $id);


        echo 1;
        exit;
    } else {
        echo 0;
        exit;
    }
}
if ($request == 5) {
    $code = $_POST['code'];
    mysqli_query($con, "DELETE FROM photos WHERE code= '$code' ");


    echo 1;
    exit;
}

// Fetch user details