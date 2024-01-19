<?php 
session_start();
require_once '../dbconfig.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Help Desk | Admin</title>
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
            document.querySelector('a[name="account"]').classList.add('nav-link', 'active');
        });
        </script>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>เพิ่มบัญชีผู้ใช้</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">เพิ่มบัญชีผู้ใช้</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <form action="./controller/add_account" method="POST"  enctype="multipart/form-data">
                                <div class="text-center">
                                    <center>
                                          <img class="profile-user-img img-fluid img-circle" id="preview-image"
                                            src="../image_profile/no-image.png" alt="User profile picture"></br></br>
                                        <input type="file" class="form-control" id="profile-picture" name="profile-picture" style="width:50%;">
                                    </center>
                                </div>
                                <div class="form-group">
                                    <label for="id-person">เลขบัตรประชาชน</label>
                                    <input type="text" name="id-person" class="form-control" id="id-person" minlength="13" maxlength="13" pattern="\d{13}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name-title">คำนำหน้า</label>
                                    <input type="text" name="name-title" class="form-control" id="name-title">
                                </div>
                                <div class="form-group">
                                    <label for="first-name">ชื่อ</label>
                                    <input type="text" name="first-name" class="form-control" id="first-name">
                                </div>
                                <div class="form-group">
                                    <label for="last-name">นามสกุล</label>
                                    <input type="text" name="last-name" class="form-control" id="last-name">
                                </div>
                                <div class="form-group">
                                    <label for="position">ตำแหน่ง</label>
                                    <input type="text" name="position" class="form-control" id="position">
                                </div>
                                <div class="form-group">
                                    <label for="department-id">หน่วยงาน</label>
                                    <select name="department-id" class="form-control" id="department-id" >
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
                                    <label for="urole">สิทธิ์ในระบบ</label>
                                    <select name="urole" class="form-control" id="urole" required>
                                        <option value="" disabled selected>--- เลือกสิทธิ์ ---</option>
                                        <?php
                                            // ทำการดึงข้อมูลจากฐานข้อมูล
                                            $sql = "SELECT * FROM urole"; // แทน your_table_name ด้วยชื่อตารางของคุณ
                                            $result = mysqli_query($conn, $sql);

                                            // ตรวจสอบว่ามีข้อมูลหรือไม่
                                            if ($result) {
                                                // วนลูปเพื่อแสดงข้อมูลใน dropdown
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>
             
                                <button type="submit" class="form-control btn btn-primary">save</button>
                          
                                
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
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
<script>   // สร้าง event listener เมื่อมีการเลือกไฟล์รูปภาพ
    document.getElementById('profile-picture').addEventListener('change', function (e) {
        const file = e.target.files[0];

        if (file) {
            const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

            if (!allowedExtensions.exec(file.name)) {
                // แสดง Popup แจ้งเตือนถ้านามสกุลไม่ถูกต้อง
                alert('กรุณาเลือกไฟล์รูปภาพที่มีนามสกุล .jpg, .jpeg หรือ .png เท่านั้น');
                // ล้างค่า input file
                document.getElementById('profile-picture').value = '';
                return false;
            }

            const imageUrl = URL.createObjectURL(file);
            document.getElementById('preview-image').src = imageUrl;
        }
    });
</script>
<style>
    img.profile-user-img {
        width: 128px;
        height: 128px;
        object-fit: cover;   
    }
</style>