<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = mysqli_real_escape_string($condb, $_POST['username']);
        $password = mysqli_real_escape_string($condb, $_POST['password']);

        $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password' LIMIT 1";
        $result = mysqli_query($condb, $sql);

        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            // Clear old sessions and set new one
            session_unset();
            $_SESSION['username'] = $user['username'];

            // Debug: Show session (optional)
            // echo '<pre>'; print_r($_SESSION); echo '</pre>'; exit;

            header("Location: admin/dashboard.php");
            exit;
        } else {
            echo "<script>alert('Invalid username or password.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Please enter both username and password.'); window.history.back();</script>";
    }
}
?>



<!-- HTML Form UI -->
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body background = 'images/plantdoodle.jpg'>

    <div class = "w3-container" style = 'background-color: #8fbc8f;'>
        <h1 class = "w3-xxxlarge w3-text-black" align = 'center'><b><i class="fa fa-coffee" aria-hidden="true"></i> Halfday Cafe Food Ordering System <i class="fa fa-pagelines" aria-hidden="true"></i></b></h1>
    </div>

    <div class="w3-card w3-panel w3-padding-32 w3-margin-top" style="max-width:400px; margin:auto;  background-color:#dfecdf;">
        <h2 class="w3-center">Login</h2>
        <form action="admin_login.php" method="POST" >
            <label>Username</label>
            <input class="w3-input w3-margin-bottom" type="text" name="username" required>

            <label>Password</label>
            <input class="w3-input w3-margin-bottom" type="password" name="password" required>

            <input type='submit' value='Login'>
        </form>
    </div>

</body>
</html>

<?php include('footer.php');