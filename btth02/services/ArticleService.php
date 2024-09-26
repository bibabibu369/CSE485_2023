<?php
include("configs/DBConnection.php");
include("models/Article.php");

class ArticleService {
    public function getAllArticles() {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT * FROM baiviet ORDER BY ma_bviet ASC";
        $stmt = $conn->query($sql);

        $Articles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Article = new Article($row['ma_bviet'], $row['tieude'], $row['ten_bhat'], $row['ma_tloai'], $row['tomtat'], $row['noidung'], $row['ma_tgia'], $row['ngayviet'], $row['hinhanh']);
            array_push($Articles, $Article);
        }

        return $Articles;
    }

    public function addArticle($tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $ngayviet, $hinhanh) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
    
        // Lấy giá trị lớn nhất hiện tại của ma_bviet
        $sql = "SELECT MAX(ma_bviet) as max_id FROM baiviet";
        $stmt = $conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $maxId = $row['max_id'] + 1;
    
        // Chèn bản ghi mới với ma_bviet tăng lên 1
        $sql = "INSERT INTO baiviet (ma_bviet, tieude, ten_bhat, ma_tloai, tomtat, noidung, ma_tgia, ngayviet, hinhanh) VALUES (:ma_bviet, :tieude, :ten_bhat, :ma_tloai, :tomtat, :noidung, :ma_tgia, :ngayviet, :hinhanh)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ma_bviet', $maxId, PDO::PARAM_INT);
        $stmt->bindValue(':tieude', $tieude, PDO::PARAM_STR);
        $stmt->bindValue(':ten_bhat', $ten_bhat, PDO::PARAM_STR);
        $stmt->bindValue(':ma_tloai', $ma_tloai, PDO::PARAM_INT);
        $stmt->bindValue(':tomtat', $tomtat, PDO::PARAM_STR);
        $stmt->bindValue(':noidung', $noidung, PDO::PARAM_STR);
        $stmt->bindValue(':ma_tgia', $ma_tgia, PDO::PARAM_INT);
        $stmt->bindValue(':ngayviet', $ngayviet, PDO::PARAM_STR);
        $stmt->bindValue(':hinhanh', $hinhanh, PDO::PARAM_STR);
    
        return $stmt->execute();
    }

    public function getMaBviet($id) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
    
        $sql = "SELECT * FROM baiviet WHERE ma_bviet = :ma_bviet";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ma_bviet', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $Article = new Article($row['ma_bviet'], $row['tieude'], $row['ten_bhat'], $row['ma_tloai'], $row['tomtat'], $row['noidung'], $row['ma_tgia'], $row['ngayviet'], $row['hinhanh']);
    
        return $Article;
    }

    public function updateArticle($id, $tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $ngayviet, $hinhanh) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
    
        $sql = "UPDATE baiviet SET tieude = :tieude, ten_bhat = :ten_bhat, ma_tloai = :ma_tloai, tomtat = :tomtat, noidung = :noidung, ma_tgia = :ma_tgia, ngayviet = :ngayviet, hinhanh = :hinhanh WHERE ma_bviet = :ma_bviet";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ma_bviet', $id, PDO::PARAM_INT);
        $stmt->bindValue(':tieude', $tieude, PDO::PARAM_STR);
        $stmt->bindValue(':ten_bhat', $ten_bhat, PDO::PARAM_STR);
        $stmt->bindValue(':ma_tloai', $ma_tloai, PDO::PARAM_INT);
        $stmt->bindValue(':tomtat', $tomtat, PDO::PARAM_STR);
        $stmt->bindValue(':noidung', $noidung, PDO::PARAM_STR);
        $stmt->bindValue(':ma_tgia', $ma_tgia, PDO::PARAM_INT);
        $stmt->bindValue(':ngayviet', $ngayviet, PDO::PARAM_STR);
        $stmt->bindValue(':hinhanh', $hinhanh, PDO::PARAM_STR);
    
        return $stmt->execute();
    }

    public function deleteArticle($id) {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
    
        $sql = "DELETE FROM baiviet WHERE ma_bviet = :ma_bviet";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ma_bviet', $id, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
}