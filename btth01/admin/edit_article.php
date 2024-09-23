<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'BTTH01_CSE485');

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra xem có ID bài viết được truyền vào không
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Lấy thông tin bài viết hiện tại
    $result = $conn->query("SELECT * FROM baiviet WHERE ma_bviet = $id");
    $article = $result->fetch_assoc();
}

// Kiểm tra nếu không tìm thấy bài viết
if (!$article) {
    echo "Bài viết không tồn tại.";
    exit();
}

// Kiểm tra nếu có dữ liệu gửi từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tieude = $conn->real_escape_string($_POST['tieude']);
    $ten_bhat = $conn->real_escape_string($_POST['ten_bhat']);
    $ma_tloai = (int)$_POST['ma_tloai'];
    $tomtat = $conn->real_escape_string($_POST['tomtat']);
    $noidung = $conn->real_escape_string($_POST['noidung']);
    $ma_tgia = (int)$_POST['ma_tgia'];
    $hinhanh = $conn->real_escape_string($_POST['hinhanh']);

    // Cập nhật bài viết
    $sql = "UPDATE baiviet SET tieude = '$tieude', ten_bhat = '$ten_bhat', ma_tloai = '$ma_tloai', tomtat = '$tomtat', noidung = '$noidung', ma_tgia = '$ma_tgia', hinhanh = '$hinhanh' WHERE ma_bviet = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: article.php"); // Quay lại trang article.php sau khi sửa thành công
        exit();
    } else {
        $msg = "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa bài viết</title>
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
                        <a class="nav-link" href="author.php">Tác giả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="article.php">Bài viết</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5 mb-5">
        <h3 class="text-center">Sửa bài viết</h3>
        <form action="" method="post">
            <div class="mb-3">
                <label for="tieude" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" name="tieude" value="<?php echo $article['tieude']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="ten_bhat" class="form-label">Tên bài hát</label>
                <input type="text" class="form-control" name="ten_bhat" value="<?php echo $article['ten_bhat']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="ma_tloai" class="form-label">Mã thể loại</label>
                <input type="number" class="form-control" name="ma_tloai" value="<?php echo $article['ma_tloai']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="tomtat" class="form-label">Tóm tắt</label>
                <textarea class="form-control" name="tomtat" rows="3" required><?php echo $article['tomtat']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="noidung" class="form-label">Nội dung</label>
                <textarea class="form-control" name="noidung" rows="5"><?php echo $article['noidung']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="ma_tgia" class="form-label">Mã tác giả</label>
                <input type="number" class="form-control" name="ma_tgia" value="<?php echo $article['ma_tgia']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="hinhanh" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control" name="hinhanh" value="<?php echo $article['hinhanh']; ?>">
            </div>
            <button type="submit" class="btn btn-success">Lưu lại</button>
            <a href="article.php" class="btn btn-warning">Quay lại</a>
        </form>
    </main>
    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
        <h4 class="text-center">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>