<?php
include 'db/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $sql = "UPDATE `newconn_pds` SET `nc_status` = ? WHERE `nc_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
