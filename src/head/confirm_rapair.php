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
$recomment = $row['recomment'];
$reasons = $row['reasons'];
$techSignature = $row['signature_tech'];
$tech_id = $row['tech_id'];
$amount = $row['amount'];
$last_amount = $row['last_amount'];
$inspector_name_1 = $row['inspector_name1'];
$inspector_name_2 = $row['inspector_name2'];
$inspector_name_3 = $row['inspector_name3'];
$tech_repair_type = $row['repair_type'];



///////////  แสดงชื่อด้วยบัตร ปชช id_person 
function name_person($id) {
    global $conn; // Assuming $conn is your database connection variable
  
    $sql_person = "SELECT name_title,first_name,last_name FROM account WHERE id_person = '$id' LIMIT 1";
    $result_person = mysqli_query($conn, $sql_person);
  
    if ($row_person = mysqli_fetch_assoc($result_person)) {
      $person_name = $row_person['name_title'] . $row_person['first_name'].' ' . $row_person['last_name'];
        return $person_name;
    } else {
      $person_name = '';
        return$person_name;
    }
  }
  
  
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
    <title>Help Desk | Head</title>
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
                                <form id="quickForm" action="head_department_klung" method="post">
                                    <div class="card-body">
                                        <div class="form-group">

                                            <label for="type-rapair">ประเภท : </label>
                                            <input type="text" name="type" class="form-control" id="type"
                                                value="<?php echo $type?>" readonly>
                                        </div>
                                        <div class="form-group">

                                            <label for="type-rapair">หมวดหมู่ครุภัณฑ์</label>
                                            <input type="text" name="id-repair" class="form-control" id="id-repair"
                                                value="<?php echo $id_repair?>" hidden>
                                            <input type="text" name="type-repair" class="form-control" id="type-repair"
                                                value="<?php echo $typeRepair?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="department-id">ชื่อหน่วยงาน</label>
                                            <input type="text" name="show_department" class="form-control" value="<?php echo name_department($departmentName)?>" readonly>
                                            <input type="text" name="department-id" id="department-id" value="<?php echo $departmentName?>" hidden>
                                        </div>
                                        <div class="form-group">
                                            <label for="asset-name">ทรัพย์สินที่ต้องการซ่อม</label>
                                            <input type="text" name="asset-name" class="form-control" id="asset-name"
                                                value="<?php echo $assetName?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="asset-id">หมายเลขครุภัณฑ์</label>
                                            <input type="text" name="asset-id" class="form-control" id="asset-id"
                                                value="<?php echo $assetId?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="asset-detail">สภาพการชำรุด</label>
                                            <input type="text" name="asset-detail" class="form-control"
                                                id="asset-detail" value="<?php echo $assetDetail?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="building">อาคาร</label>
                                            <input type="text" name="building" class="form-control" id="building"
                                                value="<?php echo $building?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="room-number">ห้อง</label>
                                            <input type="text" name="room-number" class="form-control" id="room-number"
                                                value="<?php echo $room_number?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <img src="../image_signature/<?php echo $reportSignature; ?>"
                                                alt="signature_report" width="180px">
                                        </div>
                                        <div class="form-group">
                                            <label for="neet">ชื่อผู้แจ้งซ่อม</label>
                                            <input type="text" name="report_name" class="form-control" id="report_name"
                                                value="<?php echo $reportName?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="reasons">เหตุผลความจำเป็นในการจ้างซ่อมทรัพย์สิน</label>
                                            <input type="text" name="reasons" class="form-control" id="reasons"
                                            value="<?php echo $reasons?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="recomment">งานช่างได้ตรวจสอบการชำรุดแล้วปรากกฏว่า</label>
                                            <textarea name="recomment" class="form-control" id="recomment" readonly><?php echo $recomment ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="repair-type">ประเภทการซ่อม</label>
                                            <input type="text" name="repair-type" class="form-control" id="repair-type"
                                            value="<?php echo $tech_repair_type?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <img src="../image_signature/<?php echo $techSignature; ?>"
                                                alt="tech_report" width="180px">
                                        </div>
                                        <div class="form-group">
                                            <label for="tech-name">ช่างที่ตรวจสอบ</label>
                                            <input type="text" name="show_name_tech" class="form-control" value="<?php echo name_person($tech_id)?>" readonly>
                                            <input type="text" name="tech-name"  id="tech-name"value="<?php echo $tech_id?>" hidden>
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">วงเงินที่จะซ่อม</label>
                                            <input type="number" name="amount" class="form-control" id="amount"
                                            value="<?php echo $amount?>"readonly>
                                            <small class="text-danger" id="amount-error"
                                                style="display: none;">กรุณากรอกค่าที่ไม่ติดลบ</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="amount_last">ราคาที่ซ่อมครั้งสุดท้าย</label>
                                            <input type="number" name="amount_last" class="form-control"
                                                id="amount_last" value="<?php echo $last_amount?>"readonly>
                                            <small class="text-danger" id="amount-last-error"
                                                style="display: none;">กรุณากรอกค่าที่ไม่ติดลบ</small>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="inspector">ขอเสนอรายชื่อเพื่อแต่งตั้งเป็นคณะกรรมการตรวจรับพัสดุ</label>
                                            <input type="text" name="inspector_name1" class="form-control"
                                                id="inspector_name1" value="<?php echo $inspector_name_1?>"readonly><br>
                                            <input type="text" name="inspector_name2" class="form-control"
                                                id="inspector_name2"value="<?php echo $inspector_name_2?>"readonly><br>
                                            <input type="text" name="inspector_name3" class="form-control"
                                                id="inspector_name3" value="<?php echo $inspector_name_3?>"readonly>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer d-flex justify-content-end">
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#cancelModal">ยกเลิกการซ่อม</button>&nbsp&nbsp
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

.form-group label[for="inspector"]::after {
    content: ' (ถ้ามีให้ระบุ)';
    color: red;
    font-weight: bold;
}
</style>
<!-- ส่วนของ Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel"
    aria-hidden="true">
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
document.getElementById('amount').addEventListener('input', function() {
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
document.getElementById('amount_last').addEventListener('input', function() {
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