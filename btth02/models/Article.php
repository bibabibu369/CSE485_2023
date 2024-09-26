<?php
class Article {
    private $ma_bviet;
    private $tieuDe;
    private $ten_bhat;
    private $ma_tloai;
    private $tomtat;
    private $noidung;
    private $ma_tgia;
    private $ngayviet;
    private $hinhanh;


    public function __construct($ma_bviet,$tieuDe,$ten_bhat,$ma_tloai,$tomtat,$noidung,$ma_tgia,$ngayviet,$hinhanh){
        $this->ma_bviet = $ma_bviet;
        $this->tieuDe = $tieuDe;
        $this->ten_bhat = $ten_bhat;
        $this->ma_tloai = $ma_tloai;
        $this->tomtat = $tomtat;
        $this->noidung = $noidung;
        $this->ma_tgia = $ma_tgia;
        $this->ngayviet = $ngayviet;
        $this->hinhanh = $hinhanh;
    }

    // Setter và Getter
    public function getMaBviet(){
        return $this->ma_bviet;
    }

    public function setMaBviet($ma_bviet){
        return $this->ma_bviet = $ma_bviet;
    }

    public function getTieude(){
        return $this->tieuDe;
    }

    public function setTieude($tieuDe){
        return $this->tieuDe = $tieuDe;
    }

    public function getTenBhat()
    {
        return $this->ten_bhat;
    }

    public function setTenBhat($ten_bhat){
        return $this->ten_bhat = $ten_bhat;
    }

    public function getMaTloai(){
        return $this->ma_tloai;
    }

    public function setMaTloai($ma_tloai){
        return $this->ma_tloai = $ma_tloai;
    }

    public function getTomtat(){
        return $this->tomtat;
    }

    public function setTomtat($tomtat){
        return $this->tomtat = $tomtat;
    }

    public function getNoidung(){
        return $this->noidung;
    }

    public function setNoidung($noidung){
        return $this->noidung = $noidung;
    }

    public function getMaTgia(){
        return $this->ma_tgia;
    }

    public function setMaTgia($ma_tgia){
        return $this->ma_tgia = $ma_tgia;
    }

    public function getNgayviet(){
        return $this->ngayviet;
    }

    public function setNgayviet($ngayviet){
        return $this->ngayviet = $ngayviet;
    }

    public function getHinhanh(){
        return $this->hinhanh;
    }

    public function setHinhanh($hinhanh){
        return $this->hinhanh = $hinhanh;
    }
}