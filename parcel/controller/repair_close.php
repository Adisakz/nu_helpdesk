<?php
session_start();
require_once '../../dbconfig.php';

    $id = $_GET['id'];

    $sql = "UPDATE repair_report_pd05 SET send_to='' , status='3' ,close=CURRENT_TIMESTAMPWHERE id_repair ='$id' ";
    $result = mysqli_query($conn, $sql);
    if ($result) {
    header("location: ../repair?success=success");
    }
    else {
        header("location: ../repair?error=error");
    }
?>