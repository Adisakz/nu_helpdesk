<?php 
session_start();
require_once '../dbconfig.php';

//add_qty_parcel.php
//cut_qty_parcel.php

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
            const typeParcelNavItem = document.querySelector('a[name="stock-add-cut"]')
            const stockLink = document.querySelector('li[name="stock"]');
            const stockLinkActive = document.querySelector('a[name="stock"]');
            const parcelLink = document.querySelector('li[name="parcel"]');
            const parcelLinkActive = document.querySelector('a[name="parcel-head"]');
            if (stockLink) {
                stockLink.classList.add('nav-item', 'menu-open');
            }
            if (parcelLink) {
                parcelLink.classList.add('nav-item', 'menu-open');
            }

            if (typeParcelNavItem) {
                typeParcelNavItem.classList.add('nav-link', 'active');
            }
            if (stockLinkActive) {
                stockLinkActive.classList.add('nav-link', 'active');
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
                            <h1>พัสดุ</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./index">Home</a></li>
                                <li class="breadcrumb-item active">พัสดุ</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="card-title">รายการข้อมูลพัสดุ</h3>
                            </div>
                            <div class="col-6 text-right">
                                <a class="btn btn-success btn-sm btn-add" href="#"><i class="fas fa-plus"></i> Add</a>
                                <a class="btn btn-danger btn-sm btn-cut" href="#"><i class="fas fa-minus"></i>Cut</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0" style="margin: 10px 10px 0 10px;">
                        <div class="form-group">
                            <label for="departmentFilter">เลือกหมวดหมู่พัสดุ:</label>
                            <select class="form-control" id="departmentFilter">
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
                        <div class="table-responsive">
                            <table class="table table-striped projects" cellspacing="0" width="100%"
                                id="dtBasicExample">

                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            #
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
                                        <th class="text-center">
                                            จำนวนคงเหลือ
                                        </th>
                                        <th class="text-center" width="250px">
                                            เพิ่ม - ลด
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sql = "SELECT * FROM parcel_data";
                $result = mysqli_query($conn, $sql); 
               
                if ($result) {
                    // วนลูปเพื่อแสดงข้อมูล
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo '<tr>';
                      echo '<td class="text-center">' . $row['id_parcel'] . '</td>';
                      echo '<td class="text-center">' . name_parcel($row['type'] ). '</td>';
                      echo '<td class="text-center">' . $row['name_parcel'] . '</td>';
                      echo '<td class="text-center">' . $row['model'] . '</td>';
                      echo '<td class="text-center">' .  $row['brand'] . '</td>';
                      echo '<td class="text-center">' .name_unit($row['unit_num'])  . '</td>';
                      echo '<td class="text-center">' . $row['qty'] . '</td>';                      
                      echo '<td class="text-center" >';
                    echo '<input class="input-num qty-input" type="number" min="0" value="0" data-id="' . $row['id_parcel'] . '" " >';
                    echo '</td>';
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
                    </div>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

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
    <script src="..//plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="..//plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="..//dist/js/adminlte.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</body>

<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close-popup">&times;</span>
        <p id="popup-message">บันทึกเรียบร้อย โปรดรอรีเฟรชหน้า</p>
    </div>
</div>

</html>
<script>
$(document).ready(function() {
    var table = $('#dtBasicExample').DataTable({
        // ... ตั้งค่า DataTables ตามต้องการ ...
    });

    // การให้ความสามารถ Show/Hide Columns
    $('a.toggle-vis').on('click', function(e) {
        e.preventDefault();
        var column = table.column($(this).attr('data-column'));
        column.visible(!column.visible());
    });

    // การให้ความสามารถค้นหา (Search)
    $('#dtBasicExample_filter input').unbind().bind('input', function() {
        table.search(this.value).draw();
    });

    // การกรองตารางโดยใช้ Dropdown แผนก
    $('#departmentFilter').on('change', function() {
        var selectedDepartment = $(this).val();
        table.column(1) // 6 คือ index ของคอลัมน์ที่ต้องการกรอง (index นับตั้งแต่ 0)
            .search(selectedDepartment)
            .draw();
    });
});


$(document).ready(function() {
    $(".btn-add").on("click", function() {
        var quantities = {};

        // Collect quantities from input fields
        $(".qty-input").each(function() {
            var id = $(this).data("id");
            var quantity = $(this).val();
            quantities[id] = quantity;
        });

        // Send the data to the server using AJAX
        $.ajax({
            type: "POST",
            url: "./controller/add_qty_parcel.php",
            data: {
                quantities: quantities
            },
            success: function(response) {
                console.log("Server Response:", response);

                // แสดง Popup และรีเฟรชหน้าหลังจากเวลาที่กำหนด (ในตัวอย่างคือ 2 วินาที)
                showPopup(response.message);
            },
            error: function(error) {
                console.error(error);
            }
        });
    });

    // กำหนดการคลิกที่ปุ่มลบ
    $(".btn-cut").on("click", function() {
        var quantities = {};

        // Collect quantities from input fields
        $(".qty-input").each(function() {
            var id = $(this).data("id");
            var quantity = $(this).val();
            quantities[id] = quantity;
        });

        // Send the data to the server using AJAX
        $.ajax({
            type: "POST",
            url: "./controller/cut_qty_parcel.php",
            data: {
                quantities: quantities
            },
            success: function(response) {
                console.log("Server Response:", response);

                // แสดง Popup และรีเฟรชหน้าหลังจากเวลาที่กำหนด (ในตัวอย่างคือ 2 วินาที)
                showPopup(response.message);
            },
            error: function(error) {
                console.error(error);
            }
        });
    });

    // ฟังก์ชันแสดง Popup
    function showPopup(message) {
        // กำหนดข้อความใน Popup
        $("#popup-message").text(message);

        // แสดง Popup
        $("#popup").fadeIn();

        // รีเฟรชหน้าหลังจากเวลาที่กำหนด (ในตัวอย่างคือ 2 วินาที)
        setTimeout(function() {
            location.reload();
        }, 2000);
    }

    // ปิด Popup ด้วยการคลิกที่ปุ่มปิด
    $(".close-popup").on("click", function() {
        $("#popup").fadeOut();
    });
});
</script>
<style>
.popup {
    display: none;
    position: fixed;
    top: 70px;
    right: 20px;
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.popup-content {
    display: flex;
    align-items: center;
}

.close-popup {
    cursor: pointer;
    margin-left: 10px;
    font-size: 20px;
}

input {
    display: block;
    width: 300px;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

@media screen and (max-width: 767px) {

    /* ปรับสไตล์เมื่อขนาดจอเล็กลงไป (max-width: 767px) */
    input {
        width: 70px;
        /* ปรับความสูงเป็น 100px */
    }
}
</style>