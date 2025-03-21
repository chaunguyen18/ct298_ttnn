var map;
var marker;

// Hàm di chuyển đến vị trí mới
function moveTo(lat, lon, locationName = "Vị trí đã tìm") {
  map.setView([lat, lon], 15);

  if (marker) {
    marker
      .setLatLng([lat, lon])
      .bindPopup(`<b>${locationName}</b>`)
      .openPopup();
  } else {
    marker = L.marker([lat, lon])
      .addTo(map)
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

  fetch(
    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(
      query
    )}`
  )
    .then((response) => response.json())
    .then((data) => {
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
    .catch((error) => {
      console.error("Lỗi khi tìm kiếm địa điểm:", error);
      alert("Có lỗi xảy ra!");
    });
}

document.addEventListener("DOMContentLoaded", function () {
  map = L.map("map").setView([10.0309, 105.7709], 15);
  const menuItems = document.querySelectorAll(".menu-item");
  const contentAction = document.querySelector(".content-action");

  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "&copy; OpenStreetMap contributors",
  }).addTo(map);

  marker = L.marker([10.0309, 105.7709])
    .addTo(map)
    .bindPopup(
      `<div style="text-align: center;">
                        <img src="assets/logo_ctu.jpg" width="50" alt="CTU Logo"><br>
                        <b>CTU</b>
                    </div>`
    )
    .openPopup();

  document
    .getElementById("search-input")
    .addEventListener("keypress", function (event) {
      if (event.key === "Enter") {
        event.preventDefault(); // Ngăn chặn reload trang
        searchLocation();
      }
    });

  if (!contentAction) {
    console.error("Không tìm thấy phần tử .content-action!");
    return;
  }

  menuItems.forEach((item) => {
    item.addEventListener("click", function () {
      const selectedMenu = this.textContent.trim();
      let fileName = "";

      // Xác định file HTML cần tải
      switch (selectedMenu) {
        case "Tìm kiếm nâng cao":
          fileName = "advanced_search.php";
          break;
        case "So sánh học phí":
          fileName = "compare_fee.php";
          break;

        case "Đánh giá":
          fileName = "user_review.php";
          break;

        case "Quản lý thông tin cá nhân":
          fileName = "user_info.php";
          break;

        default:
          contentAction.innerHTML = "<p>Chức năng chưa hỗ trợ.</p>";
          return;
      }

      fetch(fileName)
        .then((response) => response.text())
        .then((html) => {
          contentAction.innerHTML = html;
        })
        .catch((error) => {
          console.error("Lỗi tải giao diện:", error);
          contentAction.innerHTML = "<p>Lỗi tải giao diện.</p>";
        });
    });
  });

  /* Xử lý đăng nhập */

  document
    .getElementById("loginForm")
    .addEventListener("submit", function (event) {
      event.preventDefault(); // Ngăn form reload trang

      let username = document.getElementById("loginUserName").value;
      let password = document.getElementById("loginUserPwd").value;

      let formData = new FormData();
      formData.append("username", username);
      formData.append("password", password);

      fetch("process_login.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "success") {
            if (data.role == 1) {
              window.location.href = "admin.php";
            } else if (data.role == 2) {
              window.location.href = "user.php";
            }
          } else {
            alert("Đăng nhập thất bại! Vui lòng kiểm tra lại.");
          }
        })
        .catch((error) => console.error("Error:", error));
    });
});
