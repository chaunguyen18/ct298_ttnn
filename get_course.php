<?php
include 'connect.php'; 

if (isset($_GET['tt_id'])) {
    $tt_id = $_GET['tt_id'];

    $query = "SELECT DISTINCT k.KH_ID, k.KH_ten 
              FROM khoa_hoc k
              JOIN thoi_gian t ON k.KH_ID = t.KH_ID
              WHERE t.TT_ID = ?";
    
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $tt_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode($data);
    } else {
        echo json_encode(["error" => "Lỗi truy vấn SQL"]);
    }
} else {
    echo json_encode(["error" => "Thiếu TT_ID"]);
}
?>