<?php
include("configs/DBConnection.php");
include("models/CategoryModel.php");

class CategoryService {
    public function getAllCategory() {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT * FROM theloai";
        $stmt = $conn->query($sql);

        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category = new Category($row['ma_tloai'], $row['ten_tloai']);
            array_push($categories, $category);
        }

        return $categories;
    }

    public function addCategory($ten_tloai) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
    
        // Lấy giá trị lớn nhất hiện tại của ma_tloai
        $sql = "SELECT MAX(ma_tloai) as max_id FROM theloai";
        $stmt = $conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $maxId = $row['max_id'] + 1;
    
        // Chèn bản ghi mới với ma_tloai tăng lên 1
        $sql = "INSERT INTO theloai (ma_tloai, ten_tloai) VALUES (:ma_tloai, :ten_tloai)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ma_tloai', $maxId, PDO::PARAM_INT);
        $stmt->bindValue(':ten_tloai', $ten_tloai, PDO::PARAM_STR);
    
        return $stmt->execute();
    }

    public function getMaTloai($id) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT ma_tloai, ten_tloai FROM theloai WHERE ma_tloai = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Category($row['ma_tloai'], $row['ten_tloai']);
        }

        return null;
    }

    public function updateCategory($id, $ten_tloai) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "UPDATE theloai SET ten_tloai = :ten_tloai WHERE ma_tloai = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':ten_tloai', $ten_tloai);

        return $stmt->execute();
    }

    public function deleteCategory($id) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
    
        // Kiểm tra xem thể loại có bài viết liên quan hay không
        $sql = "SELECT COUNT(*) as count FROM baiviet WHERE ma_tloai = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row['count'] > 0) {
            // Có bài viết liên quan, không thể xóa
            return false;
        }
    
        // Không có bài viết liên quan, tiến hành xóa
        $sql = "DELETE FROM theloai WHERE ma_tloai = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
}