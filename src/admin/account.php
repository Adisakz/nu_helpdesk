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
          <a class="btn btn-success btn-sm" href="#" style=" margin-left: 10px ;margin-right: auto; "><i class="fas fa-plus"></i>Add</a>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th  class="text-center">
                          เลข ปชช.
                      </th>
                      <th class="text-center">
                          คำนำหน้า
                      </th>
                      <th  class="text-center">
                          ชื่อ
                      </th>
                      <th  class="text-center">
                          นามสกุล
                      </th>
                      <th  class="text-center">
                          ตำแหน่ง
                      </th>
                      <th class="text-center">
                         แผนก
                      </th>
                      <th class="text-center" >
                         สิทธิ์ในระบบ
                      </th>
                      <th class="text-center" width="250px">
                     
                      </th>
                  </tr>
              </thead>
              <tbody>
                
               <?php 
               $sqlCount = "SELECT COUNT(*) AS total FROM account";
               $resultCount = mysqli_query($conn, $sqlCount);
               $totalRecords = mysqli_fetch_assoc($resultCount)['total'];
               // กำหนดจำนวนรายการต่อหน้า
               $recordsPerPage = 5;

               // รับค่าหน้าปัจจุบัน
               $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

               // คำนวณ offset สำหรับคำสั่ง SQL
               $offset = ($page - 1) * $recordsPerPage;

               // คำสั่ง SQL สำหรับดึงข้อมูลพร้อมกับการใช้ LIMIT
               $sql = "SELECT * FROM account LIMIT $offset, $recordsPerPage";
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
                        echo '<td class="text-center">' . $row['department'] . '</td>';
                        echo '<td class="text-center">' . $row['urole'] . '</td>';
                        echo '<td class="project-actions text-right">';
                        echo '<a class="btn btn-primary btn-sm" href="#"><i class="fas fa-folder"></i> View</a>&nbsp&nbsp';
                        echo '<a class="btn btn-warning btn-sm" href="#"><i class="fas fa-pencil-alt"></i> Edit</a>&nbsp';
                        echo '<a class="btn btn-danger btn-sm" href="#"><i class="fas fa-trash"></i> Delete</a>';
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
        <div class="card-footer">
          <nav aria-label="Contacts Page Navigation">
              <ul class="pagination justify-content-center m-0">
                  <?php
                  // คำนวณจำนวนหน้าทั้งหมด
                  $totalPages = ceil($totalRecords / $recordsPerPage);

                  // แสดงปุ่ม Pagination
                  for ($i = 1; $i <= $totalPages; $i++) {
                      $activeClass = ($page == $i) ? 'active' : '';
                      echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                  }
                  ?>
              </ul>
          </nav>
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
</body>
</html>
