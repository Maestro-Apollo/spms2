<?php
session_start();
if (isset($_SESSION['name2']) || isset($_SESSION['admin2'])) {
} else {
    header('location:login.php');
}
include_once('class/database.php');
class signInUp extends database
{
    protected $link;
    public function showFunction()
    {
        $code = $_GET['code'];
        $sql = "SELECT * from building_info where code = '$code' ";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function showImages()
    {
        $code = $_GET['code'];
        $sql = "SELECT * from photos where code = '$code' ";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function showLandlord()
    {
        $code = $_GET['code'];
        $sql = "SELECT * from landlord_details where code = '$code' ";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
    public function showComment()
    {
        $code = $_GET['code'];
        $sql = "SELECT * from comment where code = '$code' ";
        $res = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($res) > 0) {
            return $res;
        } else {
            return false;
        }
        # code...
    }
}
$obj = new signInUp;
$objSignIn = $obj->showFunction();
$objImages = $obj->showImages();
$objLandLord = $obj->showLandlord();
$objComment = $obj->showComment();
$row = mysqli_fetch_assoc($objSignIn);
$rowLand = mysqli_fetch_assoc($objLandLord);

if (is_object($objComment)) {
    $rowComment = mysqli_fetch_assoc($objComment);
}

header('Content-Type: text/html; charset=utf-8');

// echo floor(microtime(true) * 1000);
// echo '<br>';
// echo floor(microtime(true) * 1000 + 1);
// echo date("d/m/Y h:i:s a", time() + 30);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="./image-uploader/image-uploader.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
    <style>
    body {
        font-family: 'Lato', sans-serif;

    }

    .navbar-brand {
        width: 7%;
    }

    section {
        padding: 0px;
    }

    .table th {
        white-space: nowrap;
    }

    .bg_color {
        background-color: #274472 !important;
    }

    .list-group {
        height: 300px;
        background-color: skyblue;
        /* position: absolute;
        z-index: 1;
        padding: 0px;
        left: 0;
        right: 0; */


        /* width: 200px; */
        overflow-y: scroll;
    }

    .sw.sw-justified>.nav .nav-link,
    .sw.sw-justified>.nav>li {
        background-color: #F8F8F8;
    }
    </style>
    <?php if (isset($_SESSION['admin2'])) { ?>
    <style>
    .bg_color {
        background-color: #3D5B59 !important;
    }
    </style>
    <?php } ?>
    <!-- <link rel="stylesheet" href="css/multi-form.css"> -->
    <link rel="stylesheet" href="css/smart_wizard_all.min.css">
</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>
    <!-- <a href="https://api.whatsapp.com/send?text=www.google.com" data-action="share/whatsapp/share">Share via Whatsapp
        web</a> -->

    <section>
        <div class="">



            <h3>Photos</h3>
            <div class="table-responsive">

                <table id="userTable" class="table table-striped table-bordered" style="width: 100%;">
                    <thead>
                        <tr>

                            <th>Images</th>
                            <th>Action</th>


                        </tr>
                    </thead>


                </table>
            </div>
            <div class="text-center mt-5">
                <button class="btn btn-danger" id="delAll">Delete All</button>

            </div>

        </div>
        </div>
        </div>
        </div>
        <!-- </form> -->



        </div>

    </section>



    <?php include('layout/script.php') ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="js/datepicker.js"></script>
    <script src="js/jquery.multifile.js"></script>
    <script src="js/jquery.multifile.preview.js"></script>

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script>
    var userDataTable = $('#userTable').DataTable({
        'processing': true,
        'serverSide': true,
        'columnDefs': [{
            orderable: false,
            targets: 0
        }],
        'serverMethod': 'post',
        "pageLength": 50,
        'ajax': {
            'url': 'ajaxImage.php',
            "data": {
                'code': '<?php echo $_GET['code']; ?>'
            }
        },
        'columns': [{
            data: 'image'
        }, {
            data: 'action'
        }, ]
    });
    $('#userTable').on('click', '.deleteUser', function() {
        var id = $(this).data('id');

        var deleteConfirm = confirm("Are you sure?");
        if (deleteConfirm == true) {
            // AJAX request
            $.ajax({
                url: 'ajaxImage.php',
                type: 'post',
                data: {
                    request: 4,
                    id: id
                },
                success: function(response) {

                    if (response == 1) {
                        alert("Record deleted.");

                        // Reload DataTable
                        userDataTable.ajax.reload();
                    } else {
                        alert("Invalid ID.");
                    }

                }
            });
        }

    });
    </script>

    <script>
    $('#delAll').on('click', (e) => {
        var deleteConfirmAll = confirm("Are you sure?");
        if (deleteConfirmAll == true) {
            // AJAX request
            $.ajax({
                url: 'ajaxImage.php',
                type: 'post',
                data: {
                    request: 5,
                    code: '<?php echo $_GET['code']; ?>'
                },
                success: function(response) {

                    if (response == 1) {
                        alert("Records deleted.");

                        // Reload DataTable
                        userDataTable.ajax.reload();
                    } else {
                        alert("Invalid ID.");
                    }

                }
            });
        }
    })
    </script>


</body>

</html>