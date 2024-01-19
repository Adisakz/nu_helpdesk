<?php
session_start();
require_once '../dbconfig.php';


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

function resizeImage($tmp_name, $img_name, $img_size, $dir, $new_width, $new_height) {
  list($width, $height) = getimagesize($tmp_name);
  $tmp_img = imagecreatetruecolor($new_width, $new_height);

  $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
  $img_ex_lc = strtolower($img_ex);

  switch ($img_ex_lc) {
      case 'jpg':
      case 'jpeg':
          $source = imagecreatefromjpeg($tmp_name);
          break;
      case 'png':
          $source = imagecreatefrompng($tmp_name);
          break;
      default:
          echo "สกุลไม่ถูกต้อง";
          exit();
  }

  imagecopyresampled($tmp_img, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

  $resized_img_name = uniqid("RESIZED_IMG-", true) . '.' . $img_ex_lc;
  $resized_path = $dir . $resized_img_name;

  switch ($img_ex_lc) {
      case 'jpg':
      case 'jpeg':
          imagejpeg($tmp_img, $resized_path);
          break;
      case 'png':
          imagepng($tmp_img, $resized_path);
          break;
  }

  imagedestroy($source);
  imagedestroy($tmp_img);

  return $resized_img_name;
}


error_reporting(E_ERROR | E_PARSE);
date_default_timezone_set("Asia/Bangkok");

$dateTh = ThDate();

if (isset($_POST['submit'])) { 
  $id_durable = $_POST['id-durable'];
  $type = $_POST['type'];
  $type_Repair = $_POST['type-repair'];
  $assetId = $_POST['asset-id'];
  $departmentName = $_POST['department-id'];
  $assetName = $_POST['asset-name'];
  $assetDetail = $_POST['asset-detail'];
  $neet = $_POST['neet'];
  $status = $_POST['status'];
  $id_tech = $_POST['name-tech-s'];
  $id_person = $_SESSION['id'] ;
  $building = $_POST['building'];
  $room_number = $_POST['room-number'];
  $singature_report = $_POST['image-signature-report'];
  $name_report = $_POST['name-report'];
  $reasons = $_POST['reasons'];
  $data1 = $_POST['department-option'];
 /* echo $id_durable;
  echo 'Type: ' . $type . '<br>';
echo 'Type Repair: ' . $type_Repair . '<br>';
echo 'Asset ID: ' . $assetId . '<br>';
echo 'Department Name: ' . $departmentName . '<br>';
echo 'Asset Name: ' . $assetName . '<br>';
echo 'Asset Detail: ' . $assetDetail . '<br>';
echo 'Neet: ' . $neet . '<br>';
echo 'Status: ' . $status . '<br>';
echo 'Name Tech: ' . $id_tech . '<br>';
echo 'ID Person: ' . $id_person . '<br>';
echo 'Building: ' . $building . '<br>';
echo 'Room Number: ' . $room_number . '<br>';
echo 'Signature Report: ' . $singature_report . '<br>';
echo 'Name Report: ' . $name_report . '<br>';
echo 'Department Option: ' . $data1 . '<br>';*/
/*<input type="hidden" name="data1" value="<?php echo htmlspecialchars($type); ?>">
<input type="hidden" name="data2" value="<?php echo htmlspecialchars($type_Repair); ?>">
<input type="hidden" name="data3" value="<?php echo htmlspecialchars($assetId); ?>">
<input type="hidden" name="data4" value="<?php echo htmlspecialchars($departmentName); ?>">
<input type="hidden" name="data5" value="<?php echo htmlspecialchars($assetName); ?>">
<input type="hidden" name="data6" value="<?php echo htmlspecialchars($assetDetail); ?>">
<input type="hidden" name="data7" value="<?php echo htmlspecialchars($neet); ?>">
<input type="hidden" name="data8" value="<?php echo htmlspecialchars($status); ?>">
<input type="hidden" name="data9" value="<?php echo htmlspecialchars($id_tech); ?>">
<input type="hidden" name="data10" value="<?php echo htmlspecialchars($id_person); ?>">
<input type="hidden" name="data11" value="<?php echo htmlspecialchars($building); ?>">
<input type="hidden" name="data12" value="<?php echo htmlspecialchars($room_number); ?>">
<input type="hidden" name="data13" value="<?php echo htmlspecialchars($name_report); ?>">*/


if ($data1 == 2) {
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: '<h4 class="t1"><strong>ลงนามผู้รับรอง</strong></h4>',
        html: '<center><div class="mb-3"><div class="mb-3"><label class="form-label" for="imp_sig"></label><div id="canvasDiv"></div><br><button type="button" class="btn btn-danger" id="reset-btn">Clear</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-success" id="btn-save">Save</button></div> <form id="signatureform" action="save_repair" style="display:none" method="post"><input type="hidden" id="signature" name="signature"><input type="hidden" name="signaturesubmit" value="1"><input type="hidden" name="data1" value="<?php echo htmlspecialchars($type); ?>"><input type="hidden" name="data2" value="<?php echo htmlspecialchars($type_Repair); ?>"><input type="hidden" name="data3" value="<?php echo htmlspecialchars($assetId); ?>"><input type="hidden" name="data4" value="<?php echo htmlspecialchars($departmentName); ?>"><input type="hidden" name="data5" value="<?php echo htmlspecialchars($assetName); ?>"><input type="hidden" name="data6" value="<?php echo htmlspecialchars($assetDetail); ?>"><input type="hidden" name="data7" value="<?php echo htmlspecialchars($neet); ?>"><input type="hidden" name="data8" value="<?php echo htmlspecialchars($status); ?>"><input type="hidden" name="data9" value="<?php echo htmlspecialchars($id_tech); ?>"><input type="hidden" name="data10" value="<?php echo htmlspecialchars($id_person); ?>"><input type="hidden" name="data11" value="<?php echo htmlspecialchars($building); ?>"><input type="hidden" name="data12" value="<?php echo htmlspecialchars($room_number); ?>"><input type="hidden" name="data13" value="<?php echo htmlspecialchars($name_report); ?>"><input type="hidden" name="data14" value="<?php echo htmlspecialchars($id_durable); ?>"><input type="hidden" name="data15" value="<?php echo htmlspecialchars($reasons); ?>"></form></div></center>',
        confirmButtonText: '<div class="text t1">ออก</div>',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'form_rapair';
        }
    });
});
</script>

