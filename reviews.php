<?php
include 'connect.php';

// Lấy danh sách trung tâm nổi bật
$topCentersQuery = "SELECT TT.TT_ID, TT.TT_ten, CDTT.CDTT_ten, HA.HA_url, 
                           COALESCE(AVG(DG.DG_sao), 0) AS avg_rating
                    FROM trung_tam TT 
                    JOIN capdo_trungtam CDTT ON TT.CDTT_ID = CDTT.CDTT_ID
                    JOIN hinh_anh HA ON TT.TT_ID = HA.TT_ID
                    LEFT JOIN danh_gia DG ON TT.TT_ID = DG.TT_ID
                    GROUP BY TT.TT_ID 
                    ORDER BY avg_rating DESC 
                    LIMIT 5";
$topCenters = $conn->query($topCentersQuery);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đánh giá trung tâm</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            width: 90%;
            margin: 20px auto;
        }
        .left-section {
            width: 65%;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .right-section {
            width: 30%;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }
        .center-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .center-info img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
        }
        .center-info h2 {
            font-size: 18px;
            margin: 0;
        }
        .center-info p {
            font-size: 14px;
            margin: 5px 0;
        }
        .reviews {
            margin-top: 20px;
        }
        .review {
            background: #fff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .review .user {
            font-weight: bold;
        }
        .review .course {
            font-size: 12px;
            color: gray;
        }
        .review .rating {
            color: gold;
        }
        .review .date {
            font-size: 12px;
            color: gray;
        }
        .center-item {
            display: flex;
            align-items: center;
            background: white;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .center-item:hover {
            background: #e0e0e0;
        }
        .center-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        

        .btn-back {
    display: inline-block;
    padding: 10px 15px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: 0.3s;
}
.btn-back:hover {
    background: #0056b3;
}

    </style>
</head>
<body>

<div class="container">
    <div class="left-section">
        <div class="center-info">
            <img id="center-avatar" src="default.jpg" alt="Avatar Trung Tâm">
            <div>
                <h2 id="center-name">Chọn trung tâm để xem đánh giá</h2>
                <p id="center-level">Cấp độ trung tâm</p>
                <p id="center-address">📍 Địa chỉ</p>
                <p id="center-phone">📞 Số điện thoại</p>
                <p id="center-email">✉️ Email</p>
            </div>
        </div>
        



        <!-- Bộ lọc đánh giá -->
<div class="filter-section">
    <label for="filter-rating">📊 Lọc theo số sao:</label>
    <select id="filter-rating" onchange="filterReviews()">
        <option value="all">Tất cả</option>
        <option value="5">⭐⭐⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="2">⭐⭐</option>
            <option value="1">⭐</option>
    </select>

    <label for="sort-reviews">🔄 Sắp xếp theo:</label>
    <select id="sort-reviews" onchange="sortReviews()">
        <option value="relevant">Liên quan nhất</option>
        <option value="newest">Mới nhất</option>
        <option value="highest">Xếp hạng cao nhất</option>
        <option value="lowest">Xếp hạng thấp nhất</option>
    </select>
</div>
<!-- Nút Thêm Đánh Giá -->
<button onclick="showReviewForm()" class="btn-add-review">➕ Thêm Đánh Giá</button>




        <div class="reviews" id="reviews">
            <p>Chọn trung tâm để xem đánh giá</p>
        </div>
        
    </div>

    

    <div class="right-section">
    <div style="position: relative; height: 50px;">
    <a href="user.php" style="display: inline-block; padding: 8px 12px; background-color: #ddd; color: #333; text-decoration: none; font-size: 14px; border-radius: 5px; position: absolute; right: 10px; top: 10px;">
        ⬅Home
    </a>
</div>


        
        <h3>Trung tâm nổi bật</h3>
        <?php while ($row = $topCenters->fetch_assoc()) { ?>
            <div class="center-item" onclick="loadCenter(<?php echo $row['TT_ID']; ?>)">
                <img src="<?php echo $row['HA_url']; ?>" alt="Avatar">
                <div>
                    <p><strong><?php echo $row['TT_ten']; ?></strong></p>
                    <p><?php echo $row['CDTT_ten']; ?></p>
                    <p>⭐ <?php echo number_format($row['avg_rating'], 1); ?> / 5</p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    function loadCenter(centerId) {
        fetch(`get_reviews.php?center_id=${centerId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("center-avatar").src = data.center.avatar;
                document.getElementById("center-name").textContent = data.center.name;
                document.getElementById("center-level").textContent = data.center.level;
                document.getElementById("center-address").textContent = "📍 " + data.center.address;
                document.getElementById("center-phone").textContent = "📞 " + data.center.phone;
                document.getElementById("center-email").textContent = "✉️ " + data.center.email;

                let reviewsContainer = document.getElementById("reviews");
                reviewsContainer.innerHTML = "";
                data.reviews.forEach(review => {
                    let reviewDiv = document.createElement("div");
                    reviewDiv.classList.add("review");
                    reviewDiv.innerHTML = `
                        <p class="user">${review.user}</p>
                        <p class="course">${review.course}</p>
                        <p class="rating">⭐${review.rating}</p>
                        <p class="content">${review.comment}</p>
                        <p class="date">${review.date}</p>
                    `;
                    reviewsContainer.appendChild(reviewDiv);
                });
            });
    }



    function loadCenter(centerId) {
    fetch(`get_reviews.php?center_id=${centerId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById("center-avatar").src = data.center.avatar;
            document.getElementById("center-name").textContent = data.center.name;
            document.getElementById("center-level").textContent = data.center.level;
            document.getElementById("center-address").textContent = "📍 " + data.center.address;
            document.getElementById("center-phone").textContent = "📞 " + data.center.phone;
            document.getElementById("center-email").textContent = "✉️ " + data.center.email;

            let reviewsContainer = document.getElementById("reviews");
            reviewsContainer.innerHTML = "";
            data.reviews.forEach(review => {
                let reviewDiv = document.createElement("div");
                reviewDiv.classList.add("review");
                reviewDiv.innerHTML = `
                    <p class="user">${review.user}</p>
                    <p class="course">${review.course}</p>
                    <p class="rating">⭐${review.rating}</p>
                    <p class="content">${review.comment}</p>
                    <p class="date">${review.date}</p>
                `;
                reviewsContainer.appendChild(reviewDiv);
            });
        });
}

//bộ lọc
function filterReviews() {
    let ratingFilter = document.getElementById("filter-rating").value;
    let reviews = document.querySelectorAll(".review");

    reviews.forEach(review => {
        let rating = review.querySelector(".rating").textContent.replace("⭐", "").trim();
        if (ratingFilter === "all" || rating === ratingFilter) {
            review.style.display = "block";
        } else {
            review.style.display = "none";
        }
    });
}

function sortReviews() {
    let sortOption = document.getElementById("sort-reviews").value;
    let reviewsContainer = document.getElementById("reviews");
    let reviews = Array.from(reviewsContainer.querySelectorAll(".review"));

    reviews.sort((a, b) => {
        let ratingA = parseFloat(a.querySelector(".rating").textContent.replace("⭐", "").trim());
        let ratingB = parseFloat(b.querySelector(".rating").textContent.replace("⭐", "").trim());
        let dateA = new Date(a.querySelector(".date").textContent);
        let dateB = new Date(b.querySelector(".date").textContent);

        switch (sortOption) {
            case "newest":
                return dateB - dateA; // Mới nhất trước
            case "highest":
                return ratingB - ratingA; // Xếp hạng cao nhất trước
            case "lowest":
                return ratingA - ratingB; // Xếp hạng thấp nhất trước
            default:
                return 0; // Không thay đổi nếu chọn "Liên quan nhất"
        }
    });

    reviewsContainer.innerHTML = "";
    reviews.forEach(review => reviewsContainer.appendChild(review));
}


//Nút
function showReviewForm() {
    // Chuyển hướng review.php
    window.location.href = "review.php?trungtam_id=1&khoahoc_id=3";
}
</script>

</body>
</html>
