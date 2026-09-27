<?php
include '../Controller/patient_validation.php';
require_once '../Model/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["changePassword"])) {
    $currentPassword = trim($_POST["currentPassword"] ?? "");
    $newPassword = trim($_POST["newPassword"] ?? "");
    $confirmPassword = trim($_POST["confirmPassword"] ?? "");

    $patientId = $_SESSION["patient_id"] ?? null;

    if (!$patientId) {
        header("Location: patient_settings.php?status=pw_error&reason=demo");
        exit;
    }

    if (strlen($newPassword) < 5) {
        header("Location: patient_settings.php?status=pw_error&reason=short");
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        header("Location: patient_settings.php?status=pw_error&reason=mismatch");
        exit;
    }

    $stmt = $pdo->prepare("SELECT password FROM patients WHERE id = :id LIMIT 1");
    $stmt->execute(["id" => $patientId]);
    $row = $stmt->fetch();

    if (!$row || $row["password"] !== $currentPassword) {
        header("Location: patient_settings.php?status=pw_error&reason=wrong_current");
        exit;
    }

    $update = $pdo->prepare("UPDATE patients SET password = :password WHERE id = :id");
    $update->execute(["password" => $newPassword, "id" => $patientId]);

    header("Location: patient_settings.php?status=pw_success");
    exit;
}

header("Location: patient_settings.php");
exit;
?>