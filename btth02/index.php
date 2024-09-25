<?php
// Khởi động phiên
session_start();

// Lấy controller và action từ query string
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Tạo tên file controller
$controllerFile = 'controllers/' . ucfirst($controller) . 'Controller.php';

// Kiểm tra nếu file controller tồn tại
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    // Tạo tên class controller
    $controllerClass = ucfirst($controller) . 'Controller';

    // Kiểm tra nếu class controller tồn tại
    if (class_exists($controllerClass)) {
        $controllerObject = new $controllerClass();

        // Kiểm tra nếu phương thức action tồn tại
        if (method_exists($controllerObject, $action)) {
            $controllerObject->$action();
        } else {
            die("Phương thức $action không tồn tại trong controller $controllerClass.");
        }
    } else {
        die("Class controller $controllerClass không tồn tại.");
    }
} else {
    die("File controller $controllerFile không tồn tại.");
}
?>