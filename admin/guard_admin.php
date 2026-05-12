<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Not logged in
    header("Location: ../admin_login.php");
    exit;
}
?>