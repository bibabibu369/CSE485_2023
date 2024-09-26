<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm bài viết mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <div class="h3">
                    <a class="navbar-brand" href="index.php?controller=admin&action=index#">Administration</a>
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
                        <a class="nav-link" aria-current="page" href="index.php?controller=admin&action=index#">Tổng quan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=user&action=index">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=category&action=index">Thể loại</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=author&action=index">Tác giả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="index.php?controller=article&action=index">Bài viết</a>
                    </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mt-5 mb-5">
        <div class="row">
            <div class="col-sm">
            <h3 class="text-center text-uppercase fw-bold">Thêm mới bài viết</h3>
                <form action="index.php?controller=article&action=add" method="POST">
                    <div class="mb-3">
                        <label for="txtTitle" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control" id="txtTitle" name="txtTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="txtSongName" class="form-label">Tên bài hát</label>
                        <input type="text" class="form-control" id="txtSongName" name="txtSongName" required>
                    </div>
                    <div class="mb-3">
                        <label for="txtCatId" class="form-label">Mã thể loại</label>
                        <input type="number" class="form-control" id="txtCatId" name="txtCatId" required>
                    </div>
                    <div class="mb-3">
                        <label for="txtSummary" class="form-label">Tóm tắt</label>
                        <textarea class="form-control" id="txtSummary" name="txtSummary" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="txtContent" class="form-label">Nội dung</label>
                        <textarea class="form-control" id="txtContent" name="txtContent" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="txtAutId" class="form-label">Mã tác giả</label>
                        <input type="number" class="form-control" id="txtAutId" name="txtAutId" required>
                    </div>
                    <div class="mb-3">
                        <label for="txtDate" class="form-label">Ngày viết</label>
                        <input type="date" class="form-control" id="txtDate" name="txtDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="txtImage" class="form-label">Hình ảnh</label>
                        <input type="text" class="form-control" id="txtImage" name="txtImage" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm bài viết</button>
                </form>
            </div>
        </div>
    </main>
    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>