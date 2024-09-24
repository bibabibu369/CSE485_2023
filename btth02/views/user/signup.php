<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style_login.css">
</head>
<body>
    <div id="notification" class="alert alert-danger" style="display: none;" role="alert">
    <p id="message-content"><?php echo isset($signup_message) ? $signup_message : ''; ?></p>
    </div>

    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <div class="my-logo">
                    <a class="navbar-brand" href="index.php?controller=home&action=index">
                        <img src="images/logo2.png" alt="" class="img-fluid">
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link" href="index.php?controller=home&action=index">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="index.php?controller=user&action=login">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                    <a style="font-weight:600" class="nav-link active" aria-current="page" href="index.php?controller=user&action=signup">Đăng kí</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Nội dung cần tìm" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Tìm</button>
                </form>
                </div>
            </div>
        </nav>
        
    </header>
    <main class="container mt-5 mb-5">
        <!-- <h3 class="text-center text-uppercase mb-3 text-primary">CẢM NHẬN VỀ BÀI HÁT</h3> -->
        <div class="d-flex justify-content-center h-100">
                <div class="card">
                    <div class="card-header">
                        <h3>Sign Up</h3>
                        <div class="d-flex justify-content-end social_icon">
                            <span><i class="fab fa-facebook-square"></i></span>
                            <span><i class="fab fa-google-plus-square"></i></span>
                            <span><i class="fab fa-twitter-square"></i></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="index.php?controller=user&action=signup">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="txtUser"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" placeholder="Username" name="username" autofocus>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="txtPass"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control" placeholder="Password" name="password">
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="txtPass"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control" placeholder="Repeat Password" name="repeat_password">
                            </div>
                        
                            <div class="form-group">
                                <input type="submit" value="Sign Up" class="btn float-end login_btn">
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </main>
    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary  border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
<script>
    window.onload = function() {
        var message = document.getElementById('message-content').innerText;
        if (message) {
            document.getElementById('notification').style.display = 'block';

            setTimeout(function() {
                var notification = document.getElementById('notification');
                if (notification.style.display === 'block') {
                    notification.style.display = 'none';
                }
            }, 2000);
        }

        document.addEventListener('click', function(event) {
            var notification = document.getElementById('notification');
            if (notification.style.display === 'block') {
                notification.style.display = 'none';
            }
        });

        document.getElementById('notification').addEventListener('click', function(event) {
            event.stopPropagation();
        });
    };

</script>
</html>