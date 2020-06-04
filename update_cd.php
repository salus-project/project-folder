<?php
session_start();
require 'dbconfi/confi.php';
require 'edit_profile.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Update</title>
        <link rel="stylesheet" href="css_codes/style.css">
    </head>

    <body style="background-color: #dedede">
    <?php require 'header.php' ?>

    <script> btnPress(1) </script>

        <center>
            <h1> Update my Info </h1>
            
            <div class="div1">
            <form  class="form_box" action="update_cd.php" method="POST">

                <label class="label">First Name </label><br>
                <input name = "first_name" type="text" class="input_box" value="<?php echo $_SESSION['first_name']; ?>" required /><br>
                
                <label class="label">Last Name </label><br>
                <input name = "last_name" type="text" class="input_box" value="<?php echo $_SESSION['last_name']; ?>" required/><br>

                <label class="label"> Gender </label><br>
                <select  name="gender" type="text" class="input_box" value="<?php echo $_SESSION['gender']; ?>" required/><br>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>

                <label class="label">District </label><br>
                <input name = "district" type="text" class="input_box" value="<?php echo $_SESSION['district']; ?>" required/><br>

                <label class="label">Occupation </label><br>
                <input name = "occupation" type="text" class="input_box" value="<?php echo $_SESSION['Occupation']; ?>"required/><br>

                <label class="label">Address </label><br>
                <input name = "address" type="text" class="input_box" value="<?php echo $_SESSION['address']; ?>"required/><br>

                <label class="label">Email </label><br>
                <input name = "email" type="text" class="input_box" value="<?php echo $_SESSION['email']; ?>"required/><br>

                <label class="label">Phone Number </label><br>
                <input name = "phone_num" type="text" class="input_box" value="<?php echo $_SESSION['phone_num']; ?>"required/><br>
                
                <label class="label">Password </label><br>
                <input name="password" type="password" class="input_box" required/><br>
                
                <input name="update_button" type="submit"  value="Update"  class="login_button"><br>
                
                
            </form>

            
            </div>
        <center>
        
    </body>
</html>