<?php
include('../connection.php');
include('guard_admin.php');

if (!isset($_GET['item_id']) || !is_numeric($_GET['item_id'])) {
    echo "<script>alert('Invalid item ID.'); window.location.href='manage_menu.php';</script>";
    exit;
}

$item_id = intval($_GET['item_id']);
$result = mysqli_query($condb, "SELECT * FROM menu_items WHERE item_id = $item_id");
$item = mysqli_fetch_assoc($result);

if (!$item) {
    echo "<script>alert('Item not found.'); window.location.href='manage_menu.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($condb, $_POST['name']);
    $category = mysqli_real_escape_string($condb, $_POST['category']);
    $price = floatval($_POST['price']);
    $is_available = isset($_POST['is_available']) && in_array($_POST['is_available'], ['0', '1'])
        ? intval($_POST['is_available']) : 0;

    $image_path = $item['image_path'];

    if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../images/';
        $filename = basename($_FILES['item_image']['name']);
        $new_path = $upload_dir . time() . "_" . $filename;

        if (move_uploaded_file($_FILES['item_image']['tmp_name'], $new_path)) {
            if (!empty($item['image_path']) && file_exists($item['image_path'])) {
                unlink($item['image_path']);
            }
            $image_path = $new_path;
        }
    }

    $query = "UPDATE menu_items SET 
                name = '$name',
                category = '$category',
                price = $price,
                is_available = $is_available,
                image_path = '$image_path'
              WHERE item_id = $item_id";

    if (mysqli_query($condb, $query)) {
        echo "<script>alert('Item updated successfully.'); window.location.href='manage_menu.php?category=$category';</script>";
    } else {
        echo "<script>alert('Failed to update item.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Menu Item</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <div class="w3-container w3-padding-16" style='background-color: #8fbc8f;'>
        <h2>Edit Menu</h2>
    </div>
</head>
<body class="w3-container" background="../images/plantdoodle.jpg">

<div class="w3-card w3-padding w3-margin-top" style="max-width:600px; margin:auto; background-color:beige">
    <form method="POST" enctype="multipart/form-data">
        <label>Item Name:</label>
        <input class="w3-input w3-margin-bottom" type="text" name="name" value="<?= htmlspecialchars($item['name']) ?>" required>

        <label>Category:</label>
        <input class="w3-input w3-margin-bottom" type="text" name="category" value="<?= htmlspecialchars($item['category']) ?>" required>

        <label>Price (RM):</label>
        <input class="w3-input w3-margin-bottom" type="number" step="0.01" name="price" value="<?= number_format($item['price'], 2) ?>" required>

        <label>Status:</label>
        <select class="w3-select w3-margin-bottom" name="is_available" required>
            <option value="1" <?= $item['is_available'] == 1 ? 'selected' : '' ?>>Available</option>
            <option value="0" <?= $item['is_available'] == 0 ? 'selected' : '' ?>>Out of Stock</option>
        </select>

        <label>Current Image:</label><br>
        <?php if (!empty($item['image_path']) && file_exists($item['image_path'])): ?>
            <img src="<?= $item['image_path'] ?>" style="max-width: 150px;"><br><br>
        <?php else: ?>
            <em>No image available</em><br><br>
        <?php endif; ?>

        <label>Change Image:</label>
        <input type="file" name="item_image" accept="image/*" class="w3-input w3-margin-bottom">

        <button class="w3-button w3-brown w3-block" type="submit">Update Item</button>
        <a href="manage_menu.php?category=<?= urlencode($item['category']) ?>" class="w3-button w3-brown w3-block w3-margin-top">Cancel</a>
    </form>
</div>

</body>
</html>

<?php mysqli_close($condb); ?>
<?php include('../footer.php'); ?>
