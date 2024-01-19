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
            const typeParcelNavItem = document.querySelector('a[name="qr"]')
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
                            <h1>Qr-code</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./index">Home</a></li>
                                <li class="breadcrumb-item active">Qr-code</li>
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
                            <label for="departmentFilter">เลือกแผนก:</label>
                            <select class="form-control" id="departmentFilter">
                                <option value="">ทั้งหมด</option>
                                <!-- เพิ่มตัวเลือกแผนกจากฐานข้อมูลหรือวงเล็บ PHP -->
                                <?php
                                            $sql_type_parcel = "SELECT * FROM type_parcel";
                                            $result_type_parcel = mysqli_query($conn, $sql_type_parcel);
                                            while ($row_type_parcel = mysqli_fetch_assoc($result_type_parcel)) {
                                                echo '<option value="' . $row_type_parcel['name'] . '">' . $row_type_parcel['name'] . '</option>';
                                            }
                                            ?>
                            </select>
                            <div class="form-group">
                                <label for="searchInput">ค้นหา:</label>
                                <input type="text" class="form-control" id="searchInput" placeholder="ค้นหา...">
                            </div>
                        </div>
                        <div class="form-group">
                            <form id="pdfForm" action="../pdf/GeneratePDFQr" method="post">
                                <div class="table-responsive">
                                    <table class="table table-striped projects">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    <input type="checkbox" name="select-all"> เลือกทั้งหมด
                                                </th>
                                                <th class="text-center">
                                                    หมวดหมู่พัสดุ
                                                </th>
                                                <th class="text-center">
                                                    ชื่อพัสดุ
                                                </th>
                                                <th class="text-center">
                                                    รุ่น
                                                </th>
                                                <th class="text-center">
                                                    ยี่ห้อ
                                                </th>
                                                <th class="text-center">
                                                    หน่วยนับ
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM parcel_data";
                                            $result = mysqli_query($conn, $sql);
                                            if ($result) {
                                            // วนลูปเพื่อแสดงข้อมูล
                                            while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<tr>';
                                            echo '<td class="text-center"><input type="checkbox" name="selectedIds[]" value="' . $row['id_parcel'] . '"></td>';
                                            echo '<td class="text-center">' . name_parcel($row['type']) . '</td>';
                                            echo '<td class="text-center">' . $row['name_parcel'] . '</td>';
                                            echo '<td class="text-center">' . $row['model'] . '</td>';
                                            echo '<td class="text-center">' . $row['brand'] . '</td>';         
                                            echo '<td class="text-center">' . name_unit($row['unit_num']) . '</td>';
                                            echo '</tr>';
                                            }
                                            } else {
                                            echo "ผิดพลาด: " . $sql . "<br>" . mysqli_error($conn);
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <button class="form-control btn btn-danger" id="resetBtn">Reset</button><br><br>
                                <button type="submit" class="form-control btn btn-primary">Generate PDF</button>
                            </form>
                            <iframe id="pdfIframe" name="pdfIframe" style="display: none;"></iframe>
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
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 10000;
}
</style>
</html>
<script>
    
