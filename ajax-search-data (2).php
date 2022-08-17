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
    $info = $_POST['myKey'];

    ## Search 
    $searchQuery = " ";
    if ($searchValue != '') {
        $searchQuery = " and (landlord_details.in_charges like '%" . $searchValue . "%' or 
        landlord_details.tel1 like '%" . $searchValue . "%' or 
        landlord_details.landlord_name like '%" . $searchValue . "%' or 
        building_info.street like '%" . $searchValue . "%' or 
        building_info.building like '%" . $searchValue . "%' or 
        landlord_details.tel2 like '%" . $searchValue . "%' or 
        landlord_details.tel3 like '%" . $searchValue . "%' or 
        landlord_details.bank like '%" . $searchValue . "%' or 
        landlord_details.bank_acc like '%" . $searchValue . "%' or 
        landlord_details.remarks like '%" . $searchValue . "%' or 
        landlord_details.code like '%" . $searchValue . "%' or 
        building_info.district like '%" . $searchValue . "%' or 
        building_info.block like '%" . $searchValue . "%' or 
        building_info.building like '%" . $searchValue . "%' or 
        building_info.floor like '%" . $searchValue . "%' or 
        building_info.flat like '%" . $searchValue . "%' or 
        building_info.no_room like '%" . $searchValue . "%' or 
        building_info.enter_password like '%" . $searchValue . "%' or 
        building_info.cargo_lift like '%" . $searchValue . "%' or 
        building_info.customer_lift like '%" . $searchValue . "%' or 
        building_info.tf_hr like '%" . $searchValue . "%' or 
        facilties.gross_area like '%" . $searchValue . "%' or 
        facilties.salesable_area like '%" . $searchValue . "%' or 
        facilties.rent like '%" . $searchValue . "%')  ";
    }

    $extraCondition = " landlord_details.in_charges = '" . $info . "' OR landlord_details.tel1 = '" . $info . "' OR landlord_details.landlord_name = '" . $info . "' OR building_info.street = '" . $info . "' OR building_info.building = '" . $info . "' OR facilties.gross_area = '" . $info . "' OR facilties.salesable_area = '" . $info . "' OR facilties.rent = '" . $info . "'";

    ## Total number of records without filtering
    $sel = mysqli_query($con, "SELECT count(*) as allcount FROM landlord_details INNER JOIN building_info ON landlord_details.code = building_info.code INNER JOIN facilties ON landlord_details.code = facilties.code WHERE" . $extraCondition);
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($con, "SELECT count(*) as allcount FROM landlord_details INNER JOIN building_info ON landlord_details.code = building_info.code INNER JOIN facilties ON landlord_details.code = facilties.code WHERE" . $extraCondition . $searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "SELECT * FROM landlord_details INNER JOIN building_info ON landlord_details.code = building_info.code INNER JOIN facilties ON landlord_details.code = facilties.code WHERE" . $extraCondition . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
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

            "code" => $row['code'],
            "in_charges" => $row['in_charges'],
            "tel1" => $row['tel1'],
            "tel2" => $row['tel2'],
            "tel3" => $row['tel3'],
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
            "enter_password" => $row['enter_password'],
            "block" => $row['block'],
            "cargo_lift" => $row['cargo_lift'],
            "customer_lift" => $row['customer_lift'],
            "tf_hr" => $row['tf_hr'],
            "gross_area" => $row['gross_area'],
            "salesable_area" => $row['salesable_area'],
            "rent" => $row['rent'],

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