<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BẢN ĐỒ</title>

    <!-- Liên kết file style.css -->
    <link rel="stylesheet" href="style.css">

    <!-- Thư viện Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body>

    <!-- Sidebar -->
    <div id="sidebar">
        <h2>Chức năng</h2>
        <div id="search-box">
            <input type="text" id="search-input" placeholder="Nhập địa chỉ...">
        </div>
        <div class="menu-item" onclick="moveTo(10.0309, 105.7709, 'Khu II - ĐH Cần Thơ')">Khu II - ĐH Cần Thơ</div>
        <h2>Quản lý</h2>
        <div class="menu-item" onclick="toggleSubMenu()">Quản lý thông tin</div>
        <div id="sub-menu" class="submenu">
            <div class="menu-item">Thêm</div>
            <div class="menu-item">Sửa</div>
        </div>
        <div class="menu-item">Quản lý trung tâm</div>
        <div class="menu-item">Quản lý khóa học</div>
        <div class="menu-item">Thống kê</div>
    </div>

    <!-- Leaflet Map -->
    <div id="map"></div>

    <script>
        // Khởi tạo bản đồ Leaflet
        var map = L.map('map').setView([10.0309, 105.7709], 15); // Khu II - ĐH Cần Thơ

        // Thêm tile từ OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Khởi tạo marker ban đầu
        var marker = L.marker([10.0309, 105.7709]).addTo(map)
            .bindPopup(`
                <div style="text-align: center;">
                    <img src="assets/logo_ctu.jpg" width="50" alt="CTU Logo"><br>
                    <b>CTU</b>
                </div>
            `).openPopup();

        // Hàm di chuyển marker đến vị trí mới và hiển thị popup
        function moveTo(lat, lng, locationName = "Vị trí đã tìm") {
            map.setView([lat, lng], 15);
            marker.setLatLng([lat, lng])
                .bindPopup(`<b>${locationName}</b>`) // Hiển thị tên địa điểm
                .openPopup();
        }

        // Tìm kiếm địa chỉ (sử dụng Nominatim API)
        document.getElementById("search-input").addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                let query = event.target.value;
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            let lat = data[0].lat;
                            let lon = data[0].lon;
                            let locationName = data[0].display_name;
                            moveTo(lat, lon, locationName);
                        } else {
                            alert("Không tìm thấy địa chỉ!");
                        }
                    })
                    .catch(error => console.error(error));
            }
        });

        function toggleSubMenu() {
            var submenu = document.getElementById("sub-menu");
            submenu.style.display = (submenu.style.display === "block") ? "none" : "block";
        }
    </script>

</body>

</html>