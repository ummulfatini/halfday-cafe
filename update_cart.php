<?php
session_start();

// If cart is not set or empty, redirect
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Your cart is empty.'); window.location.href='view_cart.php';</script>";
    exit;
}

// Handle item removals
if (isset($_POST['remove']) && is_array($_POST['remove'])) {
    foreach ($_POST['remove'] as $remove_index) {
        unset($_SESSION['cart'][$remove_index]);
    }

    // Re-index cart array after removal to prevent gaps in indexes
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

// Handle quantity updates
if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $index => $qty) {
        $qty = (int)$qty;
        if ($qty < 1) $qty = 1;

        if (isset($_SESSION['cart'][$index])) {
            $_SESSION['cart'][$index]['quantity'] = $qty;
        }
    }
}

echo "<script>alert('Cart updated successfully.'); window.location.href='view_cart.php';</script>";
exit;
?>
