<?php
    include_once("../model/dangNhap.php");
     class ControlDangNhap{
        function dangNhap($tk, $mk){
            $p = new DangNhapModel();
            $res = $p->dangNhap($tk, $mk);
            if (!$res) {
                return false;
            } else {
                return $res;
            }
        }
        
    }
    
?>
