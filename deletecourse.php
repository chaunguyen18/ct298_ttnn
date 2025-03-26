<?php
require_once "connect.php";

$id = $_GET['id'];

$sql_delete_time = "DELETE FROM thoi_gian WHERE KH_ID = $id";
mysqli_query($conn, $sql_delete_time);

$sql_delete_course = "DELETE FROM khoa_hoc WHERE KH_ID = $id";
mysqli_query($conn, $sql_delete_course);

header('Location: course_management.php');
exit();
?>
