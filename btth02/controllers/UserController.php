<?php

class UserController {
    public function index() {
        include 'configs/DBConnection.php'; // Kết nối CSDL

        $db = new DBConnection();
        $conn = $db->getConnection();

        // Truy vấn dữ liệu từ bảng users
        $sql = "SELECT ma_user, username FROM users ORDER BY ma_user ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt;

        require_once 'views/user/index.php';

        // Đóng kết nối
        $conn = null;
    }

    public function add() {
        include 'configs/DBConnection.php'; // Kết nối CSDL
    
        $db = new DBConnection();
        $conn = $db->getConnection();
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Kiểm tra xem các phần tử của mảng $_POST có tồn tại hay không
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username = $_POST['username'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
                $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':username', $username);
                $stmt->bindValue(':password', $password);
    
                if ($stmt->execute()) {
                    header('Location: index.php?controller=user&action=index');
                } else {
                    echo "Có lỗi xảy ra, vui lòng thử lại!";
                }
            } else {
                echo "Dữ liệu không hợp lệ!";
            }
        } else {
            require_once 'views/user/add_user.php';
        }
    
        $conn = null;
    }

    public function edit() {
        include 'configs/DBConnection.php'; // Kết nối CSDL
    
        $db = new DBConnection();
        $conn = $db->getConnection();
    
        $id = $_GET['id'];
        $sql = "SELECT * FROM users WHERE ma_user = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        require_once 'views/user/edit_user.php';
    
        $conn = null;
    }

    public function delete() {
        include 'configs/DBConnection.php'; // Kết nối CSDL
    
        $db = new DBConnection();
        $conn = $db->getConnection();
    
        $id = $_GET['id'];
        $sql = "DELETE FROM users WHERE ma_user = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
    
        if ($stmt->execute()) {
            header('Location: index.php?controller=user&action=index');
        } else {
            echo "Có lỗi xảy ra, vui lòng thử lại!";
        }
    
        $conn = null;

    }

    public function update() {
        include 'configs/DBConnection.php'; // Kết nối CSDL
    
        $db = new DBConnection();
        $conn = $db->getConnection();
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_GET['id'];
            $username = $_POST['username'];
            $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    
            $sql = "UPDATE users SET username = :username";
            if ($password) {
                $sql .= ", password = :password";
            }
            $sql .= " WHERE ma_user = :id";
    
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $username);
            if ($password) {
                $stmt->bindValue(':password', $password);
            }
            $stmt->bindValue(':id', $id);
    
            if ($stmt->execute()) {
                header('Location: index.php?controller=user&action=index');
            } else {
                echo "Có lỗi xảy ra, vui lòng thử lại!";
            }
        }
    
        $conn = null;
    }

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
                        window.location.href = 'index.php?controller=admin&action=index';
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
}