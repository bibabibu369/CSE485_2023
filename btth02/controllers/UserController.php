<?php
include("services/UserService.php");

class UserController {
    private $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    public function index() {
        $users = $this->userService->getAllUsers();
        require_once 'views/user/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($this->userService->addUser($username, $password)) {
                header('Location: index.php?controller=user&action=index');
            } else {
                echo "Có lỗi xảy ra, vui lòng thử lại!";
            }
        } else {
            require_once 'views/user/add_user.php';
        }
    }

    public function edit() {
        $id = $_GET['id'];
        $user = $this->userService->getUserById($id);
        require_once 'views/user/edit_user.php';
    }
    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_GET['id'];
            $username = $_POST['username'];
            $password = !empty($_POST['password']) ? $_POST['password'] : null;

            if ($this->userService->updateUser($id, $username, $password)) {
                header('Location: index.php?controller=user&action=index');
            } else {
                echo "Có lỗi xảy ra, vui lòng thử lại!";
            }
        }
    }

    public function delete() {
        $id = $_GET['id'];

        if ($this->userService->deleteUser($id)) {
            header('Location: index.php?controller=user&action=index');
        } else {
            echo "Có lỗi xảy ra, vui lòng thử lại!";
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userService->getUserByUsername($username);

            if ($user && password_verify($password, $user->getPassword())) {
                session_start();
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['username'] = $user->getUsername();
                header('Location: index.php?controller=admin&action=index');
            } else {
                $login_message = "Tên đăng nhập hoặc mật khẩu không đúng!";
                require_once 'views/user/login.php';
            }
        } else {
            require_once 'views/user/login.php';
        }
    }

    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            if ($this->userService->addUser($username, $password)) {
                header('Location: index.php?controller=user&action=login');
            } else {
                echo "Có lỗi xảy ra, vui lòng thử lại!";
            }
        } else {
            require_once 'views/user/signup.php';
        }
    }
}
?>