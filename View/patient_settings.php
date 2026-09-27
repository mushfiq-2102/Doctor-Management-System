<?php
include '../Controller/patient_validation.php';
require_once '../Model/db_connect.php';

$currentPatient = ["name" => $patientName, "email" => "", "phone" => "", "gender" => ""];
if (!empty($_SESSION["patient_id"])) {
    $stmt = $pdo->prepare("SELECT name, email, phone, gender FROM patients WHERE id = :id LIMIT 1");
    $stmt->execute(["id" => $_SESSION["patient_id"]]);
    $row = $stmt->fetch();
    if ($row) {
        $currentPatient = $row;
    }
}

$statusMessages = [
    "profile_success" => ["ok", "Profile updated successfully."],
    "profile_error" => ["error", "Could not update profile. Please check your details."],
    "pw_success" => ["ok", "Password updated successfully."],
    "pw_error" => ["error", "Could not update password. Please check your details."],
];
$status = $_GET["status"] ?? "";
$statusInfo = $statusMessages[$status] ?? null;
?>
<!DOCTYPE html>
<html>
<head>
<title>Settings - Doctor Appointment System</title>

<style>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
}

body {
  display: flex;
  background: #f4f6f8;
  color: #222;
}

/* SIDEBAR */
.sidebar {
  width: 220px;
  min-height: 100vh;
  background: #1f2937;
  color: #fff;
  display: flex;
  flex-direction: column;
  padding: 20px 0;
}

.profile {
  text-align: center;
  margin-bottom: 30px;
}

.avatar {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: #4b5563;
  margin: 0 auto 10px;
}

.sidebar nav {
  display: flex;
  flex-direction: column;
}

.sidebar nav a {
  color: #d1d5db;
  text-decoration: none;
  padding: 12px 20px;
}

.sidebar nav a:hover,
.sidebar nav a.active {
  background: #374151;
  color: #fff;
}

.logout {
  margin-top: auto;
  padding: 12px 20px;
}

.logout a {
  color: #f87171;
  text-decoration: none;
}

/* MAIN */
.main {
  flex: 1;
  padding: 20px 30px;
}

.top-head h1 {
  font-size: 22px;
  margin-bottom: 16px;
}

.top-nav {
  display: flex;
  gap: 10px;
  margin-bottom: 24px;
}

.top-nav input {
  flex: 1;
  max-width: 300px;
  padding: 8px 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.top-nav button {
  padding: 8px 16px;
  border: none;
  background: #2563eb;
  color: #fff;
  border-radius: 4px;
  cursor: pointer;
}

.top-nav button:hover {
  background: #1d4ed8;
}

/* TABLE */
.doctor-list, .booking-form {
  background: #fff;
  padding: 20px;
  border-radius: 6px;
  margin-bottom: 24px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.section-title {
  margin-bottom: 12px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  text-align: left;
  padding: 10px;
  border-bottom: 1px solid #e5e7eb;
}

th {
  background: #f9fafb;
}

/* FORM */
.booking-form table td {
  padding: 8px 10px;
  border: none;
}

.booking-form label {
  font-weight: bold;
}

.booking-form input,
.booking-form select {
  width: 100%;
  padding: 6px 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

#makeApp {
  margin-top: 12px;
  padding: 8px 20px;
  background: #16a34a;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

#makeApp:hover {
  background: #15803d;
}

.message {
  border-radius: 6px;
  padding: 10px;
  margin-bottom: 15px;
  font-size: 14px;
}

.message.ok {
  background-color: #e8f5e9;
  color: #1b5e20;
  border: 1px solid #c8e6c9;
}

.message.error {
  background-color: #fdecea;
  color: #b71c1c;
  border: 1px solid #f5c6cb;
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <div class="profile">
      <div class="avatar"></div>
      <p id="patientName"><?php echo htmlspecialchars($patientName); ?></p>
  </div>
  <nav>
      <a href="patient_dashboard.php" class="active">Home</a>
      <a href="my_appointment.php">My Appointment</a>
      <a href="patient_settings.php">Settings</a>
  </nav>
  <div class="logout">
      <form method="post" action="">
          <button type="submit" name="logout" style="background:none;border:none;color:#f87171;cursor:pointer;font-size:14px;padding:0;">Logout</button>
      </form>
  </div>
</div>

<div class="main">

  <div class="top-head">
      <h1>Account Settings</h1>
  </div>

  <?php if ($statusInfo) { ?>
      <div class="message <?php echo $statusInfo[0]; ?>"><?php echo htmlspecialchars($statusInfo[1]); ?></div>
  <?php } ?>

  <div class="booking-form">
      <h2>Update Profile</h2>
      <form id="profileForm" method="post" action="update_profile.php">

      <table>
        <tr>
            <td><label>Name</label></td>
            <td><input type="text" id="ptname" name="ptname" value="<?php echo htmlspecialchars($currentPatient["name"]); ?>" required></td>
        </tr>
        <tr>
            <td><label>Email</label></td>
            <td><input type="email" id="ptemail" name="ptemail" value="<?php echo htmlspecialchars($currentPatient["email"]); ?>" required></td>
        </tr>
        <tr>
            <td><label>Phone</label></td>
            <td><input type="text" id="ptphone" name="ptphone" value="<?php echo htmlspecialchars($currentPatient["phone"] ?? ""); ?>"></td>
        </tr>
        <tr>
            <td><label>Gender</label></td>
            <td>
                <select id="ptgender" name="ptgender">
                  <option value="">-- Select --</option>
                  <option value="male" <?php echo (($currentPatient["gender"] ?? "") === "male") ? "selected" : ""; ?>>Male</option>
                  <option value="female" <?php echo (($currentPatient["gender"] ?? "") === "female") ? "selected" : ""; ?>>Female</option>
                  <option value="other" <?php echo (($currentPatient["gender"] ?? "") === "other") ? "selected" : ""; ?>>Other</option>
              </select>
            </td>
        </tr>
      </table>
      <input type="submit" name="updateProfile" id="updateProfileBtn" value="Save Changes">

      </form>
  </div>

  <div class="booking-form">
      <h2>Change Password</h2>
      <form id="passwordForm" method="post" action="change_password.php">

      <table>
        <tr>
            <td><label>Current Password</label></td>
            <td><input type="password" id="currentPassword" name="currentPassword" required></td>
        </tr>
        <tr>
            <td><label>New Password</label></td>
            <td><input type="password" id="newPassword" name="newPassword" required></td>
        </tr>
        <tr>
            <td><label>Confirm New Password</label></td>
            <td><input type="password" id="confirmPassword" name="confirmPassword" required></td>
        </tr>
      </table>
      <input type="submit" name="changePassword" id="changePasswordBtn" value="Update Password">

      </form>
  </div>

</div>
</body>
</html>