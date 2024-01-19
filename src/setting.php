<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
require_once './dbconfig.php';

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
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Help Desk</title>
    <!-- Custom fonts for this template-->
    <link href="./css/all.min.css" rel="stylesheet" type="text/css">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="./css/fonts.css">
    <link rel="stylesheet" href="./css/bg.css">
    <!-- animation -->
    <link rel="stylesheet" href="./css/animation.css">
    <!-- Custom styles for this template-->
    <link href="./css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="./image/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>

<body class="bg">
    <div id="overlay"></div>
    <div class="w3-container w3-center w3-animate-top" style="animation-duration: 500ms;">
        <div class="container">
            <!-- Outer Row -->
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="p-5">
                                    <form action="./save_setting" method="POST" enctype="multipart/form-data">

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
                                                value="<?php echo $title_name_edit?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="first-name">ชื่อ</label>
                                            <input type="text" name="first-name" class="form-control" id="first-name"
                                                value="<?php echo $first_name_edit?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="last-name">นามสกุล</label>
                                            <input type="text" name="last-name" class="form-control" id="last-name"
                                                value="<?php echo $last_name_edit?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="position">ตำแหน่ง</label>
                                            <input type="text" name="position" class="form-control" id="position"
                                                value="<?php echo $position_edit?>" required> 
                                        </div>
                                        <div class="form-group">
                                            <label for="about">ข้อมูลเกี่ยวกับตำแหน่ง ( แสดงให้บุคคลอื่นเห็น )</label>
                                            <textarea name="about" class="form-control" id="about" required><?php echo $about_edit?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="department">หน่วยงาน</label>
                                            <div class="flex-container">
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
                                        </div>
                                        <div class="form-group">
                                            <label>สิทธิ์ในระบบ</label>
                                            <div class="flex-container">
                                                <input type="text" name="urole" class="form-control" id="urole"
                                                    value="<?php echo $urole_edit?>" readonly> 
                                            </div>
                                        </div>

                                        <button type="submit" class="form-control btn btn-success">save</button>


                                        </form>          
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="./plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jquery-validation -->
    <script src="./plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="./plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./dist/js/adminlte.min.js"></script>
</body>
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