<?php
include 'connect.php';

$centerId = isset($_GET['center_id']) ? (int)$_GET['center_id'] : 0;

if ($centerId > 0) {
    // Lấy thông tin trung tâm 
    $query = "SELECT TT.TT_ten AS name, TT.TT_diachi AS address, TT.TT_sdt AS phone, TT.TT_email AS email, 
                     CDTT.CDTT_ten AS level, HA.HA_url AS avatar
              FROM trung_tam TT
              JOIN capdo_trungtam CDTT ON TT.CDTT_ID = CDTT.CDTT_ID
              JOIN (SELECT TT_ID, MIN(HA_url) AS HA_url FROM hinh_anh GROUP BY TT_ID) HA 
              ON TT.TT_ID = HA.TT_ID
              WHERE TT.TT_ID = ?";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $centerId);
    $stmt->execute();
    $center = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$center) {
        echo json_encode(["error" => "Center not found"]);
        exit;
    }

    // Lấy danh sách đánh giá 
    $query = "SELECT 
                ND.ND_hoten AS user, 
                KH.KH_ten AS course, 
                DG.DG_noidung AS comment, 
                DG.DG_sao AS rating, 
                DG.DG_ngay AS date,
                KH.KH_ID, KH.KH_Ten
              FROM danh_gia DG
              JOIN nguoi_dung ND ON DG.ND_ID = ND.ND_ID
              JOIN khoa_hoc KH ON DG.KH_ID = KH.KH_ID
              WHERE DG.TT_ID = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $centerId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    // Tạo mảng chứa đánh giá và danh sách khóa học duy nhất
    $reviews = [];
    $courses = [];

    while ($row = $result->fetch_assoc()) {
        $reviews[] = [
            "user" => $row["user"],
            "course" => $row["course"],
            "comment" => $row["comment"],
            "rating" => $row["rating"],
            "date" => $row["date"]
        ];

        // Lọc khóa học không trùng lặp
        if (!isset($courses[$row["KH_ID"]])) {
            $courses[$row["KH_ID"]] = [
                "id" => $row["KH_ID"],
                "name" => $row["KH_Ten"]
            ];
        }
    }

    // Chuyển danh sách khóa học từ dạng key-value sang array
    $courses = array_values($courses);

    echo json_encode([
        "center" => $center,
        "reviews" => $reviews,
        "courses" => $courses 
    ]);
}
?>
