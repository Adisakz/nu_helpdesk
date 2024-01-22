
  <!-- /.navbar -->
  <?php 
  session_start();
  require_once '../dbconfig.php';
 
  ?>
  <!-- /.navbar -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Help Desk</title>
  <link rel="shortcut icon" href="../image/favicon.ico" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../image/logo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

<!-- /.menu -->
  <?php include './navber/navber.php' ;?>
  <!-- /.menu -->
  <!-- /.menu -->
  <?php include './menu/menu.php' ;
   $id_person = $_SESSION['id'] ;
   $department = $_SESSION['department'] ;
 
 
 //แสดงจำนวนการแจ้งซ่อมทั้งหมด
 $sqlRepairme = "SELECT COUNT(*) AS Countme FROM repair_report_pd05 WHERE id_person_report = $id_person";
 $resultRepairme = mysqli_query($conn, $sqlRepairme);
 if (!$resultRepairme) {
   die("Query failed: " . mysqli_error($conn));
 }
 $resultDatame = mysqli_fetch_assoc($resultRepairme);
 $Countme = $resultDatame['Countme'];
 mysqli_free_result($resultRepairme);
 
 //แสดงจำนวนการแจ้งซ่อมที่ซ่อมแล้วทั้งหมด
 $sqlRepairsuccess = "SELECT COUNT(*) AS Countsuccess FROM repair_report_pd05 WHERE id_person_report = $id_person and status='3'";
 $resultRepairsuccess = mysqli_query($conn, $sqlRepairsuccess);
 if (!$resultRepairsuccess) {
   die("Query failed: " . mysqli_error($conn));
 }
 $resultDatasuccess = mysqli_fetch_assoc($resultRepairsuccess);
 $Countsuccess = $resultDatasuccess['Countsuccess'];
 mysqli_free_result($resultRepairsuccess);
 
 //แสดงจำนวนการแจ้งซ่อมที่ถูกยกเลิกทั้งหมด
 $sqlRepairfail = "SELECT COUNT(*) AS Countfail FROM repair_report_pd05 WHERE id_person_report = $id_person and status='2'";
 $resultRepairfail = mysqli_query($conn, $sqlRepairfail);
 if (!$resultRepairfail) {
   die("Query failed: " . mysqli_error($conn));
 }
 $resultDatafail = mysqli_fetch_assoc($resultRepairfail);
 $Countfail = $resultDatafail['Countfail'];
 mysqli_free_result($resultRepairfail);
 
 //แสดงจำนวนการแจ้งซ่อมที่รอนุมัติทั้งหมด
 $sqlRepairwait = "SELECT COUNT(*) AS Countwait FROM repair_report_pd05 WHERE id_person_report = $id_person AND status IN ('4', '5','0')";
 $resultRepairwait = mysqli_query($conn, $sqlRepairwait);
 if (!$resultRepairwait) {
   die("Query failed: " . mysqli_error($conn));
 }
 $resultDatawait = mysqli_fetch_assoc($resultRepairwait);
 $Countwait = $resultDatawait['Countwait'];
 mysqli_free_result($resultRepairwait);
 
 
 //แสดงจำนวนการเบิกพัสดุ
 $sqlNeetParcel = "SELECT COUNT(*) AS NeetParcel FROM report_req_parcel where dapartment_id =$department ";
 $resultNeetParcel = mysqli_query($conn, $sqlNeetParcel);
 if (!$resultNeetParcel) {
     die("Query failed: " . mysqli_error($conn));
 }
 $rowNeetParcel = mysqli_fetch_assoc($resultNeetParcel);
 $NeetParcel = $rowNeetParcel['NeetParcel'];
 mysqli_free_result($resultNeetParcel);
 
 
 //แสดงจำนวนการเบิกพัสดุอนุมัติ
 $sqlsuccessParcel = "SELECT COUNT(*) AS successParcel FROM report_req_parcel where dapartment_id =$department and status='3' ";
 $resultsuccessParcel = mysqli_query($conn, $sqlsuccessParcel);
 if (!$resultsuccessParcel) {
     die("Query failed: " . mysqli_error($conn));
 }
 $rowsuccessParcel = mysqli_fetch_assoc($resultsuccessParcel);
 $successParcel = $rowsuccessParcel['successParcel'];
 mysqli_free_result($resultsuccessParcel);
 
 //แสดงจำนวนการเบิกพัสดุรออนุมัติ
 $sqlwaitParcel = "SELECT COUNT(*) AS waitParcel FROM report_req_parcel where dapartment_id =$department and status='2' ";
 $resultwaitParcel = mysqli_query($conn, $sqlwaitParcel);
 if (!$resultwaitParcel) {
     die("Query failed: " . mysqli_error($conn));
 }
 $rowwaitParcel = mysqli_fetch_assoc($resultwaitParcel);
 $waitParcel = $rowwaitParcel['waitParcel'];
 mysqli_free_result($resultwaitParcel);
 
 //แสดงจำนวนการเบิกพัสดุที่ถูกยกเลิก
 $sqlcancelParcel = "SELECT COUNT(*) AS cancelParcel FROM report_req_parcel where dapartment_id =$department and status='5' ";
 $resultcancelParcel = mysqli_query($conn, $sqlcancelParcel);
 if (!$resultcancelParcel) {
     die("Query failed: " . mysqli_error($conn));
 }
 $rowcancelParcel = mysqli_fetch_assoc($resultcancelParcel);
 $cancelParcel = $rowcancelParcel['cancelParcel'];
 mysqli_free_result($resultcancelParcel);
 
  ?>
  <!-- /.menu -->
  
  <script>
    // ในกรณีที่ต้องการรอให้หน้าเว็บโหลดเสร็จก่อน
    document.addEventListener('DOMContentLoaded', function() {
        // เลือก element และเปลี่ยน class
        document.querySelector('a[name="dashboard"]').classList.add('nav-link', 'active');
    });
