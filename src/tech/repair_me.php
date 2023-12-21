

<?php 
session_start();
require_once '../dbconfig.php';


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
      $style = 'style="background-color: #ffc107; border-color: #FFC107; box-shadow: 0px 0px 4px 1px #FFC107; padding: 4px 8px; border-radius: 4px; color: #000;"';
      return '<span ' . $style .  ' >รอซ่อม</span>';
  }  else if ($status == 1){
    $style = 'style="background-color: #fd7e14; border-color: #fd7e14; box-shadow: 0px 0px 4px 1px #fd7e14; padding: 4px 8px; border-radius: 4px; color: #000;"';
    return '<span ' . $style . '  class="text-white">กำลังซ่อม</span>';
}
  else if ($status == 2){
    $style = 'style="background-color: #dc3545; border-color: #dc3545; box-shadow: 0px 0px 4px 1px #dc3545; padding: 4px 8px; border-radius: 4px; color: #000;"';
    return '<span ' . $style . '  class="text-white">ยกเลิกการซ่อม</span>';
  }
  else if ($status == 3){
    $style = 'style="background-color: #28a745; border-color: #28a745; box-shadow: 0px 0px 4px 1px #28a745; padding: 4px 8px; border-radius: 4px; color: #000;"';
    return '<span ' . $style . '  class="text-white">ซ่อมเสร็จ</span>';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Help Desk | Staff</title>
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
        document.querySelector('a[name="list-me"]').classList.add('nav-link', 'active');
    });
</script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1>รายการแจ้งซ่อมของคุณ <span style="color: blue;"><?php echo $first_name .' '. $last_name?></span></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./index">Home</a></li>
              <li class="breadcrumb-item active">รายการแจ้งซ่อม</li>
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
        <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-striped projects">
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
                      <th class="text-center">
                         วันที่
                      </th>
                      <th class="text-center" width="150px">
                         สถานะ
                      </th>
                  </tr>
              </thead>
              <tbody>
                <?php
                $sqlCount = "SELECT COUNT(*) AS total FROM repair_report_pd05 WHERE id_person_report = '$id_person'";
                $resultCount = mysqli_query($conn, $sqlCount);
                $totalRecords = mysqli_fetch_assoc($resultCount)['total'];
                
                // กำหนดจำนวนรายการต่อหน้า
                $recordsPerPage = 6;
                
                // รับค่าหน้าปัจจุบัน
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                // คำนวณ offset สำหรับคำสั่ง SQL
                $offset = ($page - 1) * $recordsPerPage;

                // คำสั่ง SQL สำหรับดึงข้อมูลพร้อมกับการใช้ LIMIT
                $sql = "SELECT * FROM repair_report_pd05 WHERE id_person_report = '$id_person' LIMIT $offset, $recordsPerPage";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    // วนลูปเพื่อแสดงข้อมูล
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td class="text-center">' .$row['type_repair'] . '</td>';
                        echo '<td class="text-center">' . $row['department_id'] . '</td>';
                        echo '<td class="text-center">' . $row['asset_name'] . '</td>';
                        echo '<td class="text-center">' . $row['asset_id'] . '</td>';
                        echo '<td class="text-center">' . $row['asset_detail'] . '</td>';
                        echo '<td class="text-center">' . date('d', strtotime($row['date_report_in'])) . ' ' . thaiMonth(date('m', strtotime($row['date_report_in']))) . ' ' . (date('Y', strtotime($row['date_report_in'])) + 543) . ' || ' . date('H:i', strtotime($row['date_report_in'])) . '</td>';
                        echo '<td class="text-center">' . getStatusText($row['status']) . '</td>';
                        echo '<td class="project-actions text-right">';
                        if ($row['status'] == 0) {
                            echo '<a class="btn btn-danger btn-sm del-repair" href="#" data-id="'. $row['id_repair'] ."-,". $row['asset_name'] ."-,". $row['asset_id']."-,". $row['asset_detail'] .'"><i class="fas fa-trash"></i> Delete</a>';
                        }
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
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <?php
                    $totalPages = ceil($totalRecords / $recordsPerPage);
                    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

                    // กำหนดจำนวนหน้าที่จะแสดง
                    $visiblePages = 7;

                    // คำนวณหน้าเริ่มต้นและสิ้นสุดที่จะแสดง
                    $startPage = max($currentPage - floor($visiblePages / 2), 1);
                    $endPage = min($startPage + $visiblePages - 1, $totalPages);

                    // ปรับค่าหน้าเริ่มต้นหากมีน้อยกว่า 1
                    $startPage = max(1, $startPage - ($visiblePages - ($endPage - $startPage)));

                    for ($i = $startPage; $i <= $endPage; $i++) {
                        echo '<li class="page-item ' . ($i == $currentPage ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                    }
                    ?>
                </ul>
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
</body>
</html>
<script>
const deleteRepair = document.querySelectorAll('.del-repair');

deleteRepair.forEach(button => {
   button.addEventListener('click', function (event) {
       event.preventDefault();
       const repairData = this.getAttribute('data-id').split('-,'); // แยกข้อมูลด้วยตัวแยก '-'
       const repairId = repairData[0];
       const repairName = repairData[1];
       const repairAssetid = repairData[2];
       const repairDetail = repairData[3];

       Swal.fire({
           title: '<h4><label class="label t1">คุณต้องการลบข้อมูล</label></h4>',
           html: `<div><h6><label class="label t1">ทรัพย์สินที่ต้องการซ่อม : </label> ${repairName}<br><label class="label t1">เลขครุภัณฑ์ : </label>${repairAssetid}<br><label class="label t1">สภาพการชำรุด : </label>${repairDetail}</label></h6><br>`,
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
               window.location.href = `./controller/del_repair?id_repair=${repairId}`;
           }
       });
   });
});

<?php
if (isset($_REQUEST['success'])) {
  ?>
 setTimeout(function() {
              Swal.fire({
                  title: 'ลบข้อมูลแจ้งซ่อมเรียบร้อย',
                  icon: 'success',
                  confirmButtonText: 'ตกลง',
                  allowOutsideClick: false, // ไม่อนุญาตให้คลิกนอก popup ปิด
                  allowEscapeKey: true, // ไม่อนุญาตให้กดปุ่ม ESC เพื่อปิด
                  allowEnterKey: true // ไม่อนุญาตให้กดปุ่ม Enter เพื่อปิด
              }).then((result) => {
                  if (result.isConfirmed) {
                      window.location.href = "./repair_me";
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