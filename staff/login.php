<?php
    session_start();
    require 'dbconfi/confi.php'
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login page</title>
        <link rel="stylesheet" href="css_codes/login.css">
    </head>
    <body>
    <form class="login_form" action="login.php" method="post">
        <div class="login_form_head">
            Login Here
        </div>
        <div class="imgcontainer">
            <img src="Profiles/login_img.png" alt="Avatar" class="avatar">
        </div>
        <div class="container">
            <label >USERNAME </label>
            <input name = "username" type="text" class="login_form_input" placeholder="USER NAME" required/>
                
            <label >PASSWORD </label>
            <input name="password" type="password" class="login_form_input" placeholder="PASSWORD" required/>     
            <button name="login" type="submit" class="login_form_submit_btn" value="LOGIN"/>LOGIN</button>
        </div>
    </form>

            <?php
                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    
                    $username=$_POST['username'];
                    $password=$_POST['password'];
                    $query="select * from officer_detail where user_name='$username' AND password='$password'";
                
                    $result=$con->query($query);
                    if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){
                            //$_SESSION['']=$row[''];
                            $_SESSION['username'] = $row["user_name"];
                            $_SESSION['user_nic'] = $row["NIC_num"];
                            $_SESSION['first_name']=$row["first_name"];
                            $_SESSION['last_name']=$row['last_name'];
                            $_SESSION['gender']=$row['gender'];
                            $_SESSION['district']=$row['district'];
                            $_SESSION['address']=$row['address'];
                        }
                            header('location:homepage.php');
                        
                    }else{
                        echo '<script type="text/javascript">';
                        echo 'alert("Invalid Username or password")';
                        echo '</script>';
                    }
                }
            ?>  
        </div>
    </body>
</html>