<?php 
session_start();
require_once '../dbconfig.php';

//add_unit_parcel
//add_type_parcel
//del_type_parcel
//del_unit_parcel
//edit_unit_parcel
//edit_type_parcel
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Help Desk | Admin</title>
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
            const typeParcelNavItem = document.querySelector('a[name="type-parcel"]')
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
                            <h1>ข้อมูลประเภทและหน่วยนับพัสดุ</h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./index">Home</a></li>
                                <li class="breadcrumb-item active">ข้อมูลประเภทและหน่วยนับพัสดุ</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- แสดงข้อมูลประเภทพัสดุ -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">ข้อมูลประเภทพัสดุ</h3>
                                    <a class="btn btn-success btn-sm" href="#"
                                        style="margin-left: 10px; margin-right: auto;" id="add-type-parcel"><i
                                            class="fas fa-plus"></i>Add</a>
                                </div>
                                <div class="card-body" style="margin: 10px 10px 0 10px;">
                                <div class="table-responsive">
                                    <table class="table table-striped projects" cellspacing="0" width="100%" id="dtBasicExample">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">ชื่อประเภท</th>
                                                    <th class="text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                    
                                   

                                    $sqlTypeParcel = "SELECT * FROM type_parcel ";
                                    $resultTypeParcel = mysqli_query($conn, $sqlTypeParcel);

                                    if ($resultTypeParcel) {
                                        while ($rowTypeParcel = mysqli_fetch_assoc($resultTypeParcel)) {
                                            echo '<tr>';
                                            echo '<td class="text-center">' . $rowTypeParcel['id'] . '</td>';
                                            echo '<td class="text-center">' . $rowTypeParcel['name'] . '</td>';
                                            echo '<td class="project-actions text-right">';
                                            echo '<a class="btn btn-warning  btn-sm ed-type-parcel" href="#" data-id="' . $rowTypeParcel['id'] . "-" . $rowTypeParcel['name'] . '"><i class="fas fa-pencil-alt"></i> Edit</a> &nbsp;';
                                            echo '<a class="btn btn-danger btn-sm del-type-parcel" href="#" data-id="' . $rowTypeParcel['id'] . "-" . $rowTypeParcel['name'] . '"><i class="fas fa-trash"></i> Delete</a>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo "ผิดพลาด: " . $sqlTypeParcel . "<br>" . mysqli_error($conn);
                                    }
                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <!-- แสดงข้อมูลหน่วยนับ -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">ข้อมูลหน่วยนับ</h3>
                                    <a class="btn btn-success btn-sm" href="#"
                                        style="margin-left: 10px; margin-right: auto;" id="add-unit-parcel"><i
                                            class="fas fa-plus"></i>Add</a>
                                </div>
                                <div class="card-body p-0" style="margin: 10px 10px 0 10px;">
                                <div class="table-responsive">
                                    <table class="table1 table-striped projects" cellspacing="0" width="100%" id="dtBasicExample1">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">หน่วยนับ</th>
                                                    <th class="text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                               
                                    $sqlUnitParcel = "SELECT * FROM unit_parcel";
                                    $resultUnitParcel = mysqli_query($conn, $sqlUnitParcel);

                                    if ($resultUnitParcel) {
                                        while ($rowUnitParcel = mysqli_fetch_assoc($resultUnitParcel)) {
                                            echo '<tr>';
                                            echo '<td class="text-center">' . $rowUnitParcel['id'] . '</td>';
                                            echo '<td class="text-center">' . $rowUnitParcel['name'] . '</td>';
                                            echo '<td class="project-actions text-right">';
                                            echo '<a class="btn btn-warning btn-sm ed-unit-parcel" href="#" data-id="' . $rowUnitParcel['id'] . "-" . $rowUnitParcel['name'] . '"><i class="fas fa-pencil-alt"></i> Edit</a> &nbsp;';
                                            echo '<a class="btn btn-danger btn-sm del-unit-parcel" href="#" data-id="' . $rowUnitParcel['id'] . "-" . $rowUnitParcel['name'] . '"><i class="fas fa-trash"></i> Delete</a>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo "Error: " . $sqlUnitParcel . "<br>" . mysqli_error($conn);
                                    }
                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</body>

</html>
<script>
$(document).ready(function() {
    var table = $('#dtBasicExample').DataTable({
        // ... ตั้งค่า DataTables ตามต้องการ ...
    });

    var table1 = $('#dtBasicExample1').DataTable({
        // ... ตั้งค่า DataTables ตามต้องการ ...
    });

    // การให้ความสามารถ Show/Hide Columns
    $('a.toggle-vis').on('click', function(e) {
        e.preventDefault();
        var column = table.column($(this).attr('data-column'));
        column.visible(!column.visible());
    });

    $('a.toggle-vis1').on('click', function(e) {
        e.preventDefault();
        var column = table1.column($(this).attr('data-column'));
        column.visible(!column.visible());
    });

    // การให้ความสามารถค้นหา (Search)
    $('#dtBasicExample_filter input').unbind().bind('input', function() {
        table.search(this.value).draw();
    });

    // การให้ความสามารถค้นหา (Search)
    $('#dtBasicExample1_filter input').unbind().bind('input', function() {
        table1.search(this.value).draw();
    });
});
///เมื่อกด add หน่วยนับพัสดุ จะแสดง popup นี้
document.getElementById('add-unit-parcel').addEventListener('click', function() {
    Swal.fire({
        title: '<h4><label class="label t1">กรุณากรอกข้อมูล</label></h4>',
        html: '<div><h6><label class="label t1">หน่วยนับ</label></h6><input class="form-control t1" id="name" type="text" required> <br>',
        focusConfirm: false,
        preConfirm: () => {
            return [
                document.getElementById('name').value
            ];
        },
        confirmButtonText: 'ยืนยัน',
        showCancelButton: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            const [name] = result.value;
            const encodedName = encodeURIComponent(name);
            window.location.href = `./controller/add_unit_parcel?name-unit-parcel=${encodedName}`;
        }
    });
});
///เมื่อกด add ประเภทพัสดุ จะแสดง popup นี้
document.getElementById('add-type-parcel').addEventListener('click', function() {
    Swal.fire({
        title: '<h4><label class="label t1">กรุณากรอกข้อมูล</label></h4>',
        html: '<div><h6><label class="label t1">ประเภทพัสดุ</label></h6><input class="form-control t1" id="name" type="text" required> <br>',
        focusConfirm: false,
        preConfirm: () => {
            return [
                document.getElementById('name').value
            ];
        },
        confirmButtonText: 'ยืนยัน',
        showCancelButton: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            const [name] = result.value;
            const encodedName = encodeURIComponent(name);
            window.location.href = `./controller/add_type_parcel.php?name=${encodedName}`;
        }
    });
});

