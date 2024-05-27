<?php
session_start();

    include_once ("../controller/cTaiKhoan.php");
    if (isset($_POST["action"])) {
        $action = $_POST["action"];
        if ($action == "themTaiKhoan") {
            $maTaiKhoan = rand(0,1000);
            $loai = $_POST['loai'];
            $tenDangNhap = $_POST['tenDangNhap'];
            $pass = $_POST['pass'];
            $viTriKho = $_POST['viTriKho'];
        }
        if ($action == 'doiMatKhau') {
            $maTaiKhoan = $_SESSION['maTaiKhoan'];
            $pass = $_POST['matKhau'];
        }
        if ($action == 'anhDaiDien') {
            $maTaiKhoan = $_SESSION['maTaiKhoan'];
            if (isset($_FILES['anhdaidien'])) {
                $file = $_FILES['anhdaidien'];
                $uploadDir =  $_SERVER['DOCUMENT_ROOT'] .'/CNM_QuanLyKho_Error/image/'; // Direc\tory to save uploaded images
                $uploadFile = $uploadDir . basename($file['name']); // Generate a unique filename
                
                if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                    // Image uploaded successfully
                    $image = $imageUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $uploadFile; // Construct the image URL
                    // Return the image URL as response
                }
            }
        }
        switch ($action) { 
            case "themTaiKhoan":
                themTaiKhoan($maTaiKhoan,$loai, $tenDangNhap, $pass,$viTriKho);
                break;
            case 'doiMatKhau':
                doiMatKhau($maTaiKhoan, $pass);
                break;
            case 'anhDaiDien':
                doiAnhDaiDien($maTaiKhoan, $image);
                break;
        }

    }
    function themTaiKhoan($maTaiKhoan,$loai, $tenDangNhap, $pass,$viTriKho){
        $p = new ControlTaiKhoan(); 
        $res = $p->themTaiKhoan($maTaiKhoan,$loai, $tenDangNhap, $pass,$viTriKho);
        if (!$res){
            echo json_encode(false);
        }else{
           echo json_encode(true);
        }
    
    }
    function doiMatKhau($maTaiKhoan, $pass){
        $p = new ControlTaiKhoan(); 
        $res = $p->doiMatKhau($maTaiKhoan, $pass);
        if (!$res){
            echo json_encode(false);
        }else{
           echo json_encode(true);
        }
    
    }
    function doiAnhDaiDien($maTaiKhoan, $anh){
        $p = new ControlTaiKhoan(); 
        $res = $p->anhDaiDien($maTaiKhoan, $anh);
        if (!$res){
            echo json_encode(false);
        }else{
           echo json_encode(true);
        }
    
    }
  

?>