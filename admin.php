<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['role'] == 2) {
    header("Location: user.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Trung Tâm Ngoại Ngữ TalkWise </title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


</head>

<body data-role="admin">
    <div class="container-fluid">
        <div class="row content-map">
            <div class="sidebar col-md-3 text-white p-3">
                <form id="search-box" class="search-box row">
                    <div class="col-md-9">
                        <input type="text" id="search-input" class="search-input">
                    </div>
                    <div class="col-md-3">
                        <button class="btnSearch" type="button" onclick="searchLocation()">Tìm</button>
                    </div>
                </form>

                <div class="sidebar-menu">
                    <div class="menu-item">Quản lý trung tâm</div>
                    <div class="menu-item">Quản lý khóa học</div>
                    <div class="menu-item">Quản lý thông tin</div>
                    <div class="menu-item">Quản lý đánh giá</div>
                    <div class="menu-item">Quản lý giảng viên</div>

                    <div class="menu-item"><a href="logout.php">Đăng xuất</a></div>
                </div>
            </div>
            <div id="map" class="map col-md-9 p-0">
            </div>
            <!-- <script>
                var map = L.map('map').setView([10.12, 105.53], 11); // Tọa độ trung tâm Cần Thơ

                // Thêm bản đồ nền từ OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                // Bản đồ từ Carto (Dark Mode)


                // Thêm lớp bản đồ hành chính từ GeoServer
                var geoServerLayer = L.tileLayer.wms("http://localhost:8080/geoserver/cantho/wms", {
                    layers: "cantho:ct_qh_gadm", // Đúng với GeoServer của bạn
                    format: "image/png",
                    transparent: true,
                    opacity: 0.3,
                    version: "1.1.0"
                }).addTo(map);

                var labelsLayer = L.layerGroup().addTo(map); // Tạo một lớp để chứa nhãn

                fetch("http://localhost:8080/geoserver/cantho/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=cantho:ct_qt_gadmgadm&outputFormat=application/json")
                    .then(response => response.json())
                    .then(data => {
                        labelsLayer.clearLayers(); // Xóa nhãn cũ trước khi vẽ mới

                        L.geoJSON(data, {
                            style: function(feature) {
                                return {
                                    fillColor: feature.properties.color || "blue",
                                    weight: 2,
                                    opacity: 1,
                                    color: "white",
                                    fillOpacity: 0.5
                                };
                            },
                            onEachFeature: function(feature, layer) {
                                if (feature.geometry.type === "MultiPolygon" || feature.geometry.type === "Polygon") {
                                    var center = turf.centerOfMass(feature);
                                    var label = L.marker(center.geometry.coordinates.reverse(), {
                                        icon: L.divIcon({
                                            className: 'label-icon',
                                            html: `<b>${feature.properties.ten_huyen}</b>`,
                                            iconSize: [100, 30]
                                        })
                                    });
                                    labelsLayer.addLayer(label); // Thêm nhãn vào lớp quản lý nhãn
                                }
                            }
                        }).addTo(map);
                    });
            </script> -->
        </div>
        <div class="container-fluid">
            <div class="content-action row">
                <h1>Vui lòng chọn 1 chức năng để quản lý.</h1>
            </div>
        </div>
    </div>

    <footer>
        <i class="fa-solid fa-copyright"></i> Bản quyền thuộc về nhóm 4 - 2025.
    </footer>

    <script src="script.js"></script>
</body>


</html>