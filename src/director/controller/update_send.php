<?php
session_start();
require_once '../../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idRepair = $_POST['id-repair'];
    $departmentId = $_POST['department-name'];
    $assetId = $_POST['asset-id'];
    $namereport = $_POST['name-report'];
    $reasons = $_POST['reasons'];
    $amount = $_POST['amount'];
    $amountLast = $_POST['amount_last'];
    $recomment = $_POST['recomment'];
    $inspectorName1 = $_POST['inspector_name1'];
    $inspectorName2 = $_POST['inspector_name2'];
    $inspectorName3 = $_POST['inspector_name3'];
    $repairType = $_POST['repairType'];
    $repairTypeTech = $_POST['repairTypeTech'];
    $id_person_send = $_POST['id-person-send'];

    // ตัวอย่างการแสดงผลเฉย ๆ
    /*echo "ID Repair: $idRepair<br>";
    echo "Repair Type: $repairType<br>";
    echo "Department ID: $departmentId<br>";
    echo "Asset ID: $assetId<br>";
    echo "Name report: $namereport<br>";
    echo "Reasons: $reasons<br>";
    echo "Amount: $amount<br>";
    echo "Amount Last: $amountLast<br>";
    echo "Recommendation: $recomment<br>";
    echo "Inspector Name 1: $inspectorName1<br>";
    echo "Inspector Name 2: $inspectorName2<br>";
    echo "Inspector Name 3: $inspectorName3<br>"; 
    echo "Repair Type Tech: $repairTypeTech<br>";
    echo "Send To: $id_person_send<br>";*/

    // $sql = "UPDATE repairs SET department_id = '$departmentid', asset_id = '$assetId', reasons = '$reasons', amount = '$amount', amount_last = '$amountLast', recomment = '$recomment', inspector_name1 = '$inspectorName1', inspector_name2 = '$inspectorName2', inspector_name3 = '$inspectorName3', repair_type = '$repair_type' WHERE id = '$idRepair'";
    // mysqli_query($conn, $sql);

    
} else {
    // กรณีไม่ใช่การเรียกผ่าน POST
    echo "Invalid request method";
}
?>
