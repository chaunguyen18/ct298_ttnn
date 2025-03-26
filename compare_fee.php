<?php 
include("connect.php");
$sql = "SELECT khoa_hoc.*, 
               capdo_khoahoc.CDKH_ten, 
               thoi_gian.TG_ngaybatdau, 
               thoi_gian.TG_thoigian, 
               trung_tam.TT_ten
        FROM khoa_hoc 
        INNER JOIN capdo_khoahoc ON khoa_hoc.CDKH_ID = capdo_khoahoc.CDKH_ID
        LEFT JOIN thoi_gian ON khoa_hoc.KH_ID = thoi_gian.KH_ID
        LEFT JOIN trung_tam ON thoi_gian.TT_ID = trung_tam.TT_ID";



$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trung Tâm Ngoại Ngữ TalkWise </title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="manage">
        <div class="container-fluid">

            <h2>So sánh học phí</h2>
            
        </div>
    </div>
    <script src="script.js"></script>
</body>


</html>