const delete_type_parcel = document.querySelectorAll('.del-type-parcel');

delete_type_parcel.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const typeParcelData = this.getAttribute('data-id').split('-'); // แยกข้อมูลด้วยตัวแยก '-'
        const typeParcelId = typeParcelData[0];
        const typeParcelName = typeParcelData[1];

        Swal.fire({
            title: '<h4><label class="label t1">คุณต้องการลบข้อมูล</label></h4>',
            html: `<div><h6><label class="label t1">(ID: ${typeParcelId}-${typeParcelName})</label></h6><br>`,
            focusConfirm: false,
            preConfirm: () => {
                return [];
            },
            confirmButtonText: 'Delete',
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Modify the URL to include the typeParcelId
                window.location.href =
                    `./controller/del_type_parcel?id=${typeParcelId}&name=${typeParcelName}`;
            }
        });
    });
});

///เมื่อกด Edit ประเภทพัสดุ จะแสดง popup นี้
const edit_type_parcel = document.querySelectorAll('.ed-type-parcel');

edit_type_parcel.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const typeParcelData = this.getAttribute('data-id').split('-');
        const typeParcelId = typeParcelData[0];
        const typeParcelName = typeParcelData[1];

        Swal.fire({
            title: '<h4><label class="label t1">แก้ไขข้อมูล</label></h4>',
            html: `<div><h6><label class="label t1">ประเภทพัสดุ</label></h6><input class="form-control t1" id="name" type="text" required value="${typeParcelName}"> <br>`,
            focusConfirm: false,
            preConfirm: () => {
                const name = document.getElementById('name').value;
                return [name];
            },
            confirmButtonText: 'Edit',
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                const [name] = result.value;

                // ส่งค่า name และ id ไปยังหน้าอื่น
                window.location.href =
                    `./controller/edit_type_parcel?id=${typeParcelId}&name=${name}`;
            }
        });
    });
});