$(document).ready(function() {
    // หาก Checkbox "เลือกทั้งหมด" ถูกคลิก
    $('input[name="select-all"]').click(function() {
        // ตรวจสอบว่า Checkbox "เลือกทั้งหมด" ถูกเลือกหรือไม่
        var isChecked = $(this).prop('checked');

        // ตั้งค่าการเลือก Checkbox ทั้งหมดในตารางที่มี style.display ไม่เป็น 'none'
        $('input[name="selectedIds[]"]:visible').prop('checked', isChecked);

        // อัปเดตจำนวนที่ถูกเลือกในปุ่ม Generate PDF
        updateSelectedCount();
    });

    // หากมีการคลิกที่ Checkbox ในตาราง
    $('input[name="selectedIds[]"]').click(function() {
        // ตรวจสอบว่า Checkbox ทั้งหมดถูกเลือกหรือไม่
        var selectAllChecked =
            $('input[name="selectedIds[]"]:visible:checked').length === $(
                'input[name="selectedIds[]"]:visible').length;

        // ตั้งค่า Checkbox "เลือกทั้งหมด" ตามผลการตรวจสอบ
        $('input[name="select-all"]').prop('checked', selectAllChecked);

        // อัปเดตจำนวนที่ถูกเลือกในปุ่ม Generate PDF
        updateSelectedCount();
    });

    // เพิ่ม event listener สำหรับปุ่ม Generate PDF
    $('button[type="submit"]').on('click', function(event) {
        event.preventDefault(); // ป้องกันการ submit ฟอร์ม
        showLoadingPopup(); // แสดง Popup ค้างไว้
        generatePDF(); // เรียกใช้ฟังก์ชั่น generatePDF
    });
    function showLoadingPopup() {
    $('#loadingPopup').modal('show');
}
function hideLoadingPopup() {
    $('#loadingPopup').modal('hide');
}
    // เพิ่ม event listener สำหรับปุ่ม Reset
    $('#resetBtn').on('click', function(event) {
        event.preventDefault(); // ป้องกันการ submit ฟอร์ม

        // รีเซ็ต checkbox ทั้งหมด
        $('input[name="selectedIds[]"]').prop('checked', false);

        // รีเซ็ต dropdown และ input ค้นหา
        $('#departmentFilter').val('');
        $('#searchInput').val('');

        // อัปเดตตารางโดยการเรียกฟังก์ชั่น filterTable
        filterTable();

        // อัปเดตจำนวนที่ถูกเลือกในปุ่ม Generate PDF
        updateSelectedCount();
    });


    // ฟังก์ชั่น generatePDF
    function generatePDF() {
    var selectedIds = [];

    // ถ้าไม่เลือก 'all', ดึงค่า checkbox ที่ถูกเลือกและส่งไปที่ PHP
    var checkboxes = $('input[name="selectedIds[]"]:checked');

    checkboxes.each(function() {
        selectedIds.push($(this).val());
    });

    // ส่งข้อมูลไปที่ PHP หรือทำอย่างอื่นตามที่คุณต้องการ
    document.getElementById('pdfForm').submit();
    
}

// เพิ่มเพื่อตรวจสอบสถานะ checkbox เมื่อหน้าเว็บโหลดเสร็จ
$(document).ready(function() {
    updateSelectedCountForPDFButton();
});

    // ฟังก์ชั่นกรองข้อมูล
    function filterTable() {
        // ดึงค่าที่ถูกเลือกจาก dropdown
        var selectedDepartment = $('#departmentFilter').val().toLowerCase();

        // ดึงค่าจาก input ค้นหา
        var searchText = $('#searchInput').val().toLowerCase();

        // เลือกตาราง
        var table = $('.table');

        // เลือกทุกรายการในตาราง
        var rows = table.find('tbody tr');

        // ล้างการเลือกทั้งหมดก่อน
        $('input[name="select-all"]').prop('checked', false);

        // วนลูปทุกรายการและซ่อน/แสดงตามเงื่อนไข
        rows.each(function() {
            var departmentCell = $(this).find('td:nth-child(2)').text().toLowerCase();
            var nameCell = $(this).find('td:nth-child(3)').text().toLowerCase();

            // ตรวจสอบเงื่อนไขและแสดงหรือซ่อนแถว
            if (
                (selectedDepartment === '' || departmentCell === selectedDepartment) &&
                (searchText === '' || nameCell.includes(searchText))
            ) {
                $(this).show();

                // ให้ checkbox เป็น visible ทั้งหมด
                $(this).find('input[name="selectedIds[]"]').css('visibility', 'visible');
            } else {
                $(this).hide();

                // ให้ checkbox เป็น hidden เมื่อแถวถูกซ่อน
                $(this).find('input[name="selectedIds[]"]').css('visibility', 'hidden');
            }
        });

        // ตรวจสอบว่า Checkbox "เลือกทั้งหมด" ควรถูกเลือกหรือไม่
        var visibleCheckboxes = $('input[name="selectedIds[]"]:visible');
        var visibleCheckedCheckboxes = $('input[name="selectedIds[]"]:visible:checked');
        var allVisibleCheckboxesChecked =
            visibleCheckboxes.length > 0 && visibleCheckboxes.length === visibleCheckedCheckboxes.length;

        // ตั้งค่า Checkbox "เลือกทั้งหมด" ตามผลการตรวจสอบ
        $('input[name="select-all"]').prop('checked', allVisibleCheckboxesChecked);

        // อัปเดตจำนวนที่ถูกเลือกในปุ่ม Generate PDF
        updateSelectedCount();
    }

    // ฟังก์ชั่นอัปเดตจำนวนที่ถูกเลือกในปุ่ม Generate PDF
    function updateSelectedCount() {
        var selectedCount = $('input[name="selectedIds[]"]:checked:visible').length;
        $('#selectedCount').text(selectedCount);

        // เรียกใช้งาน updateSelectedCount ทุกครั้งที่มีการเปลี่ยนแปลง checkbox
        // เพื่อให้จำนวนถูกต้องทุกครั้ง
        updateSelectedCountForPDFButton();
    }

    // ฟังก์ชั่นอัปเดตจำนวนที่ถูกเลือกในปุ่ม Generate PDF และปรับปุ่มตามจำนวนที่เลือก
    function updateSelectedCountForPDFButton() {
        var selectedCount = $('input[name="selectedIds[]"]:checked:visible').length;

        // ตรวจสอบว่ามี checkbox ที่ถูกเลือกหรือไม่
        if (selectedCount > 0) {
            $('button[type="submit"]').text('Generate PDF (' + selectedCount + ' selected)');
            $('button[type="submit"]').prop('disabled', false);
        } else {
            $('button[type="submit"]').text('Generate PDF');
            $('button[type="submit"]').prop('disabled', true);
        }
    }

    // เลือก element dropdown
    var departmentFilter = document.getElementById('departmentFilter');

    // เลือก input สำหรับค้นหา
    var searchInput = document.getElementById('searchInput');

    // เพิ่ม event listener เมื่อ dropdown มีการเปลี่ยนแปลง
    departmentFilter.addEventListener('change', function() {
        filterTable();
    });

    // เพิ่ม event listener เมื่อมีการพิมพ์ข้อมูลใน input ค้นหา
    searchInput.addEventListener('input', function() {
        filterTable();
    });
});
</script>

<?php
require '../popup/popup.php';

?>