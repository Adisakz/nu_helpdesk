<?php
require_once '../../dbconfig.php';
error_reporting(E_ERROR | E_PARSE);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากฟอร์ม
    $idPerson = $_POST['id-person'];
    $nameTitle = $_POST['name-title'];
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $position = $_POST['position'];
    $about = $_POST['about'];



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

        // ตรวจสอบว่าไฟล์ที่จะบันทึกมีอยู่แล้วหรือไม่
        if (file_exists($targetFileName)) {
            // ถ้ามีอยู่แล้ว สร้างชื่อไฟล์ใหม่หรือทำการตอบกลับหรือกระทำตามที่คุณต้องการ
            $filename = 'user_' . $idPerson . '_' . time() . '.' . $fileExtension;
            $targetFileName = $uploadDirectory . $filename;
        }
    
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
        $checkDuplicateSql = "SELECT profile_img FROM account WHERE id_person = '$idPerson'";
        $resultDuplicate = mysqli_query($conn, $checkDuplicateSql);
        $row = mysqli_fetch_assoc($resultDuplicate);
        $filename = $row['profile_img']; 
    }
    // ทำตามคำสั่งอื่น ๆ ที่ต้องการ...
/*echo "idPerson: $idPerson<br>";
echo "nameTitle: $nameTitle<br>";
echo "firstName: $firstName<br>";
echo "lastName: $lastName<br>";
echo "position: $position<br>";
echo "about: $about<br>";
echo "targetFileName: $filename<br>";
*/

    // เพิ่มหรือปรับปรุงข้อมูลในฐานข้อมูล
    $sql = "UPDATE account SET
        name_title = '$nameTitle',
        first_name = '$firstName',
        last_name = '$lastName',
        position = '$position',
        about = '$about',
        profile_img = '$filename'
        WHERE id_person = '$idPerson'";

    if (mysqli_query($conn, $sql)) {
        // สำเร็จ
        echo '<script>window.location.href = "../edit_account?id='.$idPerson.'";</script>';
    } else {
        // ไม่สำเร็จ
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    mysqli_close($conn);
}
?>