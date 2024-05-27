<?php
    include_once("../model/ketnoi.php");
     class DangNhapModel {
        function dangNhap($tk, $mk){
            
            $p= new KetNoiModel();
            $p->ketNoi($conn);
            $stmt = $conn->prepare("SELECT tk.ViTriKho,tk.MaTaiKhoan, tk.TenDangNhap,TenVaiTro, tk.MaVaiTro FROM taikhoan as tk join vaitro as v on v.MaVaiTro = tk.MaVaiTro WHERE tenDangNhap = '" . $tk . "' and matKhau = '" . $mk ."'");
            $stmt->execute();
            $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!$menuItems){
                return false;
            }else{
                $p->dongKetNoi($conn);
                return $menuItems;
            }
        }
    }
?>
