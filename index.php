<?php
session_start();
include("connect.php"); 

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $username = $_POST['loginUserName'];
//     $password = $_POST['loginUserPwd'];

    
//     $sql = "SELECT * FROM nguoi_dung WHERE ND_username = ? AND ND_password = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("ss", $username, $password);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows == 1) {
//         $user = $result->fetch_assoc();
//         $_SESSION['user_id'] = $user['ND_ID'];
//         $_SESSION['username'] = $user['ND_username'];
//         $_SESSION['role'] = $user['ND_ROLE'];

       
//         if ($user['ND_ROLE'] == 1) {
//             header("Location: index.php");
//         } else {
//             header("Location: user.php");  
//         }
//         exit();
//     } else {
//         $error = "Sai tài khoản hoặc mật khẩu!";
//     }
// }
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trung Tâm Ngoại Ngữ TalkWise </title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="script.js"></script>
</head>

<body>
    <div class="container-fluid d-flex justify-content-center align-items-center">
        <div class="login">
            <h1>Đăng nhập</h1>
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <form id="loginForm" method="POST" action="process_login.php">
                <label>Tên đăng nhập</label>
                <input type="text" id="loginUserName" name="loginUserName" required>

                <label for="">Mật khẩu:</label>
                <input type="password" id="loginUserPwd" name="loginUserPwd" required>

                <button class="btnSubmit" type="submit">Gửi</button>
            </form>
            <a href="admin.php"><i class="fa-solid fa-arrow-left"></i>Về trang chủ</a>
            <div class="d-flex justify-content-between w-100">
                <a href="register.php" >Chưa có tài khoản?</a>
                <a href="">Quên mật khẩu</a>
            </div>

        </div>

    </div>


    <footer>
        <i class="fa-solid fa-copyright"></i>Bản quyền thuộc về nhóm 4 - 2025.
    </footer>
</body>


</html>