<?php 

session_start();
require_once '../dbconfig.php';

function getStatusColor($status) {
  switch ($status) {
      case 'ชำรุด':
          return 'red';
      case 'พร้อมใช้งาน':
          return 'green';
      // เพิ่มเงื่อนไขสถานะเพิ่มเติมตามต้องการ
      default:
          return 'black';
  }
}

function getStatusColorFromDurableCheck($conn, $asset_id) {
  $sql_check1 = "SELECT status FROM durable_check WHERE asset_id = '$asset_id' ORDER BY id DESC LIMIT 1";
  $result_check1 = mysqli_query($conn, $sql_check1);

  if ($row_check1 = mysqli_fetch_assoc($result_check1)) {
      return $row_check1['status'];
  } else {
      return ('N/A');
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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Help Desk | Parcel</title>
    <link rel="shortcut icon" href="../image/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="">
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
            document.querySelector('a[name="parcel"]').classList.add('nav-link', 'active');
        });
        </script>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>ครุภัณฑ์</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./index">Home</a></li>
                                <li class="breadcrumb-item active">ครุภัณฑ์</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card" >
                    <div class="card-header" >
                        <h3 class="card-title">รายการข้อมูลครุภัณฑ์</h3>
                        <a class="btn btn-success btn-sm" href="form_add_asset"
                            style=" margin-left: 10px ;margin-right: auto; "><i class="fas fa-plus"></i>Add</a>                      
                    </div>
                    <div class="card-body p-0" style="margin: 10px 10px 0 10px;">
                        <table class="table table-striped projects" cellspacing="0" width="100%" id="dtBasicExample">
                            <thead >
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th class="text-center">
                                        หมวดหมู่ครุภัณฑ์
                                    </th>
                                    <th class="text-center">
                                        เลขที่ครุภัณฑ์
                                    </th>
                                    <th class="text-center">
                                        ชื่อครุภัณฑ์
                                    </th>
                                    <th class="text-center" >
                                        ปีที่ซื้อ
                                    </th>
                                    <th class="text-center" >
                                        ราคา(บาท)
                                    </th>
                                    <th class="text-center" >
                                        แผนกที่รับผิดชอบ
                                    </th>
                                    <th class="text-center">
                                        Service ล่าสุด
                                    </th>
                                    <th class="text-center">
                                        ซ่อมล่าสุด
                                    </th>
                                    <th class="text-center">
                                        ดูข้อมูล
                                    </th>
                                    <th class="text-center">
