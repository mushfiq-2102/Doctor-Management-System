<?php
session_start();

if (empty($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: login.php");
    exit;
}

$adminName = $_SESSION["admin_name"];
$adminUsername = $_SESSION["admin_username"];
$adminEmail = $_SESSION["admin_email"];

if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>