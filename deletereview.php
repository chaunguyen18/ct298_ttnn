<?php
    require_once "connect.php";
    $id = $_GET['id'];
    $sql = "DELETE FROM danh_gia WHERE ND_ID = $id";
    $query = mysqli_query($conn, $sql);
    header('location: review_management.php');
?>    