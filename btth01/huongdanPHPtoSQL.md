Hướng dẫn kết nối CSDL -> PHP
1. Kết nối CSDL từ PHP
Tạo một file PHP kết nối đến cơ sở dữ liệu, ví dụ: db.php.

<!-- 
<?php
$servername = "localhost"; // Tên server của bạn
$username = "root";        // Username MySQL
$password = "";            // Mật khẩu MySQL (nếu có)
$dbname = "BTTH01_CSE485"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?> -->

2. Hiển thị Thể loại trong category.php
Trong file category.php, bạn cần thực hiện truy vấn lấy dữ liệu từ bảng theloai và hiển thị ra trang. Giả sử bạn đã có template HTML sẵn, chỉ cần thêm PHP vào để hiển thị dữ liệu:

<!-- <?php
include 'db.php'; // Kết nối CSDL

// Truy vấn lấy danh sách thể loại
$sql = "SELECT ma_tloai, ten_tloai FROM theloai";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Hiển thị thể loại
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['ma_tloai'] . "</td>";
        echo "<td>" . $row['ten_tloai'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "Không có thể loại nào.";
}
?> -->

3. Hiển thị thống kê trong index.php
Trong file index.php, bạn cần thực hiện các truy vấn để đếm số lượng thể loại, tác giả, bài viết và người dùng, sau đó hiển thị ra trang. Dưới đây là ví dụ về cách đếm và hiển thị các số liệu này:

<!-- <?php
include 'db.php'; // Kết nối CSDL

// Đếm số lượng thể loại
$sql_theloai = "SELECT COUNT(ma_tloai) AS count_theloai FROM theloai";
$result_theloai = $conn->query($sql_theloai);
$count_theloai = $result_theloai->fetch_assoc()['count_theloai'];

// Đếm số lượng tác giả
$sql_tacgia = "SELECT COUNT(ma_tgia) AS count_tacgia FROM tacgia";
$result_tacgia = $conn->query($sql_tacgia);
$count_tacgia = $result_tacgia->fetch_assoc()['count_tacgia'];

// Đếm số lượng bài viết
$sql_baiviet = "SELECT COUNT(ma_bviet) AS count_baiviet FROM baiviet";
$result_baiviet = $conn->query($sql_baiviet);
$count_baiviet = $result_baiviet->fetch_assoc()['count_baiviet'];

// Đếm số lượng người dùng (Giả sử bạn có bảng 'users')
$sql_users = "SELECT COUNT(id) AS count_users FROM users";
$result_users = $conn->query($sql_users);
$count_users = $result_users->fetch_assoc()['count_users'];

?>

<!-- Hiển thị thông tin thống kê trên trang -->
<!-- <div>
    <p>Số lượng thể loại: <?php echo $count_theloai; ?></p>
    <p>Số lượng tác giả: <?php echo $count_tacgia; ?></p>
    <p>Số lượng bài viết: <?php echo $count_baiviet; ?></p>
    <p>Số lượng người dùng: <?php echo $count_users; ?></p>
</div> --> -->


LOGIN
Tạo file login.php để kết nối và xác thực
Trong file login.php, thực hiện việc kết nối CSDL và xác thực người dùng dựa trên tên đăng nhập và mật khẩu. Giả sử mật khẩu đã được mã hóa bằng password_hash() khi tạo người dùng.

<!-- <?php
include 'db.php'; // Kết nối CSDL

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn để tìm user theo username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // So sánh mật khẩu (đã được mã hóa)
        if (password_verify($password, $user['password'])) {
            echo "<script>alert('Đăng nhập thành công!');</script>";
        } else {
            echo "<script>alert('Sai mật khẩu!');</script>";
        }
    } else {
        echo "<script>alert('Không tìm thấy người dùng!');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!-- Form đăng nhập -->
<form method="POST" action="login.php">
    <input type="text" name="username" placeholder="Tên đăng nhập" required>
    <input type="password" name="password" placeholder="Mật khẩu" required>
    <button type="submit">Đăng nhập</button>
</form>
