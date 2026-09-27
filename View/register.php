<?php
include '../Controller/register_validation.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Register - Doctor Appointment System</title>

        <script>
            function collect_patient_data() {
            let ptname = document.getElementById("ptfname").value.trim();
            let ptphone = document.getElementById("ptphon").value.trim();
            let ptdob = document.getElementById("ptdob").value;
            let ptgender = document.querySelector('input[name="gender"]:checked');
            let ptemail = document.getElementById("ptemail").value.trim();
            let ptpass = document.getElementById("ptpass").value.trim();
            let valid = true;
            let message="";

    if (ptname.length < 3) {
        message += "Full name must be at least 3 characters.\n";
        valid = false;
    }

    if (ptphone.length < 11) {
        message += "Phone number must be at least 11 characters.\n";
        valid = false;
    }

    if (!ptdob) {
        message += "Date of birth is required.\n";
        valid = false;
    }

    if (!ptgender) {
        message += "Please select a gender.\n";
        valid = false;
    }

    if (ptemail === "") 
        {
        message += "Email is required.";
        valid = false;
        } else if (!ptemail.endsWith("@gmail.com")) {
        message += "Email must end with @gmail.com.";
        valid = false;
        }

    if (ptpass.length < 5) {
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
  background-color: beige;
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
  color: #1a4dd6;
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
input[type="password"],
input[type="date"] {
  width: 100%;
  padding: 9px;
  border: 1px solid #999;
  border-radius: 8px;
  font-size: 15px;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus,
input[type="date"]:focus {
  outline: none;
  border-color: #1a4dd6;
}

input[type="radio"] {
  cursor: pointer;
}

input[type="radio"] + label {
  display: inline;
  margin-right: 12px;
  cursor: pointer;
}

input[type="checkbox"] + label {
  display: inline;
  margin-left: 6px;
  cursor: pointer;
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
  background-color: #d92626;
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
            <h1>Register for Doctor Appointment System</h1>

            <?php if (!empty($message)) { ?>
                <div class="message <?php echo $success ? 'success' : ''; ?>"><?php echo htmlspecialchars($message); ?></div>
            <?php } ?>

            <form action="" method="POST" onsubmit="return collect_patient_data();">
                <table>
                    <tr>
                        <td><label for="Name">Full Name:</label></td>
                        <td><input type="text" id="ptfname" name="ptfname" value="<?php echo htmlspecialchars($ptname); ?>"></td>
                    </tr>

                    <tr>
                        <td><label for="Phone">Phone:</label></td>
                        <td><input type="text" id="ptphon" name="ptphon" value="<?php echo htmlspecialchars($ptphone); ?>"></td>
                    </tr>

                    <tr>
                        <td><label for="Dob">Date of birth:</label></td>
                        <td><input type="date" id="ptdob" name="ptdob" value="<?php echo htmlspecialchars($ptdob); ?>"></td>
                    </tr>

                    <tr>
                        <td><label for="Gender">Gender:</label></td>
                        <td>
                            <input type="radio" id="male" name="gender" value="male" <?php echo ($ptgender === "male") ? "checked" : ""; ?>>
                            <label for="male">Male</label>
                            <input type="radio" id="female" name="gender" value="female" <?php echo ($ptgender === "female") ? "checked" : ""; ?>>
                            <label for="female">Female</label>
                            <input type="radio" id="other" name="gender" value="other" <?php echo ($ptgender === "other") ? "checked" : ""; ?>>
                            <label for="other">Other</label>
                        </td>
                    </tr>

                    <tr>
                        <td> <label for="Email:"> Email: <span class="required">*</span> </label></td>
                        <td> <input type="email" id="ptemail" name="ptemail" value="<?php echo htmlspecialchars($ptemail); ?>"></td>
                    </tr>

                    <tr>
                        <td> <label for="pass"> Password: </label></td>
                        <td> <input type="password" id="ptpass" name="ptpass"></td>
                    </tr>

                    <tr>
                        <td colspan="2"> 
                            <input type="checkbox" id="remember" name="remember" value="1" <?php echo (!empty($_COOKIE["remember_user"])) ? "checked" : ""; ?>>
                            <label for="remember"> Remember Me </label>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                        <input type="submit" id="submit" value="Register">
                        <input type="reset" id="reset"> </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <label for="login">Already have an account? <a href="login.php">Login here</a></label>
                        </td>
                    </tr>

                    

                    



                    
                </table>
                
            </form>
        </div>
    </body>
</html>