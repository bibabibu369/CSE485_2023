<?php
class Author {
    private $ma_tgia;
    private $ten_tgia;
    private $hinh_tgia;  

    public function __construct($ma_tgia, $ten_tgia, $hinh_tgia) {
        $this->ma_tgia = $ma_tgia;
        $this->ten_tgia = $ten_tgia;
        $this->hinh_tgia = $hinh_tgia;
    }

    public function getMaTgia() {
        return $this->ma_tgia;
    }

    public function getTenTgia() {
        return $this->ten_tgia;
    }

    public function getHinhAnh() {
        return $this->hinh_tgia;
    }
}
?>