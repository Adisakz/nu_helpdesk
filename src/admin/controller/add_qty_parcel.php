<?php
require_once '../../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantities = $_POST['quantities'];

    // ตัวแปรสำหรับตรวจสอบว่าทุกรายการถูกบันทึกเรียบร้อย
    $success = true;

    foreach ($quantities as $id => $quantity) {
        // อัปเดตจำนวนในฐานข้อมูล
        $updateSql = "UPDATE parcel_data SET qty = qty + $quantity WHERE id_parcel = $id";
        $updateResult = mysqli_query($conn, $updateSql);

        if (!$updateResult) {
            // ถ้าเกิดข้อผิดพลาดในการอัปเดต ตั้งค่า $success เป็น false
            $success = false;
            echo "เกิดข้อผิดพลาดในการอัปเดตจำนวน: " . mysqli_error($conn);
            exit;
        }
    }
    if ($success) {
        $responseData = array(
            'success' => true,
            'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'updatedQuantities' => $quantities
        );
    } else {
        $responseData = array(
            'success' => false,
            'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'
        );
    }
    
    // ทำการส่งข้อมูลในรูปแบบ JSON
    header('Content-Type: application/json');
    echo json_encode($responseData);
    exit();
} else {
    echo "วิธีการร้องขอไม่ถูกต้อง";
}
?>