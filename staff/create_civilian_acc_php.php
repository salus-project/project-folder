<?php

if (isset($_POST['nic'])){
    
    $isOk=1;
    $nic = strtoupper(filt_inp($_POST["nic"]));
    if (!preg_match("/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/",$nic)){
        $isOk=0;
        $nic_err="Invalid NIC number";
    }

    $first_name = ucfirst(filt_inp($_POST["first_name"]));
    if(!preg_match("/^[a-zA-Z]*$/", $first_name)){
        $isOk=0;
        $first_name_err="Characters only";
    }

    $last_name = ucfirst(filt_inp($_POST["last_name"]));
    if(!preg_match("/^[a-zA-Z]*$/", $last_name)){
        $isOk=0;
        $last_name_err="Characters only";
    }

    $email_address = filt_inp($_POST["email_address"]);
    if (!filter_var($email_address, FILTER_VALIDATE_EMAIL) && $email_address!='') {
        $email_address_err = "Invalid email format";
        $isOk=0;
    }

    $gender = filt_inp($_POST["gender"]); 
    $address = filt_inp($_POST["address"]);
    $district = filt_inp($_POST["district"]);
    $village = filt_inp($_POST["village"]);
    $street = filt_inp($_POST["street"]);
    $occupation = filt_inp($_POST["occupation"]);
    $phone_number = filt_inp($_POST["phone_number"]);

    if(!preg_match("/^[0-9]{10}$/",$phone_number) and $_POST["phone_number"]!=''){
        $phone_number_err='Only 10 numbers allowed';
        $isOk=0;
    }

    $nic_check='SELECT NIC_num FROM `civilian_detail` WHERE NIC_num="'.$nic.'"';
    $result_=$con->query($nic_check);
    if (mysqli_num_rows($result_) > 0){
        echo '<script type="text/javascript"> alert ("This NIC number already have an account") </script>';
        $isOk=0;
    }
    if ($email_address != ""){
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        function generate_string($input, $strength = 10) {
            $input_length = strlen($input);
            $random_string = '';
            for($i = 0; $i < $strength; $i++) {
                $random_character = $input[mt_rand(0, $input_length - 1)];
                $random_string .= $random_character;
            }
            return $random_string;
        }

        $password= generate_string($permitted_chars) ;

    }else{
        echo '<script type="text/javascript"> alert ("Enter email") </script>';
    }

    if($isOk==1){
        $gender = ($_POST["gender"]!='')?"'".filt_inp($_POST["gender"])."'":"NULL"; 
        $address = ($_POST["address"]!='')?"'".filt_inp($_POST["address"])."'":"NULL";
        $district = ($_POST["district"]!='')?"'".filt_inp($_POST["district"])."'":"NULL";
        $village = ($_POST["village"]!='')?"'".filt_inp($_POST["village"])."'":"NULL";
        $street = ($_POST["street"]!='')?"'".filt_inp($_POST["street"])."'":"NULL";
        $occupation = ($_POST["occupation"]!='')?"'".filt_inp($_POST["occupation"])."'":"NULL";
        $phone_number = ($_POST["phone_number"]!='')?"'".filt_inp($_POST["phone_number"])."'":"NULL";

        $hash_passwd= md5($password);
        
        $sql = "INSERT INTO civilian_detail (password, first_name, last_name, gender, NIC_num, address, district,village,street, Occupation, phone_num, email)
        VALUES ('$hash_passwd', '$first_name', '$last_name', $gender, '$nic', $address, $district, $village,$street,$occupation, $phone_number, '$email_address')";
        $query_run= mysqli_query($con,$sql);

        echo $sql;

        if($query_run ){
            
            $query="ALTER TABLE disaster_events ADD COLUMN `user_".$nic."` varchar(50) NOT NULL DEFAULT 'not_set not_requested not_applied'";
            $query_run= mysqli_query($con,$query);

            $query1="";
            $query1.= "create table `user_notif_ic_".$nic."` (Notification_id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY not null,Date date, Time time,Content text, link varchar(100), status varchar(10) default 'unseen');"; 
            $query1.="create table `user_message_".$nic."` (id int(5) AUTO_INCREMENT primary key, _from varchar(12) default null, _to varchar(12) default null, time datetime, content text, status tinyint(1) default 0);";
            $notification_DB = NotificationDb::getConnection();
            $query1_run= mysqli_multi_query($notification_DB,$query1);

            $to_email = $email_address ;
            $subject = 'Your DCA account was created successfully';
            $message = 'Your DCA account was just created successfully and your password is '.$password.', change your password by log-in to http://d-c-a.000webhostapp.com/';
            $headers = 'From: dca@gmail.com';
            set_error_handler(function() { /* ignore errors */ });
                if(mail($to_email,$subject,$message,$headers)){
                    
                }
            restore_error_handler();

            copy($_SERVER['DOCUMENT_ROOT'] . '/common/documents/Profiles/default.jpg', $_SERVER['DOCUMENT_ROOT'] . '/common/documents/Profiles/'.$nic.'.jpg');
            copy($_SERVER['DOCUMENT_ROOT'] . '/common/documents/Profiles/resized/default.jpg', $_SERVER['DOCUMENT_ROOT'] . '/common/documents/Profiles/resized/'.$nic.'.jpg');
            copy($_SERVER['DOCUMENT_ROOT'] . '/common/documents/Covers/default.jpg', $_SERVER['DOCUMENT_ROOT'] . '/common/documents/Covers/'.$nic.'.jpg');

            header('location:member.php');
        }else{
            echo '<script type="text/javascript"> alert ("Data not Uploaded") </script>';
        }
        
    }else{
        echo '<script type="text/javascript"> alert ("Please fill form correctly") </script>';
    }
}
?>