<?php
include("connect.php");
$sql = "SELECT khoa_hoc.*, 
               capdo_khoahoc.CDKH_ten, 
               thoi_gian.TG_ngaybatdau, 
               thoi_gian.TG_thoigian, 
               thoi_gian.TG_hocphi,
               trung_tam.TT_diachi,
               trung_tam.TT_toado_x,
               trung_tam.TT_toado_y,
               trung_tam.TT_ten
        FROM khoa_hoc 
        INNER JOIN capdo_khoahoc ON khoa_hoc.CDKH_ID = capdo_khoahoc.CDKH_ID
        LEFT JOIN thoi_gian ON khoa_hoc.KH_ID = thoi_gian.KH_ID
        LEFT JOIN trung_tam ON thoi_gian.TT_ID = trung_tam.TT_ID";

$result = $conn->query($sql);

$sql_khoahoc = "SELECT KH_ID, KH_ten FROM khoa_hoc";
$result_khoahoc = $conn->query($sql_khoahoc);

$sql_quan = "SELECT DISTINCT QH_ID, QH_ten FROM quan_huyen";
$result_quan = $conn->query($sql_quan);
if (!$result_quan) {
    die("Lỗi SQL: " . $conn->error);
}

$sql_phuong = "SELECT DISTINCT XP_ID, XP_ten FROM xa_phuong";
$result_phuong = $conn->query($sql_phuong);


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

            <h2 class="mt-3">So sánh học phí</h2>

            <?php
            $khoaHocList = [];
            while ($row = $result_khoahoc->fetch_assoc()) {
                $khoaHocList[] = $row;
            }

            ?>
            <div class="compare-fee row d-flex justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="d-flex justify-content-center align-items-center flex-column">

                        <h3>So sánh học phí</h3>
                        <h6>Lựa chọn khóa học cần so sánh.</h6>

                        <form id="mainForm" class="mt-3 mb-3">
                            <div class="form-container d-flex flex-column">

                                <select class="form-select" aria-label="courseName">
                                    <option selected>Lựa chọn khóa học</option>
                                    <?php foreach ($khoaHocList as $row) {
                                        echo "<option value='{$row['KH_ID']}'>{$row['KH_ten']}</option>";
                                    } ?>
                                </select>

                            </div>
                            <div class="d-flex justify-content-center gap-3">
                                <button type="button" class="btnComparePrice" onClick="comparePrice()">So sánh</button>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-center align-items-center flex-column">

                        <h3>So sánh học phí theo phạm vi</h3>
                        <h6>Lựa chọn thông tin cần so sánh.</h6>

                        <form id="mainForm" class="mt-3 mb-3">
                            <div class="form-container d-flex flex-column">

                                <select class="form-select" aria-label="courseRangeName">
                                    <option selected>Lựa chọn khóa học</option>
                                    <?php foreach ($khoaHocList as $row) {
                                        echo "<option value='{$row['KH_ID']}'>{$row['KH_ten']}</option>";
                                    } ?>
                                </select>


                                <select class="form-select mb-3" aria-label="stateName">
                                    <option selected>Quận/Huyện</option>
                                    <?php
                                    while ($row = $result_quan->fetch_assoc()) {
                                        echo "<option value='{$row['QH_ID']}'>{$row['QH_ten']}</option>";
                                    }
                                    ?>
                                </select>

                                <select class="form-select" aria-label="phuongxaName">
                                    <option selected>Phường/Xã</option>
                                    <?php
                                    while ($row = $result_phuong->fetch_assoc()) {
                                        echo "<option value='{$row['XP_ID']}'>{$row['XP_ten']}</option>";
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="d-flex justify-content-center gap-3">
                                <button type="button" class="btnComparePrice" onClick="comparePricePV()">So sánh</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

            <div class="row mt-3">
                <div class="compare-fee-content" id="compareTable">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th>STT</th>
                                <th>Học phí</th>
                                <th>Cấp độ khóa học</th>
                                <th>Trung tâm</th>
                                <th>Địa chỉ</th>
                                <th>Ngày bắt đầu</th>
                                <th>Thời gian</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="compareData">
                            <?php
                            if ($result->num_rows > 0) {
                                $index = 1;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>{$index}</td>
                                        <td>{$row['TG_hocphi']}</td>
                                        <td>{$row['CDKH_ten']}</td>
                                        <td>{$row['TT_ten']}</td>
                                        <td>{$row['TT_diachi']}</td>
                                        <td>{$row['TG_ngaybatdau']}</td>
                                        <td>{$row['TG_thoigian']} tháng</td>
                                        <td>                
                                            <button class='btn btn-success'>Tìm kiếm</button>
                                        </td>
                
                                    </tr>";
                                    $index++;
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>Không có dữ liệu</td></tr>";
                            }
                            ?>
                        </tbody>


                    </table>
                </div>
            </div>

        </div>
    </div>
    <script src="user.js"></script>

</body>


</html>