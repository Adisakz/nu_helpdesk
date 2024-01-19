<?php 
session_start();
require_once '../dbconfig.php';

///////////  แสดงชื่อหมวดหมู่พัสดุ
function name_parcel($id) {
    global $conn; // Assuming $conn is your database connection variable

    $sql_parcel = "SELECT name FROM type_parcel WHERE id = '$id' LIMIT 1";
    $result_parcel = mysqli_query($conn, $sql_parcel);

    if ($row_parcel = mysqli_fetch_assoc($result_parcel)) {
        $parcel = $row_parcel['name'];
        return $parcel;
    } else {
        $parcel = '';
        return $parcel;
    }
}

///////////  แสดงชื่อหมวดหมู่พัสดุ
function name_unit($id) {
    global $conn; // Assuming $conn is your database connection variable

    $sql_parcel = "SELECT name FROM unit_parcel WHERE id = '$id' LIMIT 1";
    $result_parcel = mysqli_query($conn, $sql_parcel);

    if ($row_parcel = mysqli_fetch_assoc($result_parcel)) {
        $parcel = $row_parcel['name'];
        return $parcel;
    } else {
        $parcel = '';
        return $parcel;
    }
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<style>
.table-responsive {
    overflow-y: auto;
    max-height: 500px;
    /* ตั้งค่าความสูงสูงสุดของ div ที่มี scrollbar */
}
</style>

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
        document.addEventListener('DOMContentLoaded', function() {
            const typeParcelNavItem = document.querySelector('a[name="report"]')
            const parcelLink = document.querySelector('li[name="print"]');
            const parcelLinkActive = document.querySelector('a[name="print-option"]');

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
                            <h1>ออกรายงานการแจ้งซ่อม</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./index">Home</a></li>
                                <li class="breadcrumb-item active">ออกรายงานการแจ้งซ่อม</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="card">
                    <div class="card-body p-0" style="margin: 10px 10px 0 10px;">
                        <div class="form-group">
                            <form action="../pdf/GeneratePDFreport" method="post" class="text-center"  id="reportForm">
                                <h4>กรุณาเลือกวันที่เริ่มต้นและสิ้นสุด</h4>
                                <label for="start_date">วันที่เริ่มต้น:</label>
                                <input type="date" id="start_date" name="start_date" required>

                                <label for="end_date">วันที่สิ้นสุด:</label>
                                <input type="date" id="end_date" name="end_date" required>

                                <!-- input เพื่อเก็บค่าวันที่ที่เลือก -->
                                <input type="hidden" id="selected_dates" name="selected_dates" value=""><br><br>

                                <button type="button" class="form-control btn btn-danger"
                                    id="resetBtn">รีเซ็ต</button><br><br>
                                <button type="submit" class="form-control btn btn-primary" id="generatePdfBtn" disabled>
                                    สร้างรายงาน PDF
                                </button>
                            </form>

                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        <!-- /.navbar -->
        <?php include './footer/footer.php' ;?>
        <!-- /.navbar -->

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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</body>
<!-- เพิ่ม div สำหรับหน้าต่าง loading -->
<div id="loadingPopup" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>Loading...</p>
            </div>
        </div>
    </div>
</div>

<style>
    #loadingPopup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* สีพื้นหลังสีเทา */
        justify-content: center;
        align-items: center;
        z-index: 10000;
    }

</style>

</html>
<script>
function showLoadingPopup() {
    $('#loadingPopup').show();
}

function hideLoadingPopup() {
    $('#loadingPopup').hide();
}
$(document).ready(function() {
    const startDateInput = $('#start_date');
    const endDateInput = $('#end_date');
    const generatePdfBtn = $('#generatePdfBtn');
    const selectedDatesInput = $('#selected_dates');
    const resetBtn = $('#resetBtn');

    // เพิ่ม event listener เมื่อมีการเลือกวันที่
    startDateInput.on('input', updateGeneratePdfBtn);
    endDateInput.on('input', updateGeneratePdfBtn);

    // เพิ่ม event listener เมื่อคลิกที่ปุ่ม Reset
    resetBtn.on('click', function() {
        startDateInput.val(''); // ล้างค่าวันที่เริ่มต้น
        endDateInput.val(''); // ล้างค่าวันที่สิ้นสุด
        generatePdfBtn.prop('disabled', true).addClass('disabled-btn');
        selectedDatesInput.val('');
    });

    // ฟังก์ชั่นอัปเดตปุ่ม Generate PDF
    function updateGeneratePdfBtn() {
        const startDate = startDateInput.val();
        const endDate = endDateInput.val();
      
        // ตรวจสอบว่ามีการเลือกวันที่เริ่มและสิ้นสุดหรือไม่
        if (startDate && endDate) {
            generatePdfBtn.prop('disabled', false).removeClass('disabled-btn').addClass('btn-primary');
            selectedDatesInput.val(startDate + ',' + endDate);
        } else {
            generatePdfBtn.prop('disabled', true).addClass('disabled-btn');
            selectedDatesInput.val('');
        }
    }

    // เพิ่ม event listener เมื่อ submit ฟอร์ม
    $('#reportForm').on('submit', function(event) {
        showLoadingPopup(); 
        const startDate = startDateInput.val();
        const endDate = endDateInput.val();
        // ตรวจสอบว่ามีการเลือกวันที่เริ่มและสิ้นสุดหรือไม่
        if (!startDate || !endDate) {
            event.preventDefault(); // ป้องกันการ submit ฟอร์ม
            alert('กรุณาเลือกวันที่เริ่มและสิ้นสุดก่อนที่จะสร้างรายงาน PDF');
        } 
    });
});
</script>

<?php
require '../popup/popup.php';

?>