<?php 
session_start();
error_reporting(E_ERROR | E_PARSE);
require_once '../dbconfig.php';

$id_asset = urldecode($_GET['id']);
$sql = "SELECT * FROM durable_articles WHERE asset_id = '$id_asset'";
$result = mysqli_query($conn, $sql); 
$row = mysqli_fetch_assoc($result);
$type_durable = $row['type_durable'];
$department_id = $row['department'];
$asset_id = $row['asset_id'];
$name_asset = $row['name'];
$building = $row['building'];
$room_number = $row['room_number'];
$model = $row['model'];
$brand = $row['brand'];
$year = $row['year'];

$price = $row['price'];
$image = $row['image_asset'];

$department = $row['department'];
$sql_department = "SELECT name FROM department WHERE id_department = ' $department_id' LIMIT 1";
$result_department = mysqli_query($conn, $sql_department);
if ($row_department = mysqli_fetch_assoc($result_department)) {
    $department_durable = $row_department['name'] ;
} else {
    $department_durable = '';
}                                                               



$sql_service = "SELECT date_report_in FROM repair_report_pd05 WHERE asset_id = '$id_asset' AND type = 'service' AND status = '3' ORDER BY date_report_in DESC LIMIT 1";
$result_service = mysqli_query($conn, $sql_service);
                      
if ($result_service && $row_service = mysqli_fetch_assoc($result_service)) {
    $date_service = date('d', strtotime($row_service['date_report_in'])) . ' ' . thaiMonth(date('m', strtotime($row_service['date_report_in']))) . ' ' . (date('Y', strtotime($row_service['date_report_in'])) + 543) . ' || ' . date('H:i', strtotime($row_service['date_report_in']));
} else {
    $date_service = 'N/A';
}

$sql_check = "SELECT date_report_in FROM repair_report_pd05 WHERE asset_id = '$id_asset' AND type = 'ซ่อม' AND status = '3' ORDER BY date_report_in DESC LIMIT 1";
$result_check = mysqli_query($conn, $sql_check);
if ($result_check && $row_check = mysqli_fetch_assoc($result_check)) {
    $date_repair = date('d', strtotime($row_check['date_report_in'])) . ' ' . thaiMonth(date('m', strtotime($row_check['date_report_in']))) . ' ' . (date('Y', strtotime($row_check['date_report_in'])) + 543) . ' || ' . date('H:i', strtotime($row_check['date_report_in']));
} else {
    $date_repair = 'N/A';
}


function getStatusText($status) {
    if ($status == 0) {
        $style = 'style="background-color: #ffc107; border-color: #FFC107; box-shadow: 0px 0px 4px 1px #FFC107; padding: 4px 8px; border-radius: 4px; color: #000;"';
        return '<span ' . $style .  ' >รอซ่อม</span>';
    } else if ($status == 1){
        $style = 'style="background-color: #007bff; border-color: #007bff; box-shadow: 0px 0px 4px 1px #007bff; padding: 4px 8px; border-radius: 4px; color: #000;"';
        return '<span ' . $style . '  class="text-white">กำลังซ่อม</span>';
    }
    else if ($status == 2){
      $style = 'style="background-color: #dc3545; border-color: #dc3545; box-shadow: 0px 0px 4px 1px #dc3545; padding: 4px 8px; border-radius: 4px; color: #000;"';
      return '<span ' . $style . '  class="text-white">ยกเลิกการซ่อม</span>';
    }
    else if ($status == 3){
      $style = 'style="background-color: #28a745; border-color: #28a745; box-shadow: 0px 0px 4px 1px #28a745; padding: 4px 8px; border-radius: 4px; color: #000;"';
      return '<span ' . $style . '  class="text-white">ซ่อมเสร็จ</span>';
    }
    else if ($status == 4){
      $style = 'style="background-color: #007bff; border-color: #007bff; box-shadow: 0px 0px 4px 1px #007bff; padding: 4px 8px; border-radius: 4px; color: #000;"';
      return '<span ' . $style . '  class="text-white">รออนุมัติ</span>';
    }
  }


