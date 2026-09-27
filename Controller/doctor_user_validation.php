<?php
session_start();

if (empty($_SESSION["logged_in"]) || $_SESSION["role"] !== "doctor") {
    header("Location: login.php");
    exit;
}

$doctorName = $_SESSION["doctor_name"] ?? $_SESSION["username"] ?? "Doctor";
$doctorEmail = $_SESSION["doctor_email"] ?? "";

if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
