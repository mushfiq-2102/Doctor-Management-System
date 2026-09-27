<?php
include '../Controller/doctor_user_validation.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Doctor Dashboard - Doctor Appointment System</title>
<style>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
}

body {
  display: flex;
  background: linear-gradient(135deg, #e0f2fe 0%, #f8fafc 35%, #ecfeff 100%);
  color: #1f2937;
}

.sidebar {
  width: 220px;
  min-height: 100vh;
  background: linear-gradient(180deg, #0f172a 0%, #134e4a 100%);
  color: #fff;
  display: flex;
  flex-direction: column;
  padding: 20px 0;
  box-shadow: 2px 0 18px rgba(15, 23, 42, 0.18);
}

.profile {
  text-align: center;
  margin-bottom: 30px;
}

.avatar {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: #115e59;
  margin: 0 auto 10px;
}

.sidebar nav {
  display: flex;
  flex-direction: column;
}

.sidebar nav a {
  color: #d1fae5;
  text-decoration: none;
  padding: 12px 20px;
}

.sidebar nav a:hover,
.sidebar nav a.active {
  background: #134e4a;
  color: #fff;
}

.logout {
  margin-top: auto;
  padding: 12px 20px;
}

.logout button {
  background: none;
  border: none;
  color: #fca5a5;
  cursor: pointer;
  font-size: 14px;
  padding: 0;
}

.main {
  flex: 1;
  padding: 30px;
  background: rgba(255, 255, 255, 0.2);
}

.top-head h1 {
  font-size: 26px;
  margin-bottom: 18px;
  color: #0f172a;
}

.card-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 18px;
  margin-top: 12px;
}

.card {
  background: rgba(255,255,255,0.9);
  padding: 22px;
  border-radius: 14px;
  box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
  text-decoration: none;
  color: #1f2937;
  border-left: 5px solid #14b8a6;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 14px 28px rgba(15, 23, 42, 0.12);
}

.card h2 {
  font-size: 18px;
  margin-bottom: 8px;
  color: #0f766e;
}

.card p {
  font-size: 14px;
  color: #475569;
  line-height: 1.5;
}
</style>
</head>
<body>

<div class="sidebar">
  <div class="profile">
      <div class="avatar"></div>
      <p><?php echo htmlspecialchars($doctorName); ?></p>
  </div>
  <nav>
      <a href="doctor_dashboard.php" class="active">Home</a>
      <a href="doctor_schedule.php">My Schedule</a>
      <a href="doctor_patients.php">Patients</a>
  </nav>
  <div class="logout">
      <form method="post" action="">
          <button type="submit" name="logout">Logout</button>
      </form>
  </div>
</div>

<div class="main">
  <div class="top-head">
      <h1>Welcome, <?php echo htmlspecialchars($doctorName); ?></h1>
  </div>

  <div class="card-grid">
      <a href="doctor_schedule.php" class="card">
          <h2>My Schedule</h2>
          <p>Review your available appointment slots and weekly plan.</p>
      </a>
      <a href="doctor_patients.php" class="card">
          <h2>Patients</h2>
          <p>View patient records and upcoming consultations.</p>
      </a>
  </div>
</div>

</body>
</html>