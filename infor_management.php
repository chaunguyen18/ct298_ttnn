<?php
include("connect.php");
$sql = "SELECT * from nguoi_dung";
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

            <h2>Danh sách người dùng</h2>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Mã người dùng</th>
                        <th>Họ tên người dùng</th>
                        <th>SDT</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Role</th>
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
                        <td>{$row['ND_sdt']}</td>
                        <td>{$row['ND_email']}</td>
                        <td>{$row['ND_username']}</td>
                        <td>{$row['ND_password']}</td>
                        <td>{$row['ND_ROLE']}</td>
                        <td>
                        <div class='d-flex flex-column gap-3' >
                            <button class='btn btn-warning'>                                  
                                Cập nhật
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