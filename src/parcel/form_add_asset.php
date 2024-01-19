<?php 
session_start();
require_once '../dbconfig.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Help Desk | Parcel</title>
    <link rel="shortcut icon" href="../image/favicon.ico" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include './navber/navber.php' ;?>
        <!-- /.navbar -->
        <?php include './menu/menu.php' ;?>
        <script>
        // ในกรณีที่ต้องการรอให้หน้าเว็บโหลดเสร็จก่อน
        document.addEventListener('DOMContentLoaded', function() {
            // เลือก element และเปลี่ยน class
            document.querySelector('a[name="asset"]').classList.add('nav-link', 'active');
        });
        </script>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>เพิ่ม - ครุภัณฑ์</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">เพิ่ม - ครุภัณฑ์</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">เพิ่มข้อมูลครุภัณฑ์</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" action="./controller/save_add_asset" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="type-rapair">หมวดหมู่ครุภัณฑ์ *</label>
                                            <select name="type-asset" class="form-control" id="type-asset" required>
                                                <option value="" disabled selected>--- เลือกประเภท ---</option>
                                                <?php
                        // ทำการดึงข้อมูลจากฐานข้อมูล
                        $sql = "SELECT * FROM type_repair"; // แทน your_table_name ด้วยชื่อตารางของคุณ
                        $result = mysqli_query($conn, $sql);

                        // ตรวจสอบว่ามีข้อมูลหรือไม่
                        if ($result) {
                            // วนลูปเพื่อแสดงข้อมูลใน dropdown
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' .$row['name'] . '">' . $row['name'] . '</option>';
                            }

                            // ปิดการเชื่อมต่อ
                           
                        }
                        ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="asset-id">หมายเลขครุภัณฑ์ *</label>
                                            <input type="text" name="asset-id" class="form-control" id="asset-id" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="asset-name">ชื่อครุภัณฑ์ *</label>
                                            <input type="text" name="asset-name" class="form-control" id="asset-name"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="department-id">หน่วยงานที่รับผิดชอบ *</label>
                                            <select name="department-id" class="form-control" id="department-id"
                                            required>
                                                <option value="" disabled selected>--- เลือกหน่วยงาน ---</option>
                                                <?php
                                                    // ทำการดึงข้อมูลจากฐานข้อมูล
                                                    $sql = "SELECT * FROM department"; // แทน your_table_name ด้วยชื่อตารางของคุณ
                                                    $result = mysqli_query($conn, $sql);

                                                    // ตรวจสอบว่ามีข้อมูลหรือไม่
                                                    if ($result) {
                                                        // วนลูปเพื่อแสดงข้อมูลใน dropdown
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo '<option value="' . $row['id_department'] . '">' . $row['name'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="brand">ยี่ห้อ</label>
                                            <input type="text" name="brand" class="form-control" id="brand">
                                        </div>
                                        <div class="form-group">
                                            <label for="model">รุ่น</label>
                                            <input type="text" name="model" class="form-control" id="model"
                                                >
                                        </div>

                                        <div class="form-group">
                                            <label for="building">อาคาร</label>
                                            <input type="text" name="building" class="form-control"
                                                id="building" >
                                        </div>
                                        <div class="form-group">
                                            <label for="room-number">ห้อง</label>
                                            <input type="text" name="room-number" class="form-control" id="room-number"
                                                >
                                        </div>
                                        <div class="form-group">
                                            <label for="year">ปีที่ซื้อ</label>
                                            <input type="text" name="year" class="form-control" id="year"
                                                >
                                        </div>
                                        <div class="form-group">
                                            <label for="price">ราคา(บาท)</label>
                                            <input type="text" name="price" class="form-control" id="price"
                                               required >
                                        </div>
                                        <div class="form-group">
                                            <label for="image">อัพโหลดรูปภาพครุภัณฑ์ : </label>
                                            <input type="file" class="form-control" id="image-signature-report" name="image-asset">
                                        </div>
                                        <div class="card-footer">
                                                    <center aria-label="Contacts Page Navigation"  >
                                                      <button type="button" class="btn btn-danger" onclick="cancelAction()">ยกเลิก</button>&nbsp&nbsp
                                                      <button type="submit" class="btn btn-primary">บันทึก</button>
                                                    </center>
                                        </div>
                                    </div>

                            </div>
                            <!-- /.card-body -->
                            
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
   
                   
                <!-- /.row -->
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include './footer/footer.php' ;?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jquery-validation -->
    <script src="../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- Page specific script -->

</body>

</html>
<script>
    function cancelAction() {
        window.location.href = 'parcel';
    }


</script>