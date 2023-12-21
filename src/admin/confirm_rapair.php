<?php 
session_start();
require_once '../dbconfig.php';

$id_repair = $_GET['id'];
$sql = "SELECT * FROM repair_report_pd05 WHERE id_repair = $id_repair";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$typeRepair = $row['type_repair'];
$departmentName = $row['department_name'];
$assetName = $row['asset_name'];
$assetId = $row['asset_id'];
$assetDetail = $row['asset_detail'];
$location = $row['location'];
$neet = $row['neet'];
$reportSignature = $row['report_signature'];
$reportName = $row['report_name'];
$status = $row['status'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Help Desk | Tech</title>
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
        document.querySelector('a[name="check-repair"]').classList.add('nav-link', 'active');
    });
</script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ฟอร์มตรวจสอบการแจ้งซ่อม</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index">Home</a></li>
              <li class="breadcrumb-item active">ฟอร์มตรวจสอบการแจ้งซ่อม</li>
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
                    <input type="text" name="type-rapair" class="form-control" id="type-repair" value="<?php echo $typeRepair?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="department-name">ชื่อหน่วยงาน</label>
                    <input type="text" name="department-name" class="form-control" id="department-name" value="<?php echo $departmentName?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="asset-name">ทรัพย์สินที่ต้องการซ่อม</label>
                    <input type="text" name="asset-name" class="form-control" id="asset-name" value="<?php echo $assetName?>" readonly>
                  </div>
                  <div class="form-group">
                  <label for="asset-id">หมายเลขครุภัณฑ์</label>
                  <input type="text" name="asset-id" class="form-control" id="asset-id" value="<?php echo $assetId?>">
                  </div>
                  <div class="form-group">
                    <label for="asset-detail">สภาพการชำรุด</label>
                    <input type="text" name="asset-detail" class="form-control" id="asset-detail" value="<?php echo $assetDetail?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="location">ที่ตั้ง</label>
                    <input type="text" name="location" class="form-control" id="location" value="<?php echo $location?>" readonly>
                  </div>
                  <div class="form-group">
                      <img src="../image_signature/<?php echo $reportSignature; ?>" alt="signature_report" width="180px">
                  </div>
                  <div class="form-group">
                    <label for="neet">ชื่อผู้แจ้งซ่อม</label>
                    <input type="text" name="neet" class="form-control" id="neet" value="<?php echo $reportName?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="reasons">เหตุผลความจำเป็นในการจ้างซ่อมทรัพย์สิน</label>
                    <input type="text" name="reasons" class="form-control" id="reasons"  required>
                  </div>
                  <div class="form-group">
                    <label for="amount">วงเงินที่จะซ่อม</label>
                    <input type="number" name="amount" class="form-control" id="amount"  required>
                    <small class="text-danger" id="amount-error" style="display: none;">กรุณากรอกค่าที่ไม่ติดลบ</small>
                  </div>
                  <div class="form-group">
                    <label for="amount_last">ราคาที่ซ่อมครั้งสุดท้าย</label>
                    <input type="number" name="amount_last" class="form-control" id="amount_last"  required>
                    <small class="text-danger" id="amount-last-error" style="display: none;">กรุณากรอกค่าที่ไม่ติดลบ</small>
                  </div>
                  <div class="form-group">
                    <label for="recomment">งานช่างได้ตรวจสอบการชำรุดแล้วปรากกฏว่า</label>
                    <input type="text" name="recomment" class="form-control" id="recomment"  required>
                  </div>
              </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex justify-content-end">
                  <button type="submit" class="btn btn-danger">ยกเลิกการซ่อม</button>&nbsp&nbsp
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
<script>
document.getElementById('amount').addEventListener('input', function () {
    var amountInput = this.value;
    var amountError = document.getElementById('amount-error');

    if (amountInput < 0) {
        amountError.style.display = 'block';
        this.setCustomValidity('กรุณากรอกค่าที่ไม่ติดลบ');
    } else {
        amountError.style.display = 'none';
        this.setCustomValidity('');
    }
});
document.getElementById('amount_last').addEventListener('input', function () {
    var amountInput = this.value;
    var amountError = document.getElementById('amount-last-error');

    if (amountInput < 0) {
        amountError.style.display = 'block';
        this.setCustomValidity('กรุณากรอกค่าที่ไม่ติดลบ');
    } else {
        amountError.style.display = 'none';
        this.setCustomValidity('');
    }
});
</script>