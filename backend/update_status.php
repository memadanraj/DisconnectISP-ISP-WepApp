<?php
include 'db/connect.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $sql = "UPDATE `contact_pds` SET `status` = ? WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $id);
    
    if ($stmt->execute()) {
        echo "Status updated successfully!";
    } else {
        echo "Error updating status: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

