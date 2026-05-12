<?php
session_start();
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="w3-container w3-padding-16" style='background-color: #8fbc8f;'>
        <h2 style="text-align: center;"><b><i class="fa fa-coffee" aria-hidden="true"></i> Welcome to Halfday Cafe <i class="fa fa-pagelines" aria-hidden="true"></i></b></h2>
    </div>
</head>

<hr>

<?php
if (!empty($_SESSION['table_no'])) {
    echo "
    <div class='w3-border' style='background-color: #8fbc8f; text-align: center;'>
        <h4><i class='fa fa-cutlery'></i> Table No: <strong>{$_SESSION['table_no']}</strong></h4>
    </div>
    ";
} else {
    echo "
    <div class='w3-container w3-card w3-margin w3-padding' style='background-color: darkkhaki; text-align: center;'>
        <p><i class='fa fa-map-marker'></i> 2, Jalan Betik, Taman Maju, Parit Raja<br>
        <i class='fa fa-phone'></i> +607 454 2108</p>
    </div>
    ";
}
?>

