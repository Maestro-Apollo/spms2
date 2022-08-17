<?php
/*
    this file serves as a tool for the file ("general-page.php").
    
    Usage:
        Call this file in an async call with new room number using
        formData in JavaScript. image URL should be uploaded too.
        
    Functionality:
        it changes the image room number in the database. it accesses
        the photo through the URL. 
*/

session_start();

require_once('class/database.php');

// validate user requesting the action
if (isset($_SESSION['name2'])) {
} else {
    header('location:login.php');
    exit();
}

class signInUp extends database
{
    protected $link;

    public function changeRoom()
    {
        $newroom = intval($_GET['roomnum']);
        $imageURL = $_GET['imageURL'];
        if (file_exists($imageURL)) {
            $image = substr($imageURL, 6); // get rid of "files/"
            $sql = "UPDATE `photos` SET `room_number`= $newroom WHERE `image` = '$image'";
            mysqli_query($this->link, $sql);
        }
    }
}
$obj = new signInUp;
$obj->changeRoom();
