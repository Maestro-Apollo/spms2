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
    $columnName = ' building_created_at'; // Column name
    $columnSortOrder = ' DESC'; // asc or desc

    $searchValue = mysqli_escape_string($con, $_POST['search']['value']); // Search value

    ## Search 
    $searchQuery = " ";
    if ($searchValue != '') {
        $searchQuery = " and (code like '%" . $searchValue . "%' or 
            district like '%" . $searchValue . "%' or 
            street like'%" . $searchValue . "%' or 
            building like'%" . $searchValue . "%')  ";
    }

    ## Total number of records without filtering
    $sel = mysqli_query($con, "select count(*) as allcount from building_info");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($con, "select count(*) as allcount from building_info WHERE 1" . $searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "select * from building_info WHERE 1" . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

    while ($row = mysqli_fetch_assoc($empRecords)) {

        // Update Button


        // Delete Button
        $deleteButton = "<button class='btn btn-block btn-sm btn-danger deleteUser' data-id='" . $row['building_id'] . "'>Delete</button>";
        $imageButton = "<a href='deletePhotos.php?code=" . $row['code'] . "' class='btn btn-block btn-sm btn-success' data-id='" . $row['building_id'] . "'>View Photos</a>";

        $action = $deleteButton . $imageButton;
        if (isset($_SESSION['admin2'])) {
            $link = '<a href="general-page.php?code=' . $row['code'] . '">' . $row['code'] . '</a>';
        } else {
            $link = $row['code'];
        }


        $data[] = array(
            "code" => $link,
            "district" => $row['district'],
            "street" => $row['street'],
            "building" => $row['building'],
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
    $record = mysqli_query($con, "SELECT building_id FROM building_info WHERE building_id=" . $id);
    if (mysqli_num_rows($record) > 0) {

        mysqli_query($con, "DELETE FROM building_info WHERE building_id=" . $id);


        echo 1;
        exit;
    } else {
        echo 0;
        exit;
    }
}

// Fetch user details