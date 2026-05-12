<?php
include('../connection.php');
include('guard_admin.php');

if (!isset($_GET['item_id']) || !is_numeric($_GET['item_id'])) {
    echo "<script>alert('Invalid item ID.'); window.location.href='manage_menu.php';</script>";
    exit;
}

$item_id = intval($_GET['item_id']);

// Delete related rows first to satisfy foreign key constraints
mysqli_query($condb, "DELETE FROM order_items WHERE item_id = $item_id");
mysqli_query($condb, "DELETE FROM item_options WHERE item_id = $item_id");

// Now delete the item
$query = "DELETE FROM menu_items WHERE item_id = $item_id";
if (mysqli_query($condb, $query)) {
    echo "<script>alert('Item deleted successfully.'); window.location.href='manage_menu.php';</script>";
} else {
    echo "<script>alert('Failed to delete item.'); window.location.href='manage_menu.php';</script>";
}

mysqli_close($condb);

?>
