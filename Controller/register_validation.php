<?php
session_start();
require_once '../Model/db_connect.php';

$ptname = "";
$ptphone = "";
$ptdob = "";
$ptgender = "";
$ptemail = "";
$ptpass = "";
$message = "";
$success = false;
$remember = false;

if (isset($_COOKIE["remember_user"])) {
    $ptemail = $_COOKIE["remember_user"];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ptname = trim($_POST["ptfname"] ?? "");
    $ptphone = trim($_POST["ptphon"] ?? "");
    $ptdob = $_POST["ptdob"] ?? "";
    $ptgender = $_POST["gender"] ?? "";
    $ptemail = trim($_POST["ptemail"] ?? "");
    $ptpass = trim($_POST["ptpass"] ?? "");
    $remember = isset($_POST["remember"]) && $_POST["remember"] === "1";

    $errors = [];

    if (strlen($ptname) < 3) {
        $errors[] = "Full name must be at least 3 characters.";
    }
    if (strlen($ptphone) < 11) {
        $errors[] = "Phone number must be at least 11 characters.";
    }
    if ($ptdob === "") {
        $errors[] = "Date of birth is required.";
    }
    if ($ptgender === "") {
        $errors[] = "Please select a gender.";
    }
    if ($ptemail === "" || !str_ends_with($ptemail, "@gmail.com")) {
        $errors[] = "Email must end with @gmail.com.";
    }
    if (strlen($ptpass) < 5) {
        $errors[] = "Password must be at least 5 characters.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM patients WHERE LOWER(email) = LOWER(:email) LIMIT 1");
        $stmt->execute(["email" => $ptemail]);
        if ($stmt->fetch()) {
            $errors[] = "An account with that email already exists.";
        }
    }

    if (empty($errors)) {
        $insert = $pdo->prepare("INSERT INTO patients (name, phone, dob, gender, email, password) VALUES (:name, :phone, :dob, :gender, :email, :password)");
        $insert->execute([
            "name" => $ptname,
            "phone" => $ptphone,
            "dob" => $ptdob,
            "gender" => $ptgender,
            "email" => $ptemail,
            "password" => $ptpass,
        ]);

        if ($remember) {
            setcookie("remember_user", $ptemail, time() + 60 * 60 * 24 * 7, "/");
        }

        $success = true;
        $message = "Account created successfully. You can now log in.";
        $ptname = "";
        $ptphone = "";
        $ptdob = "";
        $ptgender = "";
        $ptemail = "";
    } else {
        $message = implode(" ", $errors);
    }
}
?>
