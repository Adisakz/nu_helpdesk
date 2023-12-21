<?php
session_start();
require_once '../../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // รับข้อมูลจาก URL
    $id_repair = $_GET['id_repair'];
    $cancelReason = $_GET['cancelReason'];
    // ทำการอัปเดตข้อมูลในฐานข้อมูล
    $sql = "UPDATE repair_report_pd05 SET cancel_comment = '$cancelReason', date_cancel = CURRENT_TIMESTAMP, status = '2' WHERE id_repair = $id_repair";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../repair?success=ok");
        exit();
    } 

    mysqli_close($conn);
} else {
    echo "Invalid request method!";
}
?>
