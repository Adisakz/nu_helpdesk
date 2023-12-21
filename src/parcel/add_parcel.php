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
</head>

<body class="hold-transition sidebar-mini custom-body">
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
            const typeParcelNavItem = document.querySelector('a[name="add_parcel"]')
            const parcelLink = document.querySelector('li[name="parcel"]');
            const parcelLinkActive = document.querySelector('a[name="parcel-head"]');

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
                            <h1>ข้อมูลพัสดุ</h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./index">Home</a></li>
                                <li class="breadcrumb-item active">ข้อมูลพัสดุ</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">พัสดุ</h3>
                        <a class="btn btn-success btn-sm" href="#" style=" margin-left: 10px ;margin-right: auto; "
                            id="add_parcel"><i class="fas fa-plus"></i>Add</a>
                        <!-- Dropdown for selecting category -->
                        <div class="float-right" style="margin-right: 10px;">
                            <select class="form-control" id="categoryFilter">
                                <option value="">ทั้งหมด</option>
                                <!-- เพิ่มตัวเลือกแผนกจากฐานข้อมูลหรือวงเล็บ PHP -->
                                <?php
                                                $sql_departments = "SELECT * FROM type_parcel";
                                                $result_departments = mysqli_query($conn, $sql_departments);
                                                 while ($row_department = mysqli_fetch_assoc($result_departments)) {
                                                    echo '<option value="' . $row_department['name'] . '">' . $row_department['name'] . '</option>';
                                                }
                                                ?>
                            </select>
                        </div>
                        <!-- ช่องค้นหา -->
                        <div class="float-right">
                            <input type="text" class="form-control" id="searchInput" placeholder="ค้นหา...">
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-striped projects">
                                <thead>
                                    <tr>
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
                                       <!-- /.card-header  <th class="text-center" width="70px">
                                            Qr code
                                        </th> -->
                                        <th class="text-center" width="300px">

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                    $sqlCount = "SELECT COUNT(*) AS total FROM parcel_data";
                    $resultCount = mysqli_query($conn, $sqlCount);
                    $totalRecords = mysqli_fetch_assoc($resultCount)['total'];
                    // กำหนดจำนวนรายการต่อหน้า
                    $recordsPerPage = 5;

                    // รับค่าหน้าปัจจุบัน
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                    // คำนวณ offset สำหรับคำสั่ง SQL
                    $offset = ($page - 1) * $recordsPerPage;

                    // คำสั่ง SQL สำหรับดึงข้อมูลพร้อมกับการใช้ LIMIT
                    $sql = "SELECT * FROM parcel_data LIMIT $offset, $recordsPerPage";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        // วนลูปเพื่อแสดงข้อมูล
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td class="text-center">' . name_parcel($row['type']) . '</td>';
                            echo '<td class="text-center">' . $row['name_parcel'] . '</td>';
                            echo '<td class="text-center">' . $row['model'] . '</td>';
                            echo '<td class="text-center">' . $row['brand'] . '</td>';         
                            echo '<td class="text-center">' . name_unit($row['unit_num']) . '</td>';
                            //echo '<td class="text-center"><img src="https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl='. $row['id_parcel'] .'" alt="" style="100%"></td>';
                            echo '<td class="project-actions text-right">';
                            echo '<a class="btn btn-danger btn-sm del-type-repair" href="#" data-id="' . $row['id_parcel'] ."-". $row['name_parcel'] . '" onclick="deleteParcel(this)"><i class="fas fa-trash"></i> Delete</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo "ผิดพลาด: " . $sql . "<br>" . mysqli_error($conn);
                    }
                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <?php
                    // คำนวณจำนวนหน้าทั้งหมด
                    $totalPages = ceil($totalRecords / $recordsPerPage);

                    // แสดงปุ่ม Pagination
                    for ($i = 1; $i <= $totalPages; $i++) {
                        $activeClass = ($page == $i) ? 'active' : '';
                        echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                    }?>
                        </ul>
                    </div>

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
</body>


<!-- หากกด add จะแสดงชุดในเพื่อกรอกค่า -->

