<?php
include("configs/DBConnection.php");
include("models/Author.php");

class AuthorService {
    public function getAllAuthors() {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT * FROM tacgia ORDER BY ma_tgia ASC";
        $stmt = $conn->query($sql);

        $Authors = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Author = new Author($row['ma_tgia'], $row['ten_tgia']);
            array_push($Authors, $Author);
        }

        return $Authors;
    }

    public function addAuthor($ten_tgia) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
    
        // Lấy giá trị lớn nhất hiện tại của ma_tgia
        $sql = "SELECT MAX(ma_tgia) as max_id FROM tacgia";
        $stmt = $conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $maxId = $row['max_id'] + 1;
    
        // Chèn bản ghi mới với ma_tgia tăng lên 1
        $sql = "INSERT INTO tacgia (ma_tgia, ten_tgia) VALUES (:ma_tgia, :ten_tgia)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ma_tgia', $maxId, PDO::PARAM_INT);
        $stmt->bindValue(':ten_tgia', $ten_tgia, PDO::PARAM_STR);
    
        return $stmt->execute();
    }

    public function getMaTgia($id) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT ma_tgia, ten_tgia FROM tacgia WHERE ma_tgia = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Author($row['ma_tgia'], $row['ten_tgia']);
        }

        return null;
    }

    public function updateAuthor($id, $ten_tgia) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "UPDATE tacgia SET ten_tgia = :ten_tgia WHERE ma_tgia = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':ten_tgia', $ten_tgia, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function deleteAuthor($id) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "DELETE FROM tacgia WHERE ma_tgia = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

}