<?php 
session_start();
require_once '../dbconfig.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Help Desk | Parcel</title>
  <link rel="shortcut icon" href="../image/favicon.ico" type="image/x-icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
    // ในกรณีที่ต้องการรอให้หน้าเว็บโหลดเสร็จก่อน
    document.addEventListener('DOMContentLoaded', function() {
        // เลือก element และเปลี่ยน class
        document.querySelector('a[name="type-repair"]').classList.add('nav-link', 'active');
    });
</script>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ข้อมูลหมวดหมู่ครุภัณฑ์</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./index">Home</a></li>
              <li class="breadcrumb-item active">ข้อมูลหมวดหมู่ครุภัณฑ์</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">หมวดหมู่ครุภัณฑ์</h3>
                <a class="btn btn-success btn-sm" href="#" style=" margin-left: 10px ;margin-right: auto; " id="add-type-repair"><i class="fas fa-plus"></i>Add</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="margin: 10px 10px 0 10px;">
              <div class="table-responsive">
                <table class="table table-striped projects" cellspacing="0" width="100%" id="dtBasicExample">
                  <thead>
                      <tr>
                          <th  class="text-center">
                              #
                          </th>
                          <th class="text-center">
                              ชื่อหมวดหมู่ครุภัณฑ์
                          </th>
                          <th  class="text-center" width="200px">
                              
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php
                    $sql = "SELECT * FROM type_repair ";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        // วนลูปเพื่อแสดงข้อมูล
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td class="text-center">' . $row['id_type_repair'] . '</td>';
                            echo '<td class="text-center">' . $row['name'] . '</td>';
                            echo '<td class="project-actions text-right">';
                            echo '<a class="btn btn-warning  btn-sm ed-type-repair" href="#" data-id="' . $row['id_type_repair'] ."-". $row['name'] . '"><i class="fas fa-pencil-alt"></i> Edit</a>  &nbsp;';
                            echo '<a class="btn btn-danger btn-sm del-type-repair" href="#" data-id="' . $row['id_type_repair'] ."-". $row['name'] . '"><i class="fas fa-trash"></i> Delete</a>';
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
            </div>
            <!-- /.card -->

        </div>
          <!-- /.col -->
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
    $('#btn-next-step').hide();
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

});
  ///เมื่อกด add ประเภทการซ่อม จะแสดง popup นี้
    document.getElementById('add-type-repair').addEventListener('click', function() {
    Swal.fire({
        title: '<h4><label class="label t1">กรุณากรอกข้อมูล</label></h4>',
        html: '<div><h6><label class="label t1">หมวดหมู่ครุภัณฑ์</label></h6><input class="form-control t1" id="name" type="text" required> <br>',
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
            window.location.href = `./controller/add_type_repair?name-type-repair=${encodedName}`;
        }
    });
});

///เมื่อกด Delete ประเภทการซ่อม จะแสดง popup นี้
 const delete_type_repair = document.querySelectorAll('.del-type-repair');

 delete_type_repair.forEach(button => {
    button.addEventListener('click', function (event) {
        event.preventDefault();
        const typeRepairData = this.getAttribute('data-id').split('-'); // แยกข้อมูลด้วยตัวแยก '-'
        const typeRepairId = typeRepairData[0];
        const typeRepairName = typeRepairData[1];

        Swal.fire({
            title: '<h4><label class="label t1">คุณต้องการลบข้อมูล</label></h4>',
            html: `<div><h6><label class="label t1">(ID: ${typeRepairId}-${typeRepairName})</label></h6><br>`,
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
                window.location.href = `./controller/del_type_repair?id_type_repair=${typeRepairId}&name=${typeRepairName}`;
            }
        });
    });
});

///เมื่อกด Edit หน่วยงาน จะแสดง popup นี้
const edit_type_repair = document.querySelectorAll('.ed-type-repair');

edit_type_repair.forEach(button => {
    button.addEventListener('click', function (event) {
        event.preventDefault();
        const typeRepairData = this.getAttribute('data-id').split('-');
        const typeRepairId = typeRepairData[0];
        const typeRepairName = typeRepairData[1];

        Swal.fire({
            title: '<h4><label class="label t1">แก้ไขข้อมูล</label></h4>',
            html: `<div><h6><label class="label t1">หมวดหมู่ครุภัณฑ์</label></h6><input class="form-control t1" id="name" type="text" required value="${typeRepairName}"> <br>`,
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
                window.location.href = `./controller/edit_type_repair?id_type_repair=${typeRepairId}&name=${name}`;
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
                      window.location.href = "./type_repair";
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
                      window.location.href = "./type_repair";
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
                      window.location.href = "./type_repair";
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
                      window.location.href = "./type_repair";
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
                      window.location.href = "./type_repair";
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