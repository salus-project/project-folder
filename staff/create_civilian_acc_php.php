
<?php
if (isset($_POST['submit'])){
    $password = $_POST["password"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $gender = $_POST["gender"];
    $nic = $_POST["nic"];
    $address = $_POST["address"]; 
    $district = $_POST["district"];
    $village = $_POST["village"]; 
    $street = $_POST["street"]; 
    $occupation = $_POST["occupation"];
    $phone_number = $_POST["phone_number"];
    $email_address = $_POST["email_address"];

    $sql = "INSERT INTO civilian_detail (password, first_name, last_name, gender, NIC_num, address, district,village,street, Occupation, phone_num, email)
    VALUES ('$password', '$first_name', '$last_name', '$gender', '$nic', '$address', '$district', '$village','$street','$occupation', '$phone_number', '$email_address')";
    $query_run= mysqli_query($con,$sql);

    if($query_run ){
        
        $query="ALTER TABLE disaster_events ADD COLUMN `user_".$nic."` varchar(50) NOT NULL DEFAULT 'not_set not_requested not_applied'";
        $query_run= mysqli_query($con,$query);

        $query1 = "CREATE TABLE `user_".$nic."` (Notification_id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,Date date, Time time,Content text)"; 
        $query1_run= mysqli_query($notification_DB,$query1);

        echo '<script type="text/javascript"> alert ("Data Uploaded") </script>';
        header('location:member.php');
    }else{
        echo '<script type="text/javascript"> alert ("Data not Uploaded") </script>';

    }
}
?>