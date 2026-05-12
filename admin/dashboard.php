<?php
include('guard_admin.php');
$current_page = basename($_SERVER['PHP_SELF']); 

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

</head>

<body background = '../images/plantdoodle.jpg'>
    <div class="w3-container w3-padding-16" style = 'background-color: #8fbc8f;'>
    <h2>Admin Dashboard</h2>
    </div>
   
    <div class="w3-bar w3-border w3-padding w3-margin-top" style = 'background-color: #8fbc8f;'>    
        <a href="dashboard.php" class="w3-bar-item w3-button <?= ($current_page == 'dashboard.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Dashboard</a>
        <a href="manage_menu.php" class="w3-bar-item w3-button <?= ($current_page == 'manage_menu.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Menu</a>
        <a href="view_orders.php" class="w3-bar-item w3-button <?= ($current_page == 'view_orders.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Orders</a>
        <a href="admin_payments.php" class="w3-bar-item w3-button <?= ($current_page == 'admin_payments.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Payments</a>
        <a href="report.php" class="w3-bar-item w3-button <?= ($current_page == 'report.php') ? 'w3-text-grey w3-hover-text-black' : 'w3-text-black w3-hover-text-grey' ?>">Report</a>
        <a href="../logout.php" class="w3-bar-item w3-button w3-text-black w3-hover-text-grey w3-right">Logout</a> 
    </div>
<div class='w3-container'>
<p><h2> Welcome, <strong><?php echo $_SESSION['username']; ?></strong>!</h2></p></div>
<div class="w3-center w3-container w3-margin-top w3-margin-bottom">
    <img src = '../images/cover.jpg' class='w3-image'>
</div>

</body>
</html>

<?php include('../footer.php');
