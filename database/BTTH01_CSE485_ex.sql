USE BTTH01_CSE485;
GO

SELECT * FROM theloai
SELECT * FROM tacgia
SELECT * FROM baiviet ORDER BY ma_tloai ASC

--Liệt kê các bài viết về các bài hát thuộc thể loại Nhạc trữ tình--
SELECT *
FROM baiviet
WHERE ma_tloai = 2


--Liệt kê các bài viết của tác giả “Nhacvietplus”--
SELECT *
FROM baiviet
WHERE ma_tgia = 1

--Liệt kê các thể loại nhạc chưa có bài viết cảm nhận nào--
SELECT ten_tloai AS 'The Loai Nhac'
FROM theloai
LEFT JOIN baiviet ON theloai.ma_tloai = baiviet.ma_tloai
WHERE baiviet.ma_tloai IS NULL
--> Kiến thức thu được: LEFT JOIN để lấy tất cả các dòng từ bảng bên trái, ngay khi không có dòng tương ứng trong bảng bên phải

--Liệt kê các bài viết với các thông tin sau: mã bài viết, tên bài viết, tên bài hát, tên tác giả, tên thể loại, ngày viết.
SELECT ma_bviet, tieude, ten_bhat, tacgia.ten_tgia, theloai.ten_tloai, ngayviet
FROM baiviet
JOIN tacgia ON BAIVIET.ma_tgia = tacgia.ma_tgia
JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai
--> Kiến thức thu được: cách sử dụng JOIN..ON.. để truy vấn các cột trong bảng khác nhau

--Tìm thể loại có số bài viết nhiều nhất--
SELECT TOP 1 theloai.ten_tloai
FROM theloai
JOIN baiviet ON theloai.ma_tloai = baiviet.ma_tloai
GROUP BY theloai.ten_tloai
ORDER BY COUNT(baiviet.ma_bviet) DESC

--Liệt kê 2 tác giả có số bài viết nhiều nhất--
SELECT ten_tgia
FROM tacgia
JOIN baiviet ON tacgia.ma_tgia = baiviet.ma_tgia
GROUP BY tacgia.ten_tgia
ORDER BY COUNT(baiviet.ma_tgia) DESC

--Liệt kê các bài viết về các bài hát có tựa bài hát chứa 1 trong các từ “yêu”, “thương”, “anh”, “em”--
SELECT *
FROM baiviet
WHERE baiviet.tomtat LIKE N'%yêu%' 
   OR baiviet.tomtat LIKE N'%thương%'
   OR baiviet.tomtat LIKE N'%anh%'
   OR baiviet.tomtat LIKE N'%em%'

-- Liệt kê các bài viết về các bài hát có tiêu đề bài viết hoặc tựa bài hát chứa 1 trong các từ “yêu”, “thương”, “anh”, “em”
SELECT *
FROM baiviet
WHERE baiviet.tomtat LIKE N'%yêu%' 
   OR baiviet.tomtat LIKE N'%thương%'
   OR baiviet.tomtat LIKE N'%anh%'
   OR baiviet.tomtat LIKE N'%em%'
   OR baiviet.tieude LIKE N'%yêu%' 
   OR baiviet.tieude LIKE N'%thương%'
   OR baiviet.tieude LIKE N'%anh%'
   OR baiviet.tieude LIKE N'%em%'

--Tạo 1 view có tên vw_Music để hiển thị thông tin về Danh sách các bài viết kèm theo Tên thể loại và tên tác giả
CREATE VIEW vw_Music AS
SELECT ma_bviet, tieude, ten_bhat, ten_tloai, ten_tgia
FROM baiviet
JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai
JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia

--Tạo 1 thủ tục có tên sp_DSBaiViet với tham số truyền vào là Tên thể loại và trả về danh sách Bài viết của thể loại đó. Nếu thể loại không tồn tại thì hiển thị thông báo lỗi
CREATE PROCEDURE sp_DSBaiViet
    @ten_tloai NVARCHAR(100)
AS
BEGIN
    -- Kiểm tra nếu thể loại không tồn tại
    IF NOT EXISTS (SELECT 1 FROM theloai WHERE ten_tloai = @ten_tloai)
    BEGIN
        PRINT 'Lỗi: Thể loại không tồn tại!'
        RETURN
    END
    
    -- Truy vấn danh sách bài viết nếu thể loại tồn tại
    SELECT ma_bviet, tieude, ten_bhat, ten_tgia
    FROM baiviet
    JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai
    JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
    WHERE theloai.ten_tloai = @ten_tloai
END

--Thêm mới cột SLBaiViet vào trong bảng theloai. Tạo 1 trigger có tên tg_CapNhatTheLoai để khi thêm/sửa/xóa bài viết thì số lượng bài viết trong bảng theloai được cập nhật theo.
ALTER TABLE theloai
ADD SLBaiViet INT DEFAULT 0
CREATE TRIGGER tg_CapNhatTheLoai
ON baiviet
AFTER INSERT, UPDATE, DELETE
AS
BEGIN
    -- Khi có thêm bài viết mới
    IF EXISTS (SELECT * FROM inserted)
    BEGIN
        UPDATE theloai
        SET SLBaiViet = (SELECT COUNT(*) FROM baiviet WHERE baiviet.ma_tloai = theloai.ma_tloai)
        FROM theloai
        WHERE theloai.ma_tloai IN (SELECT ma_tloai FROM inserted)
    END

    -- Khi có bài viết bị xóa
    IF EXISTS (SELECT * FROM deleted)
    BEGIN
        UPDATE theloai
        SET SLBaiViet = (SELECT COUNT(*) FROM baiviet WHERE baiviet.ma_tloai = theloai.ma_tloai)
        FROM theloai
        WHERE theloai.ma_tloai IN (SELECT ma_tloai FROM deleted)
    END
END

--Bổ sung thêm bảng Users để lưu thông tin Tài khoản đăng nhập và sử dụng cho chức năng Đăng nhập/Quản trị trang web.
CREATE TABLE Users (
    ma_user INT PRIMARY KEY IDENTITY(1,1),  
    username NVARCHAR(50) NOT NULL UNIQUE,
    password NVARCHAR(255) NOT NULL,
    email NVARCHAR(100) NOT NULL,
    is_admin BIT DEFAULT 0,
    created_at DATETIME DEFAULT GETDATE()
)




--ok
