<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["KH_ID"])) {
    $KH_ID = $_POST["KH_ID"];

    $sql = "SELECT khoa_hoc.KH_ten, 
                   thoi_gian.TG_hocphi, 
                   capdo_khoahoc.CDKH_ten, 
                   trung_tam.TT_ten, 
                   thoi_gian.TG_ngaybatdau, 
                   thoi_gian.TG_thoigian
            FROM khoa_hoc
            INNER JOIN capdo_khoahoc ON khoa_hoc.CDKH_ID = capdo_khoahoc.CDKH_ID
            LEFT JOIN thoi_gian ON khoa_hoc.KH_ID = thoi_gian.KH_ID
            LEFT JOIN trung_tam ON thoi_gian.TT_ID = trung_tam.TT_ID
            WHERE khoa_hoc.KH_ID = ? 
            ORDER BY thoi_gian.TG_hocphi ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $KH_ID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['KH_ten']}</td>
                    <td>{$row['TG_hocphi']} VND</td>
                    <td>{$row['CDKH_ten']}</td>
                    <td>{$row['TT_ten']}</td>
                    <td>{$row['TG_ngaybatdau']}</td>
                    <td>{$row['TG_thoigian']} tháng</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6' class='text-center'>Không có dữ liệu</td></tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>Lỗi dữ liệu</td></tr>";
}

$conn->close();
?>