</script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $Countme ;?></h3>

                <p>จำนวนการแจ้งซ่อม</p>
              </div>
              <div class="icon">
                <i class="ion"><i class="fa fa-file"></i></i>
              </div>
              <a href="./repair_me" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $Countsuccess ;?></h3>

                <p>จำนวนที่ซ่อมเสร็จ</p>
              </div>
              <div class="icon">
                <i class="ion ion-checkmark"></i>
              </div>
              <a href="./repair_me" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <h3><?php echo $Countwait  ;?></h3>

                <p>จำนวนการซ่อมที่รออนุมัติ</p>
              </div>
              <div class="icon">
                <i class="ion "><i class="fa fa-clock"></i></i>
              </div>
              <a href="./repair_me" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <h3><?php echo $Countfail  ;?></h3>

              <p>จำนวนการซ่อมที่ถูกยกเลิก</p>
              </div>
              <div class="icon">
                <i class="ion "><i class="fa fa-ban"></i></i>
              </div>
              <a href="./repair_me" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $NeetParcel ;?></h3>

                <p>จำนวนการเบิกพัสดุ</p>
              </div>
              <div class="icon">
                <i class="ion"><i class="fa fa-file"></i></i>
              </div>
              <a href="./req_parcel_list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $successParcel ;?></h3>

                <p>จำนวนเบิกพัสดุที่อนุมัติ</p>
              </div>
              <div class="icon">
                <i class="ion ion-checkmark"></i>
              </div>
              <a href="./req_parcel_list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <h3><?php echo $waitParcel  ;?></h3>

                <p>จำนวนการเบิกพัสดุที่รออนุมัติ</p>
              </div>
              <div class="icon">
                <i class="ion "><i class="fa fa-clock"></i></i>
              </div>
              <a href="./req_parcel_list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <h3><?php echo $cancelParcel ;?></h3>

              <p>จำนวนการเบิกพัสดุที่ถูกยกเลิก</p>
              </div>
              <div class="icon">
                <i class="ion "><i class="fa fa-ban"></i></i>
              </div>
              <a href="./req_parcel_list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   <!-- /.navbar -->
   <?php include './footer/footer.php' ;?>
  <!-- /.navbar -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes 
<script src="../dist/js/demo.js"></script>-->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard.js"></script>
</body>
</html>
