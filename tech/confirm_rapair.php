<?php 
session_start();
require_once '../dbconfig.php';

$id_repair = $_GET['id'];
$sql = "SELECT * FROM repair_report_pd05 WHERE id_repair = $id_repair";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$type = $row['type'];
$typeRepair = $row['type_repair'];
$departmentName = $row['department_id'];
$assetName = $row['asset_name'];
$assetId = $row['asset_id'];
$assetDetail = $row['asset_detail'];
$building = $row['building'];
$room_number = $row['room_number'];
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
              <form id="quickForm" action="./confirm_repair_save" method="post" >
                <div class="card-body">
                  <div class="form-group">

                    <label for="type-rapair">ประเภท : </label>
                    <input type="text" name="type" class="form-control" id="type" value="<?php echo $type?>" readonly>
                  </div>
                  <div class="form-group">

                    <label for="type-rapair">หมวดหมู่ครุภัณฑ์</label>
                    <input type="text" name="id-repair" class="form-control" id="id-repair" value="<?php echo $id_repair?>" hidden >
                    <input type="text" name="type-repair" class="form-control" id="type-repair" value="<?php echo $typeRepair?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="department-id">ชื่อหน่วยงาน</label>
                    <input type="text" name="department-id" class="form-control" id="department-id" value="<?php echo $departmentName?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="asset-name">ทรัพย์สินที่ต้องการซ่อม</label>
                    <input type="text" name="asset-name" class="form-control" id="asset-name" value="<?php echo $assetName?>" readonly>
                  </div>
                  <div class="form-group">
                  <label for="asset-id">หมายเลขครุภัณฑ์</label>
                  <input type="text" name="asset-id" class="form-control" id="asset-id" value="<?php echo $assetId?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="asset-detail">สภาพการชำรุด</label>
                    <input type="text" name="asset-detail" class="form-control" id="asset-detail" value="<?php echo $assetDetail?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="building">อาคาร</label>
                    <input type="text" name="building" class="form-control" id="building" value="<?php echo $building?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="room-number">ห้อง</label>
                    <input type="text" name="room-number" class="form-control" id="room-number" value="<?php echo $room_number?>" readonly>
                  </div>
                  <div class="form-group">
                      <img src="../image_signature/<?php echo $reportSignature; ?>" alt="signature_report" width="180px">
                  </div>
                  <div class="form-group">
                    <label for="neet">ชื่อผู้แจ้งซ่อม</label>
                    <input type="text" name="report_name" class="form-control" id="report_name" value="<?php echo $reportName?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="reasons">เหตุผลความจำเป็นในการจ้างซ่อมทรัพย์สิน</label>
                    <input type="text" name="reasons" class="form-control" id="reasons"  required>
                  </div>
                  <div class="form-group">
                    <label for="recomment">งานช่างได้ตรวจสอบการชำรุดแล้วปรากกฏว่า</label>
                    <textarea type="text" name="recomment" class="form-control" id="recomment"  required></textarea>
                  </div>
                  <div class="form-group">
                    <label for="repairType">ประเภทการซ่อม</label>
                    <select name="repair-typetech" class="form-control" id="repair-typetech" required>
                        <option value="" disabled selected>--- เลือกประเภทการซ่อม ---</option>
                        <option value="ส่งซ่อมภายนอก">ส่งซ่อมภายนอก</option>
                        <option value="ซ่อมด้วยตนเอง">ซ่อมด้วยตนเอง</option>
                    </select>
                  </div>
              </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex justify-content-end">
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelModal">ยกเลิกการซ่อม</button>&nbsp&nbsp
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


</body>
</html>
<!-- ทำให้ (ถ้ามีให้ระบุ) เป็นสีแดง -->
<style>
    .form-group label[for="asset-id"]::after {
        content: ' (ถ้ามีให้ระบุ)';
        color: red;
        font-weight: bold;
    }
    .form-group label[for="inspector"]::after {
        content: ' (ถ้ามีให้ระบุ)';
        color: red;
        font-weight: bold;
    }
</style>
<!-- ส่วนของ Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cancelModalLabel">ยกเลิกการซ่อม</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>กรุณากรอกเหตุผลที่ต้องการยกเลิกการซ่อม:</p>
        <textarea id="cancelReason" class="form-control" rows="4" required></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-danger" onclick="cancelRepair()">ยกเลิกการซ่อม</button>
      </div>
    </div>
  </div>
</div>
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

function cancelRepair() {
  var cancelReason = encodeURIComponent(document.getElementById('cancelReason').value);
  var idRepair = document.getElementById('id-repair').value;

  // ส่งค่า id-repair และ cancelReason ไปยังหน้าที่ต้องการ
  window.location.href = "./controller/update_cancel.php?id_repair=" + idRepair + "&cancelReason=" + cancelReason;
}

</script>