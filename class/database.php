<?php

require_once __DIR__ . '/../main_config.php';

class database

{

    // These variables will help you to connect with database

    private static $hostname = "localhost";

    private static $username = "root";

    private static $password = "";

    private static $dbname = "spms2";



    //    private static $hostname = "localhost";

    //    private static $username = "root";

    //    private static $password = "";

    //    private static $dbname = "boshinghk";



    private static $connection;

    protected $link; // legacy code use that variable



    public function __construct()

    {

        $this->link = static::conn();
    }



    public static function query($query)
    {

        return mysqli_query(static::conn(), $query);
    }



    public static function conn()
    {

        if (static::$connection) {

            return static::$connection;
        }

        // This function will help you connect with the database

        static::$connection = mysqli_connect(static::$hostname, static::$username, static::$password, static::$dbname); //connected with database



        if (static::$connection) {

            return static::$connection;
        } else {

            echo "not connected";

            die("Connection failed: " . mysqli_connect_error());
        }
    }



    public function connection()

    {

        return static::conn();
    }
}



$obj = new database;