// เมื่อกด Delete หน่วยนับ จะแสดง popup นี้
const delete_unit_parcel = document.querySelectorAll('.del-unit-parcel');

delete_unit_parcel.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const unitParcelData = this.getAttribute('data-id').split('-'); // แยกข้อมูลด้วยตัวแยก '-'
        const unitParcelId = unitParcelData[0];
        const unitParcelName = unitParcelData[1];

        Swal.fire({
            title: '<h4><label class="label t1">คุณต้องการลบข้อมูล</label></h4>',
            html: `<div><h6><label class="label t1">(ID: ${unitParcelId}-${unitParcelName})</label></h6><br>`,
            focusConfirm: false,
            preConfirm: () => {
                return [];
            },
            confirmButtonText: 'Delete',
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Modify the URL to include the unitParcelId
                window.location.href =
                    `./controller/del_unit_parcel?id=${unitParcelId}&name=${unitParcelName}`;
            }
        });
    });
});

// เมื่อกด Edit หน่วยนับพัสดุ จะแสดง popup นี้
const edit_unit_parcel = document.querySelectorAll('.ed-unit-parcel');

edit_unit_parcel.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const unitParcelData = this.getAttribute('data-id').split('-');
        const unitParcelId = unitParcelData[0];
        const unitParcelName = unitParcelData[1];

        Swal.fire({
            title: '<h4><label class="label t1">แก้ไขข้อมูล</label></h4>',
            html: `<div><h6><label class="label t1">หน่วยนับ</label></h6><input class="form-control t1" id="name" type="text" required value="${unitParcelName}"> <br>`,
            focusConfirm: false,
            preConfirm: () => {
                const name = document.getElementById('name').value;
                return [name];
            },
            confirmButtonText: 'Edit',
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                const [name] = result.value;

                // ส่งค่า name และ id ไปยังหน้าอื่น
                window.location.href =
                    `./controller/edit_unit_parcel?id_unit=${unitParcelId}&name=${name}`;
            }
        });
    });
});

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
            window.location.href = "./type_parcel";
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
            window.location.href = "./type_parcel";
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
            window.location.href = "./type_parcel";
        }
    });
});

<?php
  }
?>

<?php
if (isset($_REQUEST['del-rror'])) {
  ?>
setTimeout(function() {
    Swal.fire({
        title: 'ไม่สามารถลบข้อมูลได้',
        icon: 'error',
        confirmButtonText: 'ตกลง',
        allowOutsideClick: false, // ไม่อนุญาตให้คลิกนอก popup ปิด
        allowEscapeKey: true, // ไม่อนุญาตให้กดปุ่ม ESC เพื่อปิด
        allowEnterKey: true // ไม่อนุญาตให้กดปุ่ม Enter เพื่อปิด
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "./type_parcel";
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
            window.location.href = "./type_parcel";
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
            window.location.href = "./type_parcel";
        }
    });
});

<?php
  }
?>
</script>
<?php
require '../popup/popup.php';

?>