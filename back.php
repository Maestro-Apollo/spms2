<?php
require './class/database.php';
session_start();
class Property extends database
{
    public function searchFunc()
    {
        $building = addslashes(trim($_POST['building']));

        $include1 = (isset($_POST['include1'])) ? addslashes(trim($_POST['include1'])) : false;
        $include2 = (isset($_POST['include2'])) ? addslashes(trim($_POST['include2'])) : false;


        $gross1 = ($_POST['gross1']) ? addslashes(trim($_POST['gross1'])) : 0;
        $gross2 = ($_POST['gross2']) ? addslashes(trim($_POST['gross2'])) : 0;
        $sailable1 = ($_POST['sailable1']) ? addslashes(trim($_POST['sailable1'])) : 0;
        $sailable2 = ($_POST['sailable2']) ? addslashes(trim($_POST['sailable2'])) : 0;
        $price1 = ($_POST['price1']) ? addslashes(trim($_POST['price1'])) : 0;
        $price2 = ($_POST['price2']) ? addslashes(trim($_POST['price2'])) : 0;
        $Cargo = (isset($_POST['Cargo'])) ? addslashes(trim($_POST['Cargo'])) : 'No';
        $Customer = (isset($_POST['Customer'])) ? addslashes(trim($_POST['Customer'])) : 'No';
        $hours = (isset($_POST['hours'])) ? addslashes(trim($_POST['hours'])) : 'No';
        $Windows = (isset($_POST['Windows'])) ? addslashes(trim($_POST['Windows'])) : 'No';
        $Lavatory = (isset($_POST['Lavatory'])) ? addslashes(trim($_POST['Lavatory'])) : 'No';
        $Shower = (isset($_POST['Shower'])) ? addslashes(trim($_POST['Shower'])) : 'No';
        $Sink = (isset($_POST['Sink'])) ? addslashes(trim($_POST['Sink'])) : 'No';
        $Door = (isset($_POST['Door'])) ? addslashes(trim($_POST['Door'])) : 'No';
        $Wall = (isset($_POST['Wall'])) ? addslashes(trim($_POST['Wall'])) : 'No';
        $SeparateRoom = (isset($_POST['SeparateRoom'])) ? addslashes(trim($_POST['SeparateRoom'])) : 'No';
        $Keys = (isset($_POST['Keys'])) ? addslashes(trim($_POST['Keys'])) : 'No';
        $Wifi = (isset($_POST['Wifi'])) ? addslashes(trim($_POST['Wifi'])) : 'No';
        // $Customer = addslashes(trim($_POST['Customer']));
        // $hours = addslashes(trim($_POST['hours']));
        // $Windows = addslashes(trim($_POST['Windows']));
        // $Lavatory = addslashes(trim($_POST['Lavatory']));
        // $Shower = addslashes(trim($_POST['Shower']));
        // $Sink = addslashes(trim($_POST['Sink']));
        // $Door = addslashes(trim($_POST['Door']));
        // $Wall = addslashes(trim($_POST['Wall']));
        // $SeparateRoom = addslashes(trim($_POST['SeparateRoom']));
        // $Keys = addslashes(trim($_POST['Keys']));
        // $Wifi = addslashes(trim($_POST['Wifi']));

        $individual = (isset($_POST['individual'])) ? addslashes(trim($_POST['individual'])) : 'No';
        $Separate = (isset($_POST['Separate'])) ? addslashes(trim($_POST['Separate'])) : 'No';
        $Studio = (isset($_POST['Studio'])) ? addslashes(trim($_POST['Studio'])) : 'No';
        $Yoga = (isset($_POST['Yoga'])) ? addslashes(trim($_POST['Yoga'])) : 'No';
        $Class2 = (isset($_POST['Class2'])) ? addslashes(trim($_POST['Class2'])) : 'No';
        $Overnight = ($_POST['Overnight']) ? addslashes(trim($_POST['Overnight'])) : 'No';
        $Warehouse = (isset($_POST['Warehouse'])) ? addslashes(trim($_POST['Warehouse'])) : 'No';
        $Beauty = (isset($_POST['Beauty'])) ? addslashes(trim($_POST['Beauty'])) : 'No';
        $Shop = (isset($_POST['Shop'])) ? addslashes(trim($_POST['Shop'])) : 'No';
        $Band = (isset($_POST['Band'])) ? addslashes(trim($_POST['Band'])) : 'No';
        $Recording = (isset($_POST['Recording'])) ? addslashes(trim($_POST['Recording'])) : 'No';
        $Piano = (isset($_POST['Piano'])) ? addslashes(trim($_POST['Piano'])) : 'No';
        $Painting = (isset($_POST['Painting'])) ? addslashes(trim($_POST['Painting'])) : 'No';

        // $individual = addslashes(trim($_POST['individual']));
        // $Separate = addslashes(trim($_POST['Separate']));
        // $Studio = addslashes(trim($_POST['Studio']));
        // $Yoga = addslashes(trim($_POST['Yoga']));
        // $Class2 = addslashes(trim($_POST['Class2']));
        // $Overnight = addslashes(trim($_POST['Overnight']));
        // $Warehouse = addslashes(trim($_POST['Warehouse']));
        // $Beauty = addslashes(trim($_POST['Beauty']));
        // $Shop = addslashes(trim($_POST['Shop']));
        // $Band = addslashes(trim($_POST['Band']));
        // $Recording = addslashes(trim($_POST['Recording']));
        // $Piano = addslashes(trim($_POST['Piano']));
        // $Painting = addslashes(trim($_POST['Painting']));

        $searchQuery1 = " and (building_info.code like '%" . $building . "%' or 
        building_info.district like '%" . $building . "%' or 
        building_info.street like '%" . $building . "%' or 
        building_info.building like '%" . $building . "%' or 
        building_info.floor like '%" . $building . "%' or 
        building_info.flat like '%" . $building . "%' )";



