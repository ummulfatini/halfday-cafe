<?php
include('../connection.php');

if (isset($_POST['order_id'], $_POST['new_status'])) {
    $order_id = (int) $_POST['order_id'];
    $new_status = mysqli_real_escape_string($condb, $_POST['new_status']);

    $valid_statuses = ['pending', 'preparing', 'ready', 'completed', 'cancelled'];
    if (in_array($new_status, $valid_statuses)) {
        $query = "UPDATE cust_order SET status = '$new_status' WHERE order_id = $order_id";
        mysqli_query($condb, $query);
    }
}

header('Location: staff_orders.php');
exit;
