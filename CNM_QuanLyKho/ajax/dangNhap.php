<?php
session_start();
    include_once ("../controller/cDangNhap.php");
    if (isset($_POST["action"])) {
        $action = $_POST["action"];
        if ($action == "dangNhap") {
           $tk = $_POST['tk'];
           $mk = $_POST['mk'];
        }
        switch ($action) { 
            case "dangNhap":
                dangNhap($tk, $mk);
                break;
        }

    }
    function dangNhap($tk, $mk) {
        $p = new ControlDangNhap(); 
        $res = $p->dangNhap($tk, $mk);
        if (checkLogin($tk)) {
            if (!$res){
                $_SESSION[$tk . 'count'] = !isset($_SESSION[$tk . 'count']) ? 1 : $_SESSION[$tk . 'count'] + 1;  
                if ($_SESSION[$tk . 'count'] >= 5 ) {
                    $dateTime = new DateTime('now');
                    $_SESSION[$tk . 'timeout'] = $dateTime->modify('+5 minutes');
                } 
                echo json_encode(false);
            } else {
                $_SESSION[$tk . 'timeout'] = null;   
                $_SESSION[$tk . 'count'] = 0;
                $_SESSION["maVaiTro"] = $res[0]['MaVaiTro'];
                $_SESSION["tenVaiTro"] = $res[0]['TenVaiTro'];
                $_SESSION["maTaiKhoan"] = $res[0]['MaTaiKhoan'];
                $_SESSION["tenTaiKhoan"] = $res[0]['TenDangNhap'];
                $_SESSION["MatKhau"] = $res[0]['MatKhau'];
                if($_SESSION['maVaiTro'] == 3){
                    $_SESSION['viTriKho'] = $res[0]['ViTriKho'];
                }
                echo json_encode($res);
            }
        } else {
            echo json_encode("Bạn đã vượt quá số lần đăng nhập tối đa. Vui lòng thử lại sau 5 phút");
        }
        
    }

    function checkLogin($tk) {
        if (isset($_SESSION[$tk . 'timeout']) && $_SESSION[$tk . 'timeout'] > new DateTime('now')) {
            return false;
        }
        return true;
    }
    

?>