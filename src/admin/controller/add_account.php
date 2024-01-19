<?php
session_start();
require_once '../../dbconfig.php';
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากฟอร์ม
    $idPerson = $_POST['id-person'];
    $nameTitle = $_POST['name-title'];
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $position = $_POST['position'];
    $departmentId = $_POST['department-id'];
    $urole = $_POST['urole'];

    // ตรวจสอบว่า id_person ซ้ำหรือไม่
    $checkDuplicateSql = "SELECT * FROM account WHERE id_person = '$idPerson'";
    $resultDuplicate = mysqli_query($conn, $checkDuplicateSql);

    if (mysqli_num_rows($resultDuplicate) > 0) {
        echo '<script>window.location.href = "../account?error";</script>';
        exit;
    }

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
        $uploadDirectory = '../../image_profile/';
        $filename = 'user_' . $idPerson . '.' . $fileExtension;
        $targetFileName = $uploadDirectory . 'user_' . $idPerson . '.' . $fileExtension;

        // ทำการ resize รูปภาพ
        list($originalWidth, $originalHeight) = getimagesize($uploadedImage['tmp_name']);
        $aspectRatio = $originalWidth / $originalHeight;

        $targetHeight = floatval($targetWidth / $aspectRatio);

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
        $filename = 'no-image.png'; 
    }

    // เพิ่มข้อมูลลงในตาราง account
    $sql = "INSERT INTO account (id_person, name_title, first_name, last_name, position, department, urole, profile_img)
            VALUES ('$idPerson', '$nameTitle', '$firstName', '$lastName', '$position', '$departmentId', '$urole', '$filename')";

    if (mysqli_query($conn, $sql)) {
        echo '<script>window.location.href = "../account?success";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    mysqli_close($conn);
}
?>