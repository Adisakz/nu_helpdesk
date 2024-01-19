<?php 
session_start();
require_once '../dbconfig.php';
error_reporting(E_ERROR | E_PARSE);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากฟอร์ม
    $id_durable = $_POST['id-durable'];
    $type = $_POST['type'];
    $typeRepair = $_POST['type-repair'];
    $departmentId = $_POST['department-id'];
    $assetName = $_POST['asset-name'];
    $assetId = $_POST['asset-id'];
    $assetDetail = $_POST['asset-detail'];
    $building = $_POST['building'];
    $room_number = $_POST['room-number'];
    $neet = $_POST['neet'];
    $reasons = $_POST['reasons'];
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
  <script>
    // ในกรณีที่ต้องการรอให้หน้าเว็บโหลดเสร็จก่อน
    document.addEventListener('DOMContentLoaded', function() {
        // เลือก element และเปลี่ยน class
        document.querySelector('a[name="search_asset"]').classList.add('nav-link', 'active');
    });
</script> 
  <script>
    
function selectUser(userId, titleName, firstName, lastName) {
    var form = document.createElement('form');
    form.action = 'save_repair';
    form.method = 'post';

    var idDurableInput = document.createElement('input');
    idDurableInput.type = 'hidden';
    idDurableInput.name = 'id-durable';
    idDurableInput.value = '<?php echo $id_durable; ?>'; // Add the actual value
    form.appendChild(idDurableInput);
    
    var typeInput = document.createElement('input');
    typeInput.type = 'hidden';
    typeInput.name = 'type';
    typeInput.value = '<?php echo $type; ?>'; // Add the actual value
    form.appendChild(typeInput);

    var typeRepairInput = document.createElement('input');
    typeRepairInput.type = 'hidden';
    typeRepairInput.name = 'type-repair';
    typeRepairInput.value = '<?php echo $typeRepair; ?>'; // Add the actual value
    form.appendChild(typeRepairInput);

    var departmentIdInput = document.createElement('input');
    departmentIdInput.type = 'hidden';
    departmentIdInput.name = 'department-id';
    departmentIdInput.value = '<?php echo $departmentId; ?>'; // Add the actual value
    form.appendChild(departmentIdInput);

    var assetNameInput = document.createElement('input');
    assetNameInput.type = 'hidden';
    assetNameInput.name = 'asset-name';
    assetNameInput.value = '<?php echo $assetName; ?>'; // Add the actual value
    form.appendChild(assetNameInput);

    var assetIdInput = document.createElement('input');
    assetIdInput.type = 'hidden';
    assetIdInput.name = 'asset-id';
    assetIdInput.value = '<?php echo $assetId; ?>'; // Add the actual value
    form.appendChild(assetIdInput);

    var assetDetailInput = document.createElement('input');
    assetDetailInput.type = 'hidden';
    assetDetailInput.name = 'asset-detail';
    assetDetailInput.value = '<?php echo $assetDetail; ?>'; // Add the actual value
    form.appendChild(assetDetailInput);

    var buildingInput = document.createElement('input');
    buildingInput.type = 'hidden';
    buildingInput.name = 'building';
    buildingInput.value = '<?php echo $building; ?>';
    form.appendChild(buildingInput);

    var roomnumberInput = document.createElement('input');
    roomnumberInput.type = 'hidden';
    roomnumberInput.name = 'room-number';
    roomnumberInput.value = '<?php echo $room_number; ?>';
    form.appendChild(roomnumberInput);
    
    var neetInput = document.createElement('input');
    neetInput.type = 'hidden';
    neetInput.name = 'neet';
    neetInput.value = '<?php echo $neet; ?>'; // Add the actual value
    form.appendChild(neetInput);

    var userIDInput = document.createElement('input');
    userIDInput.type = 'hidden';
    userIDInput.name = 'id-person';
    userIDInput.value = userId; // ค่า userID ที่ถูกส่งมาจากพารามิเตอร์ของฟังก์ชัน
    form.appendChild(userIDInput);

    var titleNameInput = document.createElement('input');
    titleNameInput.type = 'hidden';
    titleNameInput.name = 'title-name';
    titleNameInput.value = titleName;
    form.appendChild(titleNameInput);

    var firstNameInput = document.createElement('input');
    firstNameInput.type = 'hidden';
    firstNameInput.name = 'first-name';
    firstNameInput.value = firstName;
    form.appendChild(firstNameInput);

    var lastNameInput = document.createElement('input');
    lastNameInput.type = 'hidden';
    lastNameInput.name = 'last-name';
    lastNameInput.value = lastName;
    form.appendChild(lastNameInput);

    var reasonsInput = document.createElement('input');
    reasonsInput.type = 'hidden';
    reasonsInput.name = 'reasons';
    reasonsInput.value = '<?php echo $reasons; ?>';
    form.appendChild(reasonsInput);

    document.body.appendChild(form);
    
    form.submit();
}
</script>


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
               $sql = "SELECT * FROM account WHERE urole = 'ช่าง' ";
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
                        echo '          <img src="../image_profile/'.$row['profile_img'].'" alt="user-avatar" class="img-circle img-fluid">';
                        echo '        </div>';
                        echo '      </div>';
                        echo '    </div>';
                        echo '    <div class="card-footer">';
                        echo '      <div class="text-right">';
                        echo '<a href="#" class="btn btn-sm btn-success" onclick="selectUser(' . $row['id_person'] . ', \'' . $row['name_title'] . '\', \'' . $row['first_name'] . '\', \'' . $row['last_name'] . '\')">';
                        echo '  <i class="fas fa-user"></i> เลือก';
                        echo '</a>';
                        echo '      </div>';
                        echo '    </div>';
                        echo '  </div>';
                        echo '</div>';
                      echo ' <style>img.img-circle {width: 128px;height: 128px;object-fit: cover;border-radius: 50%;  /* เพิ่มบรรทัดนี้เพื่อทำให้รูปภาพเป็นวงกลม */}</style>';
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
