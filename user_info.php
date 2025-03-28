<?php 
session_start();
include("connect.php");


$user_id = $_SESSION['user_id']; 

$sql = "SELECT * FROM nguoi_dung WHERE ND_ID = '$user_id'";
$result = $conn->query($sql);
$user = mysqli_fetch_assoc($result);

if (isset($_POST['add'])) {
    $trungtamName = $_POST['courseName'];
    $trungtamPhone = $_POST['coursePrice'];
    $trungtamEmail = $_POST['courseSessions'];
    $trungtamlevel = $_POST['trungtamLevel'];
    $trungtamLocation = $_POST['courseInstructor'];
    $trungtamLat = $_POST['pass'];
   
    $errors = [];


if (!preg_match('/^\d{10}$/', $trungtamPhone)) {
    $errors['coursePrice'] = "Số điện thoại phải là số và có đúng 10 chữ số.";
}


if (!filter_var($trungtamlevel, FILTER_VALIDATE_EMAIL)) {
    $errors['trungtamLevel'] = "Email không hợp lệ.";
} else {
    // Chỉ kiểm tra trùng email nếu email đã thay đổi
    if ($trungtamlevel !== $user['ND_email']) {
        $email_check_query = "SELECT ND_ID FROM nguoi_dung WHERE ND_email = '$trungtamlevel' AND ND_ID != '$user_id' LIMIT 1";
        $email_check_result = mysqli_query($conn, $email_check_query);
        if (mysqli_num_rows($email_check_result) > 0) {
            $errors['trungtamLevel'] = "Email đã tồn tại. Vui lòng sử dụng email khác.";
        }
    }
}
if ($trungtamLocation !== $trungtamLat) {
    $errors['pass'] = "Mật khẩu nhập lại không khớp!";
}

if (empty($errors)) {
    $sql1 = "UPDATE nguoi_dung SET ND_hoten='$trungtamName', ND_email='$trungtamlevel', ND_sdt='$trungtamPhone', 
            ND_password='$trungtamLocation', ND_username='$trungtamEmail' WHERE ND_ID='$user_id'";
    $result1 = mysqli_query($conn, $sql1);

    
    if ($result1) {
        
    
       
            echo "<script>
                alert('Cập học viên $trungtamName thành công!');
                window.location.href = 'user_info.php';  
            </script>";
        } else {
            echo "Lỗi khi thêm thời gian học!";
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
        .back-btn {
            position: absolute;
            top: 116px;
            right: 338px;
            font-size: 25px;
            font-weight: bold;
            text-decoration: none;
            color: #ffc108;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .back-btn:hover {
           
            color: #ffc108;
            cursor: pointer;
    
        }
       
     </style>
</head>

<body>
    <div class="manage">
        <div class="container-fluid ds-trungtam">

           
            <table class="table table-bordered">
            <thead class="table-dark">
    
</thead>
<tbody>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
               
                <td>{$row['ND_hoten']}</td>
                <td>{$row['ND_sdt']}</td>
                <td>{$row['ND_email']}</td>
                <td>{$row['ND_username']}</td>
               
                
                
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
    <div class="col-md-7">
        <div class="update-course">
            <h2 class="text-center">Cập nhật thông tin</h2>
            <form id="mainForm" method="POST" enctype="multipart/form-data">          
            <a href="user.php" class="back-btn">X</a>
                <div class="row" >              
                    <div class="col-md-6">
                        <label for="courseName">Họ tên học viên:</label>
                        <input type="text" id="courseName" name="courseName" class="form-control" required value="<?= $user['ND_hoten'] ?? '' ?>">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="coursePrice">Số điện thoại:</label>
                        <input type="text" id="coursePrice" name="coursePrice" class="form-control" required value="<?= $user['ND_sdt'] ?? '' ?>">
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
                        <input type="text" id="trungtamLevel" name="trungtamLevel" class="form-control" required value="<?= $user['ND_email'] ?? '' ?>">
                        <?php
                            if (isset($errors['trungtamLevel'])) {
                                echo '<p style="color: red; font-size: 14px;  margin-top: 5px;">' . $errors['trungtamLevel'] . '</p>';
                            }
                           
                        ?>
                    </div>
                </div>

                    
                <div class="col-md-6">
                    <label for="courseSessions">Username:</label>
                    <input type="text" id="courseSessions" name="courseSessions" class="form-control" required value="<?= $user['ND_username'] ?? '' ?>">
                </div>
                </div>

    
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="courseInstructor">Mật khẩu:</label>
                        <input type="password" id="courseInstructor" name="courseInstructor" class="form-control" required value="<?= $user['ND_password'] ?? '' ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="pass">Nhập lại mật khẩu:</label>
                        <input type="password" id="pass" name="pass" class="form-control" required value="<?= $user['ND_password'] ?? '' ?>">
                        <?php
                            if (isset($errors['pass'])) {
                                echo '<p style="color: red; font-size: 14px;  margin-top: 5px;">' . $errors['pass'] . '</p>';
                            }
                           
                        ?>
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
   
    <script src="script.js"></script>
</body>


</html>