<div class="modal fade" id="addParcelModal" tabindex="-1" role="dialog" aria-labelledby="addParcelModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addParcelModalLabel">เพิ่มพัสดุ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- แบบฟอร์มกรอกข้อมูล -->
                <form id="addParcelForm" action="./controller/add_parcel.php" method="post">
                    <div class="form-group">
                        <label for="parcelType">หมวดหมู่พัสดุ:</label>
                        <select class="form-control" id="parcelType" name="parcelType" required>
                            <option value="" disabled selected>--- เลือกหมวดหมู่พัสดุ ---</option>
                            <!-- ตรวจสอบว่ามีข้อมูลหน่วยนับจากฐานข้อมูลหรือไม่ -->
                            <?php
                            $sqlTypr = "SELECT * FROM type_parcel";
                            $resultTypr = mysqli_query($conn, $sqlTypr);

                            if ($resultTypr) {
                                while ($rowTypr = mysqli_fetch_assoc($resultTypr)) {
                                    echo '<option value="' . $rowTypr['id'] . '">' . $rowTypr['name'] . '</option>';
                                }
                            } else {
                                echo '<option value="">ไม่พบข้อมูล</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="parcelName">ชื่อพัสดุ:</label>
                        <input type="text" class="form-control" id="parcelName" name="parcelName" required>
                    </div>
                    <div class="form-group">
                        <label for="parcelModel">รุ่น:</label>
                        <input type="text" class="form-control" id="parcelModel" name="parcelModel">
                    </div>
                    <div class="form-group">
                        <label for="parcelBrand">ยี่ห้อ:</label>
                        <input type="text" class="form-control" id="parcelBrand" name="parcelBrand">
                    </div>
                    <div class="form-group">
                        <label for="unit">หน่วยนับ:</label>
                        <select class="form-control" id="unit" name="unit" required>
                            <option value="" disabled selected>--- เลือกหน่วยนับ ---</option>
                            <!-- ตรวจสอบว่ามีข้อมูลหน่วยนับจากฐานข้อมูลหรือไม่ -->
                            <?php
                            $sqlUnit = "SELECT * FROM unit_parcel";
                            $resultUnit = mysqli_query($conn, $sqlUnit);

                            if ($resultUnit) {
                                while ($rowUnit = mysqli_fetch_assoc($resultUnit)) {
                                    echo '<option value="' . $rowUnit['id'] . '">' . $rowUnit['name'] . '</option>';
                                }
                            } else {
                                echo '<option value="">ไม่พบข้อมูล</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </form>
            </div>
        </div>
    </div>
</div>




</html>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('searchInput');
    var categoryFilter = document.getElementById('categoryFilter');

    // Add an event listener for input changes on both search input and category dropdown
    [searchInput, categoryFilter].forEach(function(element) {
        element.addEventListener('input', filterTable);
    });

    function filterTable() {
        var searchValue = searchInput.value.toLowerCase().trim();
        var categoryValue = categoryFilter.value.toLowerCase();

        var rows = document.querySelectorAll('.table tbody tr');

        rows.forEach(function(row) {
            var found = false;

            // Get the category cell content (assuming it's the first cell in each row)
            var categoryCell = row.querySelector('td:first-child');
            var categoryText = categoryCell.textContent.toLowerCase();

            // Check if the category matches the selected category or if "All Categories" is selected
            if (categoryValue === '' || categoryText.indexOf(categoryValue) !== -1) {
                // Loop through each cell in the row (excluding the first cell, which is the category)
                row.querySelectorAll('td:not(:first-child)').forEach(function(cell) {
                    if (cell.textContent.toLowerCase().indexOf(searchValue) !== -1) {
                        found = true;
                    }
                });
            }

            row.style.display = found ? '' : 'none';
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    // เลือกปุ่ม "Add"
    const addParcelButton = document.getElementById('add_parcel');

    // เพิ่ม Event Listener สำหรับคลิกที่ปุ่ม "Add"
    addParcelButton.addEventListener('click', function(event) {
        event.preventDefault();

        // เรียกใช้ Bootstrap Modal
        $('#addParcelModal').modal('show');
    });
});


function deleteParcel(link) {
    // ดึงข้อมูล ID และชื่อพัสดุจาก data-id
    const parcelData = link.getAttribute('data-id').split('-');
    const parcelId = parcelData[0];
    const parcelName = parcelData[1];

    // ยืนยันการลบด้วย SweetAlert
    Swal.fire({
        title: 'ยืนยันการลบ',
        text: 'คุณต้องการลบ ' + parcelName + ' ใช่หรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'ใช่, ลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = './controller/del_parcel.php?id=' + parcelId;
        }
    });
}


<?php
if (isset($_REQUEST['success'])) {
  ?>
setTimeout(function() {
    Swal.fire({
        title: 'เพิ่มข้อมูลเรียบร้อย',
        text: 'คุณเพิ่มข้อมูลได้แล้ว',
        icon: 'success',
        confirmButtonText: 'ตกลง',
        allowOutsideClick: false, // ไม่อนุญาตให้คลิกนอก popup ปิด
        allowEscapeKey: true, // ไม่อนุญาตให้กดปุ่ม ESC เพื่อปิด
        allowEnterKey: true // ไม่อนุญาตให้กดปุ่ม Enter เพื่อปิด
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "./add_parcel";
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
        title: 'ไม่สามารถเพิ่มข้อมูลได้',
        text: 'เนื่องจากมีข้อมูลอยู่แล้ว',
        icon: 'error',
        confirmButtonText: 'ตกลง',
        allowOutsideClick: false, // ไม่อนุญาตให้คลิกนอก popup ปิด
        allowEscapeKey: true, // ไม่อนุญาตให้กดปุ่ม ESC เพื่อปิด
        allowEnterKey: true // ไม่อนุญาตให้กดปุ่ม Enter เพื่อปิด
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "./add_parcel";
        }
    });
});

<?php
  }
?>

<?php
if (isset($_REQUEST['del-success'])) {
  ?>
setTimeout(function() {
    Swal.fire({
        title: 'ลบข้อมูลเรียบร้อย',
        icon: 'success',
        confirmButtonText: 'ตกลง',
        allowOutsideClick: false, // ไม่อนุญาตให้คลิกนอก popup ปิด
        allowEscapeKey: true, // ไม่อนุญาตให้กดปุ่ม ESC เพื่อปิด
        allowEnterKey: true // ไม่อนุญาตให้กดปุ่ม Enter เพื่อปิด
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "./add_parcel";
        }
    });
});

<?php
  }
