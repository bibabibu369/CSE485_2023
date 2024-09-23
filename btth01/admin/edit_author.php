<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'BTTH01_CSE485');

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra xem có ID được truyền vào không
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Lấy thông tin tác giả hiện tại
    $result = $conn->query("SELECT * FROM tacgia WHERE ma_tgia = $id");
    $author = $result->fetch_assoc();
}

// Kiểm tra nếu không tìm thấy tác giả
if (!$author) {
    echo "Tác giả không tồn tại.";
    exit();
}

// Xử lý cập nhật thông tin tác giả
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['txtAuthorName']);
    $image = $conn->real_escape_string($_POST['txtImage']);

    // Cập nhật thông tin tác giả
    $sql = "UPDATE tacgia SET ten_tgia = '$name', hinh_tgia = '$image' WHERE ma_tgia = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: author.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin tác giả</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <div class="h3">
                    <a class="navbar-brand" href="#">Administration</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                        <a class="nav-link" href="../index.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="./">Tổng quan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="category.php">Thể loại</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="author.php">Tác giả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="article.php">Bài viết</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5 mb-5">
        <h3 class="text-center text-uppercase fw-bold">Sửa thông tin tác giả</h3>
        <form action="" method="post">
            <div class="input-group mt-3 mb-3">
                <span class="input-group-text" id="lblAuthorId">Mã tác giả</span>
                <input type="text" class="form-control" name="txtAuthorId" readonly value="<?php echo $author['ma_tgia']; ?>">
            </div>

            <div class="input-group mt-3 mb-3">
                <span class="input-group-text" id="lblAuthorName">Tên tác giả</span>
                <input type="text" class="form-control" name="txtAuthorName" value="<?php echo $author['ten_tgia']; ?>">
            </div>

            <div class="input-group mt-3 mb-3">
                <span class="input-group-text" id="lblImage">Hình ảnh</span>
                <input type="text" class="form-control" name="txtImage" value="<?php echo $author['hinh_tgia']; ?>">
            </div>

            <!-- Sử dụng text-end và mb-5 để căn chỉnh và thêm khoảng trống -->
            <div class="form-group text-end mb-5">
                <input type="submit" value="Lưu lại" class="btn btn-success">
                <a href="author.php" class="btn btn-warning">Quay lại</a>
            </div>
        </form>
    </main>

    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php
// Đóng kết nối
$conn->close();
?>