<?php
session_start();
if (isset($_SESSION['name2']) || isset($_SESSION['admin2'])) {
} else {
    header('location:login.php');
}