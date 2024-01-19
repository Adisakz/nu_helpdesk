<?php
require_once '../../dbconfig.php';

// Check if the ID and reason are received
if (isset($_POST['id']) && isset($_POST['reason'])) {
    // Sanitize input data
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);

    // Your SQL query to update the database
    $sql = "UPDATE report_req_parcel SET comment_cancel = '$reason' ,status='5'WHERE id = $id";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Send a success response
        $response['success'] = true;
    } else {
        // Send an error response
        $response['success'] = false;
        $response['error'] = mysqli_error($conn);
    }
} else {
    // Send an error response if data is not received
    $response['success'] = false;
    $response['error'] = 'Invalid data received';
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection (optional)
mysqli_close($conn);
?>