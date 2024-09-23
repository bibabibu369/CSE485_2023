<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'BTTH01_CSE485');

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy mã bài viết cao nhất và tăng lên 1 để tránh trùng lặp
$result = $conn->query("SELECT MAX(ma_bviet) AS max_id FROM baiviet");
$row = $result->fetch_assoc();
$new_id = $row['max_id'] + 1;

// Lấy danh sách thể loại
$categories = $conn->query("SELECT * FROM theloai");

// Lấy danh sách tác giả
$authors = $conn->query("SELECT * FROM tacgia");

// Kiểm tra nếu có dữ liệu gửi từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tieude = $conn->real_escape_string($_POST['tieude']);
    $ten_bhat = $conn->real_escape_string($_POST['ten_bhat']);
    $ma_tloai = (int)$_POST['ma_tloai'];
    $tomtat = $conn->real_escape_string($_POST['tomtat']);
    $noidung = $conn->real_escape_string($_POST['noidung']);
    $ma_tgia = (int)$_POST['ma_tgia'];
    $hinhanh = $conn->real_escape_string($_POST['hinhanh']);

    // Thêm bài viết vào cơ sở dữ liệu
    $sql = "INSERT INTO baiviet (ma_bviet, tieude, ten_bhat, ma_tloai, tomtat, noidung, ma_tgia, hinhanh) VALUES ('$new_id', '$tieude', '$ten_bhat', '$ma_tloai', '$tomtat', '$noidung', '$ma_tgia', '$hinhanh')";

    if ($conn->query($sql) === TRUE) {
        $msg = "Thêm bài viết thành công!";
        header("Location: article.php"); // Quay lại trang article.php sau khi thêm thành công
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
    <title>Thêm bài viết</title>
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
        <h3 class="text-center">Thêm bài viết mới</h3>
        <?php if (isset($msg)) { echo "<div class='alert alert-info'>$msg</div>"; } ?>
        <form action="" method="post">
            <div class="mb-3">
                <label for="tieude" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" name="tieude" required>
            </div>
            <div class="mb-3">
                <label for="ten_bhat" class="form-label">Tên bài hát</label>
                <input type="text" class="form-control" name="ten_bhat" required>
            </div>
            <div class="mb-3">
                <label for="ma_tloai" class="form-label">Chọn thể loại</label>
                <select class="form-select" name="ma_tloai" required>
                    <?php while ($cat = $categories->fetch_assoc()): ?>
                        <option value="<?php echo $cat['ma_tloai']; ?>"><?php echo $cat['ten_tloai']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tomtat" class="form-label">Tóm tắt</label>
                <textarea class="form-control" name="tomtat" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="noidung" class="form-label">Nội dung</label>
                <textarea class="form-control" name="noidung" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="ma_tgia" class="form-label">Chọn tác giả</label>
                <select class="form-select" name="ma_tgia" required>
                    <?php while ($author = $authors->fetch_assoc()): ?>
                        <option value="<?php echo $author['ma_tgia']; ?>"><?php echo $author['ten_tgia']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="hinhanh" class="form-label">Hình ảnh (URL)</label>
                <input type="file" class="form-control" name="hinhanh" required>
            </div>
            <button type="submit" class="btn btn-success">Thêm bài viết</button>
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