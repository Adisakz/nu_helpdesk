<?php
session_start();
require_once '../dbconfig.php';


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
    $idRepair = $_POST['id_repair'];
    $typeRepair = $_POST['type-repair'];
    $departmentId = $_POST['department-id'];
    $asset_name = $_POST['asset-name'];
    $assetId = $_POST['asset-id'];
    $asset_detail = $_POST['asset-detail'];
    $location = $_POST['location'];
    $namereport = $_POST['report_name'];
    $reasons = $_POST['reasons'];
    $amount = $_POST['amount'];
    $amountLast = $_POST['amount_last'];
    $recomment = $_POST['recomment'];
    $inspectorName1 = $_POST['inspector_name1'];
    $inspectorName2 = $_POST['inspector_name2'];
    $inspectorName3 = $_POST['inspector_name3'];
    $repairTypeTech = $_POST['repair-typetech'];
    $id_person_send = $_POST['id_person_send'];
    $Option = $_POST['signature-tech'];

    /*echo "<h2>Received Data:</h2>";    
    echo "<p>ID Repair: $idRepair</p>";
    //echo "<p>Type Repair: $typeRepair</p>";
    //echo "<p>Department ID: $departmentId</p>";
    //echo "<p>Asset Name: $asset_name</p>";
    echo "<p>Asset ID: $assetId</p>";
    //echo "<p>Asset Detail: $asset_detail</p>";
    //echo "<p>Location: $location</p>";
    //echo "<p>Name Report: $namereport</p>";
    echo "<p>Reasons: $reasons</p>";
    echo "<p>Amount: $amount</p>";
    echo "<p>Amount Last: $amountLast</p>";
    echo "<p>Recomment: $recomment</p>";
    echo "<p>Inspector Name 1: $inspectorName1</p>";
    echo "<p>Inspector Name 2: $inspectorName2</p>";
    echo "<p>Inspector Name 3: $inspectorName3</p>";
    echo "<p>Repair Type Tech: $repairTypeTech</p>";
    echo "<p>ID Person Send: $id_person_send</p>";
    echo "<p>Department Option: $Option</p>";*/

 if ($Option == 2) {
    ?>
         <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '<h4 class="t1"><strong>ลงนามผู้รับรอง</strong></h4>',
                html: '<center><div class="mb-3"><div class="mb-3"><label class="form-label" for="imp_sig"></label><div id="canvasDiv"></div><br><button type="button" class="btn btn-danger" id="reset-btn">Clear</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-success" id="btn-save">Save</button></div> <form id="signatureform" action="confirm_repair_save" style="display:none" method="post"><input type="hidden" id="signature" name="signature"><input type="hidden" name="signaturesubmit" value="1"><input type="hidden" name="data1" value="<?php echo htmlspecialchars($idRepair); ?>"><input type="hidden" name="data2" value="<?php echo htmlspecialchars($assetId); ?>"><input type="hidden" name="data3" value="<?php echo htmlspecialchars($reasons); ?>"><input type="hidden" name="data4" value="<?php echo htmlspecialchars($amount); ?>"><input type="hidden" name="data5" value="<?php echo htmlspecialchars($amountLast); ?>"><input type="hidden" name="data6" value="<?php echo htmlspecialchars($recomment); ?>"><input type="hidden" name="data7" value="<?php echo htmlspecialchars($inspectorName1); ?>"><input type="hidden" name="data8" value="<?php echo htmlspecialchars($inspectorName2); ?>"><input type="hidden" name="data9" value="<?php echo htmlspecialchars($inspectorName3); ?>"><input type="hidden" name="data10" value="<?php echo htmlspecialchars($repairTypeTech); ?>"><input type="hidden" name="data11" value="<?php echo htmlspecialchars($id_person_send); ?>"></form></div></center>',
                confirmButtonText: '<div class="text t1">ออก</div>',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'repair';
                }
            });
        });
    </script>
    
      <?php
  } else if ($Option == 1) {   
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
            $sql = "UPDATE repair_report_pd05 SET asset_id = '$assetId', reasons = '$reasons',amount = $amount, last_amount = $amountLast, recomment = '$recomment', inspector_name1='$inspectorName1',inspector_name2='$inspectorName2',inspector_name3='$inspectorName3',repair_type='$repairTypeTech',send_to='$id_person_send',status='4',signature_tech= '$resized_img_name', date_tech_confirm = CURRENT_TIMESTAMP WHERE id_repair=$idRepair";
            mysqli_query($conn, $sql);
            header("location: ./save_repair?success=success");
        } else {
            // ทำการบันทึกไฟล์ที่ไม่ต้อง resize
            $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
            $dir = '../image_signature/' . $new_img_name;
            move_uploaded_file($tmp_name, $dir);

            // INSERT into database
            $sql = "UPDATE repair_report_pd05 SET asset_id = '$assetId', reasons = '$reasons',amount = $amount, last_amount = $amountLast, recomment = '$recomment', inspector_name1='$inspectorName1',inspector_name2='$inspectorName2',inspector_name3='$inspectorName3',repair_type='$repairTypeTech',send_to='$id_person_send',status='4',signature_tech= '$new_img_name', date_tech_confirm = CURRENT_TIMESTAMP WHERE id_repair=$idRepair";
            mysqli_query($conn, $sql);
            header("location: ./save_repair?success=success");
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

    $data1 = $_POST['data1'];    
    $data2 = $_POST['data2'];    
    $data3 = $_POST['data3'];    
    $data4 = $_POST['data4'];    
    $data5 = $_POST['data5'];    
    $data6 = $_POST['data6'];   
    $data7 = $_POST['data7'];    
    $data8 = $_POST['data8'];
    $data9 = $_POST['data9'];
    $data10 = $_POST['data10'];
    $data11 = $_POST['data11'];

     /*echo "Type Repair: $data1 <br>";
     echo "Asset ID: $data2 <br>";
     echo "Reasons: $data3 <br>";
     echo "Amount: $data4 <br>";
    echo "Amount_last: $data5 <br>";
     echo "Comment: $data6 <br>";
    echo "inspectorName1: $data7 <br>";
     echo "inspectorName2: $data8 <br>";
     echo "inspectorName3: $data9 <br>";
     echo "Type_send_repair: $data10 <br>";
     echo "send_to : $data11 <br>";*/
  // INSERT into database
    $sql = "UPDATE repair_report_pd05 SET asset_id = '$data2', reasons = '$data3',amount = $data4, last_amount = $data5, recomment = '$data6', inspector_name1='$data7',inspector_name2='$data8',inspector_name3='$data9',repair_type='$data10',send_to='$data11',status='4',signature_tech= '$signatureFileName', date_tech_confirm = CURRENT_TIMESTAMP WHERE id_repair=$data1";
    mysqli_query($conn, $sql);
    header("location: ./repair?success=success");
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
  $idRepair = $_POST['id-repair'];
  $repairType = $_POST['repairType'];
  $departmentId = $_POST['department-name'];
  $asset_name = $_POST['asset-name'];
  $assetId = $_POST['asset-id'];
  $asset_detail = $_POST['asset-detail'];
  $location = $_POST['location'];
  $namereport = $_POST['name-report'];
  $reasons = $_POST['reasons'];
  $amount = $_POST['amount'];
  $amountLast = $_POST['amount_last'];
  $recomment = $_POST['recomment'];
  $inspectorName1 = $_POST['inspector_name1'];
  $inspectorName2 = $_POST['inspector_name2'];
  $inspectorName3 = $_POST['inspector_name3'];
  $repairTypeTech = $_POST['repairTypeTech'];
  $id_person_send = $_POST['id-person-send'];

  
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
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
  <link href="../assets/css/jquery.signature.css" rel="stylesheet">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
                    <input type="text" name="type-repair" value="<?php echo $repairType?>" style="display: none; ">
                    <label for="type-repair">ประเภท : <span style="font-weight: normal;"><?php echo htmlspecialchars($repairType); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="department-id" value="<?php echo $departmentId?>" style="display: none; ">
                    <label for="department-name">ชื่อหน่วยงาน : <span style="font-weight: normal;"><?php echo htmlspecialchars($departmentId); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="asset-name" value="<?php echo $asset_name?>" style="display: none; ">
                    <label for="asset-name">ทรัพย์สินที่ต้องการซ่อม : <span style="font-weight: normal;"><?php echo htmlspecialchars($asset_name); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="asset-id" value="<?php echo $assetId?>" style="display: none; ">
                    <label for="asset-id">หมายเลขครุภัณฑ์ : <span style="color: #28a745;"><?php echo htmlspecialchars($assetId); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="asset-detail" value="<?php echo $asset_detail ?>" style="display: none; ">
                    <label for="asset-detail">สภาพการชำรุด : <span style="font-weight: normal; "><?php echo htmlspecialchars($asset_detail); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="location" value="<?php echo $location?>" style="display: none; ">
                    <label for="location">ที่ตั้ง : <span style="font-weight: normal;"><?php echo htmlspecialchars($location); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="report_name" value="<?php echo $namereport?>" style="display: none; ">
                    <label for="report_name">ชื่อผู้แจ้งซ่อม : <span style="font-weight: normal;"><?php echo htmlspecialchars($namereport); ?></span></label>
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
                  <input type="text" name="amount_last" value="<?php echo $amountLast?>" style="display: none; ">
                    <label for="amount_last">ราคาที่ซ่อมครั้งสุดท้าย : <span style="color: #28a745;"><?php echo htmlspecialchars($amountLast); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="recomment" value="<?php echo $recomment?>" style="display: none; ">
                    <label for="recomment">งานช่างได้ตรวจสอบการชำรุดแล้วปรากกฏว่า : <span style="color: #28a745;"><?php echo htmlspecialchars($recomment); ?></span></label>
                  </div>
                  <div class="form-group">
                  <input type="text" name="inspector_name1" value="<?php echo $inspectorName1?>" style="display: none; ">
                  <input type="text" name="inspector_name2" value="<?php echo $inspectorName2?>" style="display: none; ">
                  <input type="text" name="inspector_name3" value="<?php echo $inspectorName3?>" style="display: none; ">
                    <label for="inspector">ขอเสนอรายชื่อเพื่อแต่งตั้งเป็นคณะกรรมการตรวจรับพัสดุ : </label><br>
                    <span style="font-weight: bold; color: #28a745;">1. <?php echo htmlspecialchars($inspectorName1); ?></span><br>
                    <span style="font-weight: bold; color: #28a745;">2. <?php echo htmlspecialchars($inspectorName2); ?></span><br>
                    <span style="font-weight: bold; color: #28a745;">3. <?php echo htmlspecialchars($inspectorName3); ?></span>
                  </div>
                  <div class="form-group">
                  <input type="text" name="repair-typetech" value="<?php echo $repairTypeTech?>" style="display: none; ">
                    <label for="repair-typetech">ประเภทการซ่อม : <span style="color: #28a745;"><?php echo htmlspecialchars($repairTypeTech); ?></span></label>
                  </div>
                  <input type="text" name="id_person_send" value="<?php echo $id_person_send?>" style="display: none; ">
                  <input type="text" name="id_repair" value="<?php echo $idRepair?>" style="display: none; ">
                  <div class="form-group">
                    <p>-------------------------------------------------------------------------------------------------------------------------------</p>
                  </div>
                  <div class="form-group" id="my-form-group">
                        <label for="signature-tech">ลายซ็น :</label> <br> 
                        
                        <!-- radio buttons -->
                        <input type="radio" name="signature-tech" id="option-with-image" value="1" required> 
                        <label for="option-with-image" style="font-weight: normal;">เลือกจากรูปภาพในเครื่อง</label><br>

                        <input type="radio" name="signature-tech" id="option-without-image" value="2" required>
                        <label for="option-without-image" style="font-weight: normal;">เซ็นตอนนี้</label>

                        <!-- ช่อง input สำหรับอัพโหลดภาพ -->
                        <div id="image-upload" style="display: none;">
                            <label for="image">อัพโหลดรูปภาพ:</label>
                            <input type="file" id="image-signature-report" name="image-signature-report">
                        </div>

                  </div>
                  </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex justify-content-end">
                  <button type="submit" name="submit" class="btn btn-primary" >ถัดไป</button>
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

<script>
<?php
if (isset($_REQUEST['success'])) {
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
                      window.location.href = "./form_rapair";
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
                      window.location.href = "./form_rapair";
                  }
              });
          });
     
  <?php
  }
?>
</script>