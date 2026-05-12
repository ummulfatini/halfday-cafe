<?php
include('../connection.php');

// Fetch current orders (not completed or cancelled)
$query = "
    SELECT 
        o.order_id,
        o.order_time,
        o.total_amount,
        o.status,
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
    WHERE o.status IN ('pending', 'preparing', 'ready')
    ORDER BY o.order_time DESC, o.order_id, oi.order_item_id
";

$result = mysqli_query($condb, $query);

// Group orders
$orders = [];

while ($row = mysqli_fetch_assoc($result)) {
    $order_id = $row['order_id'];
    $order_item_id = $row['order_item_id'];

    if (!isset($orders[$order_id])) {
        $orders[$order_id]['info'] = [
            'order_time' => $row['order_time'],
            'total_amount' => $row['total_amount'],
            'status' => $row['status'],
            'table_no' => $row['table_no'],
            'receipt_path' => $row['receipt_path']
        ];
        $orders[$order_id]['items'] = [];
    }

    if (!isset($orders[$order_id]['items'][$order_item_id])) {
        $orders[$order_id]['items'][$order_item_id] = [
            'item_name' => $row['item_name'],
            'category' => $row['category'],
            'quantity' => $row['quantity'],
            'price' => $row['price_at_order_time'],
            'options' => []
        ];
    }

    // Add item options if exist
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
    <title>Staff Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body background="../images/plantdoodle.jpg">

<div class="w3-container w3-padding" style="background-color: #8fbc8f;">
    <h2>Orders for Preparation</h2>
</div>

<div class="w3-container">
    <?php if (empty($orders)): ?>
        <p>No current orders.</p>
    <?php else: ?>
        <?php foreach ($orders as $order_id => $order): ?>
            <div style="background-color: beige;" class="w3-card w3-margin-top w3-margin-bottom w3-padding">
                <h4><b>Order # </b><?= $order_id ?> | Table <?= $order['info']['table_no'] ?></h4>
                <p><strong>Time:</strong> <?= $order['info']['order_time'] ?></p>
                <p><strong>Status:</strong> <?= ucfirst($order['info']['status']) ?></p>

                <!-- Receipt -->
                <?php if (!empty($order['info']['receipt_path'])): ?>
                    <p><strong>Receipt:</strong><br>
                        <a href="../uploads/<?= htmlspecialchars($order['info']['receipt_path']) ?>" target="_blank">
                            <img src="../uploads/<?= htmlspecialchars($order['info']['receipt_path']) ?>" width="100" height="100">
                        </a>
                    </p>
                <?php else: ?>
                    <p><strong>Receipt:</strong> <span class="w3-text-grey">Not uploaded</span></p>
                <?php endif; ?>

                <table class="w3-table w3-white">
                    <tr>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Price (RM)</th>
                        <th>Total (RM)</th>
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
                            <td><?= number_format($item['price'], 2) ?></td>
                            <td><?= number_format($item['quantity'] * $item['price'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <p class="w3-right w3-margin-top"><strong>Total: RM <?= number_format($order['info']['total_amount'], 2) ?></strong></p>    

                <!-- Status Update -->
                <form method="post" action="update_status.php" class="w3-margin-top">
                    <input type="hidden" name="order_id" value="<?= $order_id ?>">
                    <select name="new_status" class="w3-select w3-border" required>
                        <option value="" disabled selected>Change status...</option>
                        <option value="preparing">Preparing</option>
                        <option value="ready">Ready</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <button type="submit" class="w3-button w3-brown w3-margin-top">Update</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>

<?php mysqli_close($condb); ?>
<?php include("../footer.php");