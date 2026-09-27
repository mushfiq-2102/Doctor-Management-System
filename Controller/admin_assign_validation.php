<?php
require_once '../Model/db_connect.php';

$aname = "";
$aemail = "";
$auname = "";
$message = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $aname = trim($_POST["aname"] ?? "");
    $aemail = trim($_POST["aemail"] ?? "");
    $auname = trim($_POST["auname"] ?? "");
    $apass = trim($_POST["apass"] ?? "");

    $errors = [];

    if (strlen($aname) < 3) {
        $errors[] = "Full name must be at least 3 characters.";
    }
    if ($aemail === "" || !str_ends_with($aemail, "@gmail.com")) {
        $errors[] = "Email must end with @gmail.com.";
    }
    if (strlen($auname) < 4) {
        $errors[] = "Username must be at least 4 characters.";
    }
    if (strlen($apass) < 5) {
        $errors[] = "Password must be at least 5 characters.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM admins WHERE LOWER(username) = LOWER(:username) OR LOWER(email) = LOWER(:email) LIMIT 1");
        $stmt->execute(["username" => $auname, "email" => $aemail]);
        if ($stmt->fetch()) {
            $errors[] = "That username or email is already registered.";
        }
    }

    if (empty($errors)) {
        $insert = $pdo->prepare("INSERT INTO admins (name, email, username, password) VALUES (:name, :email, :username, :password)");
        $insert->execute([
            "name" => $aname,
            "email" => $aemail,
            "username" => $auname,
            "password" => $apass,
        ]);

        $success = true;
        $message = "New admin account \"" . $auname . "\" was created successfully.";
        $aname = "";
        $aemail = "";
        $auname = "";
    } else {
        $message = implode(" ", $errors);
    }
}

$adminList = $pdo->query("SELECT id, name, email, username FROM admins ORDER BY id")->fetchAll();
?>
