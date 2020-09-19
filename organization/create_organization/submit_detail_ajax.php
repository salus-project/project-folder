<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    session_start();
    $err=array();           //Defining error message values
    $output=array();
    $org_name=$leader=$district=$email=$phone_num=$description='';    //Definig variables and initiate them to empty values

    if($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['submit_button'])){
        $isOk=1;
        if(empty($_POST['org_name'])){
            $err['org_name']="Organization name is required";
            $isOk=0;
        }else{
            $org_name=filt_inp($_POST['org_name']);            
            $validate_name_query="select * from organizations where org_name='$org_name'";
            $query_run=mysqli_query($con,$validate_name_query);
            if(mysqli_num_rows($query_run)>0){
                $err['org_name']='Organization name already exists';
                $isOk=0;
            }
            if(!preg_match("/^[a-zA-Z0-9 ]*$/",$org_name)){
                $err['org_name']='Only letters and white space allowed';
                $isOk=0;
            } 
        }
        
          
        $district=filt_inp($_POST['district']);        

        $email=filt_inp($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) && $email!='') {
            $err['email'] = "Invalid email format";
            $isOk=0;
        }
        $email = $email==''?'NULL':$email;
 
        
        $phone_num=filt_inp($_POST['phone_num']);
        if(!preg_match("/^[0-9]*$/",$phone_num)){
            $err['phone_num']='Only numbers allowed';
            $isOk=0;
        }
        $phone_num = $phone_num==''?'NULL':(int)$phone_num;

        $description=filt_inp($_POST['description']);
        if(empty($_POST['leader'])){
            $err['leader']="Leader name is required";
            $isOk=0;
        }else{
            if($_POST['leader']=='you'){
                $leader=$_SESSION['user_nic'];
            }
            elseif (isset($_POST['leader_nic'])) {
                $leader=filt_inp($_POST['leader_nic']);
                if(!preg_match("/^[a-zA-Z ]*$/",$leader)){
                    $err['leader']='Invalid leader detail';
                    $isOk=0;
                }
            }else{
                $err['leader']='Please provide the leader detail';
            }
        }
        $output=array();
        if($isOk==1){ 
            $query1_run=false; $query2_run=false;
            $query1="INSERT INTO organizations (org_name, district, email, phone_num, discription) VALUES ('$org_name', '$district','$email',$phone_num,'$description');";
            $query1_run=$con->query($query1);
            $org_id = $con->insert_id;
            $output['org_id']=$org_id;

            $query2="INSERT INTO org_members (org_id, NIC_num, role) VALUES ('$org_id', '$leader', 'leader')";

            $query2_run=$con->query($query2);
            
            if($query1_run && $query2_run){
                $output['status']='ok';
                $table_query = 'create table org_'.$org_id." (msg_id int(11) auto_increment primary key, NIC_num varchar(12), sender varchar(60), message text, date date,time time(6))";
                $Orgcon = OrgDb::getConnection();
                $Orgcon->query($table_query);

                /*$nic=$_SESSION['user_nic'];    
                $members= \array_diff($members,[$nic]);
                $coleaders= \array_diff($coleaders,[$nic]);

                $name= $_SESSION['first_name']." ".$_SESSION['last_name'];
                $mssg=$name." added you to the organization ".$org_name." as ";
                $link="/organization/?selected_org=".$org_id;
                
                require $_SERVER['DOCUMENT_ROOT']."/notification/notification_sender.php";
                if($leader !=$nic){
                    $sender = new Notification_sender($leader,$mssg."leader",$link,true);
                    $sender->send();
                }
                $sender = new Notification_sender(implode(",",$coleaders),$mssg."co-leader",$link,true);
                $sender->send();
                $sender = new Notification_sender(implode(",",$members),$mssg."member",$link,true);
                $sender->send();*/

            }else{
                $output['status']='failed';
                $output['errors']=$err;
            }
        }else{
            $output['status']='invalid';
            $err['query']='not_submited';
            $output['errors']=$err;
        }
        echo json_encode($output);
        // $output=["status"=>"ok", "org_id"=>"500"];
        // echo json_encode($output);

    }else if($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['add_coleaders'])){
        $output=["status"=>"ok"];
        echo json_encode($output);

    }else if($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['add_members'])){
        $output=["status"=>"ok"];
        echo json_encode($output);

    }else if($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['add_profile'])){
        if(isset($_FILES['upload_file']) && $_FILES['upload_file']['size']>0){
            $org_id=$_POST['org_id'];
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "\common\documents\Organization\Profiles\\";
            $target_file = $target_dir . $org_id . ".jpg";
            $full_file_name = $org_id . ".jpg";
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            
            $check = getimagesize($_FILES["upload_file"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $err['file_type']="File is not an image.";
                $uploadOk = 0;
            }
            
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                $err['file_format'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $output['status']='error';
                $output['error']=$err;
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
                    require_once $_SERVER['DOCUMENT_ROOT'] .'/common/documents/resize.php';
                    $resize = new ResizeImage($target_file);
                    $resize->resizeTo(50, 50, 'exact');
                    $resize->saveImage($target_dir."resized/".$full_file_name);
                    $output['status']='ok';
                } else {
                    $output['status']='error';
                }
            }
        }
        echo json_encode($output);
    }else if($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['add_cover'])){
        if(isset($_FILES['upload_file']) && $_FILES['upload_file']['size']>0){
            $org_id=$_POST['org_id'];
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "\common\documents\Organization\Covers\\";
            $target_file = $target_dir . $org_id . ".jpg";
            $full_file_name = $org_id . ".jpg";
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            
            $check = getimagesize($_FILES["upload_file"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $err['file_type']="File is not an image.";
                $uploadOk = 0;
            }
            
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                $err['file_format'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $output['status']='error';
                $output['error']=$err;
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
                    $output['status']='ok';
                } else {
                    $output['status']='error';
                }
            }
        }
        echo json_encode($output);
    }
    
?> 