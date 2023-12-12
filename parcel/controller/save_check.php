<?php
session_start();
require_once '../../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idAsset = $_POST['id-asset'];
    $status = $_POST['status'];
    $nameCheck = $_POST['name-check'];
    $detailCheck = $_POST['detail-check'];

    $sql = "INSERT INTO durable_check (asset_id, name_check, date_update, status, detail_check) VALUES ('$idAsset','$nameCheck',CURRENT_TIMESTAMP,'$status','$detailCheck')";
     mysqli_query($conn, $sql);
     header("location: ../parcel?success=success");

} else {
    // กรณีไม่ใช่การเรียกผ่าน POST
    echo "Invalid request method";
}
?>