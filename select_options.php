<?php 
include('connection.php');
include('header.php');

// Get item ID and (optional) edit index
$item_id = isset($_GET['item_id']) ? (int)$_GET['item_id'] : 0;
$edit_index = isset($_GET['edit']) ? (int)$_GET['edit'] : null;

if ($item_id === 0 && $edit_index === null) {
    echo "<script>alert('No item selected.'); window.location.href='index.php';</script>";
    exit;
}

// If editing, load from cart
if ($edit_index !== null && isset($_SESSION['cart'][$edit_index])) {
    $cart_item = $_SESSION['cart'][$edit_index];
    $item_id = $cart_item['item_id'];
    $selected_options = $cart_item['options'] ?? [];
    $selected_quantity = $cart_item['quantity'];
} else {
    $selected_options = [];
    $selected_quantity = 1;
}

// Fetch item details
$item_query = mysqli_query($condb, "SELECT * FROM menu_items WHERE item_id = $item_id");
$item = mysqli_fetch_assoc($item_query);

// Fetch options for item
$options_query = mysqli_query($condb, "SELECT * FROM item_options WHERE item_id = $item_id");
$options = [];
while ($row = mysqli_fetch_assoc($options_query)) {
    $options[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = max(1, (int)($_POST['quantity'] ?? 1));
    $selected_opts = $_POST['options'] ?? [];

    $new_cart_item = [
        'item_id' => $item_id,
        'quantity' => $quantity,
        'options' => $selected_opts
    ];

    if ($edit_index !== null && isset($_SESSION['cart'][$edit_index])) {
        $_SESSION['cart'][$edit_index] = $new_cart_item; // Update existing item
    } else {
        $_SESSION['cart'][] = $new_cart_item; // Add new item
    }

    header("Location: view_cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customize Item</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .menu-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .option-group-label {
            font-weight: bold;
            margin-top: 12px;
        }
    </style>
</head>
<body background='images/plantdoodle.jpg'>

<div class="w3-container w3-padding-32">
    <?php 
    $image_path = $item['image_path'] ?? '';
    $image_path_clean = str_replace('../', '', $image_path); // e.g., images/item.jpg
    $server_path = __DIR__ . '/' . $image_path_clean;

    if (!empty($image_path) && file_exists($server_path)) {
        $image_url = rawurlencode(basename($image_path_clean));
        $image_dir = dirname($image_path_clean);
        $final_src = $image_dir . '/' . $image_url;

        echo "
        <div style='text-align: center; margin-bottom: 20px;'>
            <img src='$final_src' alt='Item Image' style='
                width: 200px;
                height: 200px;
                object-fit: cover;
                border-radius: 16px;
                box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            '>
        </div>";
    }
    ?>

    <h2><?= htmlspecialchars($item['name']); ?></h2>
    <p>Price: RM <?= number_format($item['price'], 2); ?></p>

    <form method="POST" class="w3-container w3-padding w3-card" style='background-color:beige'>
        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?= $selected_quantity; ?>" min="1" class="w3-input w3-margin-bottom" required>

        <?php if (!empty($options)): ?>
            <?php
            // Group options by option_type
            $grouped_options = [];
            foreach ($options as $opt) {
                $type = !empty($opt['option_type']) ? $opt['option_type'] : 'Others';
                $grouped_options[$type][] = $opt;
            }
            ?>

            <?php foreach ($grouped_options as $type => $opts): ?>
                <div class="w3-margin-top">
                    <?php if ($type !== 'Others'): ?>
                        <div class="option-group-label"><?= htmlspecialchars($type); ?>:</div>
                    <?php endif; ?>

                    <?php foreach ($opts as $opt): ?>
                        <label class="w3-margin-bottom">
                            <input type="checkbox" name="options[]" value="<?= $opt['option_id']; ?>"
                                <?= in_array($opt['option_id'], $selected_options) ? 'checked' : ''; ?>>
                            <?= htmlspecialchars($opt['option_name']); ?>
                            <?php if ($opt['additional_price'] > 0): ?>
                                (+ RM <?= number_format($opt['additional_price'], 2); ?>)
                            <?php endif; ?>
                        </label><br>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="w3-margin-top">
            <a href="index.php" class="w3-xxlarge w3-button w3-text-brown w3-large"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            <button type="submit" class="w3-xxlarge w3-button w3-text-brown"><i class="fa fa-plus-square" aria-hidden="true"></i></button>
            <a href="view_cart.php" class="w3-xxlarge w3-button w3-text-brown"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
        </div>
    </form>
</div>

</body>
</html>

<?php include('footer.php'); ?>
