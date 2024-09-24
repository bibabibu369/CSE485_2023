1. Tạo các thư mục chính cho mô hình MVC:
<!-- /project
│
├── /app
│   ├── /controllers    # Chứa các file điều khiển
│   ├── /models         # Chứa các file xử lý dữ liệu
│   └── /views          # Chứa các file giao diện
│
├── /public             # Chứa các tài nguyên tĩnh (HTML, CSS, JS)
│   └── index.php       # File chính để truy cập
│
├── /config             # Chứa các file cấu hình
│   └── database.php    # Cấu hình kết nối CSDL -->

2.  Chuyển các phần hiện có theo mô hình MVC
2.1. Model (Xử lý dữ liệu)
Các file trong thư mục models sẽ chứa logic để làm việc với cơ sở dữ liệu. Ví dụ, bạn sẽ có các model như CategoryModel.php, UserModel.php để xử lý bảng theloai, users.

Ví dụ về CategoryModel.php:

<!-- <?php
class CategoryModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllCategories() {
        $sql = "SELECT * FROM theloai";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?> -->


Để chuyển dự án của bạn theo mô hình MVC và sử dụng template đã có trong file ZIP, bạn cần thực hiện các bước sau để tổ chức lại dự án theo mô hình Model-View-Controller (MVC).

Bước 1: Giải nén và kiểm tra template
Giải nén file btth01_template.zip.
Xem qua các file và thư mục để hiểu rõ về cấu trúc hiện tại của dự án.
Tìm hiểu các phần đã được dựng sẵn, như giao diện (HTML, CSS), và các file PHP để hiển thị nội dung.
Bước 2: Tạo cấu trúc thư mục theo mô hình MVC
Tạo các thư mục chính cho mô hình MVC:

bash
Copy code
/project
│
├── /app
│   ├── /controllers    # Chứa các file điều khiển
│   ├── /models         # Chứa các file xử lý dữ liệu
│   └── /views          # Chứa các file giao diện
│
├── /public             # Chứa các tài nguyên tĩnh (HTML, CSS, JS)
│   └── index.php       # File chính để truy cập
│
├── /config             # Chứa các file cấu hình
│   └── database.php    # Cấu hình kết nối CSDL
Bước 3: Chuyển các phần hiện có theo mô hình MVC
3.1. Model (Xử lý dữ liệu)
Các file trong thư mục models sẽ chứa logic để làm việc với cơ sở dữ liệu. Ví dụ, bạn sẽ có các model như CategoryModel.php, UserModel.php để xử lý bảng theloai, users.

Ví dụ về CategoryModel.php:

php
Copy code
<?php
class CategoryModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllCategories() {
        $sql = "SELECT * FROM theloai";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
2.2. Controller (Điều khiển)
Thư mục controllers sẽ chứa các controller, nơi mà luồng dữ liệu giữa model và view được điều khiển. Ví dụ, CategoryController.php sẽ gọi CategoryModel và sau đó chuyển dữ liệu đến view.

Ví dụ về CategoryController.php:

<!-- <?php
require_once '../models/CategoryModel.php';

class CategoryController {
    private $categoryModel;

    public function __construct($db) {
        $this->categoryModel = new CategoryModel($db);
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        include '../views/category/index.php';
    }
}
?> -->

2.3. View (Hiển thị giao diện)
Thư mục views sẽ chứa các file giao diện (HTML) để hiển thị dữ liệu. Chuyển các phần HTML từ template hiện tại vào các file view tương ứng.

Ví dụ về index.php trong views/category:

<!-- /app/views/category/index.php
<!DOCTYPE html>
<html>
<head>
    <title>Danh sách thể loại</title>
</head>
<body>
    <h1>Danh sách Thể Loại</h1>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li><?php echo $category['ten_tloai']; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html> -->

2.4. Cấu hình kết nối cơ sở dữ liệu
Trong thư mục config, tạo file database.php để cấu hình kết nối với CSDL:

<!-- <?php
function getDatabaseConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "BTTH01_CSE485";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    return $conn;
}
?> -->

2.5. File chính index.php
File index.php trong thư mục public sẽ gọi các controller tương ứng để xử lý luồng dữ liệu:

<!-- <?php
require_once '../config/database.php';
require_once '../app/controllers/CategoryController.php';

$db = getDatabaseConnection();

$categoryController = new CategoryController($db);
$categoryController->index();
?> -->

3. Kết hợp các thành phần với template
Di chuyển tất cả các file HTML từ template vào thư mục views.
Các tài nguyên như CSS, JS có thể được giữ nguyên trong thư mục public.
4. Xử lý yêu cầu khác (nếu có)
Login: Bạn có thể tạo UserController.php để xử lý logic đăng nhập và lấy dữ liệu từ UserModel.php.
Thể loại: Dùng CategoryController.php để hiển thị danh sách thể loại.