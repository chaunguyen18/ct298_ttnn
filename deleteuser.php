<?php
    require_once "connect.php";
    $id = $_GET['id'];
    $sql = "DELETE FROM nguoi_dung WHERE ND_ID = $id";
    $query = mysqli_query($conn, $sql);
    header('location: infor_management.php');
?>    