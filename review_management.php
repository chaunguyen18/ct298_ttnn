<?php 
include("connect.php");
$sql = "SELECT * FROM danh_gia";
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
                    <tr>
                        <th>Tên người dùng</th>
                        <th>Mã khóa học</th>
                        <!-- <th>Tên khóa học</th> -->
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
                        <td>{$row['KH_ID']}</td>
                        
                        <td>{$row['DG_sao']}</td>
                        <td>{$row['DG_noidung']}</td>
                        <td>{$row['DG_ngay']}</td>
                        <td>
                            <button class='btn btn-warning'>                                  
                                Trả lời
                            </button>                            
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