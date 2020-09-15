<?php
if (isset($_POST['submit'])){
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $gender = $_POST["gender"];
    $nic = rtrim($_POST["nic"]);
    $address = $_POST["address"]; 
    $district = $_POST["district"];
    $village = $_POST["village"]; 
    $street = $_POST["street"]; 
    $occupation = $_POST["occupation"];
    $phone_number = $_POST["phone_number"];
    $email_address = $_POST["email_address"];

    $nic_check='SELECT NIC_num FROM `civilian_detail` WHERE NIC_num="'.$nic.'"';
    $result_=$con->query($nic_check);
    if (mysqli_num_rows($result_) > 0){
        echo '<script type="text/javascript"> alert ("This NIC number already have an account") </script>';
    }else{
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

            $sql = "INSERT INTO civilian_detail (password, first_name, last_name, gender, NIC_num, address, district,village,street, Occupation, phone_num, email)
            VALUES ('$password', '$first_name', '$last_name', '$gender', '$nic', '$address', '$district', '$village','$street','$occupation', '$phone_number', '$email_address')";
            $query_run= mysqli_query($con,$sql);

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
                $message = 'Your DCA account was just created successfully and your password is '.$password.', change your password by log-in to your DCA account.';
                $headers = 'From: kanthankanthan111@gmail.com';
                set_error_handler(function() { /* ignore errors */ });
                    if(mail($to_email,$subject,$message,$headers)){
                    }
                restore_error_handler();

                echo '<script type="text/javascript"> alert ("Data Uploaded") </script>';
                header('location:member.php');
            }else{
                echo '<script type="text/javascript"> alert ("Data not Uploaded") </script>';
            }
        }else{
            echo '<script type="text/javascript"> alert ("Enter email") </script>';
        }
    }
}
?>

