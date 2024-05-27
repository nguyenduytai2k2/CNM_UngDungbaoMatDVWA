<?php

    class KetNoiModel{
        function ketNoi(&$conn){
            if(isset($_SESSION["tenVaiTro"])){
                $user = $_SESSION["tenVaiTro"];
            }else{
                $user = "nguoidung";
            }
            $conn = new PDO('mysql:host=127.0.0.1;dbname=quanlykho', 'root', '');
        }
        function dongKetNoi($conn){
            $conn = null;
            return true;
        }
    }


?>