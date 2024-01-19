<?php 
//fetch_data.php
//add_qty_qr.php
//cut_qty_qr.php
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
    <script src="../barcode/html5-qrcode-master/minified/html5-qrcode.min.js"></script>
</head>
<style>
#videoContainer {
    display: none;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeParcelNavItem = document.querySelector('a[name="qr-code"]')
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
                            <h1>รายการข้อมูลพัสดุ</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./index">Home</a></li>
                                <li class="breadcrumb-item active">รายการข้อมูลพัสดุ</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">รายการข้อมูลพัสดุ</h3>
                    </div>
                    <!-- /.card-header -->

                    <!-- form start -->
                    <div class="card-body">
                        <div class="row">

                            <!-- ส่วนซ้าย -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="card">
                                        <center>
                                            <audio id="scan-success-sound" src="../barcode/Qr_code.mp3"></audio>
                                            <div id="qr-reader" style="width:100%"></div>
                                        </center>
                                        <button id="resetBtn" class="btn btn-danger">รีเซ็ทการสแกน</button>
                                    </div>
                                </div>
                            </div>

                            <!-- ส่วนขวา -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="card" style=" padding: 0 20px;">
                                        <h1>ข้อมูลพัสดุ</h1>
                                        <form action="">


                                            <div id="resultData"></div>



                                           

                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                <!-- เพิ่มการ์ดหัวข้อ -->
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
<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close-popup">&times;</span>
        <p id="popup-message"></p>
    </div>
</div>

</html>
<script>

function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on the next available tick
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

docReady(function() {
    var resultContainer = document.getElementById('qr-reader-results');
    var searchInput = document.getElementById('searchInput');
    var lastResult, countResults = 0;

    // Function to play scan success sound
    function playScanSuccessSound() {
        var audio = document.getElementById('scan-success-sound');
        if (audio) {
            audio.play();
        }
    }

    function performAutomaticSearch() {
        var decodedText = lastResult;
        if (decodedText) {
            // Parse the decodedText as an integer
            var searchValue = decodedText;
            // Play scan success sound
            playScanSuccessSound();
            $.ajax({
                type: 'POST',
                url: './controller/fetch_data.php', // Adjust the URL to your server-side script
                data: {
                    search: searchValue
                }, // Pass the integer value
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        console.log(response);
                        // Update the resultData div with the fetched data
                        $('#resultData').html(
                            '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">หมวดหมู่พัสดุ</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + response.type + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">ชื่อพัสดุ</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + response.name_parcel + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">รุ่น</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + response.model + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">ยี่ห้อ</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + response.brand + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' + '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">หน่วยนับ</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + response.unit_num + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' + '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">จำนวนคงเหลือ</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + response.qty + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">เพิ่ม - ลด</label>' +
                            '<div class="col-sm-8">' +
                            '<input class="form-control qty-input" type="number" min="0" value="0" data-id="' +
                            response.id + '">' +
                            '</div>' +
                            '</div>' +
                            '</div>'+
                            '<center>'+
                                '<a class="btn btn-success btn-sm btn-add" href="#">'+
                                '<i class="fas fa-plus"></i> Add</a>&nbsp;&nbsp;'+
                                '<a class="btn btn-danger btn-sm btn-cut" href="#">'+
                                '<i class="fas fa-minus"></i>Cut</a>'+
                            '</center>'
                        );
                    } else {
                        $('#resultData').html('<p>Data not found.</p>');
                    }
                },
                error: function(error) {
                    console.log('Error fetching data:', error);
                }
            });


        }

    }

    function onScanSuccess(decodedText, decodedResult) {
        if (decodedText !== lastResult) {
            ++countResults;
            lastResult = decodedText;
            // Handle on success condition with the decoded message.
            console.log(`Scan result ${decodedText}`, decodedResult);

            // Perform automatic search
            performAutomaticSearch();
        }
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", {
            fps: 10,
            qrbox: 250
        });
    html5QrcodeScanner.render(onScanSuccess);

    document.getElementById('resetBtn').addEventListener('click', function() {
        lastResult = null;
        countResults = 0;
        searchInput.value = '';
    });


 
});
// Event listener สำหรับปุ่ม "Add"
$(document).on('click', '.btn-add', function() {
    // ดึงค่าที่ผู้ใช้กรอก
    const inputValue = $('.qty-input').val();
    const itemId = $(this).closest('.form-group').find('input.qty-input').data('id');
    
    $.ajax({
                type: 'POST',
                url: './controller/add_qty_qr.php',
                data: {
                    id: itemId,
                    newQuantity: inputValue
                },
                success: function(updateResponse) {
                    showPopup('เพิ่มจำนวนเรียบร้อย');
                    $('#resultData').html(
                            '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">หมวดหมู่พัสดุ</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + updateResponse.type + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">ชื่อพัสดุ</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + updateResponse.name_parcel + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">รุ่น</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + updateResponse.model + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">ยี่ห้อ</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + updateResponse.brand + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' + '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">หน่วยนับ</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + updateResponse.unit_num + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' + '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">จำนวนคงเหลือ</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + updateResponse.qty + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">เพิ่ม - ลด</label>' +
                            '<div class="col-sm-8">' +
                            '<input class="form-control qty-input" type="number" min="0" value="0" data-id="' +
                            updateResponse.id + '">' +
                            '</div>' +
                            '</div>' +
                            '</div>'+
                            '<center>'+
                                '<a class="btn btn-success btn-sm btn-add" href="#">'+
                                '<i class="fas fa-plus"></i> Add</a>&nbsp;&nbsp;'+
                                '<a class="btn btn-danger btn-sm btn-cut" href="#">'+
                                '<i class="fas fa-minus"></i>Cut</a>'+
                            '</center>'
                        );
                },
                error: function(error) {
                    console.log('Error updating quantity:', error);
                }
            });
  
});

