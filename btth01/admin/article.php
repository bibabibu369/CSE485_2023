
<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'BTTH01_CSE485');

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra xem có ID được truyền vào để xóa không
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];

    // Xóa bài viết trong cơ sở dữ liệu
    $sql = "DELETE FROM baiviet WHERE ma_bviet = $id";

    if ($conn->query($sql) === TRUE) {
        $msg = "Xóa bài viết thành công!";
    } else {
        $msg = "Lỗi: " . $conn->error;
    }
}

// Lấy danh sách bài viết
$sql = "SELECT * FROM baiviet";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bài viết</title>
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
        <h3 class="text-center">Danh sách bài viết</h3>
        <a href="add_article.php" class="btn btn-success mb-3">Thêm bài viết</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Mã bài viết</th>
                    <th scope="col">Tiêu đề</th>
                    <th scope="col">Tên bài hát</th>
                    <th scope="col">Thể loại</th>
                    <th scope="col">Tác giả</th>
                    <th scope="col">Ngày viết</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['ma_bviet']; ?></td>
                            <td><?php echo $row['tieude']; ?></td>
                            <td><?php echo $row['ten_bhat']; ?></td>
                            <td><?php echo $row['ma_tloai']; ?></td>
                            <td><?php echo $row['ma_tgia']; ?></td>
                            <td><?php echo $row['ngayviet']; ?></td>
                            <td>
                                <a href="edit_article.php?id=<?php echo $row['ma_bviet']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                                <a href="?delete_id=<?php echo $row['ma_bviet']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Không có bài viết nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
