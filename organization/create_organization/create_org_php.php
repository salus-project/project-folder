<?php
    $nameErr=$leaderErr=$disErr=$emailErr=$phoneErr='';           //Defining error message values
    $org_name=$leader=$district=$email=$phone_num=$discription='';    //Definig variables and initiate them to empty values
    $coleaders=$members=array();


    if($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['submit_button'])){
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
                $nameErr='Organization name already exists';
                $isOk=0;
            }
            if(!preg_match("/^[a-zA-Z0-9 ]*$/",$org_name)){
                $nameErr='Only letters and white space allowed';
                $isOk=0;
            }
        }
        
        if(empty($_POST['leader'])){
            $leaderErr="Leader name is required";
            $isOk=0;
        }else{
            if($_POST['leader']=='you'){
                $leader=$_SESSION['user_nic'];
            }
            elseif (isset($_POST['leader_nic'])) {
                $leader=filter($_POST['leader_nic']);
                if(!preg_match("/^[a-zA-Z ]*$/",$leader)){
                    $leaderErr='Only letters and white space allowed';
                    $isOk=0;
                }
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
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
                $isOk=0;
            }
        }

        if(empty($_POST['phone_num'])){
            $phoneErr="Phone number is required";
            $isOk=0;
        }else{
            $phone_num=filter($_POST['phone_num']);
            if(!preg_match("/^[0-9]*$/",$phone_num)){
                $phoneErr='Only numbers allowed';
                $isOk=0;
            }
        }

        $discription=filter($_POST['discription']);
        $coleaders=array_filter($_POST['coleaders']);
        $members=array_filter($_POST['members']);
        $str_members=$_POST['hidden'];
        $str_coleaders = $_POST['hidden_coleaders'];

        //code for validating coleader and member detail

        if($isOk==1){
            $query="INSERT INTO organizations (org_name, leader, co_leader, district, email, phone_num, members, discription) VALUES ('$org_name','$leader','$str_coleaders', '$district','$email','$phone_num','$str_members','$discription')";
            //$query_run=$con->query($query);
            $org_id = $con->insert_id;
            
            if($query_run){
                $table_query = 'create table org_'.$org_id." (msg_id int(11) auto_increment primary key, NIC_num varchar(12), sender varchar(60), message text, date date,time time(6))";
                //$org_DB->query($table_query);
                echo $table_query;
                //header('location:/Project/view_org.php?selected_org='.$org_id);
            }else{
                echo '<script type="text/javascript">alert("Error")</script>';
            }
            #header('location:home_page.php');
        }else{
            echo "try again";
        }
    }
    function filter($input){
        return(htmlspecialchars(stripslashes(trim($input))));
    }
?>