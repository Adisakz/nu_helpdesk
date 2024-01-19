<?php 
session_start();
require_once '../dbconfig.php';

$department = $_SESSION['department'] ;
$id_person = $_SESSION['id'] ;
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

if (isset($_POST['submit'])) {
    $Option = $_POST['signature-tech'];
    $selectedItems = json_decode($_POST['selectedItems'], true);

 
    if ($Option == 2) {
        ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: '<h4 class="t1"><strong>ลงนามผู้รับรอง</strong></h4>',
        html: '<center><div class="mb-3"><div class="mb-3"><label class="form-label" for="imp_sig"></label><div id="canvasDiv"></div><br><button type="button" class="btn btn-danger" id="reset-btn">Clear</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-success" id="btn-save">Save</button></div> <form id="signatureform" action="req_parcel" style="display:none" method="post"><input type="hidden" id="signature" name="signature"><input type="hidden" name="signaturesubmit" value="1"><input type="hidden" name="selectedItems" value="<?php echo htmlspecialchars(json_encode($selectedItems)); ?>"></form></div></center>',
        confirmButtonText: '<div class="text t1">ออก</div>',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'form_req_parcel';
        }
    });
});
</script>

<?php
      } else if ($Option == 1) {   
        print_r( $_FILES["image-signature-report"]);
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
                // INSERT into database (report_req_parcel)
                $sql = "INSERT INTO report_req_parcel (date_in, dapartment_id, signature_req,status,id_req)
                    VALUES (CURRENT_TIMESTAMP, '$department', '$resized_img_name','1','$id_person')";
                mysqli_query($conn, $sql);

                // ดึง id_report_req_parcel ที่ถูกสร้างขึ้น
                $id_report_req_parcel = mysqli_insert_id($conn);

                // INSERT into database (list_parcel_req) โดยใส่ id_report_req_parcel เป็น foreign key
                for ($i = 0; $i < count($selectedItems); $i += 4) {
                    $dataId = $selectedItems[$i];
                    $dataName = $selectedItems[$i + 1];
                    $quantity = $selectedItems[$i + 3];

                    $sql_list_parcel = "INSERT INTO list_parcel_req (report_req_id, id_parcel,  qty)
                                        VALUES ('$id_report_req_parcel', '$dataId', '$quantity')";
                    mysqli_query($conn, $sql_list_parcel);
                }
                header("location:./req_parcel_list?success=success");
            } else {
                // ทำการบันทึกไฟล์ที่ไม่ต้อง resize
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $dir = '../image_signature/' . $new_img_name;
                move_uploaded_file($tmp_name, $dir);
    
                $sql = "INSERT INTO report_req_parcel (date_in, dapartment_id, signature_req,status,id_req)
                    VALUES (CURRENT_TIMESTAMP, '$department', '$new_img_name','1','$id_person')";
                mysqli_query($conn, $sql);

                // ดึง id_report_req_parcel ที่ถูกสร้างขึ้น
                $id_report_req_parcel = mysqli_insert_id($conn);

                 // INSERT into database (list_parcel_req) โดยใส่ id_report_req_parcel เป็น foreign key
                for ($i = 0; $i < count($selectedItems); $i += 4) {
                    $dataId = $selectedItems[$i];
                    $dataName = $selectedItems[$i + 1];
                    $quantity = $selectedItems[$i + 3];

                    $sql_list_parcel = "INSERT INTO list_parcel_req (report_req_id, id_parcel,  qty)
                                        VALUES ('$id_report_req_parcel', '$dataId', '$quantity')";
                mysqli_query($conn, $sql_list_parcel);
            }
            header("location:./req_parcel_list?success=success");
            }
        } else {
          echo "สกุลไม่ถูกต้อง";
          header("location: ./repair?error=error");
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
      $department = $_SESSION['department'] ;
      $id_person = $_SESSION['id'] ;
        $selectedItems = json_decode($_POST['selectedItems'], true);
        
    

    // INSERT into database (report_req_parcel)
    $sql = "INSERT INTO report_req_parcel (date_in, dapartment_id, signature_req,status,id_req)
            VALUES (CURRENT_TIMESTAMP, '$department', '$signatureFileName','1','$id_person')";
    mysqli_query($conn, $sql);

    // ดึง id_report_req_parcel ที่ถูกสร้างขึ้น
    $id_report_req_parcel = mysqli_insert_id($conn);

    // INSERT into database (list_parcel_req) โดยใส่ id_report_req_parcel เป็น foreign key
    for ($i = 0; $i < count($selectedItems); $i += 4) {
        $dataId = $selectedItems[$i];
        $dataName = $selectedItems[$i + 1];
        $quantity = $selectedItems[$i + 3];

        $sql_list_parcel = "INSERT INTO list_parcel_req (report_req_id, id_parcel,  qty)
                            VALUES ('$id_report_req_parcel', '$dataId', '$quantity')";
        mysqli_query($conn, $sql_list_parcel);
    }
    header("location: ./req_parcel_list?success=success");
    
        
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
            document.querySelector('a[name="req_parcel"]').classList.add('nav-link', 'active');
        });
        </script>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>ยืนยันการขอเบิก</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">ยืนยันการขอเบิก</li>
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
                                    <h3 class="card-title">ยืนยันการขอเบิก</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" action="" method="POST" enctype="multipart/form-data">
                                    <center>
                                        <p> <?php echo $name_title.$first_name .' '.$last_name?></p>
                                        <p><?php echo name_department($department) ?></p>
                                        <table border="1">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ลำดับที่</th>
                                                    <th class="text-center" width="400px">รายการ</th>
                                                    <th class="text-center">จำนวนที่จ้องการเบิก/หน่วยนับ</th>
                                                    <th class="text-center">รวมเป็นเงิน</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                // Assuming 'selectedItems' is an array with dataId, dataName, and availableQty
                                                $selectedItems = $_POST['selectedItems'];
                                            
                                                $countNum=1;
                                                if (is_array($selectedItems)) {
                                                    $count = count($selectedItems);
                                                    // ทำต่อไปตามที่ต้องการ
                                                } else {
                                                    $selectedItems = json_decode($_POST['selectedItems'], true);
                                                    $count = count($selectedItems);
                                                }
                                                for ($i = 0; $i < $count; $i += 4) {
                                                
                                                    $dataId = $selectedItems[$i];
                                                    $dataName = $selectedItems[$i + 1];
                                                    $availableQty = $selectedItems[$i + 2];
                                                    $quantity = $selectedItems[$i + 3];
                                                    echo '<tr>
                                                            <td class="text-center">' .$countNum . '</td>
                                                            <td > ' . $dataName . '</td>
                                                            <td class="text-center">' . $quantity  . ' ' . unit_parcel($dataId) . '</td>
                                                            <td class="text-center"></td>
                                                        </tr>';
                                                
                                                    $countNum++ ;
                                                }
                                            } else {

                                            }
                                            ?>
                                            <tbody>
                                        </table>
                                        <input type="hidden" name="selectedItems"
                                            value="<?php echo htmlspecialchars(json_encode($selectedItems)); ?>">
                                        <br><br>
                                        <div class="form-group">
                                            <p>-------------------------------------------------------------------------------------------------------------------------------
                                            </p>
                                        </div>

                                        <div class="form-group" id="my-form-group">
                                            <label for="signature-tech">ลายซ็น :</label> <br>

                                            <!-- radio buttons -->
                                            <input type="radio" name="signature-tech" id="option-with-image" value="1"
                                                required>
                                            <label for="option-with-image"
                                                style="font-weight: normal;">เลือกจากรูปภาพในเครื่อง</label><br>

                                            <input type="radio" name="signature-tech" id="option-without-image"
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

                                        <br>
                                        <a id="btn-back" class="btn btn-danger"
                                            style="margin-bottom: 10px;">ย้อนกลับ</a>
                                        <button type="submit" name="submit" class="btn btn-success"
                                            style="margin-bottom: 10px;">ยืนยัน</button>

                                    </center>
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