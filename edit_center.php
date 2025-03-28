<?php 
include("connect.php");

$category_query = "SELECT * FROM capdo_trungtam";
$category_result = mysqli_query($conn, $category_query);

$brand_query = "SELECT * FROM xa_phuong";
$brand_result = mysqli_query($conn, $brand_query);

$district_query = "SELECT * FROM quan_huyen";
$district_result = mysqli_query($conn, $district_query);

$id = $_GET['id'];

$sql_tt1 = "SELECT 
                c.*,
                cd.*, 
                xp.XP_ten , 
                qh.*,
                GROUP_CONCAT(ha.HA_url) AS images_list
            FROM trung_tam c
            LEFT JOIN hinh_anh ha ON c.TT_ID = ha.TT_ID
            JOIN capdo_trungtam cd ON c.CDTT_ID = cd.CDTT_ID
            JOIN xa_phuong xp ON c.XP_ID = xp.XP_ID
            JOIN quan_huyen qh ON xp.QH_ID = qh.QH_ID
            WHERE c.TT_ID = '$id'
            ;

";
$result_tt1 = $conn->query($sql_tt1);
$row_up1 = mysqli_fetch_assoc($result_tt1);
$sql_tt = "SELECT 
                c.*,
                cd.*, 
                xp.XP_ten , 
                qh.*,
                GROUP_CONCAT(ha.HA_url) AS images_list
            FROM trung_tam c
            LEFT JOIN hinh_anh ha ON c.TT_ID = ha.TT_ID
            JOIN capdo_trungtam cd ON c.CDTT_ID = cd.CDTT_ID
            JOIN xa_phuong xp ON c.XP_ID = xp.XP_ID
            JOIN quan_huyen qh ON xp.QH_ID = qh.QH_ID
            GROUP BY c.TT_ID;

";
$result_tt = $conn->query($sql_tt);
$row_up = mysqli_fetch_assoc($result_tt);


