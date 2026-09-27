<?php
include '../Controller/admin_validation.php';
include '../Controller/admin_assign_validation.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Assign New Admin - Doctor Appointment System</title>
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

/* TABLE + FORM */
.booking-form, .doctor-list {
  background: #fff;
  padding: 20px;
  border-radius: 6px;
  margin-bottom: 24px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.section-title {
  margin-bottom: 12px;
}

.booking-form table td {
  padding: 8px 10px;
  border: none;
}

.booking-form label {
  font-weight: bold;
}

.booking-form input {
  width: 100%;
  padding: 6px 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

#createAdminBtn {
  margin-top: 12px;
  padding: 8px 20px;
  background: #16a34a;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

#createAdminBtn:hover {
  background: #15803d;
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

.message {
  background-color: #fdecea;
  color: #b71c1c;
  border: 1px solid #f5c6cb;
  border-radius: 6px;
  padding: 10px;
  margin-bottom: 15px;
  font-size: 14px;
}

.message.success {
  background-color: #e8f5e9;
  color: #1b5e20;
  border-color: #c8e6c9;
}
</style>

<script>
    function collect_new_admin_data() {
        let aname = document.getElementById("aname").value.trim();
        let aemail = document.getElementById("aemail").value.trim();
        let auname = document.getElementById("auname").value.trim();
        let apass = document.getElementById("apass").value.trim();
        let valid = true;
        let message = "";

        if (aname.length < 3) {
            message += "Full name must be at least 3 characters.\n";
            valid = false;
        }
        if (aemail === "" || !aemail.endsWith("@gmail.com")) {
            message += "Email must end with @gmail.com.\n";
            valid = false;
        }
        if (auname.length < 4) {
            message += "Username must be at least 4 characters.\n";
            valid = false;
        }
        if (apass.length < 5) {
            message += "Password must be at least 5 characters.\n";
            valid = false;
        }
        if (!valid) {
            alert(message);
        }
        return valid;
    }
</script>
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
      <a href="assign_admin.php" class="active">Assign New Admin</a>
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
      <h1>Assign New Admin</h1>
  </div>

  <?php if (!empty($message)) { ?>
      <div class="message <?php echo $success ? 'success' : ''; ?>"><?php echo htmlspecialchars($message); ?></div>
  <?php } ?>

  <div class="booking-form">
      <h2 class="section-title">Create Admin Account</h2>
      <form method="post" action="" onsubmit="return collect_new_admin_data();">
      <table>
        <tr>
            <td><label>Full Name</label></td>
            <td><input type="text" id="aname" name="aname" value="<?php echo htmlspecialchars($aname); ?>"></td>
        </tr>
        <tr>
            <td><label>Email</label></td>
            <td><input type="email" id="aemail" name="aemail" value="<?php echo htmlspecialchars($aemail); ?>"></td>
        </tr>
        <tr>
            <td><label>Username</label></td>
            <td><input type="text" id="auname" name="auname" value="<?php echo htmlspecialchars($auname); ?>"></td>
        </tr>
        <tr>
            <td><label>Password</label></td>
            <td><input type="password" id="apass" name="apass"></td>
        </tr>
      </table>
      <button type="submit" id="createAdminBtn">Create Admin</button>
      </form>
  </div>

  <div class="doctor-list">
      <h2 class="section-title">Existing Admin Accounts</h2>
      <table>
          <thead>
              <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Username</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($adminList as $adminRow) { ?>
                  <tr>
                      <td><?php echo htmlspecialchars($adminRow["name"]); ?></td>
                      <td><?php echo htmlspecialchars($adminRow["email"]); ?></td>
                      <td><?php echo htmlspecialchars($adminRow["username"]); ?></td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>
  </div>

</div>

</body>
</html>