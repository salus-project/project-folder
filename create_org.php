<?php  
    session_start();
    require 'dbconfi/confi.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>create new organization </title>
        <link rel='stylesheet' href='css_codes/create_org.css'>
    </head>
    <body>
        <?php
            $nameErr=$leaderErr=$disErr=$emailErr=$phoneErr='';           //Defining error message values
            $org_name=$leader=$district=$email=$phone_num=$discription='';    //Definig variables and initiate them to empty values
            $members=array();                               //initiate $members variable as arrary

            if($_SERVER['REQUEST_METHOD']=='POST'){
                $org_name=$_POST['org_name'];
                if(isset($_POST['leader'])){
                    $leader=$_POST['leader'];
                }
                $district=$_POST['district'];
                $email=$_POST['email'];
                $phone_num=$_POST['phone_num'];
                $discription=$_POST['discription'];
                $str_value=$_POST['str_value'];
                $members=unserialize(base64_decode($str_value));
            }

            if($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['submit_button'])){
                //echo '<script type="text/javascript">alert("submit button clicked")</script>';
                $isOk=1;
                if(empty($_POST['org_name'])){
                    $nameErr="Organization name is required";
                    $isOk=0;
                }else{
                    $org_name=filter($_POST['org_name']);
                    $validate_name_query="select * from organizations where org_name='$org_name'";
                    $query_run=mysqli_query($con,$validate_name_query);
                    if(mysqli_num_rows($query_run)>0){
                        echo '<script type="text/javascript">alert("Organization name already exits...")</script>';
                        $isOk=0;
                    }
                    if(!preg_match("/^[a-zA-Z ]*$/",$org_name)){
                        $nameErr='Only letters and white space allowed';
                    }
                }
                
                if(empty($_POST['leader'])){
                    $leaderErr="Organization name is required";
                    $isOk=0;
                }else{
                    if($_POST['leader']=='you'){
                        $leader=$_SESSION['user_nic'];
                    }
                    elseif (isset($_POST['leader_nic'])) {
                        $leader=$_POST['leader_nic'];
                    }
                }

                if(empty($_POST['district'])){
                    $disErr="Service district is required";
                    $isOk=0;
                }else{
                    $district=filter($_POST['district']);
                }

                if(empty($_POST['email'])){
                    $emailErr="Email is required";
                    $isOk=0;
                }else{
                    $email=filter($_POST['email']);
                }

                if(empty($_POST['phone_num'])){
                    $phoneErr="Phone number is required";
                    $isOk=0;
                }else{
                    $phone_num=filter($_POST['phone_num']);
                }

                $discription=$_POST['discription'];

                if($isOk==1){
                    $str_members=base64_encode(serialize($members));
                    #$members=unserialize(base64_decode($str_value));
                    $query="INSERT INTO organizations (org_name, head, district, email, phone_num, members, discription) VALUES ('$org_name','$leader','$district','$email','$phone_num','$str_members','$discription')";
                    $query_run=mysqli_query($con,$query);
                    if($query_run){
                        header('location:organizations.php');
                        echo '<script type="text/javascript">alert("Successfully created")</script>';
                        
                    }else{
                        echo '<script type="text/javascript">alert("Error")</script>';
                    }
                    #header('location:home_page.php');
                }
            }
            function filter($input){
                return(htmlspecialchars(stripslashes(trim($input))));
            }

            if(isset($_POST['add_member'])){
                //$members=$_POST['']
                array_push($members,$_POST['new_member']);
            }

        require 'header.php';

        ?>
        <div id='main_body'>
            <center><h2>Create a new organization</h2></center>
            <small style="margin:10px;">Enter the details</small>
            <form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
                <input type='hidden' name='str_value' value=<?php print base64_encode(serialize($members)); ?>>
                <table id='sub_body'>
                    <tr>
                        <td colspan='2'>
                            <span id='error'>* required field</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for='org_name'>Organization name</label>
                        </td>
                        <td>
                            <input type='text' name="org_name" value=<?php echo $org_name; ?>>
                            
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for='leader'>Leader</label>
                        </td>
                        <td>
                            <input type='radio' name="leader" value='you' <?php if(isset($leader) && $leader=='you') echo 'checked'; ?> onclick='leaderFun()'>You</br>
                            <div style="display:flex; height:20px;">
                                <input type='radio' name="leader" id='other_leader' value='others' <?php if(isset($leader) && $leader=='others') echo 'checked'; ?> onclick='leaderFun()'>Others
                                <input type='text' name='leader_nic' id='other_leader_nic' placeholder='Leader NIC num' style='display:none'>
                            </div>
                            
                            <script>
                                function leaderFun(){
                                    if(document.getElementById("other_leader").checked){
                                        document.getElementById('other_leader_nic').style.display='block'
                                        
                                    }else{
                                        document.getElementById('other_leader_nic').style.display='none'
                                    }
                                }
                            </script>
                            
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for='district'>Service district</label>
                        </td>
                        <td>
                            <select name="district">
                                <option value='all island'>All island</option>
                                <option value='Ampara'>Ampara</option>
                                <option value='Anurashapura'>Anurashapura</option>
                                <option value='Badulla'>Badulla</option>
                                <option value='Batticaloa'>Batticaloa</option>
                                <option value='Colombo'>Colombo</option>
                                <option value='Galle'>Galle</option>
                                <option value='Gampha'>Gampha</option>
                                <option value='Hambatota'>Hambantota</option>
                                <option value='Jaffna'>Jaffna</option>
                                <option value='Kaltura'>Kaltura</option>
                                <option value='Kandy'>Kandy</option>
                                <option value='Kegalle'>Kegalle</option>
                                <option value='Kilinochchi'>Kilinochchi</option>
                                <option value='Kurunegala'>Kurunegala</option>
                                <option value='Mannar'>Mannar</option>
                                <option value='Matale'>Matale</option>
                                <option value='Mathara'>Mathara</option>
                                <option value='Moneragala'>Moneragala</option>
                                <option value='Mullaitivu'></option>
                                <option value='Nuwara-Eliya'>Nuwara-Eliya</option>
                                <option value='Polonnaruwa'>Polonnaruwa</option>
                                <option value='Puttalam'>Puttalam</option>
                                <option value='Ratnapura'>Ratnapura</option>
                                <option value='Tricomalee'>Tricomalee</option>
                                <option value='Vavuniya'>Vavuniya</option>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Organization Email</label>
                        </td>
                        <td>
                            <input type='email' name="email" value=<?php echo $email; ?>>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for='phone_num'>Phone number</label>
                        </td>
                        <td>
                            <input type='tel' name="phone_num" value=<?php echo $phone_num; ?>>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Discription</label>
                        </td>
                        <td>
                            <textarea name='discription'><?php echo $discription; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Members</label>
                        </td>
                        <td>
                            <?php
                                $id=0;
                                foreach((array) $members as $value){
                                    echo '<input type="text" name="members' . $id . '" value=' . $value .'>
                                    <input type="submit" name="remove_member" value="remove"></br>';
                                    $id++;
                                }
                                echo '<input type="text" name="new_member">
                                <input type="submit" name="add_member" value="add"></br>';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <input type='checkbox' name='valiate' onclick='myfunction()' id="checkbox">
                            <label for='validate'>I have read the terms and conditions</label>
                            
                            <script>
                            function myfunction(){
                                //var x = ;
                                if(document.getElementById('checkbox').checked){
                                    document.getElementById("submitBtn").disabled=false;
                                }
                                else{
                                    document.getElementById("submitBtn").disabled=true;
                                }
                                
                                
                            }
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <input type='submit' name='submit_button' id='submitBtn' disabled>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>

</html>