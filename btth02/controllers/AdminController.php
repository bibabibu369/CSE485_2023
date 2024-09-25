<?php

class AdminController {
    public function index() {
        // session_start();
        if (!isset($_SESSION['username'])) {
            header('Location: index.php?controller=user&action=login');
            exit();
        }

        include 'configs/DBConnection.php'; // Kết nối CSDL

        $db = new DBConnection();
        $conn = $db->getConnection();

        // Đếm số lượng thể loại
        $sql_theloai = "SELECT COUNT(ma_tloai) AS count_theloai FROM theloai";
        $stmt_theloai = $conn->prepare($sql_theloai);
        $stmt_theloai->execute();
        $count_theloai = $stmt_theloai->fetch(PDO::FETCH_ASSOC)['count_theloai'];

        // Đếm số lượng tác giả
        $sql_tacgia = "SELECT COUNT(ma_tgia) AS count_tacgia FROM tacgia";
        $stmt_tacgia = $conn->prepare($sql_tacgia);
        $stmt_tacgia->execute();
        $count_tacgia = $stmt_tacgia->fetch(PDO::FETCH_ASSOC)['count_tacgia'];

        // Đếm số lượng bài viết
        $sql_baiviet = "SELECT COUNT(ma_bviet) AS count_baiviet FROM baiviet";
        $stmt_baiviet = $conn->prepare($sql_baiviet);
        $stmt_baiviet->execute();
        $count_baiviet = $stmt_baiviet->fetch(PDO::FETCH_ASSOC)['count_baiviet'];

        // Đếm số lượng người dùng
        $sql_users = "SELECT COUNT(ma_user) AS count_users FROM users";
        $stmt_users = $conn->prepare($sql_users);
        $stmt_users->execute();
        $count_users = $stmt_users->fetch(PDO::FETCH_ASSOC)['count_users'];

        $conn = null;

        require_once 'views/admin/index.php';
    }
}