<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['receipt']) && isset($_POST['order_id'])) {
    $order_id = (int) $_POST['order_id'];

    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $file = $_FILES['receipt'];
    $file_name = basename($file["name"]);
    $file_tmp = $file["tmp_name"];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed_exts = ["jpg", "jpeg", "png"];
    if (!in_array($file_ext, $allowed_exts)) {
        echo "<script>alert('Invalid file type.'); window.history.back();</script>";
        exit;
    }

    $new_filename = "receipt_order_" . $order_id . "_" . time() . "." . $file_ext;
    $target_file = $target_dir . $new_filename;

    if (move_uploaded_file($file_tmp, $target_file)) {
        // Store receipt filename into DB
        $stmt = mysqli_prepare($condb, "UPDATE cust_order SET status='pending', receipt_path=? WHERE order_id=?");
        mysqli_stmt_bind_param($stmt, "si", $new_filename, $order_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        echo "<script>alert('Receipt uploaded successfully!'); window.location.href='order_success.php';</script>";
    } else {
        echo "<script>alert('Failed to upload file.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid access.'); window.location.href='index.php';</script>";
}
