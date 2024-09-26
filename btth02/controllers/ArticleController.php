<?php
include("services/ArticleService.php");

class articleController {
    private $articleService;

    public function __construct() {
        $this->articleService = new articleService();
    }

    public function index() {
        $articles = $this->articleService->getAllArticles();
        require_once 'views/article/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tieude = $_POST['txtTitle'];
            $ten_bhat = $_POST['txtSongName'];
            $ma_tloai = $_POST['txtCatId'];
            $tomtat = $_POST['txtSummary'];
            $noidung = $_POST['txtContent'];
            $ma_tgia = $_POST['txtAutId'];
            $ngayviet = $_POST['txtDate'];
            $hinhanh = $_POST['txtImage'];

            if ($this->articleService->addArticle($tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $ngayviet, $hinhanh)) {
                header('Location: index.php?controller=article&action=index');
            } else {
                echo "Có lỗi xảy ra, vui lòng thử lại!";
            }
        } else {
            require_once 'views/article/add_article.php';
        }
    }

    public function edit() {
        $id = $_GET['id'];
        $article = $this->articleService->getMaBviet($id);
        require_once 'views/article/edit_article.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_GET['id'];
            $tieude = $_POST['txtTitle'];
            $ten_bhat = $_POST['txtSongName'];
            $ma_tloai = $_POST['txtCatId'];
            $tomtat = $_POST['txtSummary'];
            $noidung = $_POST['txtContent'];
            $ma_tgia = $_POST['txtAutId'];
            $ngayviet = $_POST['txtDate'];
            $hinhanh = $_POST['txtImage'];
            
            if ($this->articleService->updateArticle($id, $tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $ngayviet, $hinhanh)) {
                header('Location: index.php?controller=article&action=index');
            } else {
                echo "Có lỗi xảy ra, vui lòng thử lại!";
            }
        }
    }

    public function delete() {
        $id = $_GET['id'];
    
        if ($this->articleService->deleteArticle($id)) {
            header('Location: index.php?controller=article&action=index');
        } else {
            echo "Không thể xóa bài viết này vì có bài viết liên quan.";
        }
    }
}