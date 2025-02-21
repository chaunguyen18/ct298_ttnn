<?php
$servername = "localhost"; // Hoặc IP của database server
$username = "root"; // Tài khoản MySQL
$password = ""; // Mật khẩu MySQL
$database = "ct298_ttnn_db"; // Tên database của bạn

// Kết nối
$conn = mysqli_connect($servername, $username, $password, $database);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
echo "Kết nối thành công!";
?>
