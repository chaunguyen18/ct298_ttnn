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
            <h1>Đăng ký</h1>
            <form id="registerForm" class="">

                <label>Email:</label>
                <input type="email" id="registerEmail" name="registerEmail">

                <label>Tên đăng nhập:</label>
                <input type="text" id="registerUserName" name="registerUserName">

                <label for="">Mật khẩu:</label>
                <input type="password" id="registerUserPwd" name="registerUserPwd">


                <button class="btnSubmit" type="submit">Gửi</button>
            </form>

            <div class="d-flex justify-content-between w-100">
                <a href="index.php"><i class="fa-solid fa-arrow-left"></i>Về trang chủ</a>
                <a href="login.php">Đã có tài khoản?</a>

            </div>

        </div>

    </div>


    <footer>
        <i class="fa-solid fa-copyright"></i>Bản quyền thuộc về nhóm 4 - 2025.
    </footer>
</body>


</html>