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
  $type = htmlspecialchars($_POST['type']);
  $repairType = htmlspecialchars($_POST['repair-type']);
  $department_id = htmlspecialchars($_POST['department-id']);
  $assetName = htmlspecialchars($_POST['asset-name']);
  $assetId = htmlspecialchars($_POST['asset-id']);
  $assetDetail = htmlspecialchars($_POST['asset-detail']);
  $building = htmlspecialchars($_POST['building']);
  $roomNumber = htmlspecialchars($_POST['room-number']);
  $reportName = htmlspecialchars($_POST['report-name']);
  $reasons = htmlspecialchars($_POST['reasons']);
  $recomment = htmlspecialchars($_POST['recomment']);
  $repairTypeTech = htmlspecialchars($_POST['repair-type-tech']);
  $amount = htmlspecialchars($_POST['amount']);
  $amountLast = htmlspecialchars($_POST['amount-last']);
  $inspectorName1 = htmlspecialchars($_POST['inspector-name-1']);
  $inspectorName2 = htmlspecialchars($_POST['inspector-name-2']);
  $inspectorName3 = htmlspecialchars($_POST['inspector-name-3']);
  $id_person_send = htmlspecialchars($_POST['id_person_send']);
  $idRepair = htmlspecialchars($_POST['id_repair']);

    // Echo the values
    /*echo "ประเภท: $type<br>";
    echo "หมวดหมู่ครุภัณฑ์: $repairType<br>";
    echo "ชื่อหน่วยงาน:  $department_id  <br>";
    echo "ทรัพย์สินที่ต้องการซ่อม: $assetName<br>";
    echo "หมายเลขครุภัณฑ์: $assetId<br>";
    echo "สภาพการชำรุด: $assetDetail<br>";
    echo "อาคาร: $building<br>";
    echo "ห้อง: $roomNumber<br>";
    echo "ชื่อผู้แจ้งซ่อม: $reportName<br>";
    echo "เหตุผลความจำเป็นในการจ้างซ่อม: $reasons<br>";
    echo "งานช่างได้ตรวจสอบการชำรุดแล้วปรากกฏว่า: $recomment<br>";
    echo "ประเภทการซ่อม: $repairTypeTech<br>";
    echo "วงเงินในการซ่อม: $amount<br>";
    echo "ราคาซ่อมล่าสุด: $amountLast<br>";
    echo "ขอเสนอรายชื่อเพื่อแต่งตั้งเป็นคณะกรรมการตรวจรับพัสดุ:<br>";
    echo "1. $inspectorName1<br>";
    echo "2. $inspectorName2<br>";
    echo "3. $inspectorName3<br>";
    echo "ส่งต่อถึง:  send_to $id_person_send<br>";*/

    // INSERT into database
    $sql = "UPDATE repair_report_pd05 SET reasons='$reasons',amount='$amount',last_amount='$amountLast',
    inspector_name1='$inspectorName1',inspector_name2='$inspectorName2',inspector_name3='$inspectorName3',send_to='$id_person_send', 
    date_tech_confirm = CURRENT_TIMESTAMP,status='5' WHERE id_repair=$idRepair";
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
  $userId = $_POST['id_person_send'];
  $idRepair = $_POST['id-repair'];
  $type = $_POST['type'];
  $repairType = $_POST['repair-type'];
  $department_id = $_POST['department-id'];
  $assetName = $_POST['asset-name'];
  $assetId = $_POST['asset-id'];
  $assetDetail = $_POST['asset-detail'];
  $building = $_POST['building'];
  $roomNumber = $_POST['room-number'];
  $reportName = $_POST['report-name'];
  $reasons = $_POST['reasons'];
  $recomment = $_POST['recomment'];
  $repairTypeTech = $_POST['repair-type-tech'];
  $amount = $_POST['amount'];
  $amountLast = $_POST['amount-last'];
  $inspectorName1 = $_POST['inspector-name-1'];
  $inspectorName2 = $_POST['inspector-name-2'];
  $inspectorName3 = $_POST['inspector-name-3'];


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
 
 /* echo "<h2>Received Data</h2>";
  echo "<p>User ID: $userId</p>";
  echo "<p>ID Repair: $idRepair</p>";
  echo "<p>Type: $type</p>";
  echo "<p>Repair Type: $repairType</p>";
  echo "<p>Repair Type: $department_id</p>";
  echo "<p>Asset Name: $assetName</p>";
  echo "<p>Asset ID: $assetId</p>";
  echo "<p>Asset Detail: $assetDetail</p>";
  echo "<p>Building: $building</p>";
  echo "<p>Room Number: $roomNumber</p>";
  echo "<p>Report Name: $reportName</p>";
  echo "<p>Reasons: $reasons</p>";
  echo "<p>Recomment: $recomment</p>";
  echo "<p>Repair Type Tech: $repairTypeTech</p>";
  echo "<p>Amount: $amount</p>";
  echo "<p>Amount Last: $amountLast</p>";
  echo "<p>Inspector Name 1: $inspectorName1</p>";
  echo "<p>Inspector Name 2: $inspectorName2</p>";
  echo "<p>Inspector Name 3: $inspectorName3</p>";*/
  
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Help Desk | Parcel</title>
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
        document.addEventListener('DOMContentLoaded', function() {
            const typeParcelNavItem = document.querySelector('a[name="check-repair"]')
            const parcelLink = document.querySelector('li[name="wait1"]');
            const parcelLinkActive = document.querySelector('a[name="wait-cheack"]');

            if (parcelLink) {
                parcelLink.classList.add('nav-item', 'menu-open');
            }

            if (typeParcelNavItem) {
                typeParcelNavItem.classList.add('nav-link', 'active');
            }
            if (parcelLinkActive) {
                parcelLinkActive.classList.add('nav-link', 'active');
            }
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
                                            <input type="text" name="type" value="<?php echo  $type?>"
                                                style="display: none; ">
                                            <label for="type">ประเภท : <span
                                                    style="font-weight: normal;"><?php echo htmlspecialchars( $type); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="repair-type" value="<?php echo $repairType?>"
                                                style="display: none; ">
                                            <label for="repair-type">หมวดหมู่ครุภัณฑ์ : <span
                                                    style="font-weight: normal;"><?php echo htmlspecialchars($repairType); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="department-id" value="<?php echo $department_id?>"
                                                style="display: none; ">
                                            <label for="department-id">ชื่อหน่วยงาน : <span
                                                    style="font-weight: normal;"><?php echo name_department($department_id); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="asset-name" value="<?php echo $assetName?>"
                                                style="display: none; ">
                                            <label for="asset-name">ทรัพย์สินที่ต้องการซ่อม : <span
                                                    style="font-weight: normal;"><?php echo htmlspecialchars($assetName); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="asset-id" value="<?php echo $assetId?>"
                                                style="display: none; ">
                                            <label for="asset-id">หมายเลขครุภัณฑ์ : <span
                                                    style="font-weight: normal;"><?php echo htmlspecialchars($assetId); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="asset-detail" value="<?php echo $assetDetail ?>"
                                                style="display: none; ">
                                            <label for="asset-detail">สภาพการชำรุด : <span
                                                    style="font-weight: normal; "><?php echo htmlspecialchars($assetDetail); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="building" value="<?php echo $building?>"
                                                style="display: none; ">
                                            <label for="building">อาคาร : <span
                                                    style="font-weight: normal;"><?php echo htmlspecialchars($building); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="room-number" value="<?php echo $roomNumber?>"
                                                style="display: none; ">
                                            <label for="room-number">ห้อง : <span
                                                    style="font-weight: normal;"><?php echo htmlspecialchars($roomNumber); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="report-name" value="<?php echo $reportName?>"
                                                style="display: none; ">
                                            <label for="report-name">ชื่อผู้แจ้งซ่อม : <span
                                                    style="font-weight: normal;"><?php echo htmlspecialchars($reportName); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="reasons" value="<?php echo $reasons?>"
                                                style="display: none; ">
                                            <label for="reasons">เหตุผลความจำเป็นในการจ้างซ่อม : <span
                                                    style="color: #28a745;"><?php echo htmlspecialchars($reasons); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="recomment" value="<?php echo $recomment?>"
                                                style="display: none; ">
                                            <label for="recomment">งานช่างได้ตรวจสอบการชำรุดแล้วปรากกฏว่า : <span
                                                    style="font-weight: normal;"><?php echo htmlspecialchars($recomment); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="repair-type-tech"
                                                value="<?php echo $repairTypeTech?>" style="display: none; ">
                                            <label for="repair-type-tech">ประเภทการซ่อม : <span
                                                    style="font-weight: normal;"><?php echo htmlspecialchars($repairTypeTech); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="amount"
                                                value="<?php echo $amount?>" style="display: none; ">
                                            <label for="amount">วงเงินที่จะซ่อม : <span
                                                    style="color: #28a745;"><?php echo htmlspecialchars($amount); ?></span></label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="amount-last"
                                                value="<?php echo $amountLast?>" style="display: none; ">
                                            <label for="amount-last">ราคาที่ซ่อมครั้งสุดท้าย : <span
                                                    style="color: #28a745;"><?php echo htmlspecialchars($amountLast); ?></span></label>
                                        </div>
                                        
                                        <div class="form-group">
                                            <input type="text" name="inspector-name-1"
                                                value="<?php echo $inspectorName1?>" style="display: none; ">
                                            <input type="text" name="inspector-name-2"
                                                value="<?php echo $inspectorName2?>" style="display: none; ">
                                            <input type="text" name="inspector-name-3"
                                                value="<?php echo $inspectorName3?>" style="display: none; ">
                                            <label for="inspector">ขอเสนอรายชื่อเพื่อแต่งตั้งเป็นคณะกรรมการตรวจรับพัสดุ
                                                : </label><br>
                                            <span style="font-weight: bold; color: #28a745;">1.
                                                <?php echo htmlspecialchars($inspectorName1); ?></span><br>
                                            <span style="font-weight: bold; color: #28a745;">2.
                                                <?php echo htmlspecialchars($inspectorName2); ?></span><br>
                                            <span style="font-weight: bold; color: #28a745;">3.
                                                <?php echo htmlspecialchars($inspectorName3); ?></span>
                                        </div>
                                        
                                        <input type="text" name="id_repair" value="<?php echo $idRepair?>"
                                            style="display: none; ">
                                        <div class="form-group">
                                            <p>-------------------------------------------------------------------------------------------------------------------------------
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="id_person_send" value="<?php echo $userId?>"
                                                style="display: none; ">
                                            <label for="id_person_send">ส่งต่อถึง : <span
                                                    style="color: #28a745;"><?php echo name_person($userId); ?></span></label>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer d-flex justify-content-end">
                                        <button type="submit" name="submit" class="btn btn-primary">ตกลง</button>
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