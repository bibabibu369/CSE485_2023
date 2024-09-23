<?php
// Khởi động phiên
session_start();

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BTTH01_CSE485";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    error_log("Kết nối thất bại: " . $conn->connect_error);
    die("Có lỗi xảy ra. Vui lòng thử lại sau.");
}

// Tạo CSRF token nếu chưa có
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Kiểm tra nếu form đã được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra CSRF token
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF token không hợp lệ.");
    }

    // Lấy dữ liệu từ form
    $username = $_POST['txtUsername'];
    $password = password_hash($_POST['txtPassword'], PASSWORD_DEFAULT); // Mã hóa mật khẩu

    // Kiểm tra xem username và password có trống hay không
    if (!empty($username) && !empty($password)) {
        // Chuẩn bị truy vấn SQL để thêm người dùng
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            error_log("Lỗi chuẩn bị truy vấn: " . $conn->error);
            die("Có lỗi xảy ra. Vui lòng thử lại sau.");
        }

        $stmt->bind_param("ss", $username, $password);

        // Thực thi truy vấn
        if ($stmt->execute()) {
            // Nếu thành công, chuyển hướng về trang danh sách người dùng
            header("Location: user.php");
            exit(); // Đảm bảo script dừng sau khi chuyển hướng
        } else {
            // Nếu xảy ra lỗi khi thêm người dùng
            echo "Lỗi khi thêm người dùng: " . $stmt->error;
        }

        // Đóng statement
        $stmt->close();
    } else {
        // Nếu username hoặc password trống
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin người dùng'); window.history.back();</script>";
    }
}

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music for Life</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style_login.css">
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
                        <a class="nav-link active fw-bold" href="user.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="category.php">Thể loại</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="author.php">Tác giả</a>
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
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center text-uppercase fw-bold">Thêm mới người dùng</h3>
                <!-- Form để thêm người dùng -->
                <form action="add_user.php" method="post">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblUsername">Tên người dùng</span>
                        <input type="text" class="form-control" name="txtUsername" required>
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblPassword">Mật khẩu</span>
                        <input type="password" class="form-control" name="txtPassword" required>
                    </div>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                    <div class="form-group float-end">
                        <input type="submit" value="Thêm" class="btn btn-success">
                        <a href="user.php" class="btn btn-warning">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
