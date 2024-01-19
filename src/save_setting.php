<?php
require_once './dbconfig.php';
// ตรวจสอบว่ามีการส่งค่าแบบ POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $id_person = $_POST['id-person'];
    $title_name = $_POST['name-title'];
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $position = $_POST['position'];
    $about = $_POST['about'];
    $department_id = $_POST['department-id'];
    
    
    // ตรวจสอบว่ามีการอัปโหลดรูปภาพหรือไม่
    if ($_FILES['profile-picture']['error'] === 0) {
        // รับข้อมูลรูปภาพจากฟอร์ม
        $uploadedImage = $_FILES['profile-picture'];

        // ตรวจสอบนามสกุลของไฟล์
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtension = pathinfo($uploadedImage['name'], PATHINFO_EXTENSION);

        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            // กรณีนามสกุลไม่ถูกต้อง, สามารถทำการตอบกลับหรือกระทำอย่างอื่นตามที่คุณต้องการ
            echo 'นามสกุลของไฟล์ไม่ถูกต้อง';
            exit;
        }

        // ทำการ resize รูปภาพ
        $targetWidth = 128;
        $targetHeight = 128;

        // สร้าง URL สำหรับ save รูปภาพ
        $uploadDirectory = './image_profile/';
        $filename = 'user_' . $id_person . '.' . $fileExtension;
        $targetFileName = $uploadDirectory . 'user_' . $id_person . '.' . $fileExtension;

        // ทำการ resize รูปภาพ
        list($originalWidth, $originalHeight) = getimagesize($uploadedImage['tmp_name']);
        $aspectRatio = $originalWidth / $originalHeight;

        $targetHeight = intval($targetWidth / $aspectRatio);

        $resizedImage = imagecreatetruecolor($targetWidth, $targetHeight);

        switch ($fileExtension) {
            case 'jpg':
            case 'jpeg':
                $sourceImage = imagecreatefromjpeg($uploadedImage['tmp_name']);
                break;
            case 'png':
                $sourceImage = imagecreatefrompng($uploadedImage['tmp_name']);
                break;
        }

        // ทำการ resize รูปภาพ
        imagecopyresampled(
            $resizedImage,
            $sourceImage,
            0, 0, 0, 0,
            $targetWidth, $targetHeight,
            $originalWidth, $originalHeight
        );

        // save รูปภาพที่ resize แล้ว
        switch ($fileExtension) {
            case 'jpg':
            case 'jpeg':
                imagejpeg($resizedImage, $targetFileName);
                break;
            case 'png':
                imagepng($resizedImage, $targetFileName);
                break;
        }

        // ล้าง memory
        imagedestroy($sourceImage);
        imagedestroy($resizedImage);
    } else {
        // กรณีไม่มีการอัปโหลดรูปภาพ
        $checkDuplicateSql = "SELECT profile_img FROM account WHERE id_person = '$id_person'";
        $resultDuplicate = mysqli_query($conn, $checkDuplicateSql);
        $row = mysqli_fetch_assoc($resultDuplicate);
        $filename = $row['profile_img']; 
    }  
    
    $update_sql = "UPDATE account SET name_title = '$title_name',first_name='$first_name',last_name='$last_name',position='$position',about='$about',department='$department_id',profile_img='$filename' WHERE id_person = $id_person ";
    $update_result = mysqli_query($conn, $update_sql);
    
    if ($update_result) {
        // บันทึกสำเร็จ
        echo "<script>alert('บันทึกข้อมูลสำเร็จ'); window.location.href = 'logout';</script>";

    } else {
        // บันทึกไม่สำเร็จ
        echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');</script>";
    }
}
?>