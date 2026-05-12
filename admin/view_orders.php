<?php
include('../connection.php');
include('guard_admin.php');

$current_page = basename($_SERVER['PHP_SELF']);

// Fetch all orders with their items (including receipt_path and payment_status)
$query = "
    SELECT 
        o.order_id,
        o.order_time,
        o.total_amount,
        o.status,
        o.payment_status,
        o.table_no,
        o.receipt_path,
        i.name AS item_name,
        i.category,
        oi.order_item_id,
        oi.quantity,
        oi.price_at_order_time,
        io.option_type,
        io.option_name
    FROM cust_order o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN menu_items i ON oi.item_id = i.item_id
    LEFT JOIN order_item_options oio ON oi.order_item_id = oio.order_item_id
    LEFT JOIN item_options io ON oio.option_id = io.option_id
    ORDER BY o.order_time DESC, o.order_id, oi.order_item_id
";

$result = mysqli_query($condb, $query);

// Group the result by order
$orders = [];

while ($row = mysqli_fetch_assoc($result)) {
    $order_id = $row['order_id'];
    $order_item_id = $row['order_item_id'];

    // Create order
    if (!isset($orders[$order_id])) {
        $orders[$order_id]['info'] = [
            'order_time' => $row['order_time'],
            'total_amount' => $row['total_amount'],
            'status' => $row['status'],
            'payment_status' => $row['payment_status'],
            'table_no' => $row['table_no'],
            'receipt_path' => $row['receipt_path']
        ];
        $orders[$order_id]['items'] = [];
    }

    // Create item
    if (!isset($orders[$order_id]['items'][$order_item_id])) {
        $orders[$order_id]['items'][$order_item_id] = [
            'item_name' => $row['item_name'],
            'category' => $row['category'],
            'quantity' => $row['quantity'],
            'price' => $row['price_at_order_time'],
            'options' => []
        ];
    }

    // Add option if available
    if (!empty($row['option_name'])) {
        $orders[$order_id]['items'][$order_item_id]['options'][] = [
            'type' => $row['option_type'],
            'name' => $row['option_name']
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body background="../images/plantdoodle.jpg">

<div class="w3-container w3-padding-16" style="background-color: #8fbc8f;">
    <h2>All Orders</h2>
</div>

<div class="w3-bar w3-border w3-margin-top w3-padding" style="background-color: #8fbc8f;">
    <a href="dashboard.php" class="w3-bar-item w3-button <?= ($current_page == 'dashboard.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Dashboard</a>
    <a href="manage_menu.php" class="w3-bar-item w3-button <?= ($current_page == 'manage_menu.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Menu</a>
    <a href="view_orders.php" class="w3-bar-item w3-button <?= ($current_page == 'view_orders.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Orders</a>
    <a href="admin_payments.php" class="w3-bar-item w3-button <?= ($current_page == 'admin_payments.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Payments</a>
    <a href="report.php" class="w3-bar-item w3-button <?= ($current_page == 'report.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Report</a>
    <a href="../logout.php" class="w3-bar-item w3-button w3-text-black w3-hover-text-grey w3-right">Logout</a> 
</div>

<div class="w3-container">
    <?php if (empty($orders)): ?>
        <p>No orders found.</p>
    <?php else: ?>
        <?php foreach ($orders as $order_id => $order): ?>
            <div style="background-color: beige;" class="w3-card w3-margin-top w3-margin-bottom w3-padding">
                <h4>Order #<?= $order_id ?> | Table <?= $order['info']['table_no'] ?></h4>
                <p><strong>Time:</strong> <?= $order['info']['order_time'] ?></p>
                <p><strong>Status:</strong> <?= ucfirst($order['info']['status']) ?></p>
                <p><strong>Payment Status:</strong> <?= ucfirst($order['info']['payment_status']) ?></p>

                <!-- Receipt Display -->
                <?php if (!empty($order['info']['receipt_path'])): ?>
                    <p><strong>Receipt:</strong><br>
                        <a href="../uploads/receipts/<?= htmlspecialchars($order['info']['receipt_path']) ?>" target="_blank">
                            <img src="../uploads/receipts/<?= htmlspecialchars($order['info']['receipt_path']) ?>" width="100" height="100" alt="Receipt">
                        </a><br>
                        <strong>Uploaded:</strong>
                        <?php
                        if (preg_match('/(\d{10})/', $order['info']['receipt_path'], $matches)) {
                            echo date("Y-m-d H:i:s", $matches[1]);
                        } else {
                            echo "<span class='w3-text-grey'>Unknown time</span>";
                        }
                        ?>
                    </p>
                <?php else: ?>
                    <p><strong>Receipt:</strong> <span class="w3-text-grey">Not uploaded</span></p>
                <?php endif; ?>

                <table class="w3-table w3-white">
                    <tr>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Price (each)</th>
                        <th>Total</th>
                    </tr>
                    <?php foreach ($order['items'] as $item): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($item['item_name']) ?>
                                <?php if (!empty($item['options'])): ?>
                                    <br><span style="font-size: 90%; color: #555;">
                                        <?= implode(', ', array_map(fn($opt) => htmlspecialchars($opt['name']), $item['options'])) ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($item['category']) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>RM <?= number_format($item['price'], 2) ?></td>
                            <td>RM <?= number_format($item['quantity'] * $item['price'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                     <div class="w3-right w3-margin-top"><strong>Total: RM <?= number_format($order['info']['total_amount'], 2) ?></strong></div>
                </table>
               
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>

<?php mysqli_close($condb); ?>
<?php include('../footer.php'); ?>
