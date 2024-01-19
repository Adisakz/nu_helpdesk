<?php 
session_start();
require_once '../dbconfig.php';

$id_req_parcel = $_GET['id'] ;
$sql_req_parcel = "SELECT * FROM report_req_parcel WHERE id = '$id_req_parcel' LIMIT 1";
$result_req_parcel = mysqli_query($conn, $sql_req_parcel);
$row1 = mysqli_fetch_assoc($result_req_parcel);
$department_req = $row1['dapartment_id'];
$date_in = $row1['date_in'];
$signature_req = $row1['signature_req'];
$id_req = $row1['id_req'];
$signature_parcel = !empty($row1['signature_parcel']) ? $row1['signature_parcel'] : '';
$id_parcel = !empty($row1['id_parcel']) ? $row1['id_parcel'] : '';
$signature_parcel_head = !empty($row1['signature_parcel_head']) ? $row1['signature_parcel_head'] : '';
$id_parcel_head = !empty($row1['id_parcel_head']) ? $row1['id_parcel_head'] : '';
$signature_sueccess = !empty($row1['signature_success']) ? $row1['signature_success'] : '';
$name_sueccess = !empty($row1['name_sueccess']) ? $row1['name_sueccess'] : '';
$comment_cancel = !empty($row1['comment_cancel']) ? 'เหตุผลที่ยกเลิก (' . $row1['comment_cancel'] . ')' : '';
///////////  แสดงชื่อด้วยบัตร ปชช id_person 
function name_person($id) {
    global $conn; // Assuming $conn is your database connection variable
  
    $sql_person = "SELECT name_title,first_name,last_name FROM account WHERE id_person = '$id' LIMIT 1";
    $result_person = mysqli_query($conn, $sql_person);
  
    if ($row_person = mysqli_fetch_assoc($result_person)) {
      $person_name = $row_person['name_title'] . $row_person['first_name'].' ' . $row_person['last_name'];
        return $person_name;
    } else {
      $person_name = '.........................';
        return $person_name;
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

///////////  แสดงหน่วนับพัสดุ
function name_unit($id) {
    global $conn; // Assuming $conn is your database connection variable

    $sql_unit = "SELECT name FROM unit_parcel WHERE id = '$id' LIMIT 1";
    $result_unit = mysqli_query($conn, $sql_unit);

    if ($row_unit = mysqli_fetch_assoc($result_unit)) {
        $unit = $row_unit['name'];
        return $unit;
    } else {
        $unit = '';
        return $unit;
    }
}


///////////  แสดงหน่วนับพัสดุ
function unit_parcel($id) {
    global $conn; // Assuming $conn is your database connection variable

    $sql_unit = "SELECT unit_num FROM parcel_data WHERE id_parcel = '$id' LIMIT 1";
    $result_unit = mysqli_query($conn, $sql_unit);

    if ($row_unit = mysqli_fetch_assoc($result_unit)) {
        $unit = name_unit($row_unit['unit_num']);
        return $unit;
    } else {
        $unit = '';
        return $unit;
    }
}

  ///////////  แสดงชื่อพัสดุ
function name_parcel($id) {
    global $conn; // Assuming $conn is your database connection variable

    $sql_parcel = "SELECT name_parcel FROM parcel_data WHERE id_parcel = '$id' LIMIT 1";
    $result_parcel = mysqli_query($conn, $sql_parcel);

    if ($row_parcel = mysqli_fetch_assoc($result_parcel)) {
        $parcel = $row_parcel['name_parcel'];
        return $parcel;
    } else {
        $parcel = '';
        return $parcel;
    }
}

function thaiMonth($month) {
    $months = array(
        '01' => 'มกราคม',
        '02' => 'กุมภาพันธ์',
        '03' => 'มีนาคม',
        '04' => 'เมษายน',
        '05' => 'พฤษภาคม',
        '06' => 'มิถุนายน',
        '07' => 'กรกฎาคม',
        '08' => 'สิงหาคม',
        '09' => 'กันยายน',
        '10' => 'ตุลาคม',
        '11' => 'พฤศจิกายน',
        '12' => 'ธันวาคม'
    );
  
    return $months[$month];
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
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../css/canvas.css">
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
            document.querySelector('a[name="list-me-req"]').classList.add('nav-link', 'active');
        });
        </script>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>รายการขอเบิก</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">รายการขอเบิก</li>
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
                                    <h3 class="card-title">รายการขอเบิก</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <center>
                                    <p><?= date('d', strtotime($date_in)) . ' ' . thaiMonth(date('m', strtotime($date_in))) . ' ' . (date('Y', strtotime($date_in)) + 543); ?>
                                    </p>
                                    <p><?php echo name_department($department_req) ?></p>
                                    
                                    <p style="color: red;"><?php echo $comment_cancel; ?></p>
                                    <table border="1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ลำดับที่</th>
                                                <th class="text-center" width="400px">รายการ</th>
                                                <th class="text-center">จำนวนที่ต้องการเบิก/หน่วยนับ</th>
                                                <th class="text-center">รวมเป็นเงิน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                   $sql_req = "SELECT * FROM list_parcel_req WHERE report_req_id = '$id_req_parcel'";
                                                   $result_req = mysqli_query($conn, $sql_req);
                                                   $countNum = 1;
                                                   while ($row = mysqli_fetch_assoc($result_req)) {
                                                       echo '<tr>
                                                               <td class="text-center">' . $countNum . '</td>
                                                               <td > ' . name_parcel($row['id_parcel']) . '</td>
                                                               <td class="text-center">' . $row['qty'] . ' ' . unit_parcel($row['id_parcel']) . '</td>
                                                               <td class="text-center"></td>
                                                             </tr>';
                                                   
                                                       $countNum++;
                                                   }
                                            ?>
                                        <tbody>
                                           
                                    </table>
                                    <br>
                                            <table border="1">
                                            <tr>
                                                <td colspan="2">
                                                    <label for="signature-tech" style="margin-top: 20px;">ผู้เบิกพัสดุ :
                                                        <span
                                                            style="font-weight: normal;">หัวหน้างาน/หัวหน้าหน่วย/หัวหน้าสาขา</span>
                                                    </label>
                                                    <center>
                                                        <img src="../image_signature/<?php echo $signature_req; ?> "
                                                            alt="signature_req" width="100px" height="100px"
                                                            style="margin-top: -20px;">
                                                            <p style="margin-top: -25px;">
                                                            <?php echo "ลงชื่อ ..........................................."?></p>
                                                        <p style="margin-top: -20px;">
                                                            <?php echo "( ". name_person($id_req). " )"?></p>

                                                    </center>
                                                    <label for="signature-tech" style="margin-top: 20px;">ผู้รับพัสดุ :
                                                        <span
                                                            style="font-weight: normal;">ธุรการ/จ.บริหาร/พนักงาน/ผู้ดูแล</span></label>
                                                    <center>
                                                        <?php if ($signature_sueccess): ?>
                                                        <img src="../image_signature/<?php echo $signature_sueccess; ?>"
                                                            alt="signature_req" width="100px" height="100px"
                                                            style="margin-top: -20px;">
                                                            <p style="margin-top: -25px;">
                                                            <?php echo "ลงชื่อ ..........................................."?></p>
                                                       
                                                        <?php else: ?>
                                                        <!-- ไม่พบภาพ -->
                                                        <div style="height:100px"></div>
                                                        <p style="margin-top: -25px;">
                                                            <?php echo "ลงชื่อ ..........................................."?></p>
                                                    
                                                        <?php endif; ?>
                                                       

                                                    </center>
                                                </td>
                                                <td colspan="2">
                                                    <label for="signature-tech" style="margin-top: 20px;">ผู้อนุมัติจ่ายพัสดุ :
                                                        <span
                                                            style="font-weight: normal;">หัวหน้าเจ้าหน้าที่/หัวหน้าพัสดุ</span>
                                                    </label>
                                                    <center>
                                                        <?php if ($signature_parcel_head): ?>
                                                        <img src="../image_signature/<?php echo $signature_parcel_head; ?>"
                                                            alt="signature_parcel_head" width="100px" height="100px"
                                                            style="margin-top: -20px;">
                                                            <p style="margin-top: -25px;">
                                                            <?php echo "ลงชื่อ ..........................................."?></p>
                                                        <p style="margin-top: -20px;">
                                                            <?php echo "( ". name_person($id_parcel_head). " )"?></p>
                                                        <?php else: ?>
                                                        <!-- ไม่พบภาพ -->
                                                        <div style="height:75px;"></div>
                                                        <p style="margin-top: -25px;">
                                                            <?php echo "ลงชื่อ ..........................................."?></p>
                                                        <p style="margin-top: -20px;">
                                                            <?php echo "( ". name_person($id_parcel_head). " )"?></p>
                                                        <?php endif; ?>
                                                    </center>

                                                    <label for="signature-tech" style="margin-top: 20px;">ผู้จ่ายพัสดุ :
                                                        <span style="font-weight: normal;">พัสดุ</span>
                                                    </label>
                                                    <center>
                                                        <?php if ($signature_parcel): ?>
                                                        <img src="../image_signature/<?php echo $signature_parcel; ?>"
                                                            alt="signature_req" width="100px" height="100px"
                                                            style="margin-top: -20px;">
                                                        <p style="margin-top: -25px;">
                                                            <?php echo "ลงชื่อ ..........................................."?>
                                                        </p>
                                                        <p style="margin-top: -20px;">
                                                            <?php echo "( ". name_person($id_parcel). " )"?></p>
                                                        <?php else: ?>
                                                        <div style="height:100px"></div>
                                                        <p style="margin-top: -25px;">
                                                            <?php echo "ลงชื่อ ..........................................."?>
                                                        </p>
                                                        <p style="margin-top: -20px;">
                                                            <?php echo "( ". name_person($id_parcel). " )"?></p>

                                                        <?php endif; ?>
                                                    </center>
                                                </td>
                                            </tr>
                                            </table>

                                </center>
                                <br><br>
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
document.getElementById('btn-back').addEventListener('click', function() {
    // Go back to the previous page
    history.back();
});


document.addEventListener('DOMContentLoaded', function() {
    // Add an event listener to the radio buttons
    document.querySelectorAll('input[name="signature-tech"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            // Check if the radio button with value "1" is selected
            if (this.value === '1') {
                // Show the image upload section
                document.getElementById('image-upload').style.display = 'block';
            } else {
                // Hide the image upload section
                document.getElementById('image-upload').style.display = 'none';
            }
        });
    });
});
</script>
<?php require '../popup/popup.php'; ?>
<script src="../dist/js/canvas.js"></script>