// Event listener สำหรับปุ่ม "Delete"
$(document).on('click', '.btn-cut', function() {
    // ดึงค่าที่ผู้ใช้กรอก
    const inputValue = $('.qty-input').val();
    const itemId = $(this).closest('.form-group').find('input.qty-input').data('id');
    
    $.ajax({
                type: 'POST',
                url: './controller/cut_qty_qr.php',
                data: {
                    id: itemId,
                    newQuantity: inputValue
                },
                success: function(delResponse) {
                    showPopup('ลดจำนวนเรียบร้อย');
                    $('#resultData').html(
                            '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">หมวดหมู่พัสดุ</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + delResponse.type + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">ชื่อพัสดุ</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + delResponse.name_parcel + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">รุ่น</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + delResponse.model + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">ยี่ห้อ</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + delResponse.brand + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' + '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">หน่วยนับ</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + delResponse.unit_num + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' + '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">จำนวนคงเหลือ</label>' +
                            '<div class="col-sm-8">' +
                            '<p>' + delResponse.qty + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<div class="mb-3 row">' +
                            '<label for="repair-date" class="col-sm-4 col-form-label">เพิ่ม - ลด</label>' +
                            '<div class="col-sm-8">' +
                            '<input class="form-control qty-input" type="number" min="0" value="0" data-id="' +
                            delResponse.id + '">' +
                            '</div>' +
                            '</div>' +
                            '</div>'+
                            '<center>'+
                                '<a class="btn btn-success btn-sm btn-add" href="#">'+
                                '<i class="fas fa-plus"></i> Add</a>&nbsp;&nbsp;'+
                                '<a class="btn btn-danger btn-sm btn-cut" href="#">'+
                                '<i class="fas fa-minus"></i>Cut</a>'+
                            '</center>'
                        );
                },
                error: function(error) {
                    console.log('Error updating quantity:', error);
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
        // ซ่อน Popup เมื่อหมดเวลา
        $("#popup").fadeOut();
    }, 2000);
}

// ปิด Popup ด้วยการคลิกที่ปุ่มปิด
$(".close-popup").on("click", function() {
    $("#popup").fadeOut();
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
</style>
<?php require '../popup/popup.php'; ?>