<?php
  } else if ($data1 == 1) {   
    // ทำการบันทึกภาพ
    $img_name = $_FILES["image-signature-report"]["name"];
    $img_size = $_FILES["image-signature-report"]["size"];
    $tmp_name = $_FILES["image-signature-report"]["tmp_name"];
    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_ex_lc = strtolower($img_ex);
    $allowed_exs = array("jpg", "jpeg", "png");

    // เช็คว่าสกุลของไฟล์อยู่ในรายการที่อนุญาตหรือไม่
    if (in_array($img_ex_lc, $allowed_exs)) {
        if ($img_size > 125000) {
            // ทำการ resize และบันทึกภาพ
            $resized_img_name = resizeImage($tmp_name, $img_name, $img_size, '../image_signature/', 600, 900);
            move_uploaded_file($resized_img_name, $dir);

            // INSERT into database
            $sql = "INSERT INTO repair_report_pd05 (type, type_repair, department_id, asset_name, asset_id, asset_detail, building, room_number, neet, tech_id, id_person_report, report_signature, report_name, date_report_in, status,reasons) 
                    VALUES ('$type','$type_Repair','$departmentName','$assetName','$assetId','$assetDetail','$building','$room_number','$neet','$id_tech','$id_person','$resized_img_name','$name_report',CURRENT_TIMESTAMP,'$status','$reasons')";
            mysqli_query($conn, $sql);
            header("location: ./save_repair?success=success&id=$assetId&id_durable=$id_durable");
        } else {
            // ทำการบันทึกไฟล์ที่ไม่ต้อง resize
            $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
            $dir = '../image_signature/' . $new_img_name;
            move_uploaded_file($tmp_name, $dir);

            // INSERT into database
            $sql = "INSERT INTO repair_report_pd05 (type, type_repair, department_id, asset_name, asset_id, asset_detail, building, room_number, neet, tech_id, id_person_report, report_signature, report_name, date_report_in, status,reasons) 
                    VALUES ('$type','$type_Repair','$departmentName','$assetName','$assetId','$assetDetail','$building','$room_number','$neet','$id_tech','$id_person','$new_img_name','$name_report',CURRENT_TIMESTAMP,'$status','$reasons')";
            mysqli_query($conn, $sql);
            header("location: ./save_repair?success=success&id=$assetId&id_durable=$id_durable");
        }
    } else {
      echo "สกุลไม่ถูกต้อง";
      header("location: ./save_repair?error=error");
  }
    }
}

