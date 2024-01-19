<?php
require_once '../../dbconfig.php';

   ///////////  แสดงชื่อหมวดหมู่พัสดุ
   function name_parcel($id) {
    global $conn; // Assuming $conn is your database connection variable

    $sql_parcel = "SELECT name FROM type_parcel WHERE id = '$id' LIMIT 1";
    $result_parcel = mysqli_query($conn, $sql_parcel);

    if ($row_parcel = mysqli_fetch_assoc($result_parcel)) {
        $parcel = $row_parcel['name'];
        return $parcel;
    } else {
        $parcel = '';
        return $parcel;
    }
}

///////////  แสดงหน่วยนับพัสดุ
function unit_parcel($id) {
    global $conn; // Assuming $conn is your database connection variable

    $sql_unit = "SELECT name FROM unit_parcel WHERE id = '$id' LIMIT 1";
    $result_unit = mysqli_query($conn, $sql_unit);

    if ($row_unit = mysqli_fetch_assoc($result_unit)) {
        $unit = $row_unit['name'];
        return $unit;
    } else {
        $unit = '';
        return $unit;
    }
}

// Initialize response array
$responseData = array();


// Fetch data from the database based on the QR code value
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $newQuantity =  $_POST['newQuantity'];
    $updateSql = "UPDATE parcel_data SET qty = qty + $newQuantity WHERE id_parcel = $id";
    $updateResult = mysqli_query($conn, $updateSql);
    
    if ($updateResult) {
        // Check the number of affected rows
        $affectedRows = mysqli_affected_rows($conn);
    
        if ($affectedRows > 0) {
            // Data found, construct success response
            $sql = "SELECT * FROM parcel_data WHERE id_parcel = $id";
            $result = mysqli_query($conn, $sql);
    
            if ($result) {
                $row = mysqli_fetch_assoc($result);
    
                if ($row) {
                    // Data found, construct success response
                    $responseData = array(
                        'success' => true,
                        'id' =>  $row['id_parcel'],
                        'type' => name_parcel($row['type']),
                        'name_parcel' => $row['name_parcel'],
                        'model' => $row['model'],
                        'brand' =>  $row['brand'],
                        'unit_num' => unit_parcel($row['unit_num']),
                        'qty' =>  $row['qty']
                    );
                } else {
                    // No rows affected, construct failure response
                    $responseData = array(
                        'success' => false,
                        'msg' => 'Data not found'
                    );
                }
            } else {
                // Query failed, construct error response
                $responseData = array(
                    'success' => false,
                    'msg' => 'Error fetching data'
                );
            }
        } else {
            // No rows affected, construct failure response
            $responseData = array(
                'success' => false,
                'msg' => 'Data not found'
            );
        }
    } else {
        // Query failed, construct error response
        $responseData = array(
            'success' => false,
            'msg' => 'Error updating data'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($responseData);
    exit;
}
?>