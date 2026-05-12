<?php
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['table_no']) && is_numeric($_POST['table_no'])) {
        $_SESSION['table_no'] = (int) $_POST['table_no'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Please enter a valid table number.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enter Table Number</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <div class="w3-container w3-padding-16" style = 'background-color: #8fbc8f;'>
    <h2 style="text-align: center;"><b><i class="fa fa-coffee" aria-hidden="true"></i> Welcome to Halfday Cafe <i class="fa fa-pagelines" aria-hidden="true"></i></b></h2>
    </div>
</head>
<body background = 'images/plantdoodle.jpg'>

<div class="w3-container w3-padding-32 w3-center">
    <p>Please enter your table number to begin ordering</p>

    <form method="POST" class="w3-card w3-padding" style="display: inline-block; width: 300px; background-color:beige;">
        <?php if (!empty($error)) echo "<p class='w3-text-red'>$error</p>"; ?>
        
        <label>Table Number:</label>
        <input class="w3-input w3-margin-bottom" type="number" name="table_no" min="1" required>

        <button class="w3-button w3-green w3-block" type="submit">Start Ordering</button>
    </form>
</div>

</body>
</html>

<?php include('footer.php');