?>

<?php
if (isset($_REQUEST['ed-success'])) {
  ?>
setTimeout(function() {
    Swal.fire({
        title: 'แก้ไขข้อมูลเรียบร้อย',
        icon: 'success',
        confirmButtonText: 'ตกลง',
        allowOutsideClick: false, // ไม่อนุญาตให้คลิกนอก popup ปิด
        allowEscapeKey: true, // ไม่อนุญาตให้กดปุ่ม ESC เพื่อปิด
        allowEnterKey: true // ไม่อนุญาตให้กดปุ่ม Enter เพื่อปิด
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "./add_parcel";
        }
    });
});

<?php
  }
?>

<?php
if (isset($_REQUEST['ed-error'])) {
  ?>
setTimeout(function() {
    Swal.fire({
        title: 'ไม่สามารถแก้ไขข้อมูลได้',
        text: 'เนื่องจากมีข้อมูลอยู่แล้ว',
        icon: 'error',
        confirmButtonText: 'ตกลง',
        allowOutsideClick: false, // ไม่อนุญาตให้คลิกนอก popup ปิด
        allowEscapeKey: true, // ไม่อนุญาตให้กดปุ่ม ESC เพื่อปิด
        allowEnterKey: true // ไม่อนุญาตให้กดปุ่ม Enter เพื่อปิด
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "./add_parcel";
        }
    });
});

<?php
  }
?>
</script>
<style>
.custom-body {
    --sidebar-width: 230px;
    /* Set the width of the sidebar */
    --content-margin-left: calc(var(--sidebar-width) + 15px);
    /* Adjust margin-left based on sidebar width */
}

.content-wrapper {
    margin-left: var(--content-margin-left);
}
</style>
<?php
require '../popup/popup.php';

?>