        $searchQuery2 = "  (facilties.cargo_lift = '" . $Cargo . "' AND 
        facilties.customer_lift = '" . $Customer . "' AND 
        facilties.tf_hours = '" . $hours . "' AND 
        facilties.windows = '" . $Windows . "' AND 
        facilties.lavatory = '" . $Lavatory . "' AND 
        facilties.shower = '" . $Shower . "' AND 
        facilties.sink = '" . $Sink . "' AND 
        facilties.wide_door = '" . $Door . "' AND 
        facilties.brickes_wall = '" . $Wall . "' AND 
        facilties.seprate_room = '" . $SeparateRoom . "' AND 
        facilties.electronic_keys = '" . $Keys . "' AND 
        facilties.wifi = '" . $Wifi . "' AND (facilties.gross_area BETWEEN " . $gross1 . " AND " . $gross2 . ") or (facilties.salesable_area BETWEEN " . $sailable1 . " AND " . $sailable2 . ") or (facilties.rent BETWEEN " . $price1 . " AND " . $price2 . "))";


        $searchQuery3 = "  (types.individual = '" . $individual . "' AND 
        types.seprate = '" . $Separate . "' AND 
        types.studio = '" . $Studio . "' AND 
        types.yoga = '" . $Yoga . "' AND 
        types.class = '" . $Class2 . "' AND 
        types.overnight = '" . $Overnight . "' AND 
        types.warehouse_office = '" . $Warehouse . "' AND 
        types.beauty = '" . $Beauty . "' AND 
        types.upstair_shop = '" . $Shop . "' AND 
        types.band = '" . $Band . "' AND 
        types.recording_room = '" . $Recording . "' AND 
        types.piano = '" . $Piano . "' AND 
        types.painting = '" . $Painting . "')";


        if ($include1 == 'Yes' && $include2 == 'Yes') {
            $sql = "SELECT * FROM `facilties` LEFT JOIN types ON facilties.facilties_id = types.types_id LEFT JOIN building_info ON building_info.code = facilties.code WHERE building_info.code IS NOT NULL $searchQuery1 AND $searchQuery2 AND 1";
        }
        if ($include1 == 'Yes' && $include2 == false) {
            $sql = "SELECT * FROM `facilties` LEFT JOIN types ON facilties.facilties_id = types.types_id LEFT JOIN building_info ON building_info.code = facilties.code WHERE building_info.code IS NOT NULL $searchQuery1 AND $searchQuery2 AND 1";
        }
        if ($include1 == false && $include2 == 'Yes') {
            $sql = "SELECT * FROM `facilties` LEFT JOIN types ON facilties.facilties_id = types.types_id LEFT JOIN building_info ON building_info.code = facilties.code WHERE building_info.code IS NOT NULL $searchQuery1 AND 1 AND $searchQuery3";
        }
        if ($include1 == false && $include2 == false) {
            $sql = "SELECT * FROM `facilties` LEFT JOIN types ON facilties.facilties_id = types.types_id LEFT JOIN building_info ON building_info.code = facilties.code WHERE building_info.code IS NOT NULL $searchQuery1 AND 1 AND 1";
        }

        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
    }
}
$obj = new Property;
$objShow = $obj->searchFunc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>

    <style>
    body {
        font-family: 'Lato', sans-serif;

    }

    .navbar-brand {
        width: 7%;
    }

    .bg_color {
        background-color: #274472 !important;
    }

    .divider {
        background-color: #274472;
        height: 5px;
        width: 75%;
    }
    </style>

</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>

    <section>
        <div class="container bg-white p-4  log_section pb-5">

            <h3 class="font-weight-bold">These are <?php echo mysqli_num_rows($objShow); ?> results find</h3>
            <small class="text-nowrap">(Building/Floor/Flat/Room/Gross Area/Saleable Area/Price)</small>
            <?php if ($objShow) { ?>
            <?php while ($row = mysqli_fetch_assoc($objShow)) { ?>
            <nav aria-label="breadcrumb mb-1 mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#"><?php echo $row['building']; ?></a></li>
                    <li class="breadcrumb-item"><a href="#"><?php echo $row['floor']; ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $row['flat']; ?></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $row['no_room']; ?></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $row['gross_area']; ?></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $row['salesable_area']; ?></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $row['rent']; ?></li>
                </ol>
            </nav>
            <?php } ?>
            <?php } ?>
        </div>

    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>
    <!-- <script>
    $(document).ready(function() {
        $('#msg').hide();

        $('#msg-btn').click(function(e) {
            e.preventDefault();
            $('#msg').toggle();

        })
    })
    </script> -->
</body>

</html>