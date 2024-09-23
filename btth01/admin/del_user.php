<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'BTTH01_CSE485');

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra nếu có tham số id được gửi qua URL
if (isset($_GET['id'])) {
    $userId = (int)$_GET['id'];

    // Thực hiện lệnh xóa
    $sql = "DELETE FROM users WHERE ma_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        // Xóa thành công, chuyển hướng về trang danh sách người dùng
        header("Location: user.php");
        exit();
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>