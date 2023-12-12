<?php 
session_start();
error_reporting(E_ERROR | E_PARSE);
require_once '../dbconfig.php';

$id_asset = urldecode($_GET['id']);
$sql = "SELECT * FROM durable_articles WHERE asset_id = '$id_asset'";
$result = mysqli_query($conn, $sql); 
$row = mysqli_fetch_assoc($result);

$type_durable = $row['type_durable'];
$department_durable = $row['department'];
$asset_id = $row['asset_id'];
$name_asset = $row['name'];
$building = $row['building'];
$room_number = $row['room_number'];
$model = $row['model'];
$brand = $row['brand'];
$image = $row['image_asset'];

$sql_status = "SELECT status FROM durable_check WHERE asset_id = '$id_asset' ORDER BY date_update DESC LIMIT 1";
$result_status = mysqli_query($conn, $sql_status);

// ตรวจสอบว่ามีข้อมูลหรือไม่
if ($result_status) {
    $row_status = mysqli_fetch_assoc($result_status);

    // ตรวจสอบว่ามี status หรือไม่
    $status = isset($row_status['status']) ? $row_status['status'] : 'N/A';
} else {
    // กรณีไม่มีผลลัพธ์
    $status = 'N/A';
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
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
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
                                <form id="quickForm" action="tech" method="post">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- ส่วนซ้าย -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="staticEmail"
                                                            class="col-sm-4 col-form-label">หมวดหมู่ครุภัณฑ์</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="<?php echo htmlspecialchars($type_durable); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="staticEmail"
                                                            class="col-sm-4 col-form-label">แผนกผู้รับผิดชอบ</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="<?php echo htmlspecialchars($department_durable); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="staticEmail"
                                                            class="col-sm-4 col-form-label">เลขที่ครุภัณฑ์</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="<?php echo htmlspecialchars($asset_id); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="staticEmail"
                                                            class="col-sm-4 col-form-label">ชื่อครุภัณฑ์</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="<?php echo htmlspecialchars($name_asset); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="brand"
                                                            class="col-sm-4 col-form-label">ยี่ห้อ</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="brand"
                                                                value="<?php echo htmlspecialchars($brand); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="staticEmail"
                                                            class="col-sm-4 col-form-label">รุ่น</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="<?php echo htmlspecialchars($model); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="staticEmail"
                                                            class="col-sm-4 col-form-label">อาคาร</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="<?php echo htmlspecialchars($building); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="staticEmail"
                                                            class="col-sm-4 col-form-label">ห้อง</label></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                value="<?php echo htmlspecialchars($room_number); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="mb-3 row">
                                                        <label for="staticEmail"
                                                            class="col-sm-4 col-form-label">สถานะ</label></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                                id="staticEmail"
                                                                style="color: <?php echo getStatusColor($status); ?>;"
                                                                value="<?php echo htmlspecialchars($status); ?>">
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
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- เพิ่มการ์ดหัวข้อ -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">ข้อมูลการตรวจสอบครุภัณฑ์</h3>
                                </div>
                                <div class="card-body">
                                    <!-- ส่วนที่ต้องการแสดงข้อมูล durable_check -->
                                    <?php
                                    $sqlCount = "SELECT COUNT(*) AS total FROM durable_check WHERE asset_id = '$id_asset' AND status !=''";
                                    $resultCount = mysqli_query($conn, $sqlCount);
                                    $totalRecords = mysqli_fetch_assoc($resultCount)['total'];
                                    // กำหนดจำนวนรายการต่อหน้า
                                    $recordsPerPage = 3;
                     
                                    // รับค่าหน้าปัจจุบัน
                                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                     
                                    // คำนวณ offset สำหรับคำสั่ง SQL
                                    $offset = ($page - 1) * $recordsPerPage;
                     
                                    // คำสั่ง SQL สำหรับดึงข้อมูลพร้อมกับการใช้ LIMIT
                                    $sql_check = "SELECT * FROM durable_check WHERE asset_id = '$id_asset' AND status !='' ORDER BY date_update DESC LIMIT $offset, $recordsPerPage";
                                    $result_check = mysqli_query($conn, $sql_check);

                                    if (mysqli_num_rows($result_check) > 0) {
                                    // ทำการ loop และแสดงข้อมูล
                                    while ($row_check = mysqli_fetch_assoc($result_check)) {
                                        // ในแต่ละรอบของลูป ให้แสดงข้อมูลดังนี้
                                        ?>
                                    <div class="form-group">
                                        <div class="mb-3 row">
                                            <label for="staticEmail" class="col-sm-4 col-form-label">สถานะ</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control-plaintext"
                                                    id="staticEmail"
                                                    style="color: <?php echo getStatusColor($row_check['status']); ?>;"
                                                    value="<?php echo htmlspecialchars($row_check['status']); ?>">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="mb-3 row">
                                            <label for="staticEmail" class="col-sm-4 col-form-label">ตรวจสอบโดย</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control-plaintext"
                                                    id="staticEmail" value="<?php echo$row_check['name_check']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="mb-3 row">
                                            <label for="staticEmail"
                                                class="col-sm-4 col-form-label">รายละเอียดการตรวจสอบ</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control-plaintext"
                                                    id="staticEmail"
                                                    value="<?php echo htmlspecialchars($row_check['detail_check']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="mb-3 row">
                                            <label for="staticEmail"
                                                class="col-sm-4 col-form-label">วันที่ตรวจสอบ</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control-plaintext"
                                                    id="staticEmail"
                                                    value="<?php echo date('d', strtotime($row_check['date_update'])) . ' ' . thaiMonth(date('m', strtotime($row_check['date_update']))) . ' ' . (date('Y', strtotime($row_check['date_update'])) + 543) . ' || ' . date('H:i', strtotime($row_check['date_update'])); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        ___
                                    </div>
                                    <?php
}
                                    }else {
                                        // ไม่มีข้อมูล
                                        ?>
                                        <div class="form-group">
                                            <div class="mb-3 row">
                                                <div class="col-sm-12">
                                                    <p style="color: red;">ไม่มีการตรวจเช็ค</p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
?>
                                    <div class="card-footer">
                                        <nav aria-label="Contacts Page Navigation">
                                            <ul class="pagination justify-content-center m-0">
                                                <?php
                                                    // คำนวณจำนวนหน้าทั้งหมด
                                                    $totalPages = ceil($totalRecords / $recordsPerPage);

                                                    // แสดงปุ่ม Pagination
                                                    for ($i = 1; $i <= $totalPages; $i++) {
                                                        $activeClass = ($page == $i) ? 'active' : '';
                                                        echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?id='.$id_asset.'&page=' . $i . '">' . $i . '</a></li>';
                                                    }
                                                    ?>
                                            </ul>
                                        </nav>
                                    </div>
                                    <!-- สิ้นสุดส่วนที่ให้แสดงข้อมูล durable_check -->
                                </div>
                            </div>
                            <!-- /.card -->

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