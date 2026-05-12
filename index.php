<?php
include('connection.php');
include('header.php');

if (!isset($_SESSION['table_no'])) {
    header("Location: table_select.php");
    exit;
}

// Get distinct categories from the menu_items table
$query = "SELECT DISTINCT category FROM menu_items WHERE is_available = 1";
$result = mysqli_query($condb, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halfday Cafe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <style>
        .category-card {
            background-color: beige;
            min-height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .category-card:hover {
            background-color:#d3d3d3;
            color: #000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            cursor: pointer;
        }

        .category-card h3 {
            margin: 0;
            transition: color 0.3s ease;
        }

        .category-card:hover h3 {
            color: #000;
        }
    </style>
</head>

<body background='images/plantdoodle.jpg'>
<div class="w3-container w3-center">
    <h2>Menu</h2>
</div>

<div class="w3-row-padding w3-center">
<?php
while ($row = mysqli_fetch_assoc($result)) {
    $category = htmlspecialchars($row['category']);
    echo "
    <div class='w3-half w3-margin-bottom'>
        <a href='menu.php?category=$category' title='View $category menu' style='text-decoration: none; color: inherit;'>
            <div class='w3-card w3-padding category-card'>
                <h3>$category</h3>
            </div>
        </a>
    </div>";
}
?>
</div>
</body>
</html>

<?php include('footer.php'); ?>
