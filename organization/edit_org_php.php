<?php
    if($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['edit_button'])){
        //echo '<script type="text/javascript">alert("submit button clicked")</script>';
        $isOk=1;
        $org_id=$_POST['org_id'];
        $_GET['org_id']=$org_id;
        if(empty($_POST['org_name'])){
            $nameErr="Organization name is required";
            $isOk=0;
        }else{
            $org_name=filt_inp($_POST['org_name']);
            if(!preg_match("/^[a-zA-Z ]*$/",$org_name)){
                $nameErr='Only letters and white space allowed';
                $isOk=0;
            }
        }

        if(empty($_POST['district'])){
            $disErr="Service district is required";
            $isOk=0;
        }else{
            $district=filt_inp($_POST['district']);
        }

        if(empty($_POST['email'])){
            $emailErr="Email is required";
            $isOk=0;
        }else{
            $email=filt_inp($_POST['email']);
        }

        if(empty($_POST['phone_num'])){
            $phoneErr="Phone number is required";
            $isOk=0;
        }
        else{
            $phone_num=filt_inp($_POST['phone_num']);
            if(!preg_match("/^[0-9]*$/",$phone_num)){
                $phoneErr='Only numbers allowed';
                $isOk=0;
            }
        }

        $discription=$_POST['discription'];

        if($isOk==1){
            $query2="UPDATE organizations SET org_name='$org_name', district='$district', email='$email', phone_num='$phone_num', discription='$discription' WHERE org_id=".$org_id;
            $query_run=$con->query($query2);
            if($query_run){
                header('location:/organization/?selected_org='.$org_id);
                echo '<script type="text/javascript">alert("Successfully created")</script>';

            }else{
                echo '<script type="text/javascript">alert("Error")</script>';
            }
        }else{
            echo "try again";
        }
    }
    
?> 