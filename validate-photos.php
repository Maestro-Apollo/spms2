<?php
/*
    this file serves as a tool for the file ("property-details.php").
    
    Usage:
        Call this file in an async AJAX call with an array of uploaded rooms 
        photos using formData in JavaScript. the uploaded files may be moved 
        from one input field to another (pseudo). 

        
    Functionality:
        It validates the uploaded images and saves them in a temporary folder
        called ("/temp_photos") if they were safe and accepted and returns 
        
        
    Return or result:
        On success, this file returns a JSON response with 
        -   A code (15 digits randomly generated) to identify
            the images from other rooms images.
        -   A success boolean

        On failure the images would not be uploaded and no 
        code will be returned. The form validation on 
        ("property-details.php") should precieve this as if
        the user did not provide any image and not as a failure.
        Failure should be detected with the success boolean 
        returning value of FALSE.

    IMPORTANT NOTE (SECURITY): include a .htaccess file in ("/temp_photos") 
    to prevent direct access to the images. 
*/

session_start();

if (isset($_SESSION['name2'])) {
} else {
    header('location:login.php');
    exit();
}


// this function generates the 15 digits code randomly
function generateRandomString($length = 15)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


// make sure user can make uploads here and prevent access if not
$allowed = true; // for now

// Images and images data validation logic goes here
$valid_images = true; // for now

// no uploaded photos
if (empty($_FILES["images"])) {
    $valid_images = false;
}

// to check submitted arrays
//var_dump($_POST);
//var_dump($_FILES["images"]);

// to check images data or room numbers
//var_dump(json_decode($_POST["imagesData"]));

// room numbers should be checked to be ints and in range of the maximum room
// files types and content should be verified
// etc


// this is the server response for the images upload
$response = array();
$response["success"] = false;
$paths = [];


// on success the file should return an array with the pathes of the files and their room numbers
if ($valid_images && $allowed) { // if everything is safe upload the photos and return success and code
    // files and uploaded data in arrays of same length
    $files_names = $_FILES["images"]["name"];
    $files_tmp_names = $_FILES["images"]["tmp_name"];
    $files_types = $_FILES["images"]["type"];
    $files_sizes = $_FILES["images"]["size"];
    $files_errors = $_FILES["images"]["error"];
    $files_rooms = json_decode($_POST["imagesData"]);
    $files_extensions = [];

    foreach ($files_names as $name) {
        $files_extensions[] = pathinfo($name, PATHINFO_EXTENSION);
    }

    $response["success"] = true;
    for ($index = 0; $index < count($files_names); $index++) {
        $key = "images_" . $index;

        $file_code = generateRandomString(); // 15 digits code
        $destination = "temp_photos/" . $file_code . "." . $files_extensions[$index];
        while (file_exists($destination)) {
            // make sure to give a unique code
            $file_code = generateRandomString(); // 15 digits code
            $destination = "temp_photos/" . $file_code . "." . $files_extensions[$index];
        }
        // upload the photo and send the path in response array "paths"
        move_uploaded_file($files_tmp_names[$key], $destination);
        $paths[] = array("path" => $destination, "roomnum" => $files_rooms[$index]);
    }
}

// paths will be reset when photos get moved to files
$_SESSION["uploaded-images-data"] = $paths;

echo json_encode($response);
