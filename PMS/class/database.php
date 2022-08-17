<?php

class database
{
    // These variables will help you to connect with database
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "pms2";




    // This $link variable is a part of database class which will help you run all the query
    protected $link;

    public function __construct()
    {
        $this->connection();
        # code...
    }

    public function connection()
    {

        // This function will help you connect with the database
        $this->link = mysqli_connect($this->hostname, $this->username, $this->password, $this->dbname); //connected with database

        if ($this->link) {
            // $sSQL = 'SET CHARACTER SET utf8';
            // mysqli_query($this->link, $sSQL);
            // echo "connected";
        } else {
            echo "not connected";
        }

        # code...
    }
}

$obj = new database; //database class object