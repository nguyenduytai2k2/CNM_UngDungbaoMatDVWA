<?php

include_once("../model/ketnoi.php");
class PhieuNhap{
    private $conn;

    function __construct(){
        $p = new KetNoiModel();
          $p->ketNoi($this->conn);
    }
    function layToanBoPhieuNhap($maTaiKhoan = null,$maKho = null){
        if($maTaiKhoan != null){
            $query = "CALL layToanBoPhieuNhap(:maTaiKhoan, '')";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":maTaiKhoan", $maTaiKhoan);
        }
        if($maKho != null){
            $query = "CALL layToanBoPhieuNhap('', :maKho)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":maKho", $maKho);
        }
        $stmt->execute();
        $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $menuItems ?: false;
    }
    function layPhieuNhapKhoChoNhap($maTaiKhoan = null,$maKho = null){
        if($maTaiKhoan != null){
            $query = "CALL layPhieuNhapKhoTheoKho(:maTaiKhoan, '', 'Chờ nhập')";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":maTaiKhoan", $maTaiKhoan);
        }
        if($maKho != null){
            $query = "CALL layPhieuNhapKhoTheoKho('', :maKho, 'Chờ nhập')";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":maKho", $maKho);
        }
        $stmt->execute();
        $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $menuItems ?: false;
    }

    function layPhieuNhapKhoDaNhap($maTaiKhoan = null, $maKho = null){
        if($maTaiKhoan != null){
            $query = "CALL layPhieuNhapKhoTheoKho(:maTaiKhoan, '', 'Đã nhập kho')";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":maTaiKhoan", $maTaiKhoan);
        }
        if($maKho != null){
            $query = "CALL layPhieuNhapKhoTheoKho('', :maKho, 'Đã nhập kho')";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":maKho", $maKho);
        }
        $stmt->execute();
        $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $menuItems ?: false;
    }

    function lapPhieuNhap($maPhieu, $maDon,$maKho, $maTaiKhoan, $ngayLap, $trangThai){
        $stmt = $this->conn->prepare("INSERT INTO phieunhap VALUES (?, ?,?, ?, ?, ?)");
        return  $stmt->execute([$maPhieu, $maDon,$maKho, $maTaiKhoan, $ngayLap, $trangThai]);
    }
    function lapChiTietPhieuNhap($maPhieu, $maSanPham, $soLuong, $trangThai, $ngayNhap){
        $query = "INSERT INTO chitietphieunhap VALUES (:maPhieu, :maSanPham, :soLuong, :trangThai, :ngayNhap)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maPhieu', $maPhieu);
        $stmt->bindParam(':maSanPham', $maSanPham);
        $stmt->bindParam(':soLuong', $soLuong);
        $stmt->bindParam(':trangThai', $trangThai);
        $stmt->bindParam(':ngayNhap', $ngayNhap);
        return $stmt->execute();
    }

    function layChiTietPhieuNhap($maPhieu){
        $stmt = $this->conn->prepare("CALL layChiTietPhieuNhap(?)");
        $stmt->execute([$maPhieu]);
        $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $menuItems ?: false;
    }

    function layTrangThaiPhieuNhap($maDon){
        $stmt = $this->conn->prepare("SELECT DISTINCT pn.TrangThai FROM phieunhap as pn JOIN donyeucau as d on d.MaDon = pn.MaDon WHERE d.MaDon = ?");
        $stmt->execute([$maDon]);
        $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $menuItems ?: false;
    }

    function themChiTietNguyenLieu($maChiTiet, $maSanPham, $maPhieu, $maKho, $soLuongTon, $donVi, $gia, $ngaySanXuat, $ngayHetHan){
        $stmt = $this->conn->prepare("INSERT INTO chitietsanpham VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0,0,0,0)");
        return $stmt->execute([$maChiTiet, $maSanPham, $maPhieu, $maKho, $soLuongTon, $donVi, $gia, $ngaySanXuat, $ngayHetHan]);
    }

    function xacNhanNhapKho($maPhieu){
        $stmt = $this->conn->prepare("CALL xacNhanNhapKho(?)");
        $stmt->execute([$maPhieu]);
        return $stmt->rowCount() > 0;
    }
}
?>
