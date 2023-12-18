<?php 
session_start();
require_once '../dbconfig.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากฟอร์ม
    $idRepair = $_POST['id-repair'];
    
    $type = $_POST['type'];
    $repair_type = $_POST['type-repair'];
    $departmentid = $_POST['department-id'];
    $assetName = $_POST['asset-name'];
    $assetId = $_POST['asset-id'];
    $assetDetail = $_POST['asset-detail'];
    $building= $_POST['building'];
    $room_number= $_POST['room-number'];
    $reportName = $_POST['report_name'];
    $reasons = $_POST['reasons'];
    $recomment = $_POST['recomment'];
    $repair_type_tech = $_POST['repair-type'];
    $amount = $_POST['amount'];
    $amountLast = $_POST['amount_last'];
    $inspectorName1 = $_POST['inspector_name1'];
    $inspectorName2 = $_POST['inspector_name2'];
    $inspectorName3 = $_POST['inspector_name3'];
    $id_head = $_POST['id-head'];
    $id_head_klung = $_POST['id-head-klung'];

    /*echo "idRepair: $idRepair<br>";
    
    echo "type: $type<br>";
    echo "repair_type: $repair_type<br>";
    echo "departmentid: $departmentid<br>";
    echo "assetName: $assetName<br>";
    echo "assetId: $assetId<br>";
    echo "assetDetail: $assetDetail<br>";
    echo "location: $building<br>";
    echo "location: $room_number<br>";
    echo "reportName: $reportName<br>";
    echo "reasons: $reasons<br>";
    echo "recomment: $recomment<br>";
    echo "repair_type_tech: $repair_type_tech<br>";
    echo "amount: $amount<br>";
    echo "amountLast: $amountLast<br>";   
    echo "inspectorName1: $inspectorName1<br>";
    echo "inspectorName2: $inspectorName2<br>";
    echo "inspectorName3: $inspectorName3<br>";*/
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Help Desk | Staff</title>
  <link rel="shortcut icon" href="../image/favicon.ico" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

<!-- /.navbar -->
<?php include './navber/navber.php' ;?>
  <!-- /.navbar -->
<!-- /.menu -->
  <?php include './menu/menu.php' ;?>
  <!-- /.menu -->
 



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Contacts</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Contacts</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row">
            <?php
               $sqlCount = "SELECT COUNT(*) AS total FROM account WHERE urole = 'คณบดี'";
               $resultCount = mysqli_query($conn, $sqlCount);
               $totalRecords = mysqli_fetch_assoc($resultCount)['total'];
               
               // กำหนดจำนวนรายการต่อหน้า
               $recordsPerPage = 6;
               
               // รับค่าหน้าปัจจุบัน
               $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
           
               // คำนวณ offset สำหรับคำสั่ง SQL
               $offset = ($page - 1) * $recordsPerPage;
           
               // คำสั่ง SQL สำหรับดึงข้อมูลพร้อมกับการใช้ LIMIT
               $sql = "SELECT * FROM account WHERE urole = 'คณบดี'  LIMIT $offset, $recordsPerPage";
               $result = mysqli_query($conn, $sql);

                // ตรวจสอบว่ามีข้อมูลหรือไม่
                if ($result) {
                    // วนลูปเพื่อแสดงข้อมูล
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">';
                        echo '  <div class="card bg-light d-flex flex-fill">';
                        echo '    <div class="card-header text-muted border-bottom-0">';
                        echo '    </div>';
                        echo '    <div class="card-body pt-0">';
                        echo '      <div class="row">';
                        echo '        <div class="col-7">';
                        echo '          <h2 class="lead"><b>'. $row['name_title'] . $row['first_name'] .' ' . $row['last_name'] .'</b></h2>';
                        echo '          <p class="text-muted text-sm"><b>About: </b>' . $row['about'] . '</p>';
                        echo '        </div>';
                        echo '        <div class="col-5 text-center">';
                        echo '          <img src="../dist/img/avatar.png" alt="user-avatar" class="img-circle img-fluid">';
                        echo '        </div>';
                        echo '      </div>';
                        echo '    </div>';
                        echo '    <div class="card-footer">';
                        echo '      <div class="text-right">';
                        echo '<a href="#" class="btn btn-sm btn-success" onclick="selectUser(' . $row['id_person'] . ', \'' . $idRepair. '\', \'' . $type. '\', \'' . $repair_type. '\', \'' . $departmentid. '\', \'' . $assetName . '\',\'' . $assetId. '\', \'' . $assetDetail. '\', \'' . $building. '\', \'' . $room_number. '\', \'' . $reportName. '\', \'' . $reasons. '\', \'' . $recomment . '\', \'' . $repair_type_tech. '\', \'' . $amount. '\', \'' . $amountLast. '\', \'' . $inspectorName1. '\', \'' .$inspectorName2. '\', \'' . $inspectorName3. '\', \'' . $id_head. '\', \'' . $id_head_klung. '\')">';
                        echo '  <i class="fas fa-user"></i> เลือก';
                        echo '</a>';
                        echo '      </div>';
                        echo '    </div>';
                        echo '  </div>';
                        echo '</div>';
                    }

                    // ปิดการเชื่อมต่อ
                    mysqli_close($conn);
                } else {
                    // กรณีเกิดข้อผิดพลาดในการดึงข้อมูล
                    echo 'เกิดข้อผิดพลาดในการดึงข้อมูล: ' . mysqli_error($conn);
}
?>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <nav aria-label="Contacts Page Navigation">
              <ul class="pagination justify-content-center m-0">
                  <?php
                  // คำนวณจำนวนหน้าทั้งหมด
                  $totalPages = ceil($totalRecords / $recordsPerPage);

                  // แสดงปุ่ม Pagination
                  for ($i = 1; $i <= $totalPages; $i++) {
                      $activeClass = ($page == $i) ? 'active' : '';
                      echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                  }
                  ?>
              </ul>
          </nav>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

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
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
<script>
function selectUser(userId, idRepair, type, repairType,departmentID, assetName, assetId, assetDetail, building, roomNumber, reportName, reasons, recomment, repairTypeTech, amount, amountLast, inspectorName1, inspectorName2, inspectorName3,idHead,idHeadKlung) {
    var form = document.createElement('form');
    form.action = 'confirm_repair_save.php';  // ปรับที่นี่เป็นไฟล์ PHP ที่จะรับค่า
    form.method = 'post';

    // สร้าง input สำหรับแต่ละพารามิเตอร์
    function createInput(name, value) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        form.appendChild(input);
    }

    createInput('id_person_send', userId);
    createInput('id-repair', idRepair);
    createInput('type', type);
    createInput('repair-type', repairType);
    createInput('department-id', departmentID);
    createInput('asset-name', assetName);
    createInput('asset-id', assetId);
    createInput('asset-detail', assetDetail);
    createInput('building', building);
    createInput('room-number', roomNumber);
    createInput('report-name', reportName);
    createInput('reasons', reasons);
    createInput('recomment', recomment);
    createInput('repair-type-tech', repairTypeTech);
    createInput('amount', amount);
    createInput('amount-last', amountLast);
    createInput('inspector-name-1', inspectorName1);
    createInput('inspector-name-2', inspectorName2);
    createInput('inspector-name-3', inspectorName3);
    createInput('id-head', idHead);
    createInput('id-head-klung', idHeadKlung);

    // เพิ่ม form ลงใน body และทำการ submit
    document.body.appendChild(form);
    form.submit();
}
</script>