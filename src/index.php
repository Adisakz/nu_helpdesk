<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
require_once './dbconfig.php';

if (isset($_POST['signup']) && isset($_POST['id-person'])) {
    $id_person = $_POST['id-person'];

    $sql = "SELECT *  FROM account WHERE id_person = $id_person";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row && $row['id_person'] == $id_person) {
        // User found in the database

 


        $_SESSION["id"] = $row["id_person"];
        $_SESSION["name_title"] = $row["name_title"];
        $_SESSION["first_name"] = $row["first_name"];
        $_SESSION["last_name"] = $row["last_name"];
        $_SESSION["position"] = $row["position"];
        $_SESSION["department"] = $row["department"];
        $_SESSION["profile_img"] = $row["profile_img"];
        $_SESSION["urole"] = $row["urole"];
        $_SESSION["signature"] = $row["signature"];

        if ($row['urole'] == 'admin') {
            header("location: ./admin/index");
        } else if ($row['urole'] == 'ช่าง') {
            header("location: ./tech/index");
        } else if ($row['urole'] == 'หัวหน้าหน่วย') {//หัวหน้ากองคลัง
            if ( $row["department"] =='11'){
                header("location: ./head_klung/index");
            }
            else if ( $row["department"] =='2'){//หัวหน้าพัสดุ
                header("location: ./head_parcel/index");
            }
            else {
                header("location: ./head/index");//หัวหน้าหน่วย
            }
        } else if ($row['urole'] == 'ผู้อำนวยการ') {
            header("location: ./director/index");
        } else if ($row['urole'] == 'คณบดี') {
            header("location: ./dean/index");
        } else if ($row['urole'] == 'พัสดุ') {
            header("location: ./parcel/index");
        }else if ($row['urole'] == 'พัสดุ') {
            
            header("location: ./parcel/index");
        }
    } else {
        //Login SSO KKU
        header("location: ./staff/index");
        $_SESSION['id'] = $id_person;
        $_SESSION['name_title'] = 'นาย';  //SSO
        $_SESSION['first_name'] = 'ทดสอบ'; //SSO
        $_SESSION['last_name'] = 'บุคลากร'; //SSO
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Help Desk</title>
    <!-- Custom fonts for this template-->
    <link href="./css/all.min.css" rel="stylesheet" type="text/css">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="./css/fonts.css">
    <link rel="stylesheet" href="./css/bg.css">
    <!-- animation -->
    <link rel="stylesheet" href="./css/animation.css">
    <!-- Custom styles for this template-->
    <link href="./css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="./image/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300&display=swap" rel="stylesheet">

</head>

<body class="bg">
    <div id="overlay"></div>
    <div class="w3-container w3-center w3-animate-top" style="animation-duration: 500ms;">
        <div class="container">
            <!-- Outer Row -->
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <center>
                                                <img class=" d-none d-lg-block" src="./image/logo.png" width="150px"
                                                    height="150px"><br>
                                            </center>
                                            <h1 class="h4 text-gray-900 mb-4 t1"><strong>ระบบแจ้งซ่อม <?=$_POST['id-person'];?></strong></h1>
                                            <h1 class="h4 text-gray-900 mb-4 t1"><strong>คณะพยาบาลศาสตร์
                                                    มหาวิทยาลัยขอนแก่น</strong></h1>
                                        </div>
                                        <form class="user" action="index.php" method="post">

                                            <div class="form-group row">
                                                <div class="col-sm-8 mb-3 mb-sm-0 mx-auto">
                                                <input type="text" class="form-control t1" name="id-person" placeholder="เลขบัตรประจำตัวประชาชน" minlength="13" maxlength="13" pattern="\d{13}">
                                                </div>
                                            </div>
                                            <center>
                                                <p>---- สิทธิ์เข้าระบบ ----</p>
                                                <p>ช่าง : 2222222222222</p>
                                                <p>พัสดุ : 3333333333333</p>
                                                <p>หัวหน้าพัสดุ : 4444444444444</p>
                                                <p>หัวหน้ากองคลัง : 5555555555555</p>
                                                <p>ผู้อำนวยการกองบริหารงาน : 6666666666666</p>
                                                <p>คณบดี : 7777777777777</p>
                                                <button type="submit" name="signup" value="signup" 
                                                    class="btn btn-success wider-btn1 t1">เข้าสู่ระบบ</button>
                                                    
                                            </center>
                                        </form>                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
</body>

</html>