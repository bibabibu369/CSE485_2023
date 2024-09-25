<?php

class CategoryController {
    public function index() {
        include 'configs/DBConnection.php'; // Kết nối CSDL

        $db = new DBConnection();
        $conn = $db->getConnection();

        // Truy vấn dữ liệu từ bảng thể loại
        $sql = "SELECT ma_tloai, ten_tloai FROM theloai";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt;

        // Gọi view và truyền dữ liệu
        require_once 'views/category/index.php';

        $conn = null;
    }

    public function add() {
        include 'configs/DBConnection.php'; // Kết nối CSDL

        $db = new DBConnection();
        $conn = $db->getConnection();

        // Khởi tạo CSRF token nếu chưa có
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    
        // Kiểm tra nếu form đã được submit
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lấy dữ liệu từ form
            $ten_tloai = $_POST['txtCatName'];
            
            // Kiểm tra xem tên thể loại có trống hay không
            if (!empty($ten_tloai)) {
                // Lấy giá trị lớn nhất hiện tại của cột khóa chính
                $result = $conn->query("SELECT MAX(ma_tloai) AS max_id FROM theloai");
                
                if ($result) {
                    $row = $result->fetch(PDO::FETCH_ASSOC);
                    $new_id = $row['max_id'] + 1;
    
                    // Chuẩn bị truy vấn SQL để thêm thể loại
                    $sql = "INSERT INTO theloai (ma_tloai, ten_tloai) VALUES (:id, :name)";
                    $stmt = $conn->prepare($sql);
                    
                    if ($stmt === false) {
                        error_log("Lỗi chuẩn bị truy vấn: " . $conn->error);
                        die("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    }
    
                    $stmt->bindValue(':id', $new_id);
                    $stmt->bindValue(':name', $ten_tloai);
    
                    // Thực thi truy vấn
                    if ($stmt->execute()) {
                        // Nếu thành công, chuyển hướng về trang danh sách thể loại
                        header("Location: index.php?controller=category&action=index");
                        exit(); // Đảm bảo script dừng sau khi chuyển hướng
                    } else {
                        // Nếu xảy ra lỗi khi thêm thể loại
                        echo "Lỗi khi thêm thể loại: " . $stmt->error;
                    }
    
                    // Đóng statement
                    $stmt->close();
                } else {
                    // Nếu xảy ra lỗi khi thực hiện truy vấn
                    echo "Lỗi khi lấy giá trị lớn nhất của id: " . $conn->error;
                }
            } else {
                // Nếu tên thể loại trống
                echo "<script>alert('Vui lòng nhập tên thể loại'); window.history.back();</script>";
            }
        }
    
        $conn = null;
        
        require_once 'views/category/add_category.php';
    }

    public function edit() {
        include 'configs/DBConnection.php'; // Kết nối CSDL
    
        $db = new DBConnection();
        $conn = $db->getConnection();
    
        $id = $_GET['id'];
        $sql = "SELECT * FROM theloai WHERE ma_tloai = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        require_once 'views/category/edit_category.php';

        $conn = null;
    }

    public function update() {
        include 'configs/DBConnection.php'; // Kết nối CSDL
    
        $db = new DBConnection();
        $conn = $db->getConnection();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_GET['id'];
            $ten_tloai = $_POST['txtCatName'];
    
            $sql = "UPDATE theloai SET ten_tloai = :name WHERE ma_tloai = :id";
    
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':name', $ten_tloai);
            $stmt->bindValue(':id', $id);
    
            if ($stmt->execute()) {
                header('Location: index.php?controller=category&action=index');
            } else {
                echo "Có lỗi xảy ra, vui lòng thử lại!";
            }
        } else {
            require_once 'views/category/edit_category.php';
        }
    }

    public function delete() {
        include 'configs/DBConnection.php'; // Kết nối CSDL
    
        $db = new DBConnection();
        $conn = $db->getConnection();
    
        $id = $_GET['id'];
        $sql = "DELETE FROM theloai WHERE ma_tloai = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
    
        if ($stmt->execute()) {
            header('Location: index.php?controller=category&action=index');
        } else {
            echo "Có lỗi xảy ra, vui lòng thử lại!";
        }
    
        $conn = null;
    }
}
?>