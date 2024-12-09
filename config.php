<?php

$host = "localhost";
$username="root";
$password="";
$db_name="shoe_shop";


$conn= new mysqli($host, $username, $password, $db_name);

if($conn->connect_error){
    die("Connection Failed") . $conn->connect_error;
};


?>