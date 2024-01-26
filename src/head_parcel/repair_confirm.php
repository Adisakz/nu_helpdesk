

<?php 
session_start();
require_once '../dbconfig.php';
$select_name = $_SESSION["name_title"].$_SESSION["first_name"].' '.$_SESSION["last_name"];


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

function getStatusText($status) {
  if ($status == 0) {
      $style = 'style="background-color: #ffc107; border-color: #FFC107; box-shadow: 0px 0px 4px 1px #FFC107; padding: 4px 8px; border-radius: 4px; color: #000;border:none;"';
      return '<button ' . $style . '  class="text-white">รอช่างตรวจสอบ</button>';
  }  else if ($status == 1){
    $style = 'style="background-color: #fd7e14; border-color: #fd7e14; box-shadow: 0px 0px 4px 1px #fd7e14; padding: 4px 8px; border-radius: 4px; color: #000;border:none;"';
    return '<button ' . $style . '  class="text-white">กำลังซ่อม</button>';
}
  else if ($status == 2){
    $style = 'style="background-color: #dc3545; border-color: #dc3545; box-shadow: 0px 0px 4px 1px #dc3545; padding: 4px 8px; border-radius: 4px; color: #000;border:none;"';
    return '<button ' . $style . '  class="text-white">ยกเลิกการซ่อม</button>';
  }
  else if ($status == 3){
    $style = 'style="background-color: #28a745; border-color: #28a745; box-shadow: 0px 0px 4px 1px #28a745; padding: 4px 8px; border-radius: 4px; color: #000;border:none;"';
    return '<button ' . $style . '  class="text-white">ซ่อมเสร็จ</button>';
  }
  else if ($status == 4){
    $style = 'style="background-color: #007bff; border-color: #007bff; box-shadow: 0px 0px 4px 1px #007bff; padding: 4px 8px; border-radius: 4px; color: #000;border:none;"';
    return '<button ' . $style . '  class="text-white">รออนุมัติ</button>';
  }
else if ($status == 5){
    $style = 'style="background-color: #007bff; border-color: #007bff; box-shadow: 0px 0px 4px 1px #007bff; padding: 4px 8px; border-radius: 4px; color: #000;border:none;"';
    return '<button ' . $style . '  class="text-white">รออนุมัติ</button>';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Help Desk | Head</title>
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
        document.addEventListener('DOMContentLoaded', function() {
            const typeParcelNavItem = document.querySelector('a[name="confirm-repair"]')
            const parcelLink = document.querySelector('li[name="wait"]');
            const parcelLinkActive = document.querySelector('a[name="wait-success"]');

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
            <h1>รายการแจ้งซ่อมรออนุมัติ</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./index">Home</a></li>
              <li class="breadcrumb-item active">รายการแจ้งซ่อมรออนุมัติ</li>
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
          <h3 class="card-title">รายการแจ้งซ่อม</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0" style="margin: 10px 10px 0 10px;">
          <div class="table-responsive">
             <table class="table table-striped projects" cellspacing="0" width="100%" id="dtBasicExample">
              <thead>
                  <tr>
                      <th  class="text-center">
                          ประเภท
                      </th>
                      <th class="text-center">
                          หน่วยงาน/แผนก
                      </th>
                      <th  class="text-center">
                          ทรัพย์สินที่ต้องการซ่อม
                      </th>
                      <th  class="text-center">
                          เลขครุภัณฑ์
                      </th>
                      <th  class="text-center">
                          สภาพการชำรุด
                      </th>
                      <th class="text-center" width="150px">
                         วันที่
                      </th>
                      <th class="text-center" width="95px" >
                         ความต้องการ
                      </th>
                      <th class="text-center" width="150px">
                         สถานะ
                      </th>
                      
                      <th class="text-center"  width="170px">
                         
                      </th>
                  </tr>
              </thead>
              <tbody>
                <?php
                   
                    $sql = "SELECT * FROM repair_report_pd05 WHERE send_to = '$id_person' AND status = 5 ";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        // วนลูปเพื่อแสดงข้อมูล
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td class="text-center">' .$row['type_repair'] . '</td>';
                            echo '<td class="text-center">' . name_department($row['department_id']). '</td>';
                            echo '<td class="text-center">' . $row['asset_name'] . '</td>';
                            echo '<td class="text-center">' . $row['asset_id'] . '</td>';
                            echo '<td class="text-center">' . $row['asset_detail'] . '</td>'; 
                            echo '<td class="text-center">' . date('d', strtotime($row['date_report_in'])) . ' ' . thaiMonth(date('m', strtotime($row['date_report_in']))) . ' ' . (date('Y', strtotime($row['date_report_in'])) + 543) . ' || ' . date('H:i', strtotime($row['date_report_in'])) . '</td>';
                            echo '<td class="text-center">' . $row['neet'] . '</td>';
                            echo '<td class="text-center">' . getStatusText($row['status']) . '</td>';
                            echo '<td class="project-actions text-right" style="display:flex;">';
                            echo '<a class="btn btn-primary btn-sm" href="../pdf/GeneratePDFrepair?id='. $row['id_repair'] .'"><i class="fas fa-folder"></i> View</a>&nbsp&nbsp';
                            echo '<a class="btn btn-success btn-sm del-repair" href="confirm_rapair_head_parcel?id=' . $row['id_repair'] . '"><i class="fas fa-pencil-alt"></i> ตรวจสอบ</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                      }
                       
                    // ปิดการเชื่อมต่อ
                    mysqli_close($conn);
                ?>
              </tbody>
              </table>
                    </div>
        </div>
            
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</body>
</body>
</html>
<script>
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
            window.location.href = "./repair_confirm";
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
        text: 'เนื่องจากข้อมูลลายเซ็นไม่ถูกต้อง',
        icon: 'error',
        confirmButtonText: 'ตกลง',
        allowOutsideClick: false, // ไม่อนุญาตให้คลิกนอก popup ปิด
        allowEscapeKey: true, // ไม่อนุญาตให้กดปุ่ม ESC เพื่อปิด
        allowEnterKey: true // ไม่อนุญาตให้กดปุ่ม Enter เพื่อปิด
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "./repair_confirm";
        }
    });
});

<?php
  }
?>


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
</script>
<?php
require '../popup/popup.php';

?>