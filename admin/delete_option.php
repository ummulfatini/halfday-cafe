<?php
include('../connection.php');
include('guard_admin.php');

if (isset($_GET['option_id']) && is_numeric($_GET['option_id'])) {
    $option_id = (int)$_GET['option_id'];

    // Optional: Get item_id for redirect
    $get_item_id = mysqli_query($condb, "SELECT item_id FROM item_options WHERE option_id = $option_id");
    $item_row = mysqli_fetch_assoc($get_item_id);
    $item_id = $item_row['item_id'] ?? 0;

    // Delete the option
    mysqli_query($condb, "DELETE FROM item_options WHERE option_id = $option_id");

    header("Location: admin_add_option.php?item_id=$item_id&deleted=1");
    exit;
} else {
    echo "Invalid request.";
}
?>
