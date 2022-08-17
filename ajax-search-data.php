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
        $searchQuery = " and (
        landlord_details.landlord_name like '%" . $searchValue . "%' or 
        building_info.street like '%" . $searchValue . "%' or 
        building_info.building like '%" . $searchValue . "%' or 
        landlord_details.contact1 like '%" . $searchValue . "%' or
        landlord_details.number1 like '%" . $searchValue . "%' or
        landlord_details.contact2 like '%" . $searchValue . "%' or
        landlord_details.number2 like '%" . $searchValue . "%' or
        landlord_details.contact3 like '%" . $searchValue . "%' or
        landlord_details.number3 like '%" . $searchValue . "%' or
        landlord_details.bank like '%" . $searchValue . "%' or 
        landlord_details.bank_acc like '%" . $searchValue . "%' or 
        landlord_details.remarks like '%" . $searchValue . "%' or 
        landlord_details.code like '%" . $searchValue . "%' or 
        building_info.district like '%" . $searchValue . "%' or 
        building_info.block like '%" . $searchValue . "%' or 
        building_info.floor like '%" . $searchValue . "%' or 
        building_info.flat like '%" . $searchValue . "%' or 
        building_info.no_room like '%" . $searchValue . "%' or 
        building_info.cargo_lift like '%" . $searchValue . "%' or 
        building_info.customer_lift like '%" . $searchValue . "%' or 
        building_info.tf_hr like '%" . $searchValue . "%')  ";
    }



    ## Total number of records without filtering
    $sel = mysqli_query($con, "SELECT count(*) as allcount FROM landlord_details INNER JOIN building_info ON landlord_details.code = building_info.code");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($con, "SELECT count(*) as allcount FROM landlord_details INNER JOIN building_info ON landlord_details.code = building_info.code WHERE 1" . $searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "SELECT * FROM landlord_details INNER JOIN building_info ON landlord_details.code = building_info.code WHERE 1" . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

    while ($row = mysqli_fetch_assoc($empRecords)) {

        // Update Button
        // $updateButton = "<button class='btn btn-sm btn-info updateUser' data-id='" . $row['building_id'] . "' data-toggle='modal' data-target='#updateModal' >Update</button>";

        // // Delete Button
        // $deleteButton = "<button class='btn btn-sm btn-danger deleteUser' data-id='" . $row['building_id'] . "'>Delete</button>";

        // $action = $updateButton . " " . $deleteButton;
        // $link = '<a href="general-page.php?code=' . $row['code'] . '">' . $row['code'] . '</a>';

        $data[] = array(

            "code" => '<a href="general-page.php?code=' . $row['code'] . '">' . $row['code'] . '</a>',
            "contact1" => $row['contact1'],
            "number1" => $row['number1'],
            "contact2" => $row['contact2'],
            "number2" => $row['number2'],
            "contact3" => $row['contact3'],
            "number3" => $row['number3'],

            "landlord_name" => $row['landlord_name'],
            "bank" => $row['bank'],
            "bank_acc" => $row['bank_acc'],
            "remarks" => $row['remarks'],
            "district" => $row['district'],
            "street" => $row['street'],
            "building" => $row['building'],
            "floor" => $row['floor'],
            "flat" => $row['flat'],
            "no_room" => $row['no_room'],
            "block" => $row['block'],
            "cargo_lift" => $row['cargo_lift'],
            "customer_lift" => $row['customer_lift'],
            "tf_hr" => $row['tf_hr'],


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

// Fetch user details