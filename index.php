<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


if ($_SESSION['role'] == 2) {
    header("Location: user.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Trung Tâm Ngoại Ngữ TalkWise </title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


</head>

<body data-role="admin">
    <div class="container-fluid">
        <div class="row content-map">
            <div class="sidebar col-md-3 text-white p-3">
                <form id="search-box" class="search-box row">
                    <div class="col-md-9">
                        <input type="text" id="search-input" class="search-input">
                    </div>
                    <div class="col-md-3">
                        <button class="btnSearch" type="button" onclick="searchLocation()">Tìm</button>
                    </div>
                </form>

                <div class="sidebar-menu">
                    <div class="menu-item">Quản lý trung tâm</div>
                    <div class="menu-item">Quản lý khóa học</div>
                    <div class="menu-item">Quản lý thông tin</div>
                    <div class="menu-item">Quản lý đánh giá</div>
                    
                    <div class="menu-item"><a href="logout.php">Đăng xuất</a></div>
                </div>
            </div>
            <div id="map" class="map col-md-9 p-0"></div>
        </div>
        <div class="container-fluid">
            <div class="content-action row">
                <h1>Vui lòng chọn 1 chức năng để quản lý.</h1>
            </div>
        </div>
    </div>

    <footer>
        <i class="fa-solid fa-copyright"></i> Bản quyền thuộc về nhóm 4 - 2025.
    </footer>

    <script src="script.js"></script>
</body>


</html>