function getStatusColor($status) {
    switch ($status) {
        case 'ชำรุด':
            return 'red';
        case 'พร้อมใช้งาน':
            return 'green';
        // เพิ่มเงื่อนไขสถานะเพิ่มเติมตามต้องการ
        default:
            return 'black';
    }
}



function thaiMonth($month) {
    $months = array(
        '01' => 'ม.ค.',
        '02' => 'ก.พ.',
        '03' => 'มี.ค.',
        '04' => 'เม.ย.',
        '05' => 'พ.ค.',
        '06' => 'มิ.ย.',
        '07' => 'ก.ค.',
        '08' => 'ส.ค.',
        '09' => 'ก.ย.',
        '10' => 'ต.ค.',
        '11' => 'พ.ย.',
        '12' => 'ธ.ค.'
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
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

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
            document.querySelector('a[name="parcel"]').classList.add('nav-link', 'active');
        });
        </script>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>แสดง - ครุภัณฑ์</h1>
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
                                    <h3 class="card-title">ข้อมูลครุภัณฑ์</h3>
                                </div>
                                <!-- /.card-header -->

                                <!-- form start -->
                                <form id="quickForm" action="./controller/edit_asset" method="POST"
                                    enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- ส่วนซ้าย -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="type-durable"
                                                            class="col-sm-4 col-form-label">หมวดหมู่ครุภัณฑ์</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext"
                                                                id="type-durable"
                                                                value="<?php echo ($type_durable); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="department-durable"
                                                            class="col-sm-4 col-form-label">แผนกผู้รับผิดชอบ</label>
                                                        <div class="col-sm-8">

                                                            <input type="text" class="form-control-plaintext"
                                                                id="department-durable"
                                                                value="<?php echo ($department_durable); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="asset-id"
                                                            class="col-sm-4 col-form-label">เลขที่ครุภัณฑ์</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" name="asset-id-new"
                                                                id="asset-id-new" value="<?php echo ($asset_id); ?>">
                                                            <input type="text" class="form-control" name="id" id="id"
                                                                value="<?php echo ($_GET['id_durable']);  ?>" hidden>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="name-asset"
                                                            class="col-sm-4 col-form-label">ชื่อครุภัณฑ์</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="name-asset"
                                                                name="name-asset" value="<?php echo ($name_asset); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="brand"
                                                            class="col-sm-4 col-form-label">ยี่ห้อ</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="brand"
                                                                name="brand" value="<?php echo ($brand); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="model" class="col-sm-4 col-form-label">รุ่น</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="model"
                                                                name="model" value="<?php echo ($model); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="building"
                                                            class="col-sm-4 col-form-label">อาคาร</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="building"
                                                                name="building" value="<?php echo ($building); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="room-number"
                                                            class="col-sm-4 col-form-label">ห้อง</label></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="room-number"
                                                                name="room-number"
                                                                value="<?php echo ($room_number); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="year"
                                                            class="col-sm-4 col-form-label">ปีที่ซื้อ</label></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="year"
                                                                name="year"
                                                                value="<?php echo  (isset($year) ? ($year + 543) : '') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="price"
                                                            class="col-sm-4 col-form-label">ราคา(บาท)</label></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="price"
                                                                name="price" value="<?php echo ($price); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="service-date" class="col-sm-4 col-form-label">Service
                                                            ล่าสุด</label></label>
                                                        <div class="col-sm-8">
                                                            <p><?php echo ($date_service); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="repair-date"
                                                            class="col-sm-4 col-form-label">ซ่อมล่าสุด</label></label>
                                                        <div class="col-sm-8">
                                                        <p><?php echo ($date_repair); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ส่วนขวา -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <img src="../image_asset/<?php echo $image; ?>" alt="signature_tech"
                                                        width="400px">
                                                    <!-- เพิ่ม input fields อื่น ๆ ที่ต้องการแสดงทางขวา -->
                                                </div>
                                                <div class="form-group">
                                                    <label for="image">อัพโหลดรูปภาพครุภัณฑ์ : </label>
                                                    <input type="file" class="form-control" id="image-signature-report"
                                                        name="image-asset">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div aria-label="Contacts Page Navigation">
                                            <button type="submit" name="submit" class="btn btn-success">บันทึก</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <!-- เพิ่มการ์ดหัวข้อ -->

                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">รายการ ซ่อม/service ครุภัณฑ์</h3>
                                </div>
                                <div class="card-body p-0" style="margin: 10px 10px 0 10px;">
                                    <table class="table table-striped projects" cellspacing="0" width="100%"
                                        id="dtBasicExample">

                                        <thead>
                                            <tr>
                                                <th class="text-center" width="120px">
                                                    #
                                                </th>
                                                <th class="text-center" width="120px">
                                                    ประเภทการแจ้ง
                                                </th>
                                                <th class="text-center" width="300px">
                                                    สภาพการชำรุด
                                                </th>
                                                <th class="text-center" width="150px">
                                                    ผู้แจ้ง
                                                </th>
                                                <th class="text-center" width="150px">
                                                    วันที่ดำเนินการ
                                                </th>
                                                <th class="text-center" width="150px">
                                                    สถานะ
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
                                            <?php 
                                                    $sql = "SELECT * FROM repair_report_pd05 WHERE asset_id = '$id_asset'";
                                                    $result = mysqli_query($conn, $sql); 
                                                
                                                    if ($result) {
                                                        // วนลูปเพื่อแสดงข้อมูล
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<tr>';
                                                        echo '<td class="text-center">' . $row['id_repair'] . '</td>';
                                                        echo '<td class="text-center">' . $row['type'] . '</td>';
                                                        echo '<td class="text-center">' . $row['asset_detail'] . '</td>';
                                                        echo '<td class="text-center">' . $row['report_name'] . '</td>';
                                                        echo '<td class="text-center">' . date('d', strtotime($row['date_report_in'])) . ' ' . thaiMonth(date('m', strtotime($row['date_report_in']))) . ' ' . (date('Y', strtotime($row['date_report_in'])) + 543) . ' || ' . date('H:i', strtotime($row['date_report_in'])) . '</td>';
                                                        echo '<td class="text-center">' . getStatusText($row['status']) . '</td>';
                                                        echo '</tr>';
                                                    }
                                                    } else {
                                                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                                                    }

                                                    // ปิดการเชื่อมต่อ
                                                    mysqli_close($conn);
                                                
                                                    ?>
                                        </tbody>
                                    </table>

                                </div>

                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                        </div>
                        <!-- /.card -->


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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</body>

