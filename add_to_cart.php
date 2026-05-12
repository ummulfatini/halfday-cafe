<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = (int)$_POST['item_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    $options = isset($_POST['options']) ? $_POST['options'] : [];

    // Get item details
    $item_query = mysqli_query($condb, "SELECT * FROM menu_items WHERE item_id = $item_id");
    if (!$item_query || mysqli_num_rows($item_query) == 0) {
        echo "<script>alert('Invalid item selected.'); window.location.href='index.php';</script>";
        exit;
    }

    // Prepare cart item
    $cart_item = [
        'item_id' => $item_id,
        'quantity' => $quantity,
        'options' => $options
    ];

    // Initialize cart array if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add item to cart
    $_SESSION['cart'][] = $cart_item;

    echo "<script>alert('Item added to cart!'); window.location.href='view_cart.php';</script>";
    exit;
} else {
    echo "<script>alert('Invalid request.'); window.location.href='index.php';</script>";
    exit;
}
