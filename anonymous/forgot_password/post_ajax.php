<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";

    $nic=$_POST['nic'];
    $sql="SELECT email from civilian_detail where NIC_num='$nic'";
    $result_=$con->query($sql);
    if (mysqli_num_rows($result_)>0){
        $result=$result_->fetch_row();
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
        $sql="UPDATE civilian_detail set password='$password' where NIC_num='$nic'";
        $con->query($sql);

        $to_email = $result[0];
        $subject = 'DCA account recovery';
        $message = 'Your account password reset to '.$password;
        $headers = 'From: kanthankanthan111@gmail.com';
        set_error_handler(function() { /* ignore errors */ });
            if(mail($to_email,$subject,$message,$headers)){
            }
        restore_error_handler();
        echo "mail sent";
    }else{
        echo "error";
    }
?>