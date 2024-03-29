<?php 
session_start();
require_once '../dbconfig.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Help Desk | Admin</title>
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
        document.querySelector('a[name="department"]').classList.add('nav-link', 'active');
    });
</script>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ข้อมูลหน่วยงานและสิทธิ์</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./index">Home</a></li>
              <li class="breadcrumb-item active">ข้อมูลหน่วยงาน / สิทธิ์</li>
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
                <h3 class="card-title">ข้อมูลหน่วยงาน</h3>
                <a class="btn btn-success btn-sm" href="#" style=" margin-left: 10px ;margin-right: auto; " id="add-department"><i class="fas fa-plus"></i>Add</a>
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
                              ชื่อแผนก/หน่วย
                          </th>
                          <th class="text-center">
                              
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php
    
                    $sql = "SELECT * FROM department ";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        // วนลูปเพื่อแสดงข้อมูล
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td class="text-center">' . $row['id_department'] . '</td>';
                            echo '<td class="text-center">' . $row['name'] . '</td>';
                            echo '<td class="project-actions text-right">';
                            echo '<a class="btn btn-warning  btn-sm ed-department" href="#" data-id="' . $row['id_department'] ."-". $row['name'] . '"><i class="fas fa-pencil-alt"></i> Edit</a>  &nbsp;';
                            echo '<a class="btn btn-danger btn-sm del-department" href="#" data-id="' . $row['id_department'] ."-". $row['name'] . '"><i class="fas fa-trash"></i> Delete</a>';
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
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">สิทธิ์ในระบบ</h3>
            
                <a class="btn btn-success btn-sm" href="#" style=" margin-left: 10px ;margin-right: auto; " id="add-urole"><i class="fas fa-plus"></i>Add</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="margin: 10px 10px 0 10px;">
                  <div class="table-responsive">
                    <table class="table1 table-striped projects" cellspacing="0" width="100%" id="dtBasicExample1">
                  <thead>
                      <tr>
                          <th  class="text-center">
                              #
                          </th>
                          <th class="text-center">
                              สิทธิ์ในระบบ
                          </th>
                          <th class="text-center">
                             
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php 
                  
                  $sql = "SELECT * FROM urole";
                    $result = mysqli_query($conn, $sql); 
                  
                    if ($result) {
                      // วนลูปเพื่อแสดงข้อมูล
                      while ($row = mysqli_fetch_assoc($result)) {
                          echo '<tr>';
                          echo '<td class="text-center">' . $row['id_urole'] . '</td>';
                          echo '<td class="text-center">' . $row['name'] . '</td>';
                          echo '<td class="project-actions text-right">';
                          echo '<a class="btn btn-warning  btn-sm ed-urole" href="#" data-id="' . $row['id_urole'] ."-". $row['name'] . '"><i class="fas fa-pencil-alt"></i> Edit</a>  &nbsp;';
                          echo '<a class="btn btn-danger btn-sm del-urole" href="#" data-id="' . $row['id_urole'] ."-". $row['name'] . '"><i class="fas fa-trash"></i> Delete</a>';
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
              </div><!-- /.card-body -->
            </div><!-- /.card -->  
          </div><!-- /.row --> 
          <div class="col-md-6">
            
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
  ///เมื่อกด add สิทธิ์ จะแสดง popup นี้
    document.getElementById('add-urole').addEventListener('click', function() {
    Swal.fire({
        title: '<h4><label class="label t1">กรุณากรอกข้อมูล</label></h4>',
        html: '<div><h6><label class="label t1">สิทธิ์ในระบบ</label></h6><input class="form-control t1" id="name" type="text" required> <br>',
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
            window.location.href = `./controller/add_urole?name-urole=${encodedName}`;
        }
    });
});
///เมื่อกด add หน่วยงาน จะแสดง popup นี้
document.getElementById('add-department').addEventListener('click', function() {
    Swal.fire({
        title: '<h4><label class="label t1">กรุณากรอกข้อมูล</label></h4>',
        html: '<div><h6><label class="label t1">แผนก/หน่วยงาน</label></h6><input class="form-control t1" id="name" type="text" required> <br>',
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
            window.location.href = `./controller/add_department?name=${encodedName}`;
        }
    });
});
///เมื่อกด Delete หน่วยงาน จะแสดง popup นี้
 const delete_department = document.querySelectorAll('.del-department');

 delete_department.forEach(button => {
    button.addEventListener('click', function (event) {
        event.preventDefault();
        const departmentData = this.getAttribute('data-id').split('-'); // แยกข้อมูลด้วยตัวแยก '-'
        const departmentId = departmentData[0];
        const departmentName = departmentData[1];

        Swal.fire({
            title: '<h4><label class="label t1">คุณต้องการลบข้อมูล</label></h4>',
            html: `<div><h6><label class="label t1">(ID: ${departmentId}-${departmentName})</label></h6><br>`,
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
                window.location.href = `./controller/del_department?id_department=${departmentId}&name=${departmentName}`;
            }
        });
    });
});

///เมื่อกด Edit หน่วยงาน จะแสดง popup นี้
const edit_department = document.querySelectorAll('.ed-department');

edit_department.forEach(button => {
    button.addEventListener('click', function (event) {
        event.preventDefault();
        const departmentData = this.getAttribute('data-id').split('-');
        const departmentId = departmentData[0];
        const departmentName = departmentData[1];

        Swal.fire({
            title: '<h4><label class="label t1">แก้ไขข้อมูล</label></h4>',
            html: `<div><h6><label class="label t1">แผนก/หน่วยงาน</label></h6><input class="form-control t1" id="name" type="text" required value="${departmentName}"> <br>`,
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
                window.location.href = `./controller/edit_department?id_department=${departmentId}&name=${name}`;
            }
        });
    });
});

///เมื่อกด Delete สิทธิ์ จะแสดง popup นี้
const deleteUrole = document.querySelectorAll('.del-urole');

deleteUrole.forEach(button => {
   button.addEventListener('click', function (event) {
       event.preventDefault();
       const uroleData = this.getAttribute('data-id').split('-'); // แยกข้อมูลด้วยตัวแยก '-'
       const uroleId = uroleData[0];
       const uroleName = uroleData[1];

       Swal.fire({
           title: '<h4><label class="label t1">คุณต้องการลบข้อมูล</label></h4>',
           html: `<div><h6><label class="label t1">(ID: ${uroleId}-${uroleName})</label></h6><br>`,
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
               // Modify the URL to include the uroleId
               window.location.href = `./controller/del_urole?id_urole=${uroleId}&name=${uroleName}`;
           }
       });
   });
});

///เมื่อกด Edit สิทธิ์ จะแสดง popup นี้
const edit_urole = document.querySelectorAll('.ed-urole');

edit_urole.forEach(button => {
    button.addEventListener('click', function (event) {
        event.preventDefault();
        const uroleData = this.getAttribute('data-id').split('-');
        const uroleId = uroleData[0];
        const uroleName = uroleData[1];

        Swal.fire({
            title: '<h4><label class="label t1">แก้ไขข้อมูล</label></h4>',
            html: `<div><h6><label class="label t1">สิทธิ์</label></h6><input class="form-control t1" id="name" type="text" required value="${uroleName}"> <br>`,
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
                window.location.href = `./controller/edit_urole?id_urole=${uroleId}&name=${name}`;
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
                      window.location.href = "./department";
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
                      window.location.href = "./department";
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
                      window.location.href = "./department";
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
                      window.location.href = "./department";
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
                      window.location.href = "./department";
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
                      window.location.href = "./department";
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