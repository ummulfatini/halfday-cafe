<?php 
include('connection.php');
include('header.php');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$category = isset($_GET['category']) ? mysqli_real_escape_string($condb, $_GET['category']) : '';
if (empty($category)) {
    echo "<script>alert('Category not selected.'); window.location.href='index.php';</script>";
    exit;
}

$query = "SELECT * FROM menu_items WHERE category = '$category' AND is_available = 1";
$result = mysqli_query($condb, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($category); ?> Menu</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }
        .menu-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 5px;
        }
        .w3-table td {
            vertical-align: middle !important;
        }
    </style>
</head>
<body background="images/plantdoodle.jpg">

<div class="w3-container w3-padding-16">
    <h2><?php echo htmlspecialchars($category); ?></h2>

    <div class="w3-padding-16">
        <a href="index.php" class="w3-button w3-xxlarge w3-text-brown"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        <a href="view_cart.php" class="w3-button w3-xxlarge w3-text-brown"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
    </div>

    <table class="w3-table w3-centered w3-large w3-bordered" style="background-color: beige">
        <tr style='background-color: Darkseagreen'>
            <th>Item</th>
            <th>Price (RM)</th>
            <th>Action</th>
        </tr>

        <?php while ($item = mysqli_fetch_assoc($result)) {
            $item_id = $item['item_id'];

            // Check if item has options
            $has_options = false;
            $opt_check = mysqli_query($condb, "SELECT COUNT(*) as count FROM item_options WHERE item_id = $item_id");
            $opt_data = mysqli_fetch_assoc($opt_check);
            if ($opt_data['count'] > 0) $has_options = true;
        ?>
        <tr>
            <td>
                <?php 
                    $image_path = $item['image_path']; // e.g., ../images/file.jpg
                    $image_path_clean = str_replace('../', '', $image_path); // becomes images/file.jpg
                    $server_path = __DIR__ . '/' . $image_path_clean;

                    if (!empty($image_path) && file_exists($server_path)) {
                        $image_url = rawurlencode(basename($image_path_clean));
                        $image_dir = dirname($image_path_clean);
                        $final_src = $image_dir . '/' . $image_url;

                        echo "<img src='$final_src' class='menu-img' alt='Item Image'><br>";
                    }
                    echo htmlspecialchars($item['name']);
                ?>
            </td>
            <td><?php echo number_format($item['price'], 2); ?></td>
            <td>
                <?php if ($has_options): ?>
                    <form action="select_options.php" method="GET" style="display:inline;">
                        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
                        <button type="submit" class="w3-xxlarge w3-button w3-text-brown"><i class="fa fa-plus-square" aria-hidden="true"></i></button>
                    </form>
                <?php else: ?>
                    <form action="add_to_cart.php" method="POST" style="display:inline;">
                        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="w3-xxlarge w3-button w3-text-brown"><i class="fa fa-plus-square" aria-hidden="true"></i></button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php } ?>
    </table>

    
</div>

</body>
</html>

<?php include('footer.php'); ?>