//ตอนที่ 2 เมื่อลงนามแล้วกด save ในฟอร์ม popup ลงนามแล้วให้ บันทึกลงฐานข้อมูล ------------------------------------------------------------------
if (isset($_POST['signaturesubmit'])) {
  $signature = $_POST['signature'];
  $signatureFileName = uniqid() . '.png';
  $signature = str_replace('data:image/png;base64,', '', $signature);
  $signature = str_replace(' ', '+', $signature);
  $data = base64_decode($signature);
  $file = '../image_signature/' . $signatureFileName;
  file_put_contents($file, $data);
  isset($_REQUEST['submit']);
    $data1 = $_REQUEST['data1'];   // type
    $data2 = $_REQUEST['data2'];    //type_Repair
    $data3 = $_REQUEST['data3'];    //assetId
    $data4 = $_REQUEST['data4'];    //departmentName
    $data5 = $_REQUEST['data5'];    //assetName
    $data6 = $_REQUEST['data6'];   //assetDetail
    $data7 = $_REQUEST['data7'];    //neet
    $data8 = $_REQUEST['data8'];//status
    $data9 = $_REQUEST['data9'];//id_tech
    $data10 = $_REQUEST['data10'];//name_person
    $data11 = $_REQUEST['data11'];//building
    $data12 = $_REQUEST['data12'];//room_number
    $data13 = $_REQUEST['data13'];//name_report
    $data14 = $_REQUEST['data14'];//name_report
    $data15 = $_REQUEST['data15']; //reasons
    $id_person = $_SESSION['id'] ;//
     // ทำการแสดงผลค่าที่ได้รับจากฟอร์ม
     /*echo 'Type: ' . $data1 . '<br>';
     echo 'Type Repair: ' . $data2 . '<br>';
     echo 'Asset ID: ' . $data3 . '<br>';
     echo 'Department Name: ' . $data4 . '<br>';
     echo 'Asset Name: ' . $data5 . '<br>';
     echo 'Asset Detail: ' . $data6 . '<br>';
     echo 'Neet: ' . $data7 . '<br>';
     echo 'Status: ' . $data8 . '<br>';
     echo 'ID Tech: ' . $data9 . '<br>';
     echo 'Building: ' . $data11 . '<br>';
     echo 'Room Number: ' . $data12 . '<br>';
     echo 'Name Report: ' . $data10  . '<br>';
     echo 'signature: ' . $signatureFileName . '<br>';*/
  // INSERT into database
  $sql = "INSERT INTO repair_report_pd05 (type, type_repair, department_id, asset_name, asset_id, asset_detail, building, room_number, neet, tech_id, id_person_report, report_signature, report_name, date_report_in, status,reasons) 
  VALUES ('$data1','$data2','$data4','$data5','$data3','$data6','$data11','$data12','$data7','$data9','$id_person', '$signatureFileName','$data13', CURRENT_TIMESTAMP, '$data8','$data15')";
    mysqli_query($conn, $sql);
    header("location: ./save_repair?success=success&id=$data3&id_durable=$data14");
}

