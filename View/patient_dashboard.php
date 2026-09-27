<?php
include '../Controller/patient_validation.php';

$appointmentMessage = "";
$appointmentSuccess = false;
$appointmentData = [
    "doctor" => "",
    "date" => "",
    "time" => "",
    "patientName" => "",
    "gender" => ""
];

$doctorList = json_decode(file_get_contents("../Model/doctor_demo.json"), true);
if (!is_array($doctorList)) {
    $doctorList = [];
}

$doctorSearch = trim($_GET["doctor_search"] ?? "");
$filteredDoctors = $doctorList;
if ($doctorSearch !== "") {
    $filteredDoctors = [];
    foreach ($doctorList as $doctorRow) {
        $name = strtolower($doctorRow["name"] ?? "");
        $specialization = strtolower($doctorRow["specialization"] ?? "");
        $keyword = strtolower($doctorSearch);
        if (strpos($name, $keyword) !== false || strpos($specialization, $keyword) !== false) {
            $filteredDoctors[] = $doctorRow;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["makeApp"])) {
    $appointmentData["doctor"] = trim($_POST["doctor"] ?? "");
    $appointmentData["date"] = $_POST["appointmentDate"] ?? "";
    $appointmentData["time"] = $_POST["appointmentTime"] ?? "10:00 AM";
    $appointmentData["patientName"] = trim($_POST["patientName"] ?? "");
    $appointmentData["gender"] = $_POST["gender"] ?? "";

    $errors = [];

    if ($appointmentData["doctor"] === "") {
        $errors[] = "Please select a doctor.";
    }
    if ($appointmentData["date"] === "") {
        $errors[] = "Please select an appointment date.";
    }
    if ($appointmentData["patientName"] === "") {
        $errors[] = "Please enter your name.";
    }
    if ($appointmentData["gender"] === "") {
        $errors[] = "Please select your gender.";
    }

    if (empty($errors)) {
        $appointmentList = json_decode(file_get_contents("../Model/appointment_demo.json"), true);
        if (!is_array($appointmentList)) {
            $appointmentList = [];
        }

        $newId = 1;
        foreach ($appointmentList as $row) {
            if ((int)($row["id"] ?? 0) >= $newId) {
                $newId = (int)($row["id"] ?? 0) + 1;
            }
        }

        $appointmentList[] = [
            "id" => $newId,
            "patient_name" => $appointmentData["patientName"],
            "doctor_name" => $appointmentData["doctor"],
            "date" => $appointmentData["date"],
            "time" => $appointmentData["time"],
            "status" => "Pending"
        ];

        file_put_contents("../Model/appointment_demo.json", json_encode($appointmentList, JSON_PRETTY_PRINT));

        $appointmentSuccess = true;
        $appointmentMessage = "Appointment booked successfully! Patient: " . $appointmentData["patientName"] . " | Doctor: " . $appointmentData["doctor"] . " | Date: " . $appointmentData["date"] . " | Time: " . $appointmentData["time"] . ".";

        $appointmentData["doctor"] = "";
        $appointmentData["date"] = "";
        $appointmentData["time"] = "10:00 AM";
        $appointmentData["patientName"] = "";
        $appointmentData["gender"] = "";
    } else {
        $appointmentMessage = implode(" ", $errors);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Patient Dashboard-Doctor Appointment System</title>
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
</style>

<script>
    function filterDoctorList() {
        const query = document.getElementById('searchDoctor').value.trim().toLowerCase();
        const rows = document.querySelectorAll('#doctorlist tr[data-doctor]');
        rows.forEach((row) => {
            const text = row.dataset.doctor.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });

        const select = document.getElementById('selectDoctor');
        Array.from(select.options).forEach((option) => {
            if (!option.value) {
                return;
            }
            const text = option.text.toLowerCase();
            option.style.display = text.includes(query) || query === '' ? '' : 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchDoctor');
        const searchBtn = document.getElementById('searchBtn');

        if (searchInput) {
            searchInput.addEventListener('input', filterDoctorList);
        }

        if (searchBtn) {
            searchBtn.addEventListener('click', filterDoctorList);
        }
    });
</script>
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

  <!-- Top Bar -->
  <div class="top-head">
      <h1>Welcome to Doctor Appointment System</h1>
  </div>

  <div class="top-nav">
      <input type="text" id="searchDoctor" name="doctor_search" placeholder="Search for doctor" value="<?php echo htmlspecialchars($doctorSearch); ?>">
      <button type="button" id="searchBtn">Search</button>
  </div>

  <div class="doctor-list">
    <h2 class="section-title">Available Doctor</h2>
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Doctor Name</th>
                <th>Specialist</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody id="doctorlist">
            <?php foreach ($filteredDoctors as $doctorRow) { ?>
                <tr data-doctor="<?php echo htmlspecialchars($doctorRow["name"] . ' ' . ($doctorRow["specialization"] ?? '')); ?>">
                    <td>
                        <?php $doctorImage = $doctorRow["image"] ?? ""; ?>
                        <?php if (!empty($doctorImage)) { ?>
                            <img src="<?php echo htmlspecialchars($doctorImage); ?>" alt="Doctor Photo" style="width:45px;height:45px;border-radius:50%;object-fit:cover;">
                        <?php } else { ?>
                            <div style="width:45px;height:45px;border-radius:50%;background:#dbeafe;display:flex;align-items:center;justify-content:center;font-size:11px;color:#0f172a;">Doc</div>
                        <?php } ?>
                    </td>
                    <td><?php echo htmlspecialchars($doctorRow["name"] ?? ""); ?></td>
                    <td><?php echo htmlspecialchars($doctorRow["specialization"] ?? ""); ?></td>
                    <td>Available</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
  </div>

  <?php if (!empty($appointmentMessage)) { ?>
      <div class="booking-form" style="border-left: 4px solid <?php echo $appointmentSuccess ? '#16a34a' : '#dc2626'; ?>; background: <?php echo $appointmentSuccess ? '#f0fdf4' : '#fef2f2'; ?>; color: #111827; margin-bottom: 20px;">
          <strong><?php echo $appointmentSuccess ? 'Booked Successfully' : 'Booking Error'; ?></strong>
          <p style="margin-top: 8px;"><?php echo htmlspecialchars($appointmentMessage); ?></p>
      </div>
  <?php } ?>

  <div class="booking-form">
      <h2>Book an Appointment</h2>
      <form id="bookingForm" method="post" action="">

      <table>
        <tr>
            <td><label>Select Doctor</label></td>
            <td>
                <select id="selectDoctor" name="doctor" required>
                  <option value="">-- Select Doctor --</option>
                  <?php foreach ($filteredDoctors as $doctorRow) { ?>
                      <option value="<?php echo htmlspecialchars($doctorRow["name"] ?? ""); ?>"><?php echo htmlspecialchars($doctorRow["name"] ?? ""); ?> - <?php echo htmlspecialchars($doctorRow["specialization"] ?? ""); ?></option>
                  <?php } ?>
                </select>
                <?php echo $selectDoctor ?? ''; ?>
            </td>
        </tr>

        <tr>
            <td><label>Date</label></td>
            <td><input type="date" id="appointmentDate" name="appointmentDate" value="<?php echo htmlspecialchars($appointmentData["date"]); ?>" required>
            <?php echo $selectAppDate ?? ''; ?>
            </td>
        </tr>

        <tr>
            <td><label>Time</label></td>
            <td>
                <select id="appointmentTime" name="appointmentTime" required>
                    <option value="10:00 AM" <?php echo ($appointmentData["time"] === "10:00 AM") ? "selected" : ""; ?>>10:00 AM</option>
                    <option value="11:30 AM" <?php echo ($appointmentData["time"] === "11:30 AM") ? "selected" : ""; ?>>11:30 AM</option>
                    <option value="01:00 PM" <?php echo ($appointmentData["time"] === "01:00 PM") ? "selected" : ""; ?>>01:00 PM</option>
                    <option value="02:30 PM" <?php echo ($appointmentData["time"] === "02:30 PM") ? "selected" : ""; ?>>02:30 PM</option>
                    <option value="04:00 PM" <?php echo ($appointmentData["time"] === "04:00 PM") ? "selected" : ""; ?>>04:00 PM</option>
                </select>
            </td>
        </tr>

        <tr>
            <td><label>Name</label></td>
            <td><input type="text" id="patientNameInput" name="patientName" value="<?php echo htmlspecialchars($appointmentData["patientName"]); ?>" required>
            <?php echo $ptname ?? ''; ?>
            </td>
        </tr>

        <tr>
            <td><label>Gender</label></td>
            <td>
                <select id="genderInput" name="gender" required>
                  <option value="">-- Select --</option>
                  <option value="male" <?php echo ($appointmentData["gender"] === "male") ? "selected" : ""; ?>>Male</option>
                  <option value="female" <?php echo ($appointmentData["gender"] === "female") ? "selected" : ""; ?>>Female</option>
                  <option value="other" <?php echo ($appointmentData["gender"] === "other") ? "selected" : ""; ?>>Other</option>
              </select>
              <?php echo $ptgender ?? ''; ?>
            </td>
        </tr>
      </table>
      <input type="submit" name="makeApp" id="makeApp" value="Book Appointment">

      </form>
  </div>

</div>

</body>
</html>