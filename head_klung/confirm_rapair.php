<?php 
session_start();
require_once '../dbconfig.php';

$id_repair = $_GET['id'];
$sql = "SELECT * FROM repair_report_pd05 WHERE id_repair = $id_repair";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$typeRepair = $row['type_repair'];
$departmentId = $row['department_id'];
$assetName = $row['asset_name'];
$assetId = $row['asset_id'];
$assetDetail = $row['asset_detail'];
$location = $row['location'];
$neet = $row['neet'];
$reportSignature = $row['report_signature'];
$reportName = $row['report_name'];
$status = $row['status'];
$reasons = $row['reasons'];
$amount = $row['amount'];
$last_amount = $row['last_amount'];
$recomment = $row['recomment'];
$inspector_name1 = $row['inspector_name1'];
$inspector_name2 = $row['inspector_name2'];
$inspector_name3 = $row['inspector_name3'];
$repair_type = $row['repair_type'];
$techSignature = $row['signature_tech'];
$techName = $row['tech_id'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Help Desk | Head</title>
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
              <form id="quickForm" action="head_department_klung" method="post" >
              <div class="card-body">
                  <div class="form-group">
                    <input type="text" name="type-repair" value="<?php echo $typeRepair?>" style="display: none; ">
                    <label for="type-repair">ประเภท : <span style="color: #28a745;"><?php echo htmlspecialchars($typeRepair); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="department-id" value="<?php echo $departmentId?>" style="display: none; ">
                    <label for="department-name">ชื่อหน่วยงาน : <span style="color: #28a745;"><?php echo htmlspecialchars($departmentId); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="asset-name" value="<?php echo $assetName?>" style="display: none; ">
                    <label for="asset-name">ทรัพย์สินที่ต้องการซ่อม : <span style="color: #28a745;"><?php echo htmlspecialchars($assetName); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="asset-id" value="<?php echo $assetId?>" style="display: none; ">
                    <label for="asset-id">หมายเลขครุภัณฑ์ : <span style="color: #28a745;"><?php echo htmlspecialchars($assetId); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="asset-detail" value="<?php echo $assetDetail ?>" style="display: none; ">
                    <label for="asset-detail">สภาพการชำรุด : <span style="color: #28a745;"><?php echo htmlspecialchars($assetDetail); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="location" value="<?php echo $location?>" style="display: none; ">
                    <label for="location">ที่ตั้ง : <span style="color: #28a745;"><?php echo htmlspecialchars($location); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="report_name" value="<?php echo $reportName?>" style="display: none; ">
                    <label for="report_name">ชื่อผู้แจ้งซ่อม : <span style="color: #28a745;"><?php echo htmlspecialchars($reportName); ?></span></label>
                  </div>
                  <div class="form-group">
                      <img src="../image_signature/<?php echo $reportSignature; ?>" alt="signature_report" width="180px">
                  </div>
                  <div class="form-group">
                  <input type="text" name="reasons" value="<?php echo $reasons?>" style="display: none; ">
                    <label for="reasons">เหตุผลความจำเป็นในการจ้างซ่อม : <span style="color: #28a745;"><?php echo htmlspecialchars($reasons); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="amount" value="<?php echo $amount?>" style="display: none; ">
                    <label for="amount">วงเงินที่จะซ่อม : <span style="color: #28a745;"><?php echo htmlspecialchars($amount); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="amount_last" value="<?php echo $last_amount?>" style="display: none; ">
                    <label for="amount_last">ราคาที่ซ่อมครั้งสุดท้าย : <span style="color: #28a745;"><?php echo htmlspecialchars($last_amount); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="recomment" value="<?php echo $recomment?>" style="display: none; ">
                    <label for="recomment">งานช่างได้ตรวจสอบการชำรุดแล้วปรากกฏว่า : <span style="color: #28a745;"><?php echo htmlspecialchars($recomment); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="inspector_name1" value="<?php echo $inspector_name1?>" style="display: none; ">
                  <input type="text" name="inspector_name2" value="<?php echo $inspector_name2?>" style="display: none; ">
                  <input type="text" name="inspector_name3" value="<?php echo $inspector_name3?>" style="display: none; ">
                    <label for="inspector">ขอเสนอรายชื่อเพื่อแต่งตั้งเป็นคณะกรรมการตรวจรับพัสดุ : </label><br>
                    <span style="font-weight: bold; color: #28a745;">1. <?php echo htmlspecialchars($inspector_name1); ?></span><br>
                    <span style="font-weight: bold; color: #28a745;">2. <?php echo htmlspecialchars($inspector_name2); ?></span><br>
                    <span style="font-weight: bold; color: #28a745;">3. <?php echo htmlspecialchars($inspector_name3); ?></span>
                  </div>
                  <div class="form-group">
                  <input type="text" name="repair-typetech" value="<?php echo $repair_type?>" style="display: none; ">
                    <label for="repair-typetech">ประเภทการซ่อม : <span style="color: #28a745;"><?php echo htmlspecialchars($repair_type); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="tech_name" value="<?php echo $techName?>" style="display: none; ">
                    <label for="tech_name">ช่างที่รับผิดชอบ : <span style="color: #28a745;"><?php echo htmlspecialchars($techName); ?></span></label>
                  </div>
                  <div class="form-group">
                      <img src="../image_signature/<?php echo $techSignature; ?>" alt="signature_tech" width="180px">
                  </div>
                  <input type="text" name="id-repair" id="id-repair" value="<?php echo $id_repair?>" style="display: none; ">

              </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex justify-content-end">
                  <button type="button" class="btn btn-danger" data-toggle="modal" onclick="cancelRepair()">ไม่อนุมัติ</button>&nbsp&nbsp
                  <button type="submit" class="btn btn-primary">อนุมัติ</button>
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


function cancelRepair() {
  var idRepair = document.getElementById('id-repair').value;

  // ส่งค่า id-repair และ cancelReason ไปยังหน้าที่ต้องการ
  window.location.href = "cancel_repair?id_repair=" + idRepair;
}

</script>