function ThDate()
{

    //วันภาษาไทย
    $ThDay = array("อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์");
    //เดือนภาษาไทย
    $ThMonth = array("ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    //วันที่ ที่ต้องการเอามาเปลี่ยนฟอแมต
    $myDATE = date('d M Y H:i:s'); //อาจมาจากฐานข้อมูล
    //กำหนดคุณสมบัติ
    $time = date("H:i:s", strtotime($myDATE)); // ค่าวันในสัปดาห์ (0-6)
    $week = date("w", strtotime($myDATE)); // ค่าวันในสัปดาห์ (0-6)
    $months = date("m", strtotime($myDATE)) - 1; // ค่าเดือน (1-12)
    $day = date("d", strtotime($myDATE)); // ค่าวันที่(1-31)
    $years = date("Y", strtotime($myDATE)) + 543; // ค่า ค.ศ.บวก 543 ทำให้เป็น ค.ศ.
    return
        "$day $ThMonth[$months] $years $time";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_durable = $_POST['id-durable'];
    $type = $_POST['type'];
    $assetId = $_POST['asset-id'];
    $typeRepair = $_POST['type-repair'];
    $departmentName = $_POST['department-id'];
    $assetName = $_POST['asset-name'];
    $assetDetail = $_POST['asset-detail'];
    $building = $_POST['building'];
    $room_number = $_POST['room-number'];
    $neet = $_POST['neet'];
    $id_person_tech = $_POST['id-person'];
    $title = $_POST['title-name'];
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $status = '0';
    $name_tech = $title.$firstName.' '. $lastName;
    $name_report = $_SESSION['name_title'].$_SESSION['first_name'].' '.$_SESSION['last_name'];
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
    <!-- jQuery UI Signature core CSS -->
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
        rel="stylesheet">
    <link href="../assets/css/jquery.signature.css" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../css/canvas.css">
    <script src="../libs/modernizr.js"></script>

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
        document.querySelector('a[name="search_asset"]').classList.add('nav-link', 'active');
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
                                <form id="quickForm" action="" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                    <div class="form-group">
                                            <input type="text" name="type"
                                                value="<?php echo $type?>" style="display: none; ">
                                            <label for="type">ประเภท : <span
                                                    style="color:green;"><?php echo htmlspecialchars($type); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="type-repair" value="<?php echo $typeRepair?>"
                                                style="display: none; ">
                                            <label for="type-repair">หมวดหมู่ครุภัณฑ์ : <span
                                                    style="color:green;"><?php echo htmlspecialchars($typeRepair); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="department-id"
                                                value="<?php echo $departmentName?>" style="display: none; ">
                                            <label for="department-id">ชื่อหน่วยงาน : <span
                                                    style="color:green;"><?php echo htmlspecialchars(name_department($departmentName)); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="asset-name" value="<?php echo $assetName?>"
                                                style="display: none; ">
                                            <label for="asset-name">ทรัพย์สินที่ต้องการซ่อม : <span
                                                    style="color:green;"><?php echo htmlspecialchars($assetName); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="asset-id" value="<?php echo $assetId?>"
                                                style="display: none; ">
                                            <label for="asset-id">หมายเลขครุภัณฑ์ : <span
                                                    style="color:green;"><?php echo htmlspecialchars($assetId); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="asset-detail" value="<?php echo $assetDetail?>"
                                                style="display: none; ">
                                            <label for="asset-detail">สภาพการชำรุด : <span
                                                    style="color:green;"><?php echo htmlspecialchars($assetDetail); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="building">อาคาร : <span
                                                    style="color:green;"><?php echo htmlspecialchars($building); ?></span></label>
                                            <input type="text" name="building" value="<?php echo $building?>"
                                                style="display: none; ">
                                        </div>
                                        <div class="form-group">
                                            <label for="room-number">ห้อง : <span
                                                    style="color:green;"><?php echo htmlspecialchars($room_number); ?></span></label>
                                            <input type="text" name="room-number" value="<?php echo $room_number?>"
                                                style="display: none; ">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="reasons" value="<?php echo $reasons?>"
                                                style="display: none; ">
                                            <label for="reasons">เหตุผลความจำเป็นในการจ้างซ่อมทรัพย์สิน : <span
                                                    style="color:green;"><?php echo htmlspecialchars($reasons); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="neet" value="<?php echo $neet?>"
                                                style="display: none; ">
                                            <label for="neet">ความต้องการ : <span
                                                    style="color:green;"><?php echo htmlspecialchars($neet); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="name-tech-s" value="<?php echo $id_person_tech?>"
                                                style="display: none; ">
                                            <label for="name-tech">ช่างที่รับผิดชอบ : <span
                                                    style="color:green;"><?php echo htmlspecialchars($name_tech); ?></span></label>
                                        </div>
                                        <input type="text" name="status" value="<?php echo $status?>"
                                            style="display: none; ">
                                        <input type="text" name="name-report" value="<?php echo $name_report?>"
                                            style="display: none; ">
                                        <div class="form-group">
                                        <input type="text" name="id-durable" value="<?php echo $id_durable?>"
                                            style="display: none; ">
                                            <p>-------------------------------------------------------------------------------------------------------------------------------
                                            </p>
                                        </div>

                                        <div class="form-group" id="my-form-group">
                                            <label for="department-name">ลายซ็น :</label> <br>

                                            <!-- radio buttons -->
                                            <input type="radio" name="department-option" id="option-with-image"
                                                value="1" required>
                                            <label for="option-with-image"
                                                style="font-weight: normal;">เลือกจากรูปภาพในเครื่อง</label><br>

                                            <input type="radio" name="department-option" id="option-without-image"
                                                value="2" required>
                                            <label for="option-without-image"
                                                style="font-weight: normal;">เซ็นตอนนี้</label>

                                            <!-- ช่อง input สำหรับอัพโหลดภาพ -->
                                            <div id="image-upload" style="display: none;">
                                                <label for="image">อัพโหลดรูปภาพ:</label>
                                                <input type="file" id="image-signature-report"
                                                    name="image-signature-report">
                                            </div>

                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer d-flex justify-content-end">
                                        <button type="submit" name="submit" class="btn btn-primary">ถัดไป</button>
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
document.addEventListener('DOMContentLoaded', function() {
    // Add an event listener to the radio buttons
    document.querySelectorAll('input[name="department-option"]').forEach(function(radio) {
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

<script>
<?php
if (isset($_REQUEST['success'])) {
  $id=$_GET['id'];
  ?>
setTimeout(function() {
    Swal.fire({
        title: 'แจ้งซ่อมเรียบร้อย',
        icon: 'success',
        confirmButtonText: 'ตกลง',
        allowOutsideClick: false, // ไม่อนุญาตให้คลิกนอก popup ปิด
        allowEscapeKey: true, // ไม่อนุญาตให้กดปุ่ม ESC เพื่อปิด
        allowEnterKey: true // ไม่อนุญาตให้กดปุ่ม Enter เพื่อปิด
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "./repair_me";
        }
    });
});

<?php
  }
?>
<?php
if (isset($_REQUEST['error'])) {
  ?>
setTimeout(function() {
    Swal.fire({
        title: 'ไม่สามารถแจ้งซ่อมได้',
        text: 'เนื่องจากข้อมูลลายเซ็นไม่ถูกต้อง',
        icon: 'error',
        confirmButtonText: 'ตกลง',
        allowOutsideClick: false, // ไม่อนุญาตให้คลิกนอก popup ปิด
        allowEscapeKey: true, // ไม่อนุญาตให้กดปุ่ม ESC เพื่อปิด
        allowEnterKey: true // ไม่อนุญาตให้กดปุ่ม Enter เพื่อปิด
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "./repair_me";
        }
    });
});

<?php
  }
?>
</script>