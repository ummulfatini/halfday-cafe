<?php
include('../connection.php');
include('guard_admin.php');

$item_id_from_url = isset($_GET['item_id']) ? (int)$_GET['item_id'] : 0;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = (int)$_POST['item_id'];
    $option_types = $_POST['option_type'];
    $option_names = $_POST['option_name'];
    $option_prices = $_POST['additional_price'];

    foreach ($option_names as $index => $name) {
        $type = mysqli_real_escape_string($condb, $option_types[$index]);
        $name = mysqli_real_escape_string($condb, $name);
        $price = floatval($option_prices[$index]);

        if (!empty($name) && !empty($type)) {
            $insert = "INSERT INTO item_options (item_id, option_type, option_name, additional_price)
                       VALUES ($item_id, '$type', '$name', $price)";
            mysqli_query($condb, $insert);
        }
    }

    echo "<script>alert('Options added successfully!'); window.location.href='admin_add_option.php?item_id=$item_id';</script>";
    exit;
}

// Fetch menu items for dropdown
$items_result = mysqli_query($condb, "SELECT item_id, name FROM menu_items ORDER BY name");
?>




<!DOCTYPE html>
<html>
<head>
    <title>Add Item Options</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <div class="w3-container w3-padding-16" style = 'background-color: #8fbc8f;'>
    <h2>Add Item Options</h2>
    </div>

</head>
    <div>
    <a href="manage_menu.php" class="w3-button w3-xxlarge w3-text-brown">
        <i class="fa fa-arrow-left"></i> 
    </a>
    </div>
<body background = '../images/plantdoodle.jpg'>
<div class="w3-card w3-padding w3-margin-top" style="max-width:600px; margin:auto; background-color:beige">



    <form method="POST" action="">
        <label>Select Item:</label>
        <select name="item_id" class="w3-select" required>
            <option value="">-- Choose Item --</option>
            <?php while ($row = mysqli_fetch_assoc($items_result)) { ?>
                <option value="<?= $row['item_id'] ?>" <?= $row['item_id'] == $item_id_from_url ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['name']) ?>
                </option>
            <?php } ?>
        </select><br><br>

        <div id="optionContainer">
            <div class="w3-row w3-margin-bottom">
                <div class="w3-col s4 w3-padding-right">
                    <input type="text" name="option_type[]" placeholder="Option Type" class="w3-input w3-margin-bottom" required>
                </div>
                <div class="w3-col s4 w3-padding-right">
                    <input type="text" name="option_name[]" placeholder="Option Name" class="w3-input w3-margin-bottom" required>
                </div>
                <div class="w3-col s4 w3-padding-right">
                    <input type="number" name="additional_price[]" step="0.01" placeholder="Additional Price (RM)" class="w3-input w3-margin-bottom" required>
                </div>
            </div>
        </div>

        <button type="button" onclick="addOption()" class="w3-block w3-button w3-brown"><i class="fa fa-plus" aria-hidden="true"></i> Add More Option</button>
        <br>
        <button type="submit" class="w3-block w3-button w3-brown"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save Options</button>
    </form>
</div>

<?php
if ($item_id_from_url) {
    $existing_options = mysqli_query($condb, "SELECT * FROM item_options WHERE item_id = $item_id_from_url ORDER BY option_type");

    if (mysqli_num_rows($existing_options) > 0) {
        echo "
        <div class='w3-container w3-margin-top'>
            <div class='w3-padding' style='background-color:beige'>
                <h4>Existing Options</h4>";

        $last_type = '';
        while ($opt = mysqli_fetch_assoc($existing_options)) {
            if ($opt['option_type'] !== $last_type) {
                if ($last_type !== '') {
                    echo "</table><br>"; // close previous table if not the first
                }
                echo "
                <h5 class='w3-margin-top'><b>" . htmlspecialchars($opt['option_type']) . "</b></h5>
                <table class='w3-table w3-round' style='background-color:beige'>
                    <tr style='background-color:darkseagreen'>
                        <th>Option Name</th>
                        <th>Price (RM)</th>
                        <th>Action</th>
                    </tr>";
                $last_type = $opt['option_type'];
            }

            echo "
            <tr>
                <td>" . htmlspecialchars($opt['option_name']) . "</td>
                <td>" . number_format($opt['additional_price'], 2) . "</td>
                <td>
                    <a href='delete_option.php?option_id=" . $opt['option_id'] . "' 
                       class='w3-button w3-text-brown w3-hover-text-grey w3-hover-opacity'
                       onclick=\"return confirm('Delete this option?')\">
                       <i class='fa fa-trash'></i>
                    </a>
                </td>
            </tr>";
        }

        echo "</table></div></div>";
    } else {
        echo "
        <div class='w3-container w3-padding-16'>
            <div class='w3-panel w3-pale-yellow w3-leftbar w3-border-yellow w3-round'>
                <p><i class='fa fa-info-circle'></i> No options added for this item yet.</p>
            </div>
        </div>";
    }
}
?>


<script>
function addOption() {
    const container = document.getElementById('optionContainer');
    const html = `
        <div class="w3-row w3-margin-bottom">
        <div class="w3-col s4 w3-padding-right">
                <input type="text" name="option_type[]" placeholder="Option Type" class="w3-input w3-margin-bottom" required>
            </div>
            <div class="w3-col s4 w3-padding-right">
                <input type="text" name="option_name[]" placeholder="Option Name" class="w3-input w3-margin-bottom" required>
            </div>
            <div class="w3-col s4 w3-padding-right">
                <input type="number" name="additional_price[]" step="0.01" placeholder="Additional Price (RM)" class="w3-input w3-margin-bottom" required>
            </div>
        </div>`;
    container.insertAdjacentHTML('beforeend', html);
}
</script>


</body>
</html>

<?php include('../footer.php');