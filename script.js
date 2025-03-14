var map;
var marker;

// Hàm di chuyển đến vị trí mới
function moveTo(lat, lon, locationName = "Vị trí đã tìm") {
    map.setView([lat, lon], 15); 

    if (marker) {
        marker.setLatLng([lat, lon])
            .bindPopup(`<b>${locationName}</b>`)
            .openPopup();
    } else {
        marker = L.marker([lat, lon]).addTo(map)
            .bindPopup(`<b>${locationName}</b>`)
            .openPopup();
    }
}

// Hàm tìm kiếm địa điểm
function searchLocation() {
    let query = document.getElementById("search-input").value.trim(); 

    if (query === "") {
        alert("Vui lòng nhập địa chỉ!");
        return;
    }

    console.log("Đang tìm kiếm:", query);

    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            console.log("Dữ liệu nhận được:", data);
            if (!data || data.length === 0) {
                alert("Không tìm thấy địa điểm!");
                return;
            }
            let lat = parseFloat(data[0].lat);
            let lon = parseFloat(data[0].lon);
            let locationName = data[0].display_name;

            moveTo(lat, lon, locationName);
        })
        .catch(error => {
            console.error("Lỗi khi tìm kiếm địa điểm:", error);
            alert("Có lỗi xảy ra!");
        });
}

// Khi trang web đã tải xong, khởi tạo bản đồ
document.addEventListener("DOMContentLoaded", function () {
    map = L.map('map').setView([10.0309, 105.7709], 15); 
    const menuItems = document.querySelectorAll(".menu-item");
    const contentAction = document.querySelector(".content-action");

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    marker = L.marker([10.0309, 105.7709]).addTo(map)
        .bindPopup(`<div style="text-align: center;">
                        <img src="assets/logo_ctu.jpg" width="50" alt="CTU Logo"><br>
                        <b>CTU</b>
                    </div>`)
        .openPopup();

    
    document.getElementById("search-input").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Ngăn chặn reload trang
            searchLocation();
        }
    });

    menuItems.forEach(item => {
        item.addEventListener("click", function () {
            const selectedMenu = this.textContent.trim();
            let fileName = "";

            // Xác định file HTML cần tải
            switch (selectedMenu) {
                case "Quản lý trung tâm":
                    fileName = "center_management.php";
                    break;
                case "Quản lý khóa học":
                    fileName = "course_management.php";
                    break;
                default:
                    contentAction.innerHTML = "<p>Chức năng chưa hỗ trợ.</p>";
                    return;
            }

            // Gọi file HTML và chèn vào content-action
            fetch(fileName)
                .then(response => response.text())
                .then(html => {
                    contentAction.innerHTML = html;
                })
                .catch(error => {
                    console.error("Lỗi tải giao diện:", error);
                    contentAction.innerHTML = "<p>Lỗi tải giao diện.</p>";
                });
        });
    });
});
