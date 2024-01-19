<?php
require_once '../../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantities = $_POST['quantities'];

    foreach ($quantities as $id => $quantity) {
        // ลดจำนวนในฐานข้อมูล
        $cutSql = "UPDATE parcel_data SET qty = qty - $quantity WHERE id_parcel = $id";
        $cutResult = mysqli_query($conn, $cutSql);

        if (!$cutResult) {
            echo "เกิดข้อผิดพลาดในการลดจำนวน: " . mysqli_error($conn);
            exit;
        }
    }

    // ส่งข้อมูลกลับเพื่อทำการตอบสนองในกรณีทดสอบ
    $responseData = array(
        'success' => true,
        'message' => 'ลดจำนวนเรียบร้อยแล้ว',
        'cutQuantities' => $quantities
    );

    // ส่งข้อมูลในรูปแบบ JSON
    header('Content-Type: application/json');
    echo json_encode($responseData);
    exit();
} else {
    echo "วิธีการร้องขอไม่ถูกต้อง";
}
?>