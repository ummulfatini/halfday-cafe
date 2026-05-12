<?php
include('../connection.php');
include('guard_admin.php');

$selected_category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($condb, $_POST['name']);
    $category = mysqli_real_escape_string($condb, $_POST['category']);
    $price = floatval($_POST['price']);
    $is_available = isset($_POST['is_available']) && in_array($_POST['is_available'], ['0', '1'])
        ? intval($_POST['is_available']) : 0;

    // Validate status value
    if (!in_array($is_available, [0, 1])) {
        echo "<script>alert('Please select a valid status.'); window.history.back();</script>";
        exit;
    }

    $image_path = null;
    if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../images/';
        $filename = basename($_FILES['item_image']['name']);
        $target_file = $upload_dir . time() . "_" . $filename;

        if (move_uploaded_file($_FILES['item_image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        }
    }

    // Simple validation
    if (empty($name) || empty($category) || empty($price)) {
        echo "<script>alert('Please complete all fields.'); window.history.back();</script>";
        exit;
    }

    // Insert into database
    $query = "INSERT INTO menu_items (name, category, price, is_available, image_path)
              VALUES ('$name', '$category', '$price', '$is_available', '$image_path')";

    if (mysqli_query($condb, $query)) {
        echo "<script>alert('Menu item added successfully.'); window.location.href='manage_menu.php';</script>";
    } else {
        echo "<script>alert('Failed to add item.'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Menu Item</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <div class="w3-container w3-padding-16" style='background-color: #8fbc8f;'>
        <h2>Add New Menu</h2>
    </div>
</head>
<body class="w3-container" background='../images/plantdoodle.jpg'>

<div class="w3-card w3-padding w3-margin-top" style="max-width:600px; margin:auto; background-color:beige">

    <form method="POST" enctype="multipart/form-data">

        <label>Item Name:</label>
        <input class="w3-input w3-margin-bottom" type="text" name="name" 
               value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" required>

        <label>Category:</label>
        <input class="w3-input w3-margin-bottom" type="text" name="category" 
               value="<?= $selected_category ?>" readonly>

        <label>Price (RM):</label>
        <input class="w3-input w3-margin-bottom" type="number" step="0.01" name="price" 
               value="<?= isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '' ?>" required>

        <label>Status:</label>
        <?php $selected_status = isset($_POST['is_available']) ? intval($_POST['is_available']) : 1; ?>
        <select class="w3-select w3-margin-bottom" name="is_available" required>
            <option value="1" <?= $selected_status === 1 ? 'selected' : '' ?>>Available</option>
            <option value="0" <?= $selected_status === 0 ? 'selected' : '' ?>>Out of Stock</option>
        </select>

        <label>Item Image:</label>
        <input type="file" name="item_image" accept="image/*" class="w3-input w3-margin-bottom">

        <button class="w3-button w3-block w3-brown" type="submit">Add Item</button>
        <a href="manage_menu.php" class="w3-button w3-block w3-brown w3-margin-top">Cancel</a>
    </form>

</div>

</body>
</html>

<?php mysqli_close($condb); ?>
<?php include('../footer.php'); ?>
