<?php 
session_start();
require_once '../dbconfig.php';

$id_asset = urldecode($_GET['id']);
$sql = "SELECT *FROM durable_articles WHERE asset_id = '$id_asset'";
$result = mysqli_query($conn, $sql); 
$row = mysqli_fetch_assoc($result);

$type_durable = $row['type_durable'];
$department_durable = $row['department'];
$asset_id = $row['asset_id'];
$name_asset = $row['name'];
$building = $row['building'];
$room_number = $row['room_number'];
$image = $row['image_asset'];
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
            document.querySelector('a[name="parcel"]').classList.add('nav-link', 'active');
        });
        </script>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>ตรวจสอบ - ครุภัณฑ์</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">ตรวจสอบ - ครุภัณฑ์</li>
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
                                    <h3 class="card-title">ตรวจสอบข้อมูลครุภัณฑ์</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" action="./controller/save_check" method="post">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- ส่วนซ้าย -->
                                            <div class="col-md-6">
                                            <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="type-durable"
                                                            class="col-sm-4 col-form-label">หมวดหมู่ครุภัณฑ์</label>
                                                        <div class="col-sm-8">
                                                          <p ><?php echo htmlspecialchars($type_durable); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="department-durable"
                                                            class="col-sm-4 col-form-label">แผนกผู้รับผิดชอบ</label>
                                                        <div class="col-sm-8">
                                                        <p ><?php echo htmlspecialchars($department_durable); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="asset-id"
                                                            class="col-sm-4 col-form-label">เลขที่ครุภัณฑ์</label>
                                                        <div class="col-sm-8">
                                                        <p ><?php echo htmlspecialchars($asset_id); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="name-asset"
                                                            class="col-sm-4 col-form-label">ชื่อครุภัณฑ์</label>
                                                        <div class="col-sm-8">
                                                        <p ><?php echo htmlspecialchars($name_asset); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="building"
                                                            class="col-sm-4 col-form-label">อาคาร</label>
                                                        <div class="col-sm-8">
                                                        <p ><?php echo htmlspecialchars($building); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="room-number"
                                                            class="col-sm-4 col-form-label">ห้อง</label></label>
                                                        <div class="col-sm-8">
                                                        <p ><?php echo htmlspecialchars($room_number); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="status"
                                                            class="col-sm-4 col-form-label">สถานะ</label></label>
                                                        <div class="col-sm-8">
                                                            <select id="status" name="status" class="form-control" required>
                                                                <option value="พร้อมใช้งาน">พร้อมใช้งาน</option>
                                                                <option value="ชำรุด">ชำรุด</option>
                                                                <option value="สูญหาย">สูญหาย</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="name-check"
                                                            class="col-sm-4 col-form-label">ตรวจสอบโดย</label></label>
                                                        <div class="col-sm-8">
                                                        <input type="text" name="name-check" class="form-control" id="name-check" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="detail-check"
                                                            class="col-sm-4 col-form-label">รายละเอียดการตรวจสอบ</label></label>
                                                        <div class="col-sm-8">
                                                        <input type="text" name="detail-check" class="form-control" id="detail-check" required>
                                                        <input type="text" name="id-asset" class="form-control" id="id-asset" value="<?php echo $id_asset?>" hidden >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ส่วนขวา -->
                                            <div class="col-md-6">
                                            <div class="form-group">
                                              
                                                <img src="../image_asset/<?php echo $image; ?>" alt="signature_tech" width="400px">
                                                    <!-- เพิ่ม input fields อื่น ๆ ที่ต้องการแสดงทางขวา -->
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="card-footer">
                                                    <center aria-label="Contacts Page Navigation"  >
                                                      <button type="button" class="btn btn-danger" onclick="cancelAction()">ยกเลิก</button>&nbsp&nbsp
                                                      <button type="submit" class="btn btn-primary">บันทึก</button>
                                                    </center>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                        <!-- right column -->
                        <div class="col-md-6">

                        </div>
                        <!--/.col (right) -->
                    </div>
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