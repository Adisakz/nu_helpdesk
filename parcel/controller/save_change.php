<?php
session_start();
require_once '../../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idAsset = $_POST['asset-id'];
    $department_id = $_POST['department-id'];

    $sql = "UPDATE durable_articles SET department='$department_id' WHERE asset_id ='$idAsset' ";
     mysqli_query($conn, $sql);
     header("location: ../change?success=success&id=$idAsset");

} else {
    // กรณีไม่ใช่การเรียกผ่าน POST
    echo "Invalid request method";
}
?>