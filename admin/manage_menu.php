<?php 
include('../connection.php');
include('guard_admin.php');
$current_page = basename($_SERVER['PHP_SELF']); 

$category_result = mysqli_query($condb, "SELECT DISTINCT category FROM menu_items ORDER BY category");

$selected_category = isset($_GET['category']) ? mysqli_real_escape_string($condb, $_GET['category']) : '';

$menu_query = "SELECT * FROM menu_items";
if (!empty($selected_category)) {
    $menu_query .= " WHERE category = '$selected_category'";
}
$menu_query .= " ORDER BY name";
$menu_result = mysqli_query($condb, $menu_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Menu</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body background='../images/plantdoodle.jpg'>

<div class="w3-container w3-padding-16" style='background-color: #8fbc8f;'>
    <h2>Manage Menu</h2>
</div>

<div class="w3-bar w3-border w3-margin-top w3-padding" style='background-color: #8fbc8f;'>
    <a href="dashboard.php" class="w3-bar-item w3-button <?= ($current_page == 'dashboard.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Dashboard</a>
    <a href="manage_menu.php" class="w3-bar-item w3-button <?= ($current_page == 'manage_menu.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Menu</a>
    <a href="view_orders.php" class="w3-bar-item w3-button <?= ($current_page == 'view_orders.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Orders</a>
    <a href="admin_payments.php" class="w3-bar-item w3-button <?= ($current_page == 'admin_payments.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Payments</a>
    <a href="report.php" class="w3-bar-item w3-button <?= ($current_page == 'report.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Report</a>
    <a href="../logout.php" class="w3-bar-item w3-button w3-text-black w3-hover-text-grey w3-right">Logout</a> 
</div>

<div class="w3-container w3-margin-top" style='background-color:beige;'>
    <form method="GET" class="w3-margin-top">
        <label><strong>Select Category:</strong></label>
        <select name="category" class="w3-select" onchange="this.form.submit()" style='background-color:beige;'> 
            <option value="">-- All Categories --</option>
            <?php while ($cat = mysqli_fetch_assoc($category_result)) { ?>
                <option value="<?= htmlspecialchars($cat['category']) ?>" <?= $cat['category'] == $selected_category ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['category']) ?>
                </option>
            <?php } ?>
        </select>
    </form>

    <?php if (!empty($selected_category)): ?>
        <a href="add_item.php?category=<?= urlencode($selected_category) ?>" class="w3-button w3-brown w3-margin-top">
            <i class="fa fa-cutlery" aria-hidden="true"></i> Add New Menu
        </a>
    <?php endif; ?>

    <?php if (!empty($selected_category) && mysqli_num_rows($menu_result) > 0): ?>
        <table class="w3-table w3-bordered w3-margin-top" style="table-layout: fixed; width: 100%; background-color:beige">
            <colgroup>
                <col style="width: 40%;">
                <col style="width: 15%;">
                <col style="width: 15%;">
                <col style="width: 30%;">
            </colgroup>
            <tr style='background-color: Darkseagreen;'>
                <th>Item</th>
                <th>Price (RM)</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($menu_result)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= number_format($row['price'], 2) ?></td>
                <td><?= ($row['is_available'] == 1) ? 'Available' : 'Out of Stock' ?></td>
                <td>
                    <a href="edit_item.php?item_id=<?= $row['item_id'] ?>" class="w3-button w3-large">
                        <i class="fa fa-pencil w3-text-brown"></i>
                    </a>
                    <a href="delete_item.php?item_id=<?= $row['item_id'] ?>" class="w3-button w3-large"
                       onclick="return confirm('Are you sure you want to delete this item?')">
                        <i class="fa fa-trash w3-text-brown"></i>
                    </a>
                    <a href="admin_add_option.php?item_id=<?= $row['item_id'] ?>" class="w3-button w3-large">
                        <i class="fa fa-plus-square w3-text-brown"></i>
                    </a>
                </td>
            </tr>
            <?php } ?>
        </table>
    <?php elseif (empty($selected_category)): ?>
        <!-- No category selected -->
    <?php else: ?>
        <p class="w3-margin-top">No menu items found in this category.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php mysqli_close($condb); ?>
<?php include('../footer.php'); ?>
