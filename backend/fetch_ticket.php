<?php
include 'db/connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `contact_pds` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No record found!']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid request.']);
}
?>
