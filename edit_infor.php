<?php 
include("connect.php");

$id = $_GET['id'] ?? null;

$course = null;
if ($id) {
    $sql1 = "SELECT * FROM nguoi_dung WHERE ND_ID = '$id'";

    $result1 = mysqli_query($conn, $sql1);
    if ($result1->num_rows > 0) {
        $course = mysqli_fetch_assoc($result1);
    }
}
$sql = "SELECT * FROM nguoi_dung";



$result = $conn->query($sql);


if (isset($_POST['add'])) {
    $trungtamName = $_POST['courseName'];
    $trungtamPhone = $_POST['coursePrice'];
    $trungtamEmail = $_POST['trungtamLevel']; 
    $trungtamLevel = $_POST['trungtamName'];
    $trungtamLocation = $_POST['courseInstructor'];
    $trungtamLat = $_POST['courseSessions'];

    $errors = [];


if (!preg_match('/^\d{10}$/', $trungtamPhone)) {
    $errors['coursePrice'] = "Số điện thoại phải là số và có đúng 10 chữ số.";
}


if (!filter_var($trungtamEmail, FILTER_VALIDATE_EMAIL)) {
    $errors['trungtamLevel'] = "Email không hợp lệ.";
} else {

    $email_check_query = "SELECT ND_ID FROM nguoi_dung WHERE ND_email = '$trungtamEmail'  AND ND_ID != '$id' LIMIT 1";
    $email_check_result = mysqli_query($conn, $email_check_query);
    if (mysqli_num_rows($email_check_result) > 0) {
        $errors['trungtamLevel'] = "Email đã tồn tại. Vui lòng sử dụng email khác.";
    }
}
if (empty($errors)) {

    $sql_update = "UPDATE nguoi_dung 
                    SET ND_hoten='$trungtamName', ND_email='$trungtamEmail', ND_sdt='$trungtamPhone', 
                        ND_password='$trungtamLocation', ND_ROLE='$trungtamLevel', ND_username='$trungtamLat' 
                    WHERE ND_ID=$id";

    $result_update = mysqli_query($conn, $sql_update);

    if ($result_update) {
        echo "<script>
            alert('Cập nhật người dùng \"$trungtamName\" thành công!');
            window.location.href = 'infor_management.php';  
        </script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật!');</script>";
    }
    
    
}
}
    
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
    <style>
        .form-column input,
        .form-column select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-column input:focus,
        .form-column select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
     </style>
</head>

<body>
    <div class="manage">
        <div class="container-fluid ds-trungtam">

            <h2>Danh Sách người dùng</h2>
            <table class="table table-bordered">
            <thead class="table-dark">
    <tr class="text-center">
        <th>STT</th>
        <th>Họ tên</th>
        <th>Số điện thoại</th>
        <th>Email</th>
        <th>Username</th>
        <th>Vai trò</th>
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
                <td>{$row['ND_ROLE']}</td>
                
                <td>
                            <div class='d-flex flex-column gap-3'>
                                <a href='edit_infor.php?id=" . $row['ND_ID'] . "'>
                                    <button class='btn btn-warning'>
                                        Cập nhật
                                    </button>
                                </a>
                                <button class='btn btn-danger'
                                    onclick=\"Delete(" . $row['ND_ID'] . ", '" . addslashes($row['ND_hoten']) . "')\">
                                    Xóa
                                </button>
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

        <div class="trungtam-manage">
    <div class="col-md-8">
        <div class="update-course">
            <h2 class="text-center">Thêm mới người dùng</h2>
            <form id="mainForm" method="POST" enctype="multipart/form-data">
             
                <div class="row">
                    <div class="col-md-6">
                        <label for="courseName">Họ tên người dùng:</label>
                        <input type="text" id="courseName" name="courseName" class="form-control" value="<?= $course['ND_hoten'] ?? '' ?>" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="coursePrice">Số điện thoại:</label>
                        <input type="text" id="coursePrice" name="coursePrice" class="form-control" value="<?= $course['ND_sdt'] ?? '' ?>" required>
                        <?php
                            if (isset($errors['coursePrice'])) {
                                echo '<p style="color: red; font-size: 14px;  margin-top: 5px;">' . $errors['coursePrice'] . '</p>';
                            }
                        ?>
                    </div>
                </div>

     
                <div class="row mt-3">
                <div class="col-md-6">
                    <div class="d-flex flex-column">
                        <label for="trungtamLevel" class="mb-2">Email:</label>
                        <input type="text" id="trungtamLevel" name="trungtamLevel" class="form-control" value="<?= $course['ND_email'] ?? '' ?>" required>
                        <?php
                            if (isset($errors['trungtamLevel'])) {
                                echo '<p style="color: red; font-size: 14px;  margin-top: 5px;">' . $errors['trungtamLevel'] . '</p>';
                            }
                           
                        ?>
                    </div>
                </div>

                    
                <div class="col-md-6">
                <div class="d-flex flex-column">
                    <label for="trungtamName" class="mb-2">Vai trò:</label>
                    <select id="trungtamName" name="trungtamName" class="form-control" style="height: 50px;" required>
                        <option value="">-Chọn vai trò-</option>
                        <option value="1" <?= isset($course['ND_ROLE']) && $course['ND_ROLE'] == 1 ? 'selected' : '' ?>>Admin</option>
                        <option value="2" <?= isset($course['ND_ROLE']) && $course['ND_ROLE'] == 2 ? 'selected' : '' ?>>Người dùng</option>
                    </select>
                </div>

                </div>
                </div>

             
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="courseSessions">Username:</label>
                        <input type="text" id="courseSessions" name="courseSessions" class="form-control" value="<?= $course['ND_username'] ?? '' ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="courseInstructor">Mật khẩu:</label>
                        <input type="password" id="courseInstructor" name="courseInstructor" class="form-control" value="<?= $course['ND_password'] ?? '' ?>" required>
                    </div>
                </div>

                <!-- Nút Thêm -->
                <div class="d-flex justify-content-center gap-3 mt-3">
                    <button type="submit" name="add" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

    </div>
    <script>
        function Delete(id, trungtamName) {
            if (confirm(`Bạn có chắc chắn muốn xóa giảng viên "${trungtamName}" không?`)) {
                window.location.href = `deletecourse.php?id=${id}`;
            }
        }   
    </script>
    <script src="script.js"></script>
</body>


</html>