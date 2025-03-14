<?php 
include("connect.php");
$sql = "SELECT * FROM trung_tam";
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
    <div class="manage ">
        <div class="container-fluid ds-trungtam">

            <h2>Danh Sách Trung Tâm</h2>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Mã TT</th>
                        <th>Tên Trung Tâm</th>
                        <th>SĐT</th>
                        <th>Email</th>
                        <th>Địa Chỉ</th>
                        <th>Tọa Độ X</th>
                        <th>Tọa Độ Y</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['TT_ID']}</td>
                        <td>{$row['TT_ten']}</td>
                        <td>{$row['TT_sdt']}</td>
                        <td>{$row['TT_email']}</td>
                        <td>{$row['TT_diachi']}</td>
                        <td>{$row['TT_toado_x']}</td>
                        <td>{$row['TT_toado_y']}</td>
                        <td>
                        <div class='d-flex flex-column gap-3' >
                        <button class='btn btn-warning'
                            data-id='{$row['TT_ID']}' 
                            data-name='{$row['TT_ten']}'
                            data-phone='{$row['TT_sdt']}'
                            data-email='{$row['TT_email']}'
                            data-address='{$row['TT_diachi']}'
                            data-x='{$row['TT_toado_x']}'
                            data-y='{$row['TT_toado_y']}'
                            >                                  
                                Cập nhật
                            </button>
                            <button class='btn btn-danger'>Xóa</button></div>
                            
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



        <div class="trungtam-manage">
            <h2>Cập nhật thông tin trung tâm</h2>
            <form id="mainForm">
                <div class="form-container d-flex justify-content-between gap-3">
                    <div class="form-column d-flex flex-column flex-fill">

                        <label for="trungtamID">Mã số trung tâm:</label>
                        <input type="text" id="trungtamID" name="trungtamID" readonly>

                        <label for="trungtamName">Tên trung tâm:</label>
                        <input type="text" id="trungtamName" name="trungtamName">

                        <label for="trungtamPhone">Số điện thoại:</label>
                        <input type="text" id="trungtamPhone" name="trungtamPhone">

                        <label for="trungtamEmail">Email:</label>
                        <input type="email" id="trungtamEmail" name="trungtamEmail">

                        <label for="trungtamLevel">Cấp độ:</label>
                        <input type="text" id="trungtamLevel" name="trungtamLevel">

                    </div>
                    <div class="form-column d-flex flex-column flex-fill">
                        <label for="trungtamLocation">Địa chỉ:</label>
                        <input type="text" id="trungtamLocation" name="trungtamLocation">

                        <label for="trungtamLat">Tọa độ X:</label>
                        <input type="text" id="trungtamLat" name="trungtamLat">

                        <label for="trungtamLon">Tọa độ Y:</label>
                        <input type="text" id="trungtamLon" name="trungtamLon">

                        <label for="trungtamImage">Hình ảnh trung tâm:</label>
                        <div class="d-flex align-items-center gap-3">
                            <img id="previewImage" src="" class="border rounded mt-3" width="100" height="100"
                                alt="Hình ảnh">

                            <input type="file" id="trungtamImage" name="trungtamImage" class="form-control"
                                accept="image/*">
                        </div>

                    </div>
                </div>
                <div class="d-flex justify-content-center gap-3">
                <button type="submit">Thêm</button>
                    <button type="submit">Lưu</button>
                </div>

            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>


</html>