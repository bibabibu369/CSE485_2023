<?php
include("services/CategoryService.php");

class CategoryController {
    private $categoryService;

    public function __construct() {
        $this->categoryService = new categoryService();
    }

    public function index() {
        $categories = $this->categoryService->getAllCategory();
        require_once 'views/category/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten_tloai = $_POST['txtCatName'];

            if ($this->categoryService->addCategory($ten_tloai)) {
                header('Location: index.php?controller=category&action=index');
            } else {
                echo "Có lỗi xảy ra, vui lòng thử lại!";
            }
        } else {
            require_once 'views/category/add_category.php';
        }
    }

    public function edit() {
        $id = $_GET['id'];
        $category = $this->categoryService->getMaTloai($id);
        require_once 'views/category/edit_category.php';
    }
    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_GET['id'];
            $ten_tloai = $_POST['txtCatName'];
            
            if ($this->categoryService->updateCategory($id, $ten_tloai)) {
                header('Location: index.php?controller=category&action=index');
            } else {
                echo "Có lỗi xảy ra, vui lòng thử lại!";
            }
        }
    }

    public function delete() {
        $id = $_GET['id'];
    
        if ($this->categoryService->deleteCategory($id)) {
            header('Location: index.php?controller=category&action=index');
        } else {
            echo "Không thể xóa thể loại này vì có bài viết liên quan.";
        }
    }

}