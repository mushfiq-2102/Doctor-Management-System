<?php
include '../Controller/admin_validation.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard-Doctor Appointment System</title>
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
  background: #1a237e;
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
  background: #3949ab;
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
  background: #283593;
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

/* CARDS */
.card-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 16px;
  margin-top: 10px;
}

.card {
  background: #fff;
  padding: 20px;
  border-radius: 6px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  text-decoration: none;
  color: #222;
  border-left: 4px solid #1a237e;
}

.card:hover {
  box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.card h2 {
  font-size: 16px;
  margin-bottom: 6px;
  color: #1a237e;
}

.card p {
  font-size: 13px;
  color: #666;
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <div class="profile">
      <div class="avatar"></div>
      <p id="adminName"><?php echo htmlspecialchars($adminName); ?></p>
  </div>
  <nav>
      <a href="admin_dashboard.php" class="active">Home</a>
      <a href="search_doctor.php">Search Doctor</a>
      <a href="manage_doctor.php">Manage Doctor</a>
      <a href="assign_admin.php">Assign New Admin</a>
      <a href="view_appointments.php">View Appointments</a>
  </nav>
  <div class="logout">
      <form method="post" action="">
          <button type="submit" name="logout" style="background:none;border:none;color:#f87171;cursor:pointer;font-size:14px;padding:0;">Logout</button>
      </form>
  </div>
</div>

<div class="main">

  <div class="top-head">
      <h1>Welcome, <?php echo htmlspecialchars($adminName); ?></h1>
  </div>

  <div class="card-grid">
      <a href="search_doctor.php" class="card">
          <h2>Search Doctor</h2>
          <p>Browse all doctors or search by name/specialization.</p>
      </a>
      <a href="manage_doctor.php" class="card">
          <h2>Manage Doctor</h2>
          <p>View and update basic doctor profile information.</p>
      </a>
      <a href="assign_admin.php" class="card">
          <h2>Assign New Admin</h2>
          <p>Create a new admin account for the system.</p>
      </a>
      <a href="view_appointments.php" class="card">
          <h2>View Appointments</h2>
          <p>See patient, doctor, date, time and status.</p>
      </a>
  </div>

</div>

</body>
</html>