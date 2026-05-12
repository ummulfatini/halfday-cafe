<?php
include('connection.php');
include('header.php');

// Handle removal
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $index = $_GET['remove'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); 
    header("Location: view_cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body background="images/plantdoodle.jpg">

<div class="w3-container w3-padding-32">
    <h2><i class="fa fa-shopping-cart" aria-hidden="true"></i> Your Cart</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <p>Your cart is empty.</p>
        <a href="index.php" class="w3-button w3-brown w3-large"><i class="fa fa-arrow-left" aria-hidden="true"></i> Menu</a>
    <?php else: ?>
        <table class="w3-table w3-white">
            <tr class="w3-white">
                <th>Item</th>
                <th>Options</th>
                <th>Quantity</th>
                <th>Price (RM)</th>
                <th></th>
            </tr>

            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $index => $item):
                $item_id = (int)$item['item_id'];
                $quantity = (int)$item['quantity'];
                $options = $item['options'] ?? [];

                // Get item base info
                $item_query = mysqli_query($condb, "SELECT name, price FROM menu_items WHERE item_id = $item_id");
                $item_data = mysqli_fetch_assoc($item_query);
                $name = $item_data['name'];
                $base_price = (float)$item_data['price'];

                $option_names = [];
                $option_total = 0;
                if (!empty($options)) {
                    foreach ($options as $opt_id) {
                        $opt_id = (int)$opt_id;
                        $opt_query = mysqli_query($condb, "SELECT option_name, additional_price FROM item_options WHERE option_id = $opt_id");
                        if ($opt_data = mysqli_fetch_assoc($opt_query)) {
                            $option_names[] = $opt_data['option_name'] . ($opt_data['additional_price'] > 0 ? " (+RM " . number_format($opt_data['additional_price'], 2) . ")" : "");
                            $option_total += (float)$opt_data['additional_price'];
                        }
                    }
                }

                $price = ($base_price + $option_total) * $quantity;
                $total += $price;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($name); ?></td>
                <td><?php echo implode(', ', $option_names); ?></td>
                <td><?php echo $quantity; ?></td>
                <td>RM <?php echo number_format($price, 2); ?></td>
                <td>
                    <a href="select_options.php?edit=<?php echo $index; ?>" class="w3-button w3-large"><i class="fa fa-pencil w3-text-brown"></i></a>
                    <a href="view_cart.php?remove=<?php echo $index; ?>" class="w3-button w3-large" onclick="return confirm('Remove this item?')"><i class="fa fa-trash w3-text-brown"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="w3-margin-top">
            <strong>Total: RM <?php echo number_format($total, 2); ?></strong><br><br>
            <a href="index.php" class="w3-button w3-text-brown w3-xxlarge"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            <a href="checkout.php" class="w3-right w3-button w3-brown">Checkout</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>

<?php include('footer.php'); ?>
