<?php
include '../Controller/doctor_user_validation.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Doctor Patients - Doctor Appointment System</title>
<style>
body { font-family: Arial, sans-serif; margin: 30px; background: #f4f6f8; }
.container { max-width: 900px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 8px; }
nav { margin-bottom: 20px; }
nav a { margin-right: 15px; text-decoration: none; color: #0f766e; font-weight: bold; }
.card { background: #f0fdf4; padding: 15px; border-radius: 6px; margin-top: 15px; }
</style>
</head>
<body>
<div class="container">
  <nav>
    <a href="doctor_dashboard.php">Dashboard</a>
    <a href="doctor_schedule.php">My Schedule</a>
    <a href="doctor_patients.php">Patients</a>
  </nav>
  <h1>Patients</h1>
  <div class="card">
    <p>Doctor: <?php echo htmlspecialchars($doctorName); ?></p>
    <p>No patient records are connected yet. This section is ready to extend with appointment data.</p>
  </div>
</div>
</body>
</html>