if (isset($_POST['add'])) {
    $trungtamName = $_POST['trungtamName'];
    $trungtamPhone = $_POST['trungtamPhone'];
    $trungtamEmail = $_POST['trungtamEmail'];
    $trungtamLevel = $_POST['trungtamLevel'];
    $trungtamQuan = $_POST['trungtamQuan'];
    $trungtamLocation = $_POST['trungtamLocation'];
    $trungtamLat = $_POST['trungtamLat'];
    $trungtamLon = $_POST['trungtamLon'];
    $trungtamXa = $_POST['trungtamXa'];

    $errors = [];
    if (!preg_match('/^\d{10}$/', $trungtamPhone)) {
        $errors['trungtamPhone'] = "Số điện thoại phải là số và có đúng 10 chữ số.";
    }

    
    if (!filter_var($trungtamEmail, FILTER_VALIDATE_EMAIL)) {
        $errors['trungtamEmail'] = "Email không hợp lệ.";
    } else {
       
        $email_check_query = "SELECT TT_ID FROM trung_tam WHERE TT_email = '$trungtamEmail' AND TT_ID != '$id' LIMIT 1";
        $email_check_result = mysqli_query($conn, $email_check_query);

        if (mysqli_num_rows($email_check_result) > 0) {
            $errors['trungtamEmail'] = "Email đã tồn tại. Vui lòng sử dụng email khác.";
        }
    }

    $new_xp_id = $trungtamXa; 
        if ($trungtamQuan !== $row_up['QH_ID']) {
            
            $xp_query = "SELECT XP_ID FROM xa_phuong WHERE QH_ID = '$trungtamQuan' ORDER BY XP_ID ASC LIMIT 1";
            $xp_result = mysqli_query($conn, $xp_query);
            
        }
        if (empty($errors)) {
            if (!empty($_FILES['trungtamImage']['name'])) {
                $mainImage = basename($_FILES['trungtamImage']['name']); 
                $mainImage_tmp = $_FILES['trungtamImage']['tmp_name'];

                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                $image_ext = pathinfo($mainImage, PATHINFO_EXTENSION);

                if (in_array(strtolower($image_ext), $allowed_types)) {
                if (move_uploaded_file($mainImage_tmp, 'images/' . $mainImage)) {
                
                    $checkImage = mysqli_query($conn, "SELECT * FROM hinh_anh WHERE TT_ID = '$id'");
                    
                    if (mysqli_num_rows($checkImage) > 0) {
                    
                        mysqli_query($conn, "UPDATE hinh_anh SET HA_url = '$mainImage' WHERE TT_ID = '$id'");
                    } else {
                    
                        mysqli_query($conn, "INSERT INTO hinh_anh (TT_ID, HA_url) VALUES ('$id', '$mainImage')");
                    }
                }
                }
            }

            $sql = "UPDATE trung_tam 
                    SET CDTT_ID = '$trungtamLevel', XP_ID = '$new_xp_id', TT_ten = '$trungtamName', TT_sdt = '$trungtamPhone',
                        TT_email = '$trungtamEmail', TT_diachi = '$trungtamLocation', TT_toado_x = '$trungtamLat', TT_toado_y = '$trungtamLon'
                    WHERE TT_ID = '$id'";

            $query = mysqli_query($conn, $sql);
            if ($query) {
                echo "<script>
                        alert('Cập nhật trung tâm $name thành công!');
                        window.location.href = 'center_management.php';  
                    </script>";
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
        <div class="container-fluid ds-trungtam">

            <h2>Danh Sách Trung Tâm</h2>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>STT</th>
                        <th>Tên Trung Tâm</th>
                        <th>Hình ảnh</th>
                        <th>SĐT</th>
                        <th>Email</th>
                        <th>Địa Chỉ</th>
                        <th>Cấp độ</th>
                        <th>Xã/phường</th>
                        <th>Quận huyện</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
            if ($result_tt->num_rows > 0) {
                while ($row = $result_tt->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['TT_ID']}</td>
                            <td>{$row['TT_ten']}</td>
                            <td>";

                    if (!empty($row['images_list'])) {
                        $file = explode(",", $row['images_list']);
                        foreach ($file as $image) {
                            $avatar_url = "images/" . trim($image);
                            echo "<img src='{$avatar_url}' style='width: 50px; height: auto; margin-right: 5px;'>";
                        }
                    } else {
                        echo "Không có ảnh";
                    }

                    echo "</td>
                        <td>{$row['TT_sdt']}</td>
                        <td>{$row['TT_email']}</td>
                        <td>{$row['TT_diachi']}</td>
                        <td>{$row['CDTT_ten']}</td>
                        <td>{$row['XP_ten']}</td>
                        <td>{$row['QH_ten']}</td>
                        <td>
                            <div class='d-flex flex-column gap-3'>
                                <a href='edit_center.php?id=" . $row['TT_ID'] . "'>
                                    <button class='btn btn-warning'>
                                        Cập nhật
                                    </button>
                                </a>
                                <button class='btn btn-danger'
                                    onclick=\"Delete(" . $row['TT_ID'] . ", '" . addslashes($row['TT_ten']) . "')\">
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
            <h2>Cập nhật thông tin trung tâm</h2>
            <form id="mainForm" method="POST" enctype="multipart/form-data">
                <div class="form-container d-flex justify-content-between gap-3">
                    <div class="form-column d-flex flex-column flex-fill">
                        <label for="trungtamName">Tên trung tâm:</label>
                        <input type="text" id="trungtamName" name="trungtamName" value="<?php echo $row_up1['TT_ten']; ?>" required>

                        <label for="trungtamPhone">Số điện thoại:</label>
                        <input type="text" id="trungtamPhone" name="trungtamPhone" value="<?php echo $row_up1['TT_sdt']; ?>" required>
                        <?php
                            if (isset($errors['trungtamPhone'])) {
                                echo '<p style="color: red; font-size: 14px;  margin-top: 5px;">' . $errors['trungtamPhone'] . '</p>';
                            }
                        ?>
                        <label for="trungtamEmail">Email:</label>
                        <input type="email" id="trungtamEmail" name="trungtamEmail" value="<?php echo $row_up1['TT_email']; ?>" required>
                        <?php
                            if (isset($errors['trungtamEmail'])) {
                                echo '<p style="color: red; font-size: 14px;  margin-top: 5px;">' . $errors['trungtamEmail'] . '</p>';
                            }
                           
                        ?>
                        <label for="trungtamLevel">Cấp độ trung tâm:</label>
                        <select id="trungtamLevel" name="trungtamLevel" required>
                            <option value="">-Chọn cấp độ-</option>
                            <?php
                              while ($row = mysqli_fetch_assoc($category_result)) {                                 
                                      $selected = ($row['CDTT_ID'] == $row_up1['CDTT_ID']) ? 'selected' : ''; 
                                      echo "<option value='" . $row['CDTT_ID'] . "' $selected>" . $row['CDTT_ten'] . "</option>";                                 
                              }
                            ?>
                        </select>
                        <label for="trungtamQuan">Quận huyện:</label>
                        <select id="trungtamQuan" name="trungtamQuan" required>
                            <option value="">-Chọn quận huyện-</option>
                            <?php
                              while ($row = mysqli_fetch_assoc($district_result)) {                                 
                                     $selected = ($row['QH_ID'] == $row_up1['QH_ID']) ? 'selected' : ''; 
                                      echo "<option value='" . $row['QH_ID'] . "' $selected>" . $row['QH_ten'] . "</option>";                                 
                              }
                            ?>
                        </select>
                        
                    </div>

                    <div class="form-column d-flex flex-column flex-fill">
                        <label for="trungtamLocation">Địa chỉ:</label>
                        <input type="text" id="trungtamLocation" name="trungtamLocation" value="<?php echo $row_up1['TT_diachi']; ?>" required>

                        <label for="trungtamLat">Tọa độ X:</label>
                        <input type="text" id="trungtamLat" name="trungtamLat" value="<?php echo $row_up1['TT_toado_x']; ?>" required>

                        <label for="trungtamLon">Tọa độ Y:</label>
                        <input type="text" id="trungtamLon" name="trungtamLon" value="<?php echo $row_up1['TT_toado_y']; ?>" required>
                        <label for="trungtamXa">xã phường:</label>
                        <select id="trungtamXa" name="trungtamXa" required> 
                            <option value="">-Chọn xã phường-</option>
                            <?php
                              while ($row = mysqli_fetch_assoc($brand_result)) {                                 
                                      $selected = ($row['XP_ID'] == $row_up1['XP_ID']) ? 'selected' : ''; 
                                      echo "<option value='" . $row['XP_ID'] . "' $selected>" . $row['XP_ten'] . "</option>";                                 
                              }
                            ?>
                        </select>
                        <label for="trungtamImage">Hình ảnh trung tâm:</label>
                        <div class="d-flex align-items-center gap-3">
                            <?php
                                if (!empty($row_up1['images_list'])) {
                                    $file = explode(",", $row_up1['images_list']);
                                    foreach ($file as $image) {
                                        $avatar_url = "images/" . trim($image);
                                        echo "<img id='previewImage' src='{$avatar_url}' style='width: 100px; height: auto; margin-right: 5px;'><br>";
                                    }
                                } else {
                                    echo "<img id='previewImage' src='' style='width: 100px; height: auto; display: none;'><br>";
                                }
                            ?>
                            <input type="file" id="trungtamImage" name="trungtamImage" class="form-control" accept="image/*" onchange="previewSelectedImage(event)">
                        </div>

                    </div>   
                                 
                </div>
                
                <div class="d-flex justify-content-center gap-3">
                    <button type="submit" name="add">Cập nhật</button>
                    <!-- <button type="submit" name="update">Lưu</button> -->
                </div>

            </form>
        </div>

        

            

    </div>
    <script>
        function Delete(id, trungtamName) {
            if (confirm(`Bạn có chắc chắn muốn xóa trung tâm "${trungtamName}" không?`)) {
                window.location.href = `deletecenter.php?id=${id}`;
            }
        }   
    </script>
    <script>
        function previewSelectedImage(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var preview = document.getElementById('previewImage');
                preview.src = reader.result;
                preview.style.display = 'block'; 
            };
            reader.readAsDataURL(event.target.files[0]);
        }
        </script>

    <script src="script.js"></script>
</body>


</html>