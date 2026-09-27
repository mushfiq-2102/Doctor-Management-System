<?php
session_start();
require_once '../Model/db_connect.php';

$uname = "";
$pass = "";
$message = "";
$remember = false;

if (isset($_COOKIE["remember_user"])) {
    $uname = $_COOKIE["remember_user"];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uname = trim($_POST["uname"] ?? "");
    $pass = trim($_POST["pass"] ?? "");
    $role = strtolower(trim($_POST["role"] ?? "patient"));
    $remember = isset($_POST["remember"]) && $_POST["remember"] === "1";

    $loggedIn = false;
    $redirectTo = "";

    if ($role === "admin") {
        if ($uname === "admin" && $pass === "admin123") {
            $_SESSION["logged_in"] = true;
            $_SESSION["role"] = "admin";
            $_SESSION["username"] = $uname;
            $_SESSION["admin_logged_in"] = true;
            $_SESSION["admin_name"] = "Administrator";
            $_SESSION["admin_username"] = $uname;
            $_SESSION["admin_email"] = "admin@doctorapp.local";

            $loggedIn = true;
            $redirectTo = "admin_dashboard.php";
        } else {
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE LOWER(username) = LOWER(:uname) LIMIT 1");
            $stmt->execute(["uname" => $uname]);
            $adminRow = $stmt->fetch();

            if ($adminRow && $adminRow["password"] === $pass) {
                $_SESSION["logged_in"] = true;
                $_SESSION["role"] = "admin";
                $_SESSION["username"] = $adminRow["username"];
                $_SESSION["admin_logged_in"] = true;
                $_SESSION["admin_name"] = $adminRow["name"];
                $_SESSION["admin_username"] = $adminRow["username"];
                $_SESSION["admin_email"] = $adminRow["email"];

                $loggedIn = true;
                $redirectTo = "admin_dashboard.php";
            }
        }
    } elseif ($role === "doctor") {
        $stmt = $pdo->prepare("SELECT * FROM doctors WHERE LOWER(username) = LOWER(:uname) OR LOWER(email) = LOWER(:uname) LIMIT 1");
        $stmt->execute(["uname" => $uname]);
        $doctorRow = $stmt->fetch();

        if ($doctorRow && $doctorRow["password"] === $pass) {
            $_SESSION["logged_in"] = true;
            $_SESSION["role"] = "doctor";
            $_SESSION["username"] = $doctorRow["username"] ?? $doctorRow["email"];
            $_SESSION["doctor_name"] = $doctorRow["name"];
            $_SESSION["doctor_email"] = $doctorRow["email"];
            $_SESSION["doctor_logged_in"] = true;

            $loggedIn = true;
            $redirectTo = "doctor_dashboard.php";
        }
    } else {
        if ($uname === "patient" && $pass === "pt12345") {
            $_SESSION["logged_in"] = true;
            $_SESSION["role"] = "patient";
            $_SESSION["username"] = $uname;
            $_SESSION["patient_name"] = "Patient";

            $loggedIn = true;
            $redirectTo = "patient_dashboard.php";
        } else {
            $stmt = $pdo->prepare("SELECT * FROM patients WHERE LOWER(email) = LOWER(:uname) LIMIT 1");
            $stmt->execute(["uname" => $uname]);
            $patientRow = $stmt->fetch();

            if ($patientRow && $patientRow["password"] === $pass) {
                $_SESSION["logged_in"] = true;
                $_SESSION["role"] = "patient";
                $_SESSION["username"] = $patientRow["email"];
                $_SESSION["patient_id"] = $patientRow["id"];
                $_SESSION["patient_name"] = $patientRow["name"];
                $_SESSION["patient_email"] = $patientRow["email"];

                $loggedIn = true;
                $redirectTo = "patient_dashboard.php";
            }
        }
    }

    if ($loggedIn) {
        if ($remember) {
            setcookie("remember_user", $uname, time() + 60 * 60 * 24 * 7, "/");
        } else {
            setcookie("remember_user", "", time() - 3600, "/");
        }

        header("Location: " . $redirectTo);
        exit;
    } else {
        $message = "Invalid username or password.";
    }
}