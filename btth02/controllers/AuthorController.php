<?php
include("services/AuthorService.php");

class authorController {
    private $authorService;

    public function __construct() {
        $this->authorService = new authorService();
    }

    public function index() {
        $authors = $this->authorService->getAllAuthors();
        require_once 'views/authors/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten_tgia = $_POST['txtAutName'];

            if ($this->authorService->addAuthor($ten_tgia)) {
                header('Location: index.php?controller=author&action=index');
            } else {
                echo "Có lỗi xảy ra, vui lòng thử lại!";
            }
        } else {
            require_once 'views/authors/add_author.php';
        }
    }

    public function edit() {
        $id = $_GET['id'];
        $author = $this->authorService->getMaTgia($id);
        require_once 'views/authors/edit_author.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_GET['id'];
            $ten_tgia = $_POST['txtAutName'];
            
            if ($this->authorService->updateAuthor($id, $ten_tgia)) {
                header('Location: index.php?controller=author&action=index');
            } else {
                echo "Có lỗi xảy ra, vui lòng thử lại!";
            }
        }
    }

    public function delete() {
        $id = $_GET['id'];
    
        if ($this->authorService->deleteAuthor($id)) {
            header('Location: index.php?controller=author&action=index');
        } else {
            echo "Không thể xóa tác giả này vì có bài viết liên quan.";
        }
    }
}