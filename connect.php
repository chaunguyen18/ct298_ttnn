<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "ttng";


$conn = mysqli_connect($servername, $username, $password, $database);


if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

?>