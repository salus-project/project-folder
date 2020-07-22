<?php
require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
require 'edit_profile.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Update</title>
        <link rel="stylesheet" href="/css_codes/edit_profile.css">
    </head>

    <body>

    <script> btnPress(1) </script>

            <div class="edit_prof_form_box">
            <form action="update_cd.php" method="POST">
                <div class="head_edit_prof_form"> <div class="head_edit_prof_form_det"><?php echo $_SESSION['first_name']." ".$_SESSION['last_name'];   ?>
                </div></div>
                <div class="body_edit_prof_form">
                
                <div class="edit_prof_grp">
                <label class="edit_form_label">First Name </label><br>
                <input name = "first_name" type="text" class="edit_prof_input_box" value="<?php echo $_SESSION['first_name']; ?>" required /><br>
                </div>
                <div class="edit_prof_grp">
                <label class="edit_form_label">Last Name </label><br>
                <input name = "last_name" type="text" class="edit_prof_input_box" value="<?php echo $_SESSION['last_name']; ?>" required/><br>
                </div>
                <div class="edit_prof_grp">
                <label class="edit_form_label"> Gender </label><br>
                <select  name="gender" type="text" class="edit_prof_input_box" <?php echo $_SESSION['gender']; ?> required/><br>
                <?php if ($_SESSION['gender']=="male"){ echo "<option selected value=\"male\">Male</option>";} else{echo "<option  value=\"male\">Male</option>";} ?>
                <?php if ($_SESSION['gender']=="female"){ echo "<option selected value=\"female\">Female</option>";} else{echo "<option  value=\"female\">Female</option>";} ?>
                <?php if ($_SESSION['gender']=="other"){ echo "<option selected value=\"other\">Male</option>";} else{echo "<option  value=\"other\">Other</option>";} ?>
                </select>
                </div>
                <div class="edit_prof_grp">
                <label class="edit_form_label">District </label><br>
                <input name = "district" type="text" class="edit_prof_input_box" value="<?php echo $_SESSION['district']; ?>" required/><br>
                </div>
                <div class="edit_prof_grp">
                <label class="edit_form_label">Occupation </label><br>
                <input name = "occupation" type="text" class="edit_prof_input_box" value="<?php echo $_SESSION['Occupation']; ?>"required/><br>
                </div>
                <div class="edit_prof_grp">
                <label class="edit_form_label">Address </label><br>
                <input name = "address" type="text" class="edit_prof_input_box" value="<?php echo $_SESSION['address']; ?>"required/><br>
                </div>
                <div class="edit_prof_grp">
                <label class="edit_form_label">Email </label><br>
                <input name = "email" type="text" class="edit_prof_input_box" value="<?php echo $_SESSION['email']; ?>"required/><br>
                </div>
                <div class="edit_prof_grp">
                <label class="edit_form_label">Phone Number </label><br>
                <input name = "phone_num" type="text" class="edit_prof_input_box" value="<?php echo $_SESSION['phone_num']; ?>"required/><br>
                </div>
                <div class="edit_prof_grp">
                <label class="edit_form_label">Password </label><br>
                <input name="password" type="password" class="edit_prof_input_box" required/><br>
                </div>
                </div>
                <div class="foot_edit_prof_form">
                    <button name="update_button" type="submit"  value="Update"  class="edit_form_submit_button">Update</button>
                </div>
                
            </form>
            
            </div> 
    </body>
</html>