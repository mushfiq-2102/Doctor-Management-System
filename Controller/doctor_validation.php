<?php
require_once '../Model/db_connect.php';

$keyword = trim($_GET["keyword"] ?? "");

if ($keyword === "") {
    $filteredDoctors = $pdo->query("SELECT * FROM doctors ORDER BY id")->fetchAll();
} else {
    $stmt = $pdo->prepare("SELECT * FROM doctors WHERE name LIKE :kw OR specialization LIKE :kw ORDER BY id");
    $stmt->execute(["kw" => "%" . $keyword . "%"]);
    $filteredDoctors = $stmt->fetchAll();
}

$editDoctor = null;
if (isset($_GET["edit"])) {
    $stmt = $pdo->prepare("SELECT * FROM doctors WHERE id = :id LIMIT 1");
    $stmt->execute(["id" => (int)$_GET["edit"]]);
    $editDoctor = $stmt->fetch() ?: null;
}

$message = "";
$addSuccess = false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_doctor"])) {
    $newName = trim($_POST["new_dname"] ?? "");
    $newSpec = trim($_POST["new_dspec"] ?? "");
    $newEmail = trim($_POST["new_demail"] ?? "");
    $newUsername = trim($_POST["new_dusername"] ?? "");
    $newPass = trim($_POST["new_dpass"] ?? "");
    $newPhone = trim($_POST["new_dphone"] ?? "");

    if (strlen($newName) < 3 || strlen($newSpec) < 3 || $newEmail === "" || strlen($newUsername) < 3 || strlen($newPass) < 5 || strlen($newPhone) < 6) {
        $message = "Please fill in all new doctor fields correctly.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM doctors WHERE LOWER(username) = LOWER(:username) OR LOWER(email) = LOWER(:email) LIMIT 1");
        $stmt->execute(["username" => $newUsername, "email" => $newEmail]);
        if ($stmt->fetch()) {
            $message = "That doctor username or email is already in use.";
        } else {
            $insert = $pdo->prepare(
                "INSERT INTO doctors (name, specialization, email, username, password, phone) VALUES (:name, :spec, :email, :username, :password, :phone)"
            );
            $insert->execute([
                "name" => $newName,
                "spec" => $newSpec,
                "email" => $newEmail,
                "username" => $newUsername,
                "password" => $newPass,
                "phone" => $newPhone,
            ]);

            $message = "New doctor \"" . $newName . "\" was added successfully.";
            $addSuccess = true;
            $filteredDoctors = $pdo->query("SELECT * FROM doctors ORDER BY id")->fetchAll();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["doctor_id"])) {
    $dname = trim($_POST["dname"] ?? "");
    $dspec = trim($_POST["dspec"] ?? "");
    $demail = trim($_POST["demail"] ?? "");
    $dusername = trim($_POST["dusername"] ?? "");
    $dpass = trim($_POST["dpass"] ?? "");
    $dphone = trim($_POST["dphone"] ?? "");
    $doctorId = (int)$_POST["doctor_id"];

    if (strlen($dname) < 3 || strlen($dspec) < 3 || $demail === "" || strlen($dusername) < 3 || strlen($dpass) < 5 || strlen($dphone) < 6) {
        $message = "Please fill in all fields correctly.";
        $editDoctor = [
            "id" => $doctorId,
            "name" => $dname,
            "specialization" => $dspec,
            "email" => $demail,
            "username" => $dusername,
            "password" => $dpass,
            "phone" => $dphone
        ];
    } else {
        $update = $pdo->prepare(
            "UPDATE doctors SET name = :name, specialization = :spec, email = :email, username = :username, password = :password, phone = :phone WHERE id = :id"
        );
        $update->execute([
            "name" => $dname,
            "spec" => $dspec,
            "email" => $demail,
            "username" => $dusername,
            "password" => $dpass,
            "phone" => $dphone,
            "id" => $doctorId,
        ]);

        $message = "Doctor profile updated successfully.";
        $editDoctor = null;
        $filteredDoctors = $pdo->query("SELECT * FROM doctors ORDER BY id")->fetchAll();
    }
}
?>
