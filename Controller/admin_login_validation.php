<?php
session_start();
require_once '../Model/db_connect.php';

$auname = "";
$apass = "";
$message = "";
$remember = false;

if (isset($_COOKIE["admin_remember_user"])) {
    $auname = $_COOKIE["admin_remember_user"];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $auname = trim($_POST["auname"] ?? "");
    $apass = trim($_POST["apass"] ?? "");
    $remember = isset($_POST["remember"]) && $_POST["remember"] === "1";

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE LOWER(username) = LOWER(:uname) LIMIT 1");
    $stmt->execute(["uname" => $auname]);
    $matchedAdmin = $stmt->fetch();

    if ($matchedAdmin && $matchedAdmin["password"] === $apass) {
        $_SESSION["admin_logged_in"] = true;
        $_SESSION["admin_name"] = $matchedAdmin["name"];
        $_SESSION["admin_username"] = $matchedAdmin["username"];
        $_SESSION["admin_email"] = $matchedAdmin["email"];

        if ($remember) {
            setcookie("admin_remember_user", $auname, time() + 60 * 60 * 24 * 7, "/");
        } else {
            setcookie("admin_remember_user", "", time() - 3600, "/");
        }

        header("Location: admin_dashboard.php");
        exit;
    } else {
        $message = "Invalid admin username or password.";
    }
}
?>