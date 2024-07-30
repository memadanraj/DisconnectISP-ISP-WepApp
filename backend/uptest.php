<?php
session_start();
include 'db/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['upload'])) {
    $file = $_FILES['upload'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_parts = pathinfo($file_name);
    $file_ext = strtolower($file_parts['extension']);
    $allowed_extensions = array("jpg", "jpeg", "png", "svg");

    if (!in_array($file_ext, $allowed_extensions)) {
        $response = array(
            "uploaded" => false,
            "error" => array(
                "message" => "Please choose only JPG, JPEG, PNG, or SVG file !!"
            )
        );
        echo json_encode($response);
        exit();
    }

    $new_image_name = rand() . '.' . $file_ext;
    $folder = "img/" . $new_image_name;

    if (move_uploaded_file($file_tmp, $folder)) {
        $response = array(
            "uploaded" => true,
            "url" => $folder
        );
    } else {
        $response = array(
            "uploaded" => false,
            "error" => array(
                "message" => "Failed to upload file."
            )
        );
    }

    echo json_encode($response);
}
?>
