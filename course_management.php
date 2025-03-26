<?php 
include("connect.php");
$category_query = "SELECT * FROM capdo_khoahoc";
$category_result = mysqli_query($conn, $category_query);

$brand_query = "SELECT * FROM trung_tam";
$brand_result = mysqli_query($conn, $brand_query);

$sql = "SELECT khoa_hoc.*, 
               capdo_khoahoc.CDKH_ten, 
               thoi_gian.TG_ngaybatdau, 
               thoi_gian.TG_thoigian,
               thoi_gian.TG_hocphi, 
               trung_tam.TT_ten
        FROM khoa_hoc 
        INNER JOIN capdo_khoahoc ON khoa_hoc.CDKH_ID = capdo_khoahoc.CDKH_ID
        LEFT JOIN thoi_gian ON khoa_hoc.KH_ID = thoi_gian.KH_ID
        LEFT JOIN trung_tam ON thoi_gian.TT_ID = trung_tam.TT_ID
        GROUP BY khoa_hoc.KH_ID";



$result = $conn->query($sql);

if (isset($_POST['add'])) {
    $trungtamName = $_POST['courseName'];
    $trungtamPhone = $_POST['coursePrice'];
    $trungtamEmail = $_POST['trungtamName'];
    $trungtamlevel = $_POST['trungtamLevel'];
    $trungtamLocation = $_POST['courseInstructor'];
    $trungtamLat = $_POST['courseSessions'];
   
    

    $sql1 = "INSERT INTO khoa_hoc (KH_ten, CDKH_ID) VALUES ('$trungtamName', '$trungtamlevel')";
    $result1 = mysqli_query($conn, $sql1);

    
    if ($result1) {
        $KH_ID = mysqli_insert_id($conn);
    
        $sql2 = "INSERT INTO thoi_gian (KH_ID, TG_ngaybatdau, TG_thoigian, TG_hocphi, TT_ID) 
                 VALUES ('$KH_ID', '$trungtamLat', '$trungtamLocation', '$trungtamPhone', '$trungtamEmail')";
        $result2 = mysqli_query($conn, $sql2);
    
        if ($result2) {
            echo "<script>
                alert('Thêm khóa học $trungtamName thành công!');
                window.location.href = 'course_management.php';  
            </script>";
        } else {
            echo "Lỗi khi thêm thời gian học!";
        }
    } else {
        echo "Lỗi khi thêm khóa học!";
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

            <h2>Danh Sách khóa học</h2>
            <table class="table table-bordered">
            <thead class="table-dark">
    <tr class="text-center">
        <th>STT</th>
        <th>Tên khóa học</th>
        <th>Học phí</th>
        <th>Cấp độ khóa học</th>
        <!-- <th>Trung tâm</th> -->
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
              
                <td>{$row['TG_ngaybatdau']}</td>
                <td>{$row['TG_thoigian']} tháng</td>
                <td>
                            <div class='d-flex flex-column gap-3'>
                                <a href='edit_course.php?id=" . $row['KH_ID'] . "'>
                                    <button class='btn btn-warning'>
                                        Cập nhật
                                    </button>
                                </a>
                                <button class='btn btn-danger'
                                    onclick=\"Delete(" . $row['KH_ID'] . ", '" . addslashes($row['KH_ten']) . "')\">
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
            <h2 class="text-center">Thêm mới khóa học</h2>
            <form id="mainForm" method="POST" enctype="multipart/form-data">
                <!-- Hàng 1: 2 cột -->
                <div class="row">
                    <div class="col-md-6">
                        <label for="courseName">Tên khóa học:</label>
                        <input type="text" id="courseName" name="courseName" class="form-control" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="coursePrice">Học phí:</label>
                        <input type="number" id="coursePrice" name="coursePrice" class="form-control" min='1' required>
                    </div>
                </div>

                <!-- Hàng 2: 2 cột -->
                <div class="row mt-3">
                <div class="col-md-6">
                    <div class="d-flex flex-column">
                        <label for="trungtamLevel" class="mb-2">Cấp độ khóa học:</label>
                        <select id="trungtamLevel" name="trungtamLevel" class="form-control" style="height: 50px;" required>
                            <option value="">-Chọn cấp độ-</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($category_result)) {                                  
                                echo "<option value='" . $row['CDKH_ID'] . "'>" . $row['CDKH_ten'] . "</option>";                                 
                            }
                            ?>
                        </select>
                    </div>
                </div>

                    
                <div class="col-md-6">
                    <div class="d-flex flex-column">
                        <label for="trungtamName" class="mb-2">Trung tâm giảng dạy:</label>
                        <select id="trungtamName" name="trungtamName" class="form-control" style="height: 50px;" required>
                            <option value="">-Chọn trung tâm-</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($brand_result)) {                                 
                                $selected = ($row['TT_ID'] == $row_up['TT_ID']) ? 'selected' : ''; 
                                echo "<option value='" . $row['TT_ID'] . "' $selected>" . $row['TT_ten'] . "</option>";                                 
                            }
                            ?>
                        </select>
                    </div>
                </div>
                </div>

                <!-- Hàng 3: 2 cột -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="courseSessions">Ngày bắt đầu:</label>
                        <input type="date" id="courseSessions" name="courseSessions" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="courseInstructor">Thời gian:</label>
                        <input type="text" id="courseInstructor" name="courseInstructor" class="form-control" required>
                    </div>
                </div>

                <!-- Nút Thêm -->
                <div class="d-flex justify-content-center gap-3 mt-3">
                    <button type="submit" name="add" class="btn btn-primary">Thêm</button>
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