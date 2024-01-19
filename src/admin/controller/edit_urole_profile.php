<?php
require_once '../../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $urole = $_POST['urole'];
    $update_sql = "UPDATE account SET urole = '$urole' WHERE id_person = $userId ";
    $update_result = mysqli_query($conn, $update_sql);

    if ($update_result) {
        $response = array(
            'success' => true
        );
        echo json_encode($response);
    } else {
        echo json_encode(array('success' => false));
    }
}
?>