<?php
include '../Controller/admin_validation.php';
include '../Controller/appointment_validation.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>View Appointments - Doctor Appointment System</title>
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

/* TABLE */
.doctor-list {
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

.status {
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: bold;
}

.status-Confirmed { background: #e8f5e9; color: #1b5e20; }
.status-Pending { background: #fff8e1; color: #8d6e00; }
.status-Completed { background: #e3f2fd; color: #0d47a1; }
.status-Cancelled { background: #fdecea; color: #b71c1c; }
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
      <a href="admin_dashboard.php">Home</a>
      <a href="search_doctor.php">Search Doctor</a>
      <a href="manage_doctor.php">Manage Doctor</a>
      <a href="assign_admin.php">Assign New Admin</a>
      <a href="view_appointments.php" class="active">View Appointments</a>
  </nav>
  <div class="logout">
      <form method="post" action="">
          <button type="submit" name="logout" style="background:none;border:none;color:#f87171;cursor:pointer;font-size:14px;padding:0;">Logout</button>
      </form>
  </div>
</div>

<div class="main">

  <div class="top-head">
      <h1>Appointment List</h1>
  </div>

  <div class="doctor-list">
    <h2 class="section-title">All Appointments</h2>
    <table>
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Doctor Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($appointmentList) === 0) { ?>
                <tr><td colspan="5">No appointments found.</td></tr>
            <?php } else { ?>
                <?php foreach ($appointmentList as $appointmentRow) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($appointmentRow["patient_name"]); ?></td>
                        <td><?php echo htmlspecialchars($appointmentRow["doctor_name"]); ?></td>
                        <td><?php echo htmlspecialchars($appointmentRow["date"]); ?></td>
                        <td><?php echo htmlspecialchars($appointmentRow["time"]); ?></td>
                        <td><span class="status status-<?php echo htmlspecialchars($appointmentRow["status"]); ?>"><?php echo htmlspecialchars($appointmentRow["status"]); ?></span></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
  </div>

</div>

</body>
</html>