2
                                    </th>
                                    <th class="text-center">
                                        แจ้งซ่อม
                                    </th>
                                    <th class="text-center">
                                        ลบ
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sql = "SELECT * FROM durable_articles";
                $result = mysqli_query($conn, $sql); 
               
                if ($result) {
                    // วนลูปเพื่อแสดงข้อมูล
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo '<tr>';
                      echo '<td class="text-center">' . $row['id_durable'] . '</td>';
                      echo '<td class="text-center">' . $row['type_durable'] . '</td>';
                      echo '<td class="text-center">' . $row['asset_id'] . '</td>';
                      echo '<td class="text-center">' . $row['name'] . '</td>';
                      echo '<td class="text-center">' . (isset($row['year']) ? ($row['year'] + 543) : '') . '</td>';
                      echo '<td class="text-center">' . $row['price'] . '</td>';
                      $department = $row['department'];
                      $sql_department = "SELECT name FROM department WHERE id_department = ' $department' LIMIT 1";
                      $result_department = mysqli_query($conn, $sql_department);
                      if ($row_department = mysqli_fetch_assoc($result_department)) {
                        echo '<td class="text-center">' . $row_department['name'] . '</td>';
                    } else {
                        // หากไม่พบข้อมูล, กำหนดค่าเป็น N/A หรืออื่น ๆ ตามที่ต้องการ
                        echo '<td class="text-center">N/A</td>';
                    }
                      // ดึงข้อมูลจากตาราง durable_check
                      $asset_id = $row['asset_id'];
                      $sql_service = "SELECT date_report_in FROM repair_report_pd05 WHERE asset_id = '$asset_id' AND type = 'service' AND status = '3' ORDER BY date_report_in DESC LIMIT 1";
                      $result_service = mysqli_query($conn, $sql_service);
                      
                      if ($result_service && $row_service = mysqli_fetch_assoc($result_service)) {
                        echo '<td class="text-center">' . date('d', strtotime($row_service['date_report_in'])) . ' ' . thaiMonth(date('m', strtotime($row_service['date_report_in']))) . ' ' . (date('Y', strtotime($row_service['date_report_in'])) + 543) . ' || ' . date('H:i', strtotime($row_service['date_report_in'])) . '</td>';
                      } else {
                          echo '<td class="text-center">N/A</td>';
                      }

                      $sql_check = "SELECT date_report_in FROM repair_report_pd05 WHERE asset_id = '$asset_id' AND type = 'ซ่อม' AND status = '3' ORDER BY date_report_in DESC LIMIT 1";
                      $result_check = mysqli_query($conn, $sql_check);
                      
                      if ($result_check && $row_check = mysqli_fetch_assoc($result_check)) {
                        echo '<td class="text-center">' . date('d', strtotime($row_check['date_report_in'])) . ' ' . thaiMonth(date('m', strtotime($row_check['date_report_in']))) . ' ' . (date('Y', strtotime($row_check['date_report_in'])) + 543) . ' || ' . date('H:i', strtotime($row_check['date_report_in'])) . '</td>';
                      } else {
                          echo '<td class="text-center">N/A</td>';
                      }
              
                      /*echo '<td class="project-actions text-right">';*/
                      echo '<td class="project-actions text-right"><a class="btn btn-primary btn-sm" href="./view_asset?id=' . urlencode($row['asset_id']) . '&id_durable='.$row['id_durable'].'"><i class="fa fa-search-plus"></i> View</a></td>';
                      echo '<td class="project-actions text-right"><a class="btn btn-secondary btn-sm" href="./check?id=' . urlencode($row['asset_id']) . '"><i class="fa fa-wrench"></i> Check</a></td>';
                      echo '<td class="project-actions text-right"><a class="btn btn-warning btn-sm" href="./form_rapair?id=' . urlencode($row['asset_id']) . '&id_durable='.$row['id_durable'].'"><i class="fas fa-pencil-alt"></i> Repair</a></td>';
                      echo '<td class="project-actions text-right"><a class="btn btn-danger btn-sm del-asset" href="#" data-id="'. $row['asset_id'] ."-,". $row['name'] .'"><i class="fas fa-trash"></i> Delete</a></td>';
                     /* echo '</td>';*/
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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>  
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
            window.location.href = "./parcel";
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
        icon: 'error',
        confirmButtonText: 'ตกลง',
        allowOutsideClick: false, // ไม่อนุญาตให้คลิกนอก popup ปิด
        allowEscapeKey: true, // ไม่อนุญาตให้กดปุ่ม ESC เพื่อปิด
        allowEnterKey: true // ไม่อนุญาตให้กดปุ่ม Enter เพื่อปิด
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "./parcel";
        }
    });
});

<?php
  }
?>

const deleteAsset = document.querySelectorAll('.del-asset');

deleteAsset.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const repairData = this.getAttribute('data-id').split('-,'); // แยกข้อมูลด้วยตัวแยก '-'
        const repairId = repairData[0];
        const repairName = repairData[1];

        Swal.fire({
            title: '<h4><label class="label t1">คุณต้องการลบข้อมูล</label></h4>',
            html: `<div><h6><label class="label t1">ชื่อครุภัณฑ์ : </label> ${repairName}<br><label class="label t1">เลขครุภัณฑ์ : </label>${repairId}<br></h6><br>`,
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
                window.location.href = `./controller/del_asset?id_repair=${repairId}`;
            }
        });
    });
});



$(document).ready(function () {
    $('#dtBasicExample').DataTable({
        autoWidth: false,
        scrollX: true
    });
    $('.dataTables_length').addClass('bs-select');

    // ปรับปรุงตำแหน่งของปุ่ม
    $('#dtBasicExample tbody').on('mouseenter', 'td', function () {
        $(this).find('.project-actions').css('right', '0');
    });

    $('#dtBasicExample tbody').on('mouseleave', 'td', function () {
        $(this).find('.project-actions').css('right', '-100px'); // ปรับตำแหน่งตามที่คุณต้องการ
    });
});

</script>
<style>
    .table .project-actions {
    white-space: nowrap;
}

.table .project-actions a.btn {
    margin-right: 5px;
}
</style>
<?php require '../popup/popup.php'; ?>
