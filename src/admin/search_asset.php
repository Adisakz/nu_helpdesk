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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<script>
    // ในกรณีที่ต้องการรอให้หน้าเว็บโหลดเสร็จก่อน
    document.addEventListener('DOMContentLoaded', function() {
        // เลือก element และเปลี่ยน class
        document.querySelector('a[name="search_asset"]').classList.add('nav-link', 'active');
    });
</script> 
<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

        <!-- /.navbar -->
        <?php include './navber/navber.php' ;?>
        <!-- /.navbar -->
        <!-- /.menu -->
        <?php include './menu/menu.php' ;?>
        <!-- /.menu -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>แจ้งซ่อมครุภัณฑ์</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./index">Home</a></li>
                                <li class="breadcrumb-item active">แจ้งซ่อมครุภัณฑ์</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-body p-0" style="margin: 10px 10px 0 10px;">
            <div class="form-group">
                <form action="" method="GET" id="searchForm">
                    <label for="searchInput">ค้นหา:</label>
                    <input type="text" name="search" id="searchInput" class="form-control " placeholder="กรอกเลขครุภัณฑ์" required><br>
                    <button type="submit" class="form-control btn btn-primary">ค้นหา</button>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <?php
    if (isset($_GET['search'])) {
        $search = mysqli_real_escape_string($conn, $_GET['search']);
        $sql = "SELECT * FROM durable_articles WHERE asset_id LIKE '%$search%'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
    ?>
                <div class="card 1">
                    <div class="card-body p-0" style="margin: 10px 10px 0 10px;">
                        <div class="form-group">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped projects">
                                        <tbody id="tableBody">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">หมวดหมู่ครุภัณฑ์</th>
                                                    <th class="text-center">เลขที่ครุภัณฑ์</th>
                                                    <th class="text-center">ชื่อครุภัณฑ์</th>
                                                    <th class="text-center">ปีที่ซื้อ</th>
                                                    <th class="text-center">ราคา(บาท)</th>
                                                    <th class="text-center">แผนกที่รับผิดชอบ</th>
                                                    <th class="text-center">Service ล่าสุด</th>
                                                    <th class="text-center">ซ่อมล่าสุด</th>
                                                    <th class="text-center">ดูข้อมูล</th>
                                                    <th class="text-center">แจ้งซ่อม</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr>';
                                                echo '<td class="text-center">' . $row['id_durable'] . '</td>';
                                                echo '<td class="text-center">' . $row['type_durable'] . '</td>';
                                                echo '<td class="text-center">' . $row['asset_id'] . '</td>';
                                                echo '<td class="text-center">' . $row['name'] . '</td>';
                                                echo '<td class="text-center">' . (isset($row['year']) ? ($row['year'] + 543) : '') . '</td>';
                                                echo '<td class="text-center">' . $row['price'] . '</td>';
                                                $department = $row['department'];
                                                $sql_department = "SELECT name FROM department WHERE id_department = '$department' LIMIT 1";
                                                $result_department = mysqli_query($conn, $sql_department);

                                                if ($row_department = mysqli_fetch_assoc($result_department)) {
                                                    echo '<td class="text-center">' . $row_department['name'] . '</td>';
                                                } else {
                                                    echo '<td class="text-center">N/A</td>';
                                                }

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

                                                echo '<td class="project-actions text-right"><a class="btn btn-primary btn-sm" href="./view_asset?id=' . urlencode($row['asset_id']) . '&id_durable=' . $row['id_durable'] . '"><i class="fa fa-search-plus"></i> View</a></td>';
        
                                                echo '<td class="project-actions text-right"><a class="btn btn-warning btn-sm" href="./form_rapair?id=' . urlencode($row['asset_id']) . '&id_durable=' . $row['id_durable'] . '"><i class="fas fa-pencil-alt"></i> Repair</a></td>';
                                                
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            <?php
            } else {
                $searchedAsset = $_GET['search'];
                echo '<div class="card" style="border-color: red;">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title" style="color: red;">ไม่พบหมายเลขครุภัณฑ์ ' . $searchedAsset . ' </h5>';
                echo '<p class="card-text">กรุณาตรวจสอบหมายเลขครุภัณฑ์อีกครั้ง หากต้องการแจ้งซ่อม กรุณาคลิกปุ่มด้านล่าง</p>';
                echo '<a href="./form_rapair_non_search?id='.$searchedAsset.'" class="btn btn-danger">แจ้งซ่อม</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    ?>
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


document.addEventListener('DOMContentLoaded', function() {
    // เพิ่ม Event Listener สำหรับปุ่มยกเลิก
    var cancelButton = document.getElementById('cancelButton');
    cancelButton.addEventListener('click', function() {
        closePopup();
    });
});

// ฟังก์ชันค้นหาข้อมูล
function search() {
    // เรียกใช้ AJAX หรือ Fetch API เพื่อดึงข้อมูล SQL จากเซิร์ฟเวอร์
    // แล้วนำข้อมูลมาแสดงในตาราง
    // ตัวอย่าง: ใช้ Fetch API
    var searchInput = document.getElementById('searchInput').value;
    fetch('your_server_script.php?search=' + encodeURIComponent(searchInput))
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                // แสดงข้อมูลในตาราง
                displayDataInTable(data);
            } else {
                // แสดง Popup แจ้งไม่พบข้อมูล
                alert("ไม่พบข้อมูลที่ค้นหา");
            }
        })
        .catch(error => console.error('Error:', error));
}

// ฟังก์ชันแสดงข้อมูลในตาราง
function displayDataInTable(data) {
    var tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = ''; // ล้างข้อมูลเดิม

    // วนลูปแสดงข้อมูลในตาราง
    data.forEach(row => {
        // ... (สร้างแถวและเติมข้อมูลในแต่ละเซลล์ตามความต้องการ) ...
    });
}

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