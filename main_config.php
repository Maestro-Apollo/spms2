<?php
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);

define('SUBFOLDER', str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__));
define('ROOT', $_SERVER['DOCUMENT_ROOT'].SUBFOLDER);

