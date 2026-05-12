<?php
include('../connection.php');
include('guard_admin.php'); 
$current_page = basename($_SERVER['PHP_SELF']); 

$query = "
    SELECT 
        o.order_id,
        o.order_time,
        o.total_amount,
        o.status,
        o.payment_status,
        o.receipt_path
    FROM cust_order o
    ORDER BY o.order_time DESC
";

$result = mysqli_query($condb, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Records</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        .receipt-img {
            max-width: 150px;
            height: auto;
            border: 1px solid #ccc;
        }
    </style>

        <div class="w3-container w3-padding-16" style = 'background-color: #8fbc8f;'>
        <h2>Customer Payments</h2>
        </div>

</head>
<body background = '../images/plantdoodle.jpg'>

<div class="w3-bar w3-border w3-margin-top w3-padding" style = 'background-color: #8fbc8f;'>    
        <a href="dashboard.php" class="w3-bar-item w3-button <?= ($current_page == 'dashboard.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Dashboard</a>
        <a href="manage_menu.php" class="w3-bar-item w3-button <?= ($current_page == 'manage_menu.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Menu</a>
        <a href="view_orders.php" class="w3-bar-item w3-button <?= ($current_page == 'view_orders.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Orders</a>
        <a href="admin_payments.php" class="w3-bar-item w3-button <?= ($current_page == 'admin_payments.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Payments</a>
        <a href="report.php" class="w3-bar-item w3-button <?= ($current_page == 'report.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Report</a>
        <a href="../logout.php" class="w3-bar-item w3-button w3-text-black w3-hover-text-grey w3-right">Logout</a> 
    </div>

<div class="w3-container w3-margin-top w3-padding">
<table class="w3-padding w3-table w3-bordered w3-margin-top w3-container" style="table-layout: fixed; width: 100%; background-color:beige">
    <tr style='background-color: Darkseagreen;'>
        <th>Order ID</th>
        <th>Order Time</th>
        <th>Total Amount (RM)</th>
        <th>Status</th>
        <th>Payment Status</th>
        <th>Receipt</th>
        <th>Uploaded Time</th>
    </tr> </div>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['order_id']; ?></td>
            <td><?= $row['order_time']; ?></td>
            <td><?= number_format($row['total_amount'], 2); ?></td>
            <td><?= ucfirst($row['status']); ?></td>
            <td><?= ucfirst($row['payment_status']); ?></td>
            <td>
                <?php if (!empty($row['receipt_path'])) { ?>
                    <img src="../uploads/receipts/<?= htmlspecialchars($row['receipt_path']); ?>" class="receipt-img" alt="Receipt">
                <?php } else { ?>
                    <span class="w3-text-grey">No receipt</span>
                <?php } ?>
            </td>
            <td>
                <?php 
                    if (!empty($row['receipt_path'])) {
                        // Extract time from filename if format is `receipt_TIMESTAMP_RANDOM.ext`
                        if (preg_match('/receipt_(\d+)_\d+\./', $row['receipt_path'], $matches)) {
                            echo date('Y-m-d H:i:s', $matches[1]);
                        } else {
                            echo '<span class="w3-text-grey">Unknown</span>';
                        }
                    } else {
                        echo '-';
                    }
                ?>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>

<?php include('../footer.php');
