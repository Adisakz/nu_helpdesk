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
$signature_sueccess = !empty($row1['signature_sueccess']) ? $row1['signature_sueccess'] : '';
$name_sueccess = !empty($row1['name_sueccess']) ? $row1['name_sueccess'] : '';

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
    $dataArray = json_decode($_POST['dataArrayInput'], true);
    $quantity = ($_POST['quantity']);
    $Option = $_POST['signature-tech'];
    $id_req_parcel = $_GET['id'] ;
    $id_person = $_SESSION['id'] ;
    if ($Option == 2) {
        ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: '<h4 class="t1"><strong>ลงนามผู้รับรอง</strong></h4>',
        html: '<center><div class="mb-3"><div class="mb-3"><label class="form-label" for="imp_sig"></label><div id="canvasDiv"></div><br><button type="button" class="btn btn-danger" id="reset-btn">Clear</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-success" id="btn-save">Save</button></div> <form id="signatureform" action="cheack_parcel?id=<?php echo $id_req_parcel; ?>" style="display:none" method="post"><input type="hidden" id="signature" name="signature"><input type="hidden" name="signaturesubmit" value="1"><input type="hidden" name="data1" value=\'<?php echo json_encode($dataArray); ?>\'><input type="hidden" name="data2" value=\'<?php echo json_encode($quantity); ?>\'></form></div></center>',
        confirmButtonText: '<div class="text t1">ออก</div>',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'cheack_req_parcel';
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
    
                foreach ($dataArray as $index => $item) {
                    $id_parcel = $item['id_parcel'];
                    $id_req_form = $item['id_req_form'];
                    $max = $item['max'];
                
                    // Retrieve the corresponding quantity from data2_array
                    $quantity1 = $quantity[$index];
         
                    if ($quantity1 == 0) {
                        // If quantity is 0, delete the record
                        $sql = "DELETE FROM list_parcel_req WHERE report_req_id=$id_req_form AND id_parcel = $id_parcel";
                    } else {
                        // If quantity is not 0, update the record
                        $sql = "UPDATE list_parcel_req SET qty=$quantity1 WHERE report_req_id=$id_req_form AND id_parcel = $id_parcel";
                    }
                    mysqli_query($conn, $sql);
                }
                $sql1 = "UPDATE report_req_parcel SET signature_parcel='$resized_img_name', id_parcel='$id_person' , status='2' WHERE id=$id_req_parcel";
                mysqli_query($conn, $sql1);
                header("location: ./cheack_req_parcel?success=success");

                
            } else {
                // ทำการบันทึกไฟล์ที่ไม่ต้อง resize
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $dir = '../image_signature/' . $new_img_name;
                move_uploaded_file($tmp_name, $dir);
    
                foreach ($dataArray as $index => $item) {
                    $id_parcel = $item['id_parcel'];
                    $id_req_form = $item['id_req_form'];
                    $max = $item['max'];
                
                    // Retrieve the corresponding quantity from data2_array
                    $quantity1 = $quantity[$index];
         
                    if ($quantity1 == 0) {
                        // If quantity is 0, delete the record
                        $sql = "DELETE FROM list_parcel_req WHERE report_req_id=$id_req_form AND id_parcel = $id_parcel";
                    } else {
                        // If quantity is not 0, update the record
                        $sql = "UPDATE list_parcel_req SET qty=$quantity1 WHERE report_req_id=$id_req_form AND id_parcel = $id_parcel";
                    }
                    mysqli_query($conn, $sql);
                }
                $sql1 = "UPDATE report_req_parcel SET signature_parcel='$new_img_name', id_parcel='$id_person' , status='2' WHERE id=$id_req_parcel";
                mysqli_query($conn, $sql1);
                header("location: ./cheack_req_parcel?success=success");
            }
        } else {
          echo "สกุลไม่ถูกต้อง";
          header("location: ./cheack_req_parcel?error=error");
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
    
  
        $data1_array = json_decode($_POST['data1'], true);
        $data2_array = json_decode($_POST['data2'], true); 
        $id_person = $_SESSION['id'] ;
        $id_req_form_value = null;
        foreach ($data1_array as $index => $item) {
            $id_parcel = $item['id_parcel'];
            $id_req_form = $item['id_req_form'];
            $max = $item['max'];
        
            // Retrieve the corresponding quantity from data2_array
            $quantity = $data2_array[$index];
            $id_req_form_value = $id_req_form;
 
            if ($quantity == 0) {
                // If quantity is 0, delete the record
                $sql = "DELETE FROM list_parcel_req WHERE report_req_id=$id_req_form AND id_parcel = $id_parcel";
            } else {
                // If quantity is not 0, update the record
                $sql = "UPDATE list_parcel_req SET qty=$quantity WHERE report_req_id=$id_req_form AND id_parcel = $id_parcel";
            }
            mysqli_query($conn, $sql);
        }
        $sql1 = "UPDATE report_req_parcel SET signature_parcel='$signatureFileName', id_parcel='$id_person' , status='2' WHERE id=$id_req_form_value";
        mysqli_query($conn, $sql1);
        header("location: ./cheack_req_parcel?success=success");
          
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
            document.querySelector('a[name="check-req-parcecl"]').classList.add('nav-link', 'active');
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
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <table border="1">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ลำดับที่</th>
                                                    <th class="text-center" width="400px">รายการ</th>
                                                    <th class="text-center">จำนวนที่ต้องการเบิก/หน่วยนับ</th>
                                                    <th class="text-center">จำนวนที่ให้เบิก</th>
                                                    <th class="text-center">รวมเป็นเงิน</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                   $sql_req = "SELECT * FROM list_parcel_req WHERE report_req_id = '$id_req_parcel'";
                                                   $result_req = mysqli_query($conn, $sql_req);
                                                   $dataArray = [];
                                                   $countNum = 1;
                                                   while ($row = mysqli_fetch_assoc($result_req)) {
                                                       echo '<tr>
                                                               <td class="text-center">' . $countNum . '</td>
                                                               <td > ' . name_parcel($row['id_parcel']) . '</td>
                                                               <td class="text-center">' . $row['qty'] . ' ' . unit_parcel($row['id_parcel']) . '</td>
                                                               <td class="text-center"><input type="number" name="quantity[]" class="quantity" value="' . $row['qty'] . '" style="width: 50px; text-align: center; margin-left: auto;" min="0" max="' . $row['qty'] . '"></td>
                                                               <td class="text-center"></td>
                                                             </tr>';
                                                   
                                                             $dataArray[] = [
                                                                'id_parcel' => $row['id_parcel'],
                                                                'id_req_form' => $id_req_parcel,
                                                                'max' => $row['qty'],
                                                      
                                                            ];
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
                                                            <?php echo "ลงชื่อ ..........................................."?>
                                                        </p>
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
                                                            <?php echo "ลงชื่อ ..........................................."?>
                                                        </p>
                                                        <p style="margin-top: -20px;">
                                                            <?php echo "( ". name_person($signature_sueccess). " )"?>
                                                        </p>
                                                        <?php else: ?>
                                                        <!-- ไม่พบภาพ -->
                                                        <div style="height:100px"></div>
                                                        <p style="margin-top: -25px;">
                                                            <?php echo "ลงชื่อ ..........................................."?>
                                                        </p>
                                                        <p style="margin-top: -20px;">
                                                            <?php echo "( ". name_person($signature_sueccess). " )"?>
                                                        </p>
                                                        <?php endif; ?>


                                                    </center>
                                                </td>
                                                <td colspan="2">
                                                    <label for="signature-tech"
                                                        style="margin-top: 20px;">ผู้อนุมัติจ่ายพัสดุ :
                                                        <span
                                                            style="font-weight: normal;">หัวหน้าเจ้าหน้าที่/หัวหน้าพัสดุ</span>
                                                    </label>
                                                    <center>
                                                        <?php if ($signature_parcel_head): ?>
                                                        <img src="../image_signature/<?php echo $signature_parcel_head; ?>"
                                                            alt="signature_req" width="100px" height="100px"
                                                            style="margin-top: -20px;">
                                                        <p style="margin-top: -25px;">
                                                            <?php echo "ลงชื่อ ..........................................."?>
                                                        </p>
                                                        <p style="margin-top: -20px;">
                                                            <?php echo "( ". name_person($id_parcel_head). " )"?></p>
                                                        <?php else: ?>
                                                        <!-- ไม่พบภาพ -->
                                                        <div style="height:75px;"></div>
                                                        <p style="margin-top: -25px;">
                                                            <?php echo "ลงชื่อ ..........................................."?>
                                                        </p>
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
                                        <br><br>
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
                                        <div class="card-footer">

                                            <center>
                                                <input type="hidden" id="dataArrayInput" name="dataArrayInput"
                                                    value="<?php echo htmlspecialchars(json_encode($dataArray)); ?>">

                                                    <a class="btn btn-danger btn-sm" href="#" onclick="showRejectionReasonPrompt(<?php echo $id_req_parcel; ?>)">ไม่อนุมัติ</a>
                                                <button type="submit" name="submit" class="btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i>อนุมัติ</button>
                                            </center>

                                        </div>


                                    </form>
                                </center>

                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                        <!-- right column -->

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
function showRejectionReasonPrompt(idToSend) {
        Swal.fire({
            title: 'กรุณากรอกเหตุผลที่ไม่อนุมัติ',
            input: 'textarea',
            inputPlaceholder: 'เหตุผล...',
            showCancelButton: true,
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ยืนยันไม่อนุมัติ',
            preConfirm: (reason) => {
                // Handle the rejection reason here
                if (!reason) {
                    Swal.showValidationMessage('กรุณากรอกเหตุผล');
                } else {
                    // Use AJAX to save the rejection reason and the ID to your database
                    saveRejectionReason(idToSend, reason);
                }
            },
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                // If the rejection reason is saved successfully, submit the form
                document.getElementById('myForm').submit();
            }
        });
    }

    function saveRejectionReason(id, reason) {
        // Use AJAX to send the ID and reason to your server-side script for saving in the database
        // Adjust the URL and data accordingly
        $.ajax({
            url: './controller/save_cancel_req',
            type: 'POST',
            data: {
                id: id,
                reason: reason,
                // You can include additional data if needed
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกเรียบร้อย',
                    }).then(() => {
                        // Redirect to cheack_req_parcel after clicking OK
                        window.location.href = './cheack_req_parcel';
                    });
                } else {
                    Swal.fire('เกิดข้อผิดพลาดในการบันทึก', '', 'error');
                }
            },
            error: function () {
                Swal.fire('เกิดข้อผิดพลาดในการส่งข้อมูล', '', 'error');
            }
        });
    }
</script>
<?php require '../popup/popup.php'; ?>
<script src="../dist/js/canvas.js"></script>