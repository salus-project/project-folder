<?php
    if (isset($_POST['update_button'])){
        $password=$_POST['password'];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $gender = $_POST["gender"];
        $district = $_POST["district"];
        $occupation = $_POST["occupation"];
        $address = $_POST["address"];
        $email = $_POST["email"]; 
        $phone_num = $_POST["phone_num"];
        $password = $_POST["password"];

        $query="UPDATE civilian_detail SET email='$email',phone_num='$phone_num',first_name='$first_name',last_name='$last_name',gender='$gender',district='$district',Occupation='$occupation',address='$address',password='$password' where NIC_num='".$_SESSION['user_nic']."'";
        $query_run= mysqli_query($con,$query);

        if($query_run){

            $_SESSION['first_name']=$first_name;
            $_SESSION['last_name']=$last_name;
            $_SESSION['gender']=$gender;
            $_SESSION['district']=$district;
            $_SESSION['Occupation']=$occupation;
            $_SESSION['address']=$address;
            $_SESSION['email']=$email;
            $_SESSION['phone_num']=$phone_num;

            header('location:home_page.php');
        }
        else{
            echo '<script type="text/javascript"> alert ("Data not Uploaded") </script>';

        }
    }
?>