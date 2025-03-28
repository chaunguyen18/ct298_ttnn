<?php
    require_once "connect.php";
    $id = $_GET['id'];
    $sql = "DELETE FROM giao_vien WHERE GV_ID = $id";
    $query = mysqli_query($conn, $sql);
    header('location: teacher_management.php');
?>    