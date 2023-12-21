<?php 
session_start();
require_once '../dbconfig.php';

$id_asset = $_GET['id'];



///////////  แสดงชื่อหน่วยงาน
function name_department($id) {
  global $conn; // Assuming $conn is your database connection variable

  $sql_department = "SELECT name FROM department WHERE id_department = '$id' LIMIT 1";
  $result_department = mysqli_query($conn, $sql_department);

  if ($row_department = mysqli_fetch_assoc($result_department)) {
      $department_durable = $row_department['name'];
      return $department_durable;
  } else {
      $department_durable = '';
      return $department_durable;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Help Desk | Parcel</title>
  <link rel="shortcut icon" href="../image/favicon.ico" type="image/x-icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
        document.querySelector('a[name="form_rapair"]').classList.add('nav-link', 'active');
    });
</script> 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>แบบฟอร์มแจ้งซ่อม</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">แบบฟอร์มแจ้งซ่อม</li>
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
                <h3 class="card-title">แจ้งซ่อม</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" action="tech" method="post" >
                <div class="card-body">
                
                  
                  <div class="form-group">
                    <label for="type-rapair">ประเภท</label>
                    <select name="type-repair" class="form-control" id="type-repair" required>
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
                    <label for="department-id">ชื่อหน่วยงาน</label>
                    <select name="department-id" class="form-control" id="department-id" required>
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
                    <label for="asset-name">ทรัพย์สินที่ต้องการซ่อม</label>
                    <input type="text" name="asset-name" class="form-control" id="asset-name"  >
                  </div>
                  <div class="form-group">
                  <label for="asset-id">หมายเลขครุภัณฑ์</label>
                  <input type="text" name="asset-id" class="form-control" id="asset-id" value="<?php echo $id_asset?>" >
                  </div>
                  
                  <div class="form-group">
                    <label for="building">อาคาร</label>
                    <input type="text" name="building" class="form-control" id="building" >
                  </div>
                  <div class="form-group">
                    <label for="room-number">ห้อง</label>
                    <input type="text" name="room-number" class="form-control" id="room-number" >
                  </div>
                  <div class="form-group">
                    <label for="type">ประเภทการแจ้ง</label>
                    <select name="type" class="form-control" id="type" required>
                        <option value="" disabled selected>--- เลือกประเภท ---</option>
                        <option value="ซ่อม">ซ่อม</option>
                        <option value="service">service</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="asset-detail">สภาพการชำรุด/รายละเอียดการขอ service</label>
                    <input type="text" name="asset-detail" class="form-control" id="asset-detail" required>
                  </div>
                  <div class="form-group">
                    <label for="reasons">เหตุผลความจำเป็นในการจ้างซ่อมทรัพย์สิน</label>
                    <input type="text" name="reasons" class="form-control" id="reasons"
                        required>
                  </div>
                  
                  <div class="form-group">
                    <label for="neet">ความต้องการ</label>
                    <select name="neet" class="form-control" id="neet" required>
                        <option value="" >---- เลือกตามความต้องการของคุณ ----</option>
                        <option value="ด่วนที่สุด">ด่วนที่สุด</option>
                        <option value="ด่วนมาก">ด่วนมาก</option>
                        <option value="ด่วน">ด่วน</option>
                        <option value="รอได้">รอได้</option>
                    </select>
                  </div>
              </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex justify-content-end">
                  <button type="submit" class="btn btn-primary">ถัดไป</button>
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
<!-- ทำให้ (ถ้ามีให้ระบุ) เป็นสีแดง -->
<style>
    .form-group label[for="asset-id"]::after {
        content: ' (ถ้ามีให้ระบุ)';
        color: red;
        font-weight: bold;
    }
</style>
