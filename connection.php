<?php

$server     = "localhost";
$username   = "root";
$password   = "";
$db         = "db_clientaddressbook";

// create a connection
$conn = mysqli_connect( $server, $username, $password, $db);

// check connection
if(!$conn) {
    die("Connection faild: there is a connection error!");
}


?>
