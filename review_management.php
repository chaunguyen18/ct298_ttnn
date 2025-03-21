<?php 
include("connect.php");
$sql = "SELECT danh_gia.*, khoa_hoc.KH_ten, nguoi_dung.ND_hoten 
FROM danh_gia 
INNER JOIN khoa_hoc ON danh_gia.KH_ID = khoa_hoc.KH_ID 
INNER JOIN nguoi_dung ON danh_gia.ND_ID = nguoi_dung.ND_ID;

";
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

            <h2>Đánh giá của học viên</h2>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Mã người dùng</th>
                        <th>Tên người dùng</th>
                        <th>Mã khóa học</th>
                        <th>Tên khóa học</th>
                        <th>Số sao</th>
                        <th>Nội dung đánh giá</th>
                        <th>Ngày đánh giá</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>{$row['ND_ID']}</td>
                    <td>{$row['ND_hoten']}</td>
                        <td>{$row['KH_ID']}</td>
                        <td>{$row['KH_ten']}</td>
                        <td>{$row['DG_sao']}</td>
                        <td>{$row['DG_noidung']}</td>
                        <td>{$row['DG_ngay']}</td>
                        <td>
                        <div class='d-flex flex-column gap-3' >
                            <button class='btn btn-warning'>                                  
                                Trả lời
                            </button>
                            <button class='btn btn-danger'>Xóa</button></div>      
                        </div>                      
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
    </div>
    <script src="script.js"></script>
</body>


</html>