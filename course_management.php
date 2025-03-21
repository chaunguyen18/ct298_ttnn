<?php 
include("connect.php");
$sql = "SELECT khoa_hoc.*, 
               capdo_khoahoc.CDKH_ten, 
               thoi_gian.TG_ngaybatdau, 
               thoi_gian.TG_thoigian,
               thoi_gian.TG_hocphi, 
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
        <div class="container-fluid ds-trungtam">

            <h2>Danh Sách khóa học</h2>
            <table class="table table-bordered">
            <thead class="table-dark">
    <tr class="text-center">
        <th>Mã khóa học</th>
        <th>Tên khóa học</th>
        <th>Học phí</th>
        <th>Cấp độ khóa học</th>
        <th>Trung tâm</th>
        <th>Ngày bắt đầu</th>
        <th>Thời gian</th>
        <th>Hành động</th>
    </tr>
</thead>
<tbody>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['KH_ID']}</td>
                <td>{$row['KH_ten']}</td>
                <td>{$row['TG_hocphi']}</td>
                <td>{$row['CDKH_ten']}</td>
                <td>{$row['TT_ten']}</td>
                <td>{$row['TG_ngaybatdau']}</td>
                <td>{$row['TG_thoigian']} tháng</td>
                <td>
                    <button class='btn btn-warning'>Cập nhật</button>
                    <button class='btn btn-danger'>Xóa</button>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='8' class='text-center'>Không có dữ liệu</td></tr>";
    }
    ?>
</tbody>


            </table>
        </div>

        <div class="course-manage row">
            <div class="col-md-6 d-flex justify-content-center">
                <div class="update-course">
                    <h2>Cập nhật thông tin khóa học</h2>
                    <form id="mainForm">
                        <div class="form-container d-flex flex-column">

                            <label for="courseID">Mã khóa học:</label>
                            <input type="text" id="courseID" name="courseID" readonly>

                            <label for="courseName">Tên khóa học:</label>
                            <input type="text" id="courseName" name="courseName">

                            <label for="coursePrice">Học phí:</label>
                            <input type="text" id="coursePrice" name="coursePrice">

                            <label for="courseLevel">Cấp độ khóa học:</label>
                            <input type="text" id="courseLevel" name="courseLevel">

                        </div>
                        <div class="d-flex justify-content-center gap-3">
                            <button type="submit">Thêm</button>
                            <button type="submit">Lưu</button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="col-md-6 d-flex justify-content-center">
                <div class="compare-course">
                    <h2>So sánh học phí</h2>
                    <h6>Nhập tên trung tâm và tên khóa học cần so sánh.</h6>

                    <form id="mainForm">
                        <button type="button" class="btnCompareCourseLocation">So sánh theo vị trí</button>
                        <button type="button" class="btnCompareCourseCenter">So sánh giữa các trung tâm</button>
                        <div class="form-container d-flex flex-column">

                            <label for="trungtamName">Tên trung tâm 1:</label>
                            <input type="text" id="trungtamName" name="trungtamName">

                            <label for="trungtamName">Tên trung tâm 2:</label>
                            <input type="text" id="trungtamName" name="trungtamName">

                            <label for="courseName">Tên khóa học:</label>
                            <input type="text" id="courseName" name="courseName">

                        </div>
                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="btnComparePrice" onClick="comparePrice()">So sánh</button>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
    <script src="script.js"></script>
</body>


</html>