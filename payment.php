<?php
include('connection.php');
include('header.php');

$order_id = isset($_GET['order_id']) ? (int) $_GET['order_id'] : 0;

// If form is submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;

    if ($order_id <= 0 || !isset($_FILES['receipt'])) {
        echo "<script>alert('Invalid submission.'); window.location.href='index.php';</script>";
        exit;
    }

    $upload_dir = 'uploads/receipts/';
    $receipt_file = $_FILES['receipt'];
    $file_name = basename($receipt_file['name']);
    $file_tmp = $receipt_file['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png'];

    if (!in_array($file_ext, $allowed_ext)) {
        echo "<script>alert('Invalid file type. Please upload JPG or PNG only.'); window.history.back();</script>";
        exit;
    }

    $new_file_name = 'receipt_' . time() . '_' . rand(1000,9999) . '.' . $file_ext;
    $destination = $upload_dir . $new_file_name;

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (move_uploaded_file($file_tmp, $destination)) {
        // Save receipt filename and mark payment as pending
        $stmt = $condb->prepare("UPDATE orders SET receipt_file = ?, payment_status = 'Pending' WHERE order_id = ?");
        $stmt->bind_param("si", $new_file_name, $order_id);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('Receipt uploaded successfully!'); window.location.href='thankyou.php';</script>";
    } else {
        echo "<script>alert('Failed to upload receipt. Please try again.'); window.history.back();</script>";
    }
    exit;
}

// If accessed via GET (show form)
if ($order_id <= 0) {
    echo "<script>alert('Invalid order ID.'); window.location.href='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Receipt - Payment</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body background="images/plantdoodle.jpg">

<div class="w3-container w3-padding-32">

    <div class="w3-center w3-margin-top w3-margin-bottom" style="min-height: 30;">
    <img src="images/qr.jpg" class="w3-image" alt="QR Code" style="max-width: 30%; height: auto;">
</div>

    <h2>Upload Payment Receipt</h2>
    <p>Please upload a screenshot or photo of your payment receipt.</p>
    
    <form action="upload_receipt.php" method="POST" enctype="multipart/form-data" class="w3-container w3-card w3-padding" style='background-color:beige'>
        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
        
        <label>Choose Receipt Image (JPG/PNG only):</label>
        <input class="w3-input" type="file" name="receipt" accept=".jpg,.jpeg,.png" required>

        <button type="submit" class="w3-button w3-brown w3-margin-top">Submit Payment</button>
    </form>
    <div class="w3-panel w3-pale-red w3-border w3-border-red w3-round-large w3-padding">
        <strong>Warning:</strong> Going back to the previous page will clear your cart. Please upload your receipt to complete the order.
    </div>

</div>



</body>
</html>
