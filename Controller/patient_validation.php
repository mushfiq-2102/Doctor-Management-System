<?php
session_start();
$selectDoctor = "";
$selectAppDate = "";
$ptname = "";
$ptgender = "";

if (empty($_SESSION["logged_in"]) || $_SESSION["role"] !== "patient") {
    header("Location: login.php");
    exit;
}

$patientName = $_SESSION["patient_name"] ?? $_SESSION["username"] ?? "Patient";

if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>