<?php
    $pswErr='';
    if (isset($_POST['update_button'])){
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $gender = $_POST["gender"];
        $district = $_POST["district"];
        $occupation = $_POST["occupation"];
        $address = $_POST["address"];
        $email = $_POST["email"]; 
        $phone_num = $_POST["phone_num"];
        $current_password = $_POST["current_password"];
        $new_password = $_POST["new_password"];

        $query_old="select password from civilian_detail where NIC_num='".$_SESSION['user_nic']."';";
        $data= mysqli_query($con,$query_old);
        if($data->num_rows>0){
            $row=$data->fetch_assoc();
            $password = $row["password"];
        }
        if ($current_password==$password){
            $query="UPDATE civilian_detail SET email='$email',phone_num='$phone_num',first_name='$first_name',last_name='$last_name',gender='$gender',district='$district',Occupation='$occupation',address='$address',password='$new_password' where NIC_num='".$_SESSION['user_nic']."'";
            $query_run= mysqli_query($con,$query);

            if($query_run){
                $_SESSION['first_name']=$first_name;
                $_SESSION['last_name']=$last_name;
                header('location:/home_page.php');
            }
        }
        else{
            $pswErr='Incorrect password';
            echo '<script type="text/javascript"> alert ("Incorrect password") </script>';
        }
    }