<?php
include '../Controller/admin_register_validation.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin Register-Doctor Appointment System</title>

        <script>
            function collect_admin_data() {
            let aname = document.getElementById("aname").value.trim();
            let aemail = document.getElementById("aemail").value.trim();
            let auname = document.getElementById("auname").value.trim();
            let apass = document.getElementById("apass").value.trim();
            let valid = true;
            let message="";

    if (aname.length < 3) {
        message += "Full name must be at least 3 characters.\n";
        valid = false;
    }

    if (aemail === "") 
        {
        message += "Email is required.";
        valid = false;
        } else if (!aemail.endsWith("@gmail.com")) {
        message += "Email must end with @gmail.com.";
        valid = false;
        }

    if (auname.length < 4) {
        message += "Username must be at least 4 characters.\n";
        valid = false;
    }

    if (apass.length < 5) {
        message += "Password must be at least 5 characters.\n";
        valid = false   ;
    }

     if (!valid)
         {
            alert(message);
        }

    return valid;
}

    </script>

    <style>
        * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Cambria, Cochin, Georgia, "Times New Roman", serif;
  background-color: #e3e6fb;
  padding: 50px;
  line-height: 1.5;
}

.container-register {
  max-width: 480px;
  margin: 0 auto;
  background-color: #fff;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

h1 {
  color: #1a237e;
  text-align: center;
  margin-bottom: 25px;
  font-size: 26px;
}

table {
  width: 100%;
}

td {
  padding: 8px 0;
}

label {
  display: block;
  color: #222;
  font-size: 15px;
  margin-bottom: 4px;
}

.required {
  color: #d92626;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 9px;
  border: 1px solid #999;
  border-radius: 8px;
  font-size: 15px;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
  outline: none;
  border-color: #1a237e;
}

input[type="submit"],
input[type="reset"] {
  padding: 12px 0;
  width: 100%;
  border: none;
  border-radius: 10px;
  font-weight: bold;
  font-size: 16px;
  cursor: pointer;
  margin-top: 15px;
  transition: background-color 0.2s ease;
}

input[type="submit"] {
  background-color: #1a237e;
  color: #fff;
}

input[type="submit"]:hover {
  background-color: #111;
}

input[type="reset"] {
  background-color: #ddd;
  color: #222;
  margin-top: 8px;
}

input[type="reset"]:hover {
  background-color: #bbb;
}

.message {
  background-color: #fdecea;
  color: #b71c1c;
  border: 1px solid #f5c6cb;
  border-radius: 6px;
  padding: 10px;
  margin-bottom: 15px;
  font-size: 14px;
  text-align: center;
}

.message.success {
  background-color: #e8f5e9;
  color: #1b5e20;
  border-color: #c8e6c9;
}
    </style>
    </head>

    <body>
        <div class="container-register">
            <h1>Admin Registration</h1>

            <?php if (!empty($message)) { ?>
                <div class="message <?php echo $success ? 'success' : ''; ?>"><?php echo htmlspecialchars($message); ?></div>
            <?php } ?>
            
            <form action="" method="POST" onsubmit="return collect_admin_data();">
                <table>
                    <tr>
                        <td><label for="Name">Full Name:</label></td>
                        <td><input type="text" id="aname" name="aname" value="<?php echo htmlspecialchars($aname); ?>"></td>
                    </tr>

                    <tr>
                        <td> <label for="Email:"> Email: <span class="required">*</span> </label></td>
                        <td> <input type="email" id="aemail" name="aemail" value="<?php echo htmlspecialchars($aemail); ?>"></td>
                    </tr>

                    <tr>
                        <td><label for="Username">Username:</label></td>
                        <td><input type="text" id="auname" name="auname" value="<?php echo htmlspecialchars($auname); ?>"></td>
                    </tr>

                    <tr>
                        <td> <label for="pass"> Password: </label></td>
                        <td> <input type="password" id="apass" name="apass"></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                        <input type="submit" id="submit" value="Register">
                        <input type="reset" id="reset"> </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <label for="login">Already have an admin account? <a href="login.php">Login here</a></label>
                        </td>
                    </tr>
                </table>
                
            </form>
        </div>
    </body>
</html>