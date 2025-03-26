<?php
require_once "connect.php";

$id_tt = $_GET['id']; 

$tables = ['thoi_gian', 'hinh_anh', 'danh_gia', 'giao_vien'];
foreach ($tables as $table) {
    $sql_delete = "DELETE FROM $table WHERE TT_ID = $id_tt";
    mysqli_query($conn, $sql_delete);
}


$sql_delete_center = "DELETE FROM trung_tam WHERE TT_ID = $id_tt";
if (mysqli_query($conn, $sql_delete_center)) {
    $message = "Xóa trung tâm thành công!";
} else {
    $message = "Lỗi khi xóa trung tâm!";
}

header("Location: center_management.php?message=" . urlencode($message));
exit();
?>
