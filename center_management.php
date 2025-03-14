<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trung Tâm Ngoại Ngữ TalkWise </title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="script.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="center-manage">
            <h1>Quản lý trung tâm</h1>
            <form id="centerForm" >
                <label for="centerName">Tên trung tâm:</label>
                <input type="text" id="centerName" name="centerName">

                <label for="centerLocation">Địa điểm:</label>
                <input type="text" id="centerLocation" name="centerLocation">

                <button type="submit">Lưu</button>
            </form>
        </div>
    </div>
</body>


</html>