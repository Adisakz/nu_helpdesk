<?php 
session_start();
require_once '../dbconfig.php';

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
            document.querySelector('a[name="account"]').classList.add('nav-link', 'active');
        });
        </script>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>บัญชีผู้ใช้</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./index">Home</a></li>
                                <li class="breadcrumb-item active">บัญชีผู้ใช้</li>
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
                        <h3 class="card-title">บัญชีผู้ใช้</h3>
                        <a class="btn btn-success btn-sm" href="add_account"
                            style=" margin-left: 10px ;margin-right: auto; "><i class="fas fa-plus"></i>Add</a>

                    </div>
                    <div class="card-body p-0" style="margin: 10px 10px 0 10px;">
                        <div class="form-group">
                            <label for="departmentFilter">เลือกแผนก:</label>
                            <select class="form-control" id="departmentFilter">
                                <option value="">ทั้งหมด</option>
                                <!-- เพิ่มตัวเลือกแผนกจากฐานข้อมูลหรือวงเล็บ PHP -->
                                <?php
                            $sql_departments = "SELECT * FROM department";
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
                                            เลข ปชช.
                                        </th>
                                        <th class="text-center">
                                            คำนำหน้า
                                        </th>
                                        <th class="text-center">
                                            ชื่อ
                                        </th>
                                        <th class="text-center">
                                            นามสกุล
                                        </th>
                                        <th class="text-center">
                                            ตำแหน่ง
                                        </th>
                                        <th class="text-center">
                                            แผนก
                                        </th>
                                        <th class="text-center">
                                            สิทธิ์ในระบบ
                                        </th>
                                        <th class="text-center" width="250px">

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sql = "SELECT * FROM account";
$result = mysqli_query($conn, $sql); 

if ($result) {
    // วนลูปเพื่อแสดงข้อมูล
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<tr>';
      echo '<td class="text-center">' .$row['id_person'] . '</td>';
      echo '<td class="text-center">' . $row['name_title'] . '</td>';
      echo '<td class="text-center">' . $row['first_name'] . '</td>';
      echo '<td class="text-center">' . $row['last_name'] . '</td>';
      echo '<td class="text-center">' . $row['position'] . '</td>';
      echo '<td class="text-center">' .name_department($row['department'])  . '</td>';
      echo '<td class="text-center">' . $row['urole'] . '</td>';
      echo '<td class="project-actions text-right">';
      echo '<a class="btn btn-warning btn-sm" href="./edit_account?id=' .$row['id_person'] . '"><i class="fas fa-pencil-alt"></i> Edit</a>&nbsp';
      echo '<a class="btn btn-danger btn-sm del-account" href="#" data-id="' . $row['id_person'] .'"><i class="fas fa-trash"></i> Delete</a>';
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
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</body>

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
        table.column(5) 
            .search(selectedDepartment)
            .draw();
    });
});

<?php
if (isset($_REQUEST['success'])) {
  ?>
setTimeout(function() {
    Swal.fire({
        title: 'ดำเนินการเรียบร้อย',
        icon: 'success',
        confirmButtonText: 'ตกลง',
        allowOutsideClick: false, // ไม่อนุญาตให้คลิกนอก popup ปิด
        allowEscapeKey: true, // ไม่อนุญาตให้กดปุ่ม ESC เพื่อปิด
        allowEnterKey: true // ไม่อนุญาตให้กดปุ่ม Enter เพื่อปิด
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "./account";
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
        title: 'ไม่สามารถดำเนินการได้',
        text: 'โปรดตรวจสอบความถูกต้อง',
        icon: 'error',
        confirmButtonText: 'ตกลง',
        allowOutsideClick: false, // ไม่อนุญาตให้คลิกนอก popup ปิด
        allowEscapeKey: true, // ไม่อนุญาตให้กดปุ่ม ESC เพื่อปิด
        allowEnterKey: true // ไม่อนุญาตให้กดปุ่ม Enter เพื่อปิด
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "./account";
        }
    });
});

<?php
  }
?>

///เมื่อกด Delete หน่วยงาน จะแสดง popup นี้
const delete_person = document.querySelectorAll('.del-account');

delete_person.forEach(button => {
   button.addEventListener('click', function (event) {
       event.preventDefault();
       const personData = this.getAttribute('data-id').split('-'); // แยกข้อมูลด้วยตัวแยก '-'
       const personId = personData[0];

       Swal.fire({
           title: '<h4><label class="label t1">คุณต้องการลบข้อมูล</label></h4>',
           html: `<div><h6><label class="label t1">(เลขบัตรประชาชน : ${personId})</label></h6><br>`,
           focusConfirm: false,
           preConfirm: () => {
               return [
               ];
           },
           confirmButtonText: 'Delete',
           showCancelButton: true,
           allowOutsideClick: false,
           allowEscapeKey: false,
           allowEnterKey: false
       }).then((result) => {
           if (result.isConfirmed) {
               // Modify the URL to include the departmentId
               window.location.href = `./controller/del_account?id_person=${personId}`;
           }
       });
   });
});
</script>
<?php require '../popup/popup.php'; ?>