<?php
include '../Controller/admin_validation.php';
include '../Controller/doctor_validation.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Search Doctor - Doctor Appointment System</title>
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
  background: #1a237e;
  color: #fff;
  border-radius: 4px;
  cursor: pointer;
}

.top-nav button:hover {
  background: #283593;
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
      <a href="search_doctor.php" class="active">Search Doctor</a>
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
      <h1>Browse / Search Doctor</h1>
  </div>

  <form class="top-nav" method="GET" action="">
      <input type="text" name="keyword" placeholder="Search by name or specialization" value="<?php echo htmlspecialchars($keyword); ?>">
      <button type="submit">Search</button>
  </form>

  <div class="doctor-list">
    <h2 class="section-title">Doctor List</h2>
    <table>
        <thead>
            <tr>
                <th>Doctor Name</th>
                <th>Specialization</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($filteredDoctors) === 0) { ?>
                <tr><td colspan="4">No doctors found.</td></tr>
            <?php } else { ?>
                <?php foreach ($filteredDoctors as $doctorRow) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($doctorRow["name"]); ?></td>
                        <td><?php echo htmlspecialchars($doctorRow["specialization"]); ?></td>
                        <td><?php echo htmlspecialchars($doctorRow["email"]); ?></td>
                        <td><?php echo htmlspecialchars($doctorRow["phone"]); ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
  </div>

</div>

</body>
</html>
