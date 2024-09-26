<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa bài viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2>Chỉnh sửa bài viết</h2>
        <form action="index.php?controller=article&action=update&id=<?php echo $article->getMaBviet(); ?>" method="POST">
            <div class="mb-3">
                <label for="txtTitle" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" id="txtTitle" name="txtTitle" value="<?php echo $article->getTieude(); ?>" required>
            </div>
            <div class="mb-3">
                <label for="txtSongName" class="form-label">Tên bài hát</label>
                <input type="text" class="form-control" id="txtSongName" name="txtSongName" value="<?php echo $article->getTenBhat(); ?>" required>
            </div>
            <div class="mb-3">
                <label for="txtCatId" class="form-label">Thể loại</label>
                <input type="number" class="form-control" id="txtCatId" name="txtCatId" value="<?php echo $article->getMaTloai(); ?>" required>
            </div>
            <div class="mb-3">
                <label for="txtSummary" class="form-label">Tóm tắt</label>
                <textarea class="form-control" id="txtSummary" name="txtSummary" rows="3" required><?php echo $article->getTomtat(); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="txtContent" class="form-label">Nội dung</label>
                <textarea class="form-control" id="txtContent" name="txtContent" rows="5" required><?php echo $article->getNoidung(); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="txtAutId" class="form-label">Tác giả</label>
                <input type="number" class="form-control" id="txtAutId" name="txtAutId" value="<?php echo $article->getMaTgia(); ?>" required>
            </div>
            <div class="mb-3">
                <label for="txtDate" class="form-label">Ngày viết</label>
                <input type="date" class="form-control" id="txtDate" name="txtDate" value="<?php echo $article->getNgayviet(); ?>" required>
            </div>
            <div class="mb-3">
                <label for="txtImage" class="form-label">Hình ảnh</label>
                <input type="text" class="form-control" id="txtImage" name="txtImage" value="<?php echo $article->getHinhanh(); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>