</html>
<style>
.form-group img {
    width: 100%;
    /* กำหนดให้รูปภาพเต็มความกว้างของพื้นที่ที่รูปภาพอยู่ */
    max-width: 400px;
    /* กำหนดความกว้างสูงสุดเพื่อไม่ให้รูปภาพมีขนาดใหญ่เกินไป */
    height: auto;
    /* ให้ความสูงปรับตามอัตราส่วนของรูปภาพ */
    display: block;
    /* แสดงรูปภาพเป็น block element เพื่อให้ขยับไปอยู่บนบรรทัดใหม่ */
    margin: 0 auto;
    /* กำหนดให้รูปภาพอยู่ตรงกลาง */
}

/* Media Query เมื่อขนาดหน้าจอเล็กกว่าหรือเท่ากับ 767px (tablet และมือถือ) */
@media (max-width: 767px) {
    .form-group img {
        max-width: 100%;
        /* กำหนดให้รูปภาพเต็มความกว้างของพื้นที่ที่รูปภาพอยู่ */
    }
}
</style>
<script>
$(document).ready(function() {
    $('#dtBasicExample').DataTable({
        "order": [
            [4, "desc"]
        ] // Assuming the date column is at index 4, change it if needed
    });
    $('.dataTables_length').addClass('bs-select');
});
</script>