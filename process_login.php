<?php
session_start();
include("connect.php"); // Kết nối CSDL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra biến có tồn tại không
    $username = isset($_POST['loginUserName']) ? trim($_POST['loginUserName']) : "";
    $password = isset($_POST['loginUserPwd']) ? trim($_POST['loginUserPwd']) : "";

    // Kiểm tra nếu input rỗng
    if (empty($username) || empty($password)) {
        header("Location: login.php?error=empty");
        exit();
    }

    // Kiểm tra tài khoản trong database
    $sql = "SELECT * FROM nguoi_dung WHERE ND_username = ? AND ND_password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['ND_ID'];
        $_SESSION['username'] = $user['ND_username'];
        $_SESSION['role'] = $user['ND_ROLE'];

        // Điều hướng theo quyền
        if ($user['ND_ROLE'] == 1) {
            header("Location: index.php"); 
        } else {
            header("Location: user.php");  
        }
        exit();
    } else {
        header("Location: login.php?error=invalid");
        exit();
    }
}
?>
