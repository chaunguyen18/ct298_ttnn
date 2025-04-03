<?php
session_start();
include("connect.php");

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    die("Bạn cần đăng nhập để đánh giá!");
}

// Lấy danh sách trung tâm và khóa học
$trungTamQuery = "SELECT TT_ID, TT_ten FROM trung_tam";
$khoaHocQuery = "SELECT KH_ID, KH_ten FROM khoa_hoc";
$trungTamResult = $conn->query($trungTamQuery);
$khoaHocResult = $conn->query($khoaHocQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_SESSION['user_id'];
    $trungTamID = isset($_POST['trung_tam']) ? (int)$_POST['trung_tam'] : 0;
    $khoaHocID = isset($_POST['khoa_hoc']) ? (int)$_POST['khoa_hoc'] : 0;
    $noiDung = trim($_POST['noi_dung']);
    $soSao = isset($_POST['so_sao']) ? (int)$_POST['so_sao'] : 0;
    $ngayDanhGia = date("Y-m-d");

    if ($trungTamID == 0 || $khoaHocID == 0 || empty($noiDung) || $soSao < 1 || $soSao > 5) {
        echo "<div class='alert alert-danger'>Dữ liệu không hợp lệ!</div>";
    } else {
        $tgID = 1; // Giả sử TG_ID = 1
        $sql = "INSERT INTO danh_gia (DG_noidung, DG_sao, DG_ngay, ND_ID, TT_ID, KH_ID, TG_ID) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisiiii", $noiDung, $soSao, $ngayDanhGia, $userID, $trungTamID, $khoaHocID, $tgID);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Đánh giá thành công!</div>";
        } else {
            echo "<div class='alert alert-danger'>Lỗi khi đánh giá! " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đánh Giá</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
        }
        .rating input {
            display: none;
        }
        .rating label {
            font-size: 30px;
            color: gray;
            cursor: pointer;
        }
        .rating input:checked ~ label,
        .rating input:hover ~ label {
            color: gold;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Đánh giá khóa học</h2>
        <div class="card p-4 shadow">
            <form method="POST" action="review.php">
                <div class="mb-3">
                    <label class="form-label">Chọn Trung Tâm:</label>
                    <select name="trung_tam" id="trung_tam" class="form-select" required>
                        <option value="">-- Chọn Trung Tâm --</option>
                        <?php while ($row = $trungTamResult->fetch_assoc()) { ?>
                            <option value="<?php echo $row['TT_ID']; ?>"><?php echo $row['TT_ten']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Chọn Khóa Học:</label>
                    <select name="khoa_hoc" id="khoa_hoc" class="form-select" required>
                        <option value="">-- Chọn Khóa Học --</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nội dung đánh giá:</label>
                    <textarea name="noi_dung" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Chọn số sao:</label>
                    <div class="rating">
                        <input type="radio" name="so_sao" id="star5" value="5"><label for="star5">★</label>
                        <input type="radio" name="so_sao" id="star4" value="4"><label for="star4">★</label>
                        <input type="radio" name="so_sao" id="star3" value="3"><label for="star3">★</label>
                        <input type="radio" name="so_sao" id="star2" value="2"><label for="star2">★</label>
                        <input type="radio" name="so_sao" id="star1" value="1" required><label for="star1">★</label>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='reviews.php'">Hủy</button>
                    <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                </div>
                <div class="right-section">
                <div style="position: relative; height: 50px;">
                <a href="user.php" style="display: inline-block; padding: 8px 12px; background-color: #ddd; color: #333; text-decoration: none; font-size: 14px; border-radius: 5px; position: absolute; right: 10px; top: 10px;">
                    ⬅Home
                </a>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("trung_tam").addEventListener("change", function() {
            var trungTamID = this.value;
            var khoaHocSelect = document.getElementById("khoa_hoc");

            if (trungTamID === "") {
                khoaHocSelect.innerHTML = "<option value=''>-- Chọn Khóa Học --</option>";
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_course.php?tt_id=" + trungTamID, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var khoaHocList = JSON.parse(xhr.responseText);
                    khoaHocSelect.innerHTML = "<option value=''>-- Chọn Khóa Học --</option>";
                    khoaHocList.forEach(function(khoaHoc) {
                        var option = document.createElement("option");
                        option.value = khoaHoc.KH_ID;
                        option.textContent = khoaHoc.KH_ten;
                        khoaHocSelect.appendChild(option);
                    });
                }
            };
            xhr.send();
        });
    </script>
</body>
</html>
