<?php 
include("connect.php");

$category_query = "SELECT * FROM trung_tam";
$category_result = mysqli_query($conn, $category_query);



$sql_gv = "SELECT giao_vien.*, trung_tam.TT_ten 
           FROM giao_vien 
           INNER JOIN trung_tam ON giao_vien.TT_ID = trung_tam.TT_ID";

$result_gv = $conn->query($sql_gv);

if (isset($_POST['add'])) {
    $trungtamName = $_POST['trungtamName'];
    $trungtamPhone = $_POST['trungtamPhone'];
    $trungtamEmail = $_POST['trungtamEmail'];
    $trungtamlevel = $_POST['trungtamLevel'];
    $trungtamLocation = $_POST['trungtamLocation'];
    $trungtamLat = $_POST['trungtamLat'];
    $trungtamLon = $_POST['trungtamLon'];

    $errors = [];

    if (!preg_match('/^\d{10}$/', $trungtamPhone)) {
        $errors['trungtamPhone'] = "Số điện thoại phải là số và có đúng 10 chữ số.";
    }

    if (!filter_var($trungtamEmail, FILTER_VALIDATE_EMAIL)) {
        $errors['trungtamEmail'] = "Email không hợp lệ.";
    } else {

        $email_check_query = "SELECT GV_ID FROM giao_vien WHERE GV_email = '$trungtamEmail' LIMIT 1";
        $email_check_result = mysqli_query($conn, $email_check_query);
        if (mysqli_num_rows($email_check_result) > 0) {
            $errors['trungtamEmail'] = "Email đã tồn tại. Vui lòng sử dụng email khác.";
        }
    }
    if (empty($errors)) {

        $sql = "INSERT INTO giao_vien (TT_ID, GV_ten, GV_sdt, GV_email, GV_namkn, GV_quoctich, GV_chuyenmon) 
                VALUES ('$trungtamlevel','$trungtamName', '$trungtamPhone', '$trungtamEmail', '$trungtamLocation', '$trungtamLat', '$trungtamLon')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Thêm giáo viên $trungtamName thành công!');
                    window.location.href = 'teacher_management.php';  
                </script>";
        } else {
            echo "<script>alert('Lỗi khi thêm giáo viên: " . mysqli_error($conn) . "');</script>";
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
    <div class="manage ">
        <div class="container-fluid">

        <h2>Danh Sách Giáo Viên</h2>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>STT</th>
                    <th>Họ tên</th>
                    <th>Năm kinh nghiệm</th>
                    <th>SDT</th>
                    <th>Email</th>
                    <th>Quốc tịch</th>
                    <th>Chuyên môn</th>
                    <th>Trung tâm giảng dạy</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
        if ($result_gv->num_rows > 0) {
            while ($row = $result_gv->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['GV_ID']}</td>
                    <td>{$row['GV_ten']}</td>
                    <td>{$row['GV_namkn']}</td>
                    <td>{$row['GV_sdt']}</td>
                    <td>{$row['GV_email']}</td>
                    
                    <td>{$row['GV_quoctich']}</td>
                    <td>{$row['GV_chuyenmon']}</td>
                    <td>{$row['TT_ten']}</td>
                
                    <td>
                            <div class='d-flex flex-column gap-3'>
                                <a href='edit_teacher.php?id=" . $row['GV_ID'] . "'>
                                    <button class='btn btn-warning'>
                                        Cập nhật
                                    </button>
                                </a>
                                <button class='btn btn-danger'
                                    onclick=\"Delete(" . $row['GV_ID'] . ", '" . addslashes($row['GV_ten']) . "')\">
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
            <h2>Thêm mới giảng viên</h2>
            <form id="mainForm" method="POST" enctype="multipart/form-data">
                <div class="form-container d-flex justify-content-between gap-3">
                    <div class="form-column d-flex flex-column flex-fill">
                        <label for="trungtamName">Họ tên giảng viên:</label>
                        <input type="text" id="trungtamName" name="trungtamName" required>

                        <label for="trungtamPhone">Số điện thoại:</label>
                        <input type="text" id="trungtamPhone" name="trungtamPhone" required>
                        <?php
                            if (isset($errors['trungtamPhone'])) {
                                echo '<p style="color: red; font-size: 14px;  margin-top: 5px;">' . $errors['trungtamPhone'] . '</p>';
                            }
                        ?>
                        <label for="trungtamEmail">Email:</label>
                        <input type="email" id="trungtamEmail" name="trungtamEmail" required>
                        <?php
                            if (isset($errors['trungtamEmail'])) {
                                echo '<p style="color: red; font-size: 14px;  margin-top: 5px;">' . $errors['trungtamEmail'] . '</p>';
                            }
                           
                        ?>
                        <label for="trungtamLevel">Trung tâm giảng dạy:</label>
                        <select id="trungtamLevel" name="trungtamLevel" required>
                            <option value="">-Chọn trung tâm-</option>
                            <?php
                              while ($row = mysqli_fetch_assoc($category_result)) {                                 
                                      $selected = ($row['TT_ID'] == $row_up['TT_ID']) ? 'selected' : ''; 
                                      echo "<option value='" . $row['TT_ID'] . "' $selected>" . $row['TT_ten'] . "</option>";                                 
                              }
                            ?>
                        </select>
                        
                        
                    </div>

                    <div class="form-column d-flex flex-column flex-fill">
                        <label for="trungtamLocation">Năm kinh nghiệm</label> 
                        <input type="text" id="trungtamLocation" name="trungtamLocation" required>

                        <label for="trungtamLat">Quốc tịch</label>
                        <input type="text" id="trungtamLat" name="trungtamLat" required>

                        <label for="trungtamLon">Chuyên môn</label>
                        <input type="text" id="trungtamLon" name="trungtamLon" required>
                        
                        </select>
                        
                    </div>   
                                 
                </div>
                
                <div class="d-flex justify-content-center gap-3">
                    <button type="submit" name="add">Thêm</button>
                    <!-- <button type="submit" name="update">Lưu</button> -->
                </div>

            </form>
        </div>

       

    </div>
    <script>
        function Delete(id, trungtamName) {
            if (confirm(`Bạn có chắc chắn muốn xóa giảng viên "${trungtamName}" không?`)) {
                window.location.href = `deleteteacher.php?id=${id}`;
            }
        }   
    </script>
    <script src="script.js"></script>
</body>


</html>