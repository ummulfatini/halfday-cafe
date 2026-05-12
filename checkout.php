<?php
include('connection.php');
include('header.php');

if (!isset($_SESSION['table_no'])) {
    echo "<script>alert('Please enter your table number first.'); window.location.href='index.php';</script>";
    exit;
}

if (empty($_SESSION['cart'])) {
    echo "
    <style>
        body {
            background-image: url('images/your-background.jpg'); 
            background-size: cover; 
            background-repeat: no-repeat;
            background-position: center;
        }
        .back-icon {
            display: inline-block;
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }
        .back-icon i {
            margin-right: 6px;
        }
    </style>
    <div class='w3-container w3-padding' style='margin-top:50px;'>
        <h3>Your cart is empty.</h3>
        <a href='index.php' class='back-icon'>
            <i class='fa fa-arrow-left'></i> Menu
        </a>
    </div>
    ";
    exit;
}

$cart = $_SESSION['cart'];
$total = 0;

// Step 1: Insert into cust_order
$table_no = (int)$_SESSION['table_no'];
$insert_order = "INSERT INTO cust_order (table_no, total_amount) VALUES ($table_no, 0)";
mysqli_query($condb, $insert_order);
$order_id = mysqli_insert_id($condb);

// Step 2: Loop over cart items
foreach ($cart as $cart_item) {
    $item_id = (int)$cart_item['item_id'];
    $quantity = (int)$cart_item['quantity'];
    $options = $cart_item['options'] ?? [];

    // Get base item price
    $item_query = "SELECT price FROM menu_items WHERE item_id = $item_id";
    $item_result = mysqli_query($condb, $item_query);
    $item_data = mysqli_fetch_assoc($item_result);
    $base_price = (float)$item_data['price'];

    // Calculate total additional price from valid options
    $option_total = 0;
    $valid_options = [];

    foreach ($options as $opt_id) {
        $opt_id = (int)$opt_id;
        $opt_query = "SELECT additional_price FROM item_options WHERE option_id = $opt_id";
        $opt_result = mysqli_query($condb, $opt_query);
        if ($opt_data = mysqli_fetch_assoc($opt_result)) {
            $option_total += (float)$opt_data['additional_price'];
            $valid_options[] = $opt_id;
        }
    }

    $final_price = $base_price + $option_total;
    $subtotal = $final_price * $quantity;
    $total += $subtotal;

    // Step 3: Insert into order_items
    $insert_item = "INSERT INTO order_items (order_id, item_id, quantity, price_at_order_time)
                    VALUES ($order_id, $item_id, $quantity, $final_price)";
    mysqli_query($condb, $insert_item);
    $order_item_id = mysqli_insert_id($condb);

    // Step 4: Insert valid options
    foreach ($valid_options as $opt_id) {
        $insert_opt = "INSERT INTO order_item_options (order_item_id, option_id) 
                       VALUES ($order_item_id, $opt_id)";
        mysqli_query($condb, $insert_opt);
    }
}

// Step 5: Update total
$update_total = "UPDATE cust_order SET total_amount = $total WHERE order_id = $order_id";
mysqli_query($condb, $update_total);

// Clear cart and redirect
unset($_SESSION['cart']);
header("Location: payment.php?order_id=$order_id");
exit;
?>

<?php include('footer.php'); ?>
