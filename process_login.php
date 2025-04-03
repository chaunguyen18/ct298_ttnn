<?php
session_start();
include("connect.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = isset($_POST['loginUserName']) ? trim($_POST['loginUserName']) : "";
    $password = isset($_POST['loginUserPwd']) ? trim($_POST['loginUserPwd']) : "";


    if (empty($username) || empty($password)) {
        header("Location: index.php?error=empty");
        exit();
    }


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


        if ($user['ND_ROLE'] == 1) {
            header("Location: admin.php");
        } else {
            header("Location: user.php");
        }
        exit();
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
        header("Location: index.php?error=invalid");
        
        exit();
    }
}
