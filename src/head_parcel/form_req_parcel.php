<?php 
session_start();
require_once '../dbconfig.php';

///////////  แสดงชื่อหมวดหมู่พัสดุ
function name_parcel($id) {
    global $conn; // Assuming $conn is your database connection variable

    $sql_parcel = "SELECT name FROM type_parcel WHERE id = '$id' LIMIT 1";
    $result_parcel = mysqli_query($conn, $sql_parcel);

    if ($row_parcel = mysqli_fetch_assoc($result_parcel)) {
        $parcel = $row_parcel['name'];
        return $parcel;
    } else {
        $parcel = '';
        return $parcel;
    }
}

///////////  แสดงชื่อหมวดหมู่พัสดุ
function name_unit($id) {
    global $conn; // Assuming $conn is your database connection variable

    $sql_parcel = "SELECT name FROM unit_parcel WHERE id = '$id' LIMIT 1";
    $result_parcel = mysqli_query($conn, $sql_parcel);

    if ($row_parcel = mysqli_fetch_assoc($result_parcel)) {
        $parcel = $row_parcel['name'];
        return $parcel;
    } else {
        $parcel = '';
        return $parcel;
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
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
            document.querySelector('a[name="req_parcel"]').classList.add('nav-link', 'active');
        });
        </script>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>เบิกพัสดุ</h1>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./index">Home</a></li>
                                <li class="breadcrumb-item active">เบิกพัสดุ</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">รายการพัสดุ</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped projects" cellspacing="0" width="100%"
                                            id="dtBasicExample">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        หมวดหมู่พัสดุ
                                                    </th>
                                                    <th class="text-center">
                                                        ชื่อพัสดุ
                                                    </th>

                                                    <th class="text-center">
                                                        หน่วยนับ
                                                    </th>
                                                    <th class="text-center">
                                                        จำนวนคงเหลือ
                                                    </th>
                                                    <th class="text-center">
                                                        เบิก
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $sql = "SELECT * FROM parcel_data";
                                        $result = mysqli_query($conn, $sql); 
                                    
                                        if ($result) {
                                            // วนลูปเพื่อแสดงข้อมูล
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr>';
                                                echo '<td class="text-center">' . name_parcel($row['type'] ). '</td>';
                                                echo '<td class="text-center">' . $row['name_parcel'] . '</td>';
                                                echo '<td class="text-center">' .name_unit($row['unit_num'])  . '</td>';
                                                echo '<td class="text-center">' . $row['qty'] . '</td>';                      
                                                echo '<td class="text-center" >';
                                                echo '<a class="btn btn-success btn-circle btn-sm btn-req" data-id="' . $row['id_parcel'] . '" data-name="' . $row['name_parcel'] . '" data-qty="' . $row['qty'] . '"><i class="fas fa-plus"></i></a>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                        } 
                                        else {
                                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                                        }

                                        // ปิดการเชื่อมต่อ
                                        mysqli_close($conn);
                                    
                                        ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- /.card-body -->

                            </div>
                            <!-- /.card -->

                        </div>
                        <!-- /.col -->
                        <div class="col-md-5">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title ">รายการเบิก</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <form id="selectedItemsForm" action="./req_parcel" method="post">
                                        <div class="card-body" id="selectedItems">
                                            <!-- Content of the right card goes here -->

                                        </div>
                                        <center>
                                            <button id="btn-next-step" class="btn btn-primary"
                                                style="margin-bottom: 10px;">ขั้นตอนต่อไป</button>
                                        </center>

                                    </form>

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

    // การกรองตารางโดยใช้ Dropdown แผนก
    $('#departmentFilter').on('change', function() {
        var selectedDepartment = $(this).val();
        table.column(5)
            .search(selectedDepartment)
            .draw();
    });

    var selectedItemsData = [];
    $('#dtBasicExample tbody').on('click', 'a.btn-req', function() {
        $('#btn-next-step').show();
        // Get the selected row data
        var dataId = $(this).data('id');
        var dataName = $(this).data('name');
        var availableQty = parseInt($(this).data('qty'));
        // Assuming the right card body has an element with id "selectedItems"
        var selectedItems = $('#selectedItems');

        // Check if the item is already in the right card
        var existingItem = selectedItems.find('.item[data-id="' + dataId + '"]');

        if (existingItem.length > 0) {
            // If the item exists, update its quantity
            var quantityElement = existingItem.find('.quantity');
            var quantity = parseInt(quantityElement.val());
            if (quantity < availableQty) {} else {
                // Show an alert or some message indicating that the quantity is not available
                alert('ไม่สามารถเบิกเพิ่มได้ เนื่องจากสินค้าไม่เพียงพอ');
            }
        } else {
            // Check if availableQty is greater than 0 before adding the item
            if (availableQty > 0) {
                var newItem = $('<div class="item" data-id="' + dataId +
                    '" style="display: flex; align-items: center;">' +
                    '<span class="name"> ' + dataName + ' => ' + availableQty + ' </span>' +
                    '<input type="number" id="numberInput" class="quantity" value="1" style="width: 50px; text-align: center; margin-left: auto;" min="1" max="' +
                    availableQty + '" name="selectedItems[]">' +
                    '<button class="btn btn-sm btn-danger remove-item"><i class="fas fa-trash"></i></button>' +
                    '</div>'
                );

                selectedItems.append(newItem);

                selectedItemsData.push({
                    dataId: dataId,
                    dataName: dataName,
                    availableQty: availableQty,
                    quantity: parseInt(newItem.find('.quantity').val())
                });
            } else {
                // Show an alert or some message indicating that the quantity is not available
                alert('ไม่สามารถเบิกได้ เนื่องจากสินค้าไม่เพียงพอ');
            }
        }

    });
    $('#selectedItems').on('input', 'input.quantity', function() {
        var maxQuantity = $(this).parent().data('availableQty');
        var currentQuantity = parseInt($(this).val()) || 0;

        // ตรวจสอบว่าค่าที่กรอกเข้ามาไม่เกิน maxQuantity
        if (currentQuantity > maxQuantity) {
            // ถ้าเกินให้ปรับค่าให้เท่ากับ maxQuantity
            $(this).val(maxQuantity);
            alert('ไม่สามารถกรอกค่ามากกว่า ' + maxQuantity + ' ได้');
        }

        // อัพเดตค่าใน selectedItemsData
        var dataId = $(this).parent().data('id');
        var selectedItem = selectedItemsData.find(item => item.dataId === dataId);
        if (selectedItem) {
            selectedItem.quantity = currentQuantity;
        }
    });
    // Handle click event on the "Remove" button in the right card
    $('#selectedItems').on('click', 'button.remove-item', function() {
        // Get the data-id of the item being removed
        var removedDataId = $(this).parent().data('id');

        // Remove the item from the selectedItemsData array
        selectedItemsData = selectedItemsData.filter(function(item) {
            return item.dataId !== removedDataId;
        });
        if (selectedItemsData.length === 0) {
            $('#btn-next-step').hide();
        }
        // Remove the item from the DOM
        $(this).parent().remove();
    });

    $('#btn-next-step').on('click', function() {


        // Check if there are selected items
        if (selectedItemsData.length > 0) {
            // Clear existing form fields
            $('#selectedItemsForm').empty();
            var allQuantitiesValid = true;
            // Populate form fields with selected items data
            selectedItemsData.forEach(function(item) {
                if (item.quantity <= 0 || item.quantity > item.availableQty) {
                    if (selectedItemsData.length > 1) {
                     alert('จำนวนทีต้องการเกินจำนวนที่มีอยู่ ' + item.dataName);
                    }else{
                        alert('กรุณากรอกจำนวนที่ถูกต้องสำหรับ ' + item.dataName);
                        location.reload();
                    }
                }else{
                     $('#selectedItemsForm').append(
                    '<input type="hidden" name="selectedItems[]" value="' + item.dataId +
                    '">' +
                    '<input type="hidden" name="selectedItems[]" value="' + item.dataName +
                    '">' +
                    '<input type="hidden" name="selectedItems[]" value="' + item
                    .availableQty + '">' +
                    '<input type="hidden" name="selectedItems[]" value="' + item.quantity +
                    '">' // Add this line for quantity
                );// Submit the form
            $('#selectedItemsForm').submit();
                }
               
            });

            
        } else {
            alert('กรุณาเลือกรายการเบิกก่อน');
        }
    });
});
</script>
<?php
require '../popup/popup.php';

?>