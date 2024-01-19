<?php 
//edit_department_profile.php
//edit_resume_profile
session_start();
require_once '../dbconfig.php';


$id_person = $_SESSION['id'] ;
$sql_edit = "SELECT * FROM account WHERE id_person = $id_person";
$result_edit = mysqli_query($conn, $sql_edit); 
$row_edit = mysqli_fetch_assoc($result_edit);
$id_person_edit = $row_edit['id_person'];
$title_name_edit = $row_edit['name_title'];
$first_name_edit = $row_edit['first_name'];
$last_name_edit = $row_edit['last_name'];
$position_edit = $row_edit['position'];
$department_edit = $row_edit['department'];
$profile_img_edit = $row_edit['profile_img'];
$urole_edit = $row_edit['urole'];
$about_edit = $row_edit['about'];

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
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include './navber/navber.php' ;?>
        <!-- /.navbar -->
        <?php include './menu/menu.php' ;?>
        <script>
        // ในกรณีที่ต้องการรอให้หน้าเว็บโหลดเสร็จก่อน
        document.addEventListener('DOMContentLoaded', function() {
            // เลือก element และเปลี่ยน class
            document.querySelector('a[name="profile"]').classList.add('nav-link', 'active');
        });
        </script>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>แก้ไขบัญชีผู้ใช้</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">แก้ไขบัญชีผู้ใช้</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">

                            <form action="./controller/edit_resume_profile" method="POST" enctype="multipart/form-data">

                                <div class="text-center">

                                    <center>
                                        <img class="profile-user-img img-fluid img-circle" id="preview-image"
                                            src="../image_profile/<?php echo $profile_img_edit ?>"
                                            alt="User profile picture"></br></br>
                                        <input type="file" class="form-control" id="profile-picture"
                                            name="profile-picture" style="width:50%;">
                                    </center>
                                </div>
                                <div class="form-group">
                                    <label for="id-person">เลขบัตรประชาชน</label>
                                    <input type="text" name="id-person" class="form-control" id="id-person"
                                        value="<?php echo $id_person_edit?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name-title">คำนำหน้า</label>
                                    <input type="text" name="name-title" class="form-control" id="name-title"
                                        value="<?php echo $title_name_edit?>">
                                </div>
                                <div class="form-group">
                                    <label for="first-name">ชื่อ</label>
                                    <input type="text" name="first-name" class="form-control" id="first-name"
                                        value="<?php echo $first_name_edit?>">
                                </div>
                                <div class="form-group">
                                    <label for="last-name">นามสกุล</label>
                                    <input type="text" name="last-name" class="form-control" id="last-name"
                                        value="<?php echo $last_name_edit?>">
                                </div>
                                <div class="form-group">
                                    <label for="position">ตำแหน่ง</label>
                                    <input type="text" name="position" class="form-control" id="position"
                                        value="<?php echo $position_edit?>">
                                </div>
                                <div class="form-group">
                                    <label for="about">ข้อมูลเกี่ยวกับตำแหน่ง ( แสดงให้บุคคลอื่นเห็น )</label>
                                    <input type="text" name="about" class="form-control" id="about"
                                        value="<?php echo $about_edit?>">
                                </div>
                                <div class="form-group">
                                    <label for="department">หน่วยงาน</label>
                                    <div class="flex-container">
                                    <input id="departmentInput" type="text" class="form-control" value="<?php echo name_department($department_edit)?>" readonly>
                                        <a class="btn btn-primary"
                                            onclick="showChangeDepartmentPopup()">เปลี่ยนหน่วย</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="urole">สิทธิ์ในระบบ</label>
                                    <div class="flex-container">
                                        <input type="text" name="urole" class="form-control" id="urole"
                                            value="<?php echo $urole_edit?>" readonly> 
                                    </div>
                                </div>

                                <button type="submit" class="form-control btn btn-success">save</button>


                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include './footer/footer.php' ;?>

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
    <!-- jquery-validation -->
    <script src="../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- Page specific script -->

</body>

<!-- Modal เปลี่ยนแผนก-->
<div class="modal fade" id="changeDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เปลี่ยนหน่วยงาน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Dropdown หน่วยงาน -->
                <input type="text" name="id-person" class="form-control" id="id-person"
                    value="<?php echo $id_person_edit?>" hidden>
                <select name="department-id" class="form-control" id="newDepartment" required>
                    <option value="" disabled selected>--- เลือกหน่วยงาน ---</option>
                    <?php
                                            // ทำการดึงข้อมูลจากฐานข้อมูล
                                            $sql = "SELECT * FROM department"; // แทน your_table_name ด้วยชื่อตารางของคุณ
                                            $result = mysqli_query($conn, $sql);

                                            // ตรวจสอบว่ามีข้อมูลหรือไม่
                                            if ($result) {
                                                // วนลูปเพื่อแสดงข้อมูลใน dropdown
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['id_department'] . '">' . $row['name'] . '</option>';
                                                }
                                            }
                                            ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="saveNewDepartment()">บันทึก</button>
            </div>
        </div>
    </div>
</div>

</html>
<script>

// สร้าง event listener เมื่อมีการเลือกไฟล์รูปภาพ
document.getElementById('profile-picture').addEventListener('change', function(e) {
    const file = e.target.files[0];

    if (file) {
        const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

        if (!allowedExtensions.exec(file.name)) {
            // แสดง Popup แจ้งเตือนถ้านามสกุลไม่ถูกต้อง
            alert('กรุณาเลือกไฟล์รูปภาพที่มีนามสกุล .jpg, .jpeg หรือ .png เท่านั้น');
            // ล้างค่า input file
            document.getElementById('profile-picture').value = '';
            return false;
        }

        const imageUrl = URL.createObjectURL(file);
        document.getElementById('preview-image').src = imageUrl;
    }
});

function showChangeDepartmentPopup(id) {
    $('#changeDepartmentModal').modal('show');
}

function saveNewDepartment() {
    var userId = $('#id-person').val(); // ดึงค่า id จาก input hidden
    var newDepartmentValue = $('#newDepartment').val();
    $.ajax({
            url: './controller/edit_department_profile.php', // เปลี่ยนเป็นไฟล์ที่ทำหน้าที่บันทึกข้อมูล
            method: 'POST',
            data: { 
                userId: userId, 
                department: newDepartmentValue 
            },
            success: function(response) {
                alert('บันทึกเสร็จสิ้น');
                location.reload(); // รีเฟรชหน้า

                // ปิด Modal
                $('#changeDepartmentModal').modal('hide');
            },
            error: function(error) {
                console.error('เกิดข้อผิดพลาดในการบันทึก: ' + error.responseText);
            }
        });

      
    }

        
</script>
<style>
img.profile-user-img {
    width: 128px;
    height: 128px;
    object-fit: cover;
}

.flex-container {
    display: flex;
    gap: 10px;
    /* ระยะห่างระหว่าง items */
    align-items: center;
    /* จัดให้ items อยู่ตรงกลางแนวตั้ง */
}
</style>