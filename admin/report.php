<?php
include('../connection.php');
$current_page = basename($_SERVER['PHP_SELF']); 

// Get selected report
$selected_report = isset($_GET['report']) ? $_GET['report'] : '';

// 1. Most Ordered Items
$mostOrderedQuery = "
    SELECT 
        mi.name AS item_name,
        SUM(oi.quantity) AS total_quantity_ordered
    FROM order_items oi
    JOIN menu_items mi ON oi.item_id = mi.item_id
    GROUP BY oi.item_id
    ORDER BY total_quantity_ordered DESC
    LIMIT 10
";
$mostOrderedResult = mysqli_query($condb, $mostOrderedQuery);

// 2. Orders by Table
$tableReportQuery = "
    SELECT 
        table_no,
        COUNT(*) AS total_orders,
        SUM(total_amount) AS total_spent
    FROM cust_order
    GROUP BY table_no
    ORDER BY total_spent DESC
";
$tableReportResult = mysqli_query($condb, $tableReportQuery);

// 3. Full Order List
$fullOrderQuery = "
    SELECT 
        o.order_id,
        o.order_time,
        o.table_no,
        mi.name AS item_name,
        oi.quantity,
        oi.price_at_order_time,
        io.option_name
    FROM cust_order o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN menu_items mi ON oi.item_id = mi.item_id
    LEFT JOIN order_item_options oio ON oi.order_item_id = oio.order_item_id
    LEFT JOIN item_options io ON oio.option_id = io.option_id
    ORDER BY o.order_time DESC
";
$fullOrderResult = mysqli_query($condb, $fullOrderQuery);

// 4. Daily Income
$dailyIncomeQuery = "
    SELECT 
        DATE(order_time) AS order_date,
        SUM(total_amount) AS daily_income
    FROM cust_order
    WHERE status = 'completed'
    GROUP BY order_date
    ORDER BY order_date DESC
";
$dailyIncomeResult = mysqli_query($condb, $dailyIncomeQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Reports</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <div class="w3-container w3-padding-16" style='background-color: #8fbc8f;'>
        <h2>Report</h2>
    </div>
    <div class="w3-bar w3-border w3-margin-top w3-padding" style='background-color: #8fbc8f;'>    
        <a href="dashboard.php" class="w3-bar-item w3-button <?= ($current_page == 'dashboard.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Dashboard</a>
        <a href="manage_menu.php" class="w3-bar-item w3-button <?= ($current_page == 'manage_menu.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Menu</a>
        <a href="view_orders.php" class="w3-bar-item w3-button <?= ($current_page == 'view_orders.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Orders</a>
        <a href="admin_payments.php" class="w3-bar-item w3-button <?= ($current_page == 'admin_payments.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Payments</a>
        <a href="report.php" class="w3-bar-item w3-button <?= ($current_page == 'report.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Report</a>
        <a href="../logout.php" class="w3-bar-item w3-button w3-text-black w3-hover-text-grey w3-right">Logout</a> 
    </div>
</head>
<body background='../images/plantdoodle.jpg'>

<!-- Report Selection Dropdown -->
<div class="w3-container w3-margin-top" style='background-color:beige;'>
    <form method="GET" class="w3-margin-top">
        <label><strong>Select Report:</strong></label>
        <select name="report" class="w3-select" onchange="this.form.submit()" style='background-color:beige;'> 
            <option value="">-- Show All --</option>
            <option value="all_orders" <?= ($selected_report == 'all_orders') ? 'selected' : '' ?>>All Orders</option>
            <option value="most_ordered" <?= ($selected_report == 'most_ordered') ? 'selected' : '' ?>>Most Ordered Items</option>
            <option value="by_table" <?= ($selected_report == 'by_table') ? 'selected' : '' ?>>Orders by Table</option>
            <option value="daily_income" <?= ($selected_report == 'daily_income') ? 'selected' : '' ?>>Daily Income</option>
        </select>
    </form>
</div>

<!-- Full Order List -->
<?php if ($selected_report == '' || $selected_report == 'all_orders') : ?>
<div class='w3-margin-top w3-padding'>
    <h3><b>All Orders</b></h3>
    <table class="w3-table w3-bordered" style='background-color: beige;'>
        <tr style='background-color:darkseagreen'><th>Order ID</th><th>Time</th><th>Table</th><th>Item</th><th>Qty</th><th>Price</th><th>Options</th></tr>
        <?php while ($row = mysqli_fetch_assoc($fullOrderResult)) : ?>
            <tr>
                <td><?= $row['order_id'] ?></td>
                <td><?= $row['order_time'] ?></td>
                <td><?= $row['table_no'] ?></td>
                <td><?= htmlspecialchars($row['item_name']) ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= number_format($row['price_at_order_time'], 2) ?></td>
                <td><?= htmlspecialchars($row['option_name'] ?? '-') ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php endif; ?>

<!-- Most Ordered Items -->
<?php if ($selected_report == '' || $selected_report == 'most_ordered') : ?>
<div class='w3-margin-top w3-padding'>
    <h3><b>Most Ordered Items</b></h3>
    <table class="w3-table w3-bordered" style='background-color: beige;'>
        <tr style='background-color:darkseagreen'><th>Item</th><th>Total Ordered</th></tr>
        <?php while ($row = mysqli_fetch_assoc($mostOrderedResult)) : ?>
            <tr>
                <td><?= htmlspecialchars($row['item_name']) ?></td>
                <td><?= $row['total_quantity_ordered'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php endif; ?>

<!-- Orders by Table -->
<?php if ($selected_report == '' || $selected_report == 'by_table') : ?>
<div class='w3-margin-top w3-padding'>
    <h3><b>Orders by Table</b></h3>
    <table class="w3-table w3-bordered" style='background-color: beige;'>
        <tr style='background-color:darkseagreen'><th>Table</th><th>Total Orders</th><th>Total Spent (RM)</th></tr>
        <?php while ($row = mysqli_fetch_assoc($tableReportResult)) : ?>
            <tr>
                <td><?= $row['table_no'] ?></td>
                <td><?= $row['total_orders'] ?></td>
                <td><?= number_format($row['total_spent'], 2) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php endif; ?>

<!-- Daily Income -->
<?php if ($selected_report == '' || $selected_report == 'daily_income') : ?>
<div class='w3-margin-top w3-padding'>
    <h3><b>Daily Income</b></h3>
    <table class="w3-table w3-bordered" style='background-color: beige;'>
        <tr style='background-color:darkseagreen'><th>Date</th><th>Total Income (RM)</th></tr>
        <?php while ($row = mysqli_fetch_assoc($dailyIncomeResult)) : ?>
            <tr>
                <td><?= $row['order_date'] ?></td>
                <td><?= number_format($row['daily_income'], 2) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php endif; ?>

</body>
</html>

<?php
mysqli_close($condb);
include('../footer.php');
?>
