<?php
include '../Controller/admin_validation.php';
include '../Controller/doctor_validation.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Doctor-Doctor Appointment System</title>
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
.doctor-list, .edit-form {
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

.edit-form table td {
  padding: 8px 10px;
  border: none;
}

.edit-form label {
  font-weight: bold;
}

.edit-form input {
  width: 100%;
  padding: 6px 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

#saveBtn {
  margin-top: 12px;
  padding: 8px 20px;
  background: #16a34a;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

#saveBtn:hover {
  background: #15803d;
}

.edit-link {
  color: #1a237e;
  font-weight: bold;
  text-decoration: none;
}

.message {
  background-color: #e8f5e9;
  color: #1b5e20;
  border: 1px solid #c8e6c9;
  border-radius: 6px;
  padding: 10px;
  margin-bottom: 15px;
  font-size: 14px;
}

.message.error {
  background-color: #fdecea;
  color: #b71c1c;
  border-color: #f5c6cb;
}
</style>

<script>
    function collect_doctor_data() {
        let dname = document.getElementById("dname").value.trim();
        let dspec = document.getElementById("dspec").value.trim();
        let demail = document.getElementById("demail").value.trim();
        let dphone = document.getElementById("dphone").value.trim();
        let valid = true;
        let message = "";

        if (dname.length < 3) {
            message += "Doctor name must be at least 3 characters.\n";
            valid = false;
        }
        if (dspec.length < 3) {
            message += "Specialization must be at least 3 characters.\n";
            valid = false;
        }
        if (demail === "" || !demail.includes("@")) {
            message += "A valid email is required.\n";
            valid = false;
        }
        if (dphone.length < 6) {
            message += "Phone number looks too short.\n";
            valid = false;
        }
        if (!valid) {
            alert(message);
        }
        return valid;
    }

    function collect_new_doctor_data() {
        let dname = document.getElementById("new_dname").value.trim();
        let dspec = document.getElementById("new_dspec").value.trim();
        let demail = document.getElementById("new_demail").value.trim();
        let dusername = document.getElementById("new_dusername").value.trim();
        let dpass = document.getElementById("new_dpass").value.trim();
        let dphone = document.getElementById("new_dphone").value.trim();
        let valid = true;
        let message = "";

        if (dname.length < 3) {
            message += "Doctor name must be at least 3 characters.\n";
            valid = false;
        }
        if (dspec.length < 3) {
            message += "Specialization must be at least 3 characters.\n";
            valid = false;
        }
        if (demail === "" || !demail.includes("@")) {
            message += "A valid email is required.\n";
            valid = false;
        }
        if (dusername.length < 3) {
            message += "Username must be at least 3 characters.\n";
            valid = false;
        }
        if (dpass.length < 5) {
            message += "Password must be at least 5 characters.\n";
            valid = false;
        }
        if (dphone.length < 6) {
            message += "Phone number looks too short.\n";
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
      <a href="manage_doctor.php" class="active">Manage Doctor</a>
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
      <h1>Manage Doctor Profile</h1>
  </div>

  <?php if (!empty($message)) { ?>
      <div class="message <?php echo $addSuccess ? '' : 'error'; ?>"><?php echo htmlspecialchars($message); ?></div>
  <?php } ?>

  <div class="edit-form">
      <h2 class="section-title">Add New Doctor</h2>
      <form method="post" action="manage_doctor.php" onsubmit="return collect_new_doctor_data();">
          <table>
              <tr>
                  <td><label>Doctor Name</label></td>
                  <td><input type="text" id="new_dname" name="new_dname"></td>
              </tr>
              <tr>
                  <td><label>Specialization</label></td>
                  <td><input type="text" id="new_dspec" name="new_dspec"></td>
              </tr>
              <tr>
                  <td><label>Email</label></td>
                  <td><input type="text" id="new_demail" name="new_demail"></td>
              </tr>
              <tr>
                  <td><label>Username</label></td>
                  <td><input type="text" id="new_dusername" name="new_dusername"></td>
              </tr>
              <tr>
                  <td><label>Password</label></td>
                  <td><input type="text" id="new_dpass" name="new_dpass"></td>
              </tr>
              <tr>
                  <td><label>Phone</label></td>
                  <td><input type="text" id="new_dphone" name="new_dphone"></td>
              </tr>
          </table>
          <button type="submit" id="saveBtn" name="add_doctor">Add Doctor</button>
      </form>
  </div>

  <?php if ($editDoctor) { ?>
  <div class="edit-form">
      <h2 class="section-title">Edit Doctor Profile</h2>
      <form method="post" action="manage_doctor.php" onsubmit="return collect_doctor_data();">
          <input type="hidden" name="doctor_id" value="<?php echo htmlspecialchars($editDoctor["id"]); ?>">
          <table>
              <tr>
                  <td><label>Doctor Name</label></td>
                  <td><input type="text" id="dname" name="dname" value="<?php echo htmlspecialchars($editDoctor["name"]); ?>"></td>
              </tr>
              <tr>
                  <td><label>Specialization</label></td>
                  <td><input type="text" id="dspec" name="dspec" value="<?php echo htmlspecialchars($editDoctor["specialization"]); ?>"></td>
              </tr>
              <tr>
                  <td><label>Email</label></td>
                  <td><input type="text" id="demail" name="demail" value="<?php echo htmlspecialchars($editDoctor["email"]); ?>"></td>
              </tr>
              <tr>
                  <td><label>Username</label></td>
                  <td><input type="text" id="dusername" name="dusername" value="<?php echo htmlspecialchars($editDoctor["username"] ?? ""); ?>"></td>
              </tr>
              <tr>
                  <td><label>Password</label></td>
                  <td><input type="text" id="dpass" name="dpass" value="<?php echo htmlspecialchars($editDoctor["password"] ?? ""); ?>"></td>
              </tr>
              <tr>
                  <td><label>Phone</label></td>
                  <td><input type="text" id="dphone" name="dphone" value="<?php echo htmlspecialchars($editDoctor["phone"]); ?>"></td>
              </tr>
          </table>
          <button type="submit" id="saveBtn">Save Changes</button>
      </form>
  </div>
  <?php } ?>

  <div class="doctor-list">
    <h2 class="section-title">Doctor List</h2>
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Doctor Name</th>
                <th>Specialization</th>
                <th>Email</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filteredDoctors as $doctorRow) { ?>
                <tr>
                    <td>
                        <?php $doctorImage = $doctorRow["image"] ?? ""; ?>
                        <?php if (!empty($doctorImage)) { ?>
                            <img src="<?php echo htmlspecialchars($doctorImage); ?>" alt="Doctor Photo" style="width:50px;height:50px;border-radius:50%;object-fit:cover;">
                        <?php } else { ?>
                            <div style="width:50px;height:50px;border-radius:50%;background:#dbeafe;display:flex;align-items:center;justify-content:center;font-size:12px;color:#0f172a;">Doc</div>
                        <?php } ?>
                    </td>
                    <td><?php echo htmlspecialchars($doctorRow["name"]); ?></td>
                    <td><?php echo htmlspecialchars($doctorRow["specialization"]); ?></td>
                    <td><?php echo htmlspecialchars($doctorRow["email"]); ?></td>
                    <td><?php echo htmlspecialchars($doctorRow["username"] ?? ""); ?></td>
                    <td><?php echo htmlspecialchars($doctorRow["phone"]); ?></td>
                    <td><a class="edit-link" href="manage_doctor.php?edit=<?php echo urlencode($doctorRow["id"]); ?>">Edit</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
  </div>

</div>

</body>
</html>
