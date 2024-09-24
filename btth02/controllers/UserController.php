<?php

class UserController {
    public function login() {
        include 'configs/DBConnection.php'; // Kết nối CSDL

        $db = new DBConnection();
        $conn = $db->getConnection();

        $login_message = '';
        $username = '';

        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Truy vấn để tìm user theo username
            $sql = "SELECT * FROM users WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $username);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // So sánh mật khẩu (đã được mã hóa)
                if (password_verify($password, $result['password'])) {
                    $_SESSION['username'] = $username;
                    echo "<script>
                        window.location.href = 'index.php?controller=home&action=index';
                    </script>";
                } else {
                    $login_message = 'Sai mật khẩu!';
                }
            } else {
                $login_message = 'Không tìm thấy người dùng!';
            }
        }

        $conn = null;

        require_once 'views/user/login.php';
    }

    public function signup() {
        include 'configs/DBConnection.php'; // Kết nối CSDL

        $db = new DBConnection();
        $conn = $db->getConnection();

        $signup_message = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $repeat_password = $_POST['repeat_password'];

            // Kiểm tra các trường không được để trống
            if (empty($username) || empty($password) || empty($repeat_password)) {
                $signup_message = "Vui lòng điền đầy đủ thông tin!";
            } elseif ($password !== $repeat_password) {
                $signup_message = "Mật khẩu không khớp!";
            } else {
                // Kiểm tra xem tên người dùng đã tồn tại chưa
                $sql = "SELECT * FROM users WHERE username = :username";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':username', $username);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $signup_message = "Tên người dùng đã tồn tại!";
                } else {
                    // Mã hóa mật khẩu trước khi lưu
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Thêm người dùng mới vào cơ sở dữ liệu
                    $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':username', $username);
                    $stmt->bindValue(':password', $hashed_password);

                    if ($stmt->execute()) {
                        $signup_message = "Đăng ký thành công!";
                    } else {
                        $signup_message = "Có lỗi xảy ra, vui lòng thử lại!";
                    }
                }
            }
        }

        $conn = null;

        require_once 'views/user/signup.php';
    }

    // Các action khác
}