<?php
    /**
     * This php file is in charge of making the database connection
     */
    $servername = "localhost";
    $dBUsername = "root";
    $dBPassword = "";
    $dBName = "icecreamDB";

    $conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

    if(!$conn){
        die("Connection Failed: ".mysqli_connect_error());
    }

    function connection(){
        $servername = "localhost";
        $dBUsername = "root";
        $dBPassword = "";
        $dBName = "icecreamDB";

        $conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

        if(!$conn){
            die("Connection Failed: ".mysqli_connect_error());
        }

        return $conn;
    }

?>