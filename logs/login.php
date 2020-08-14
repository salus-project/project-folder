<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        
        $nic_num=$_POST['nic_num'];
        $password=$_POST['password'];
        $query="select * from civilian_detail where NIC_num='$nic_num' AND password='$password'";
        //$query_run = mysqli_query($con,$query);
        $result=$con->query($query);
        if($result->num_rows>0){
            
            while($row=$result->fetch_assoc()){
                //$_SESSION['']=$row[''];
                $_SESSION['user_nic'] = $row["NIC_num"];
                $_SESSION['first_name']=$row["first_name"];
                $_SESSION['last_name']=$row['last_name'];
                $_SESSION['side_nav']=1;
            }

            if($_POST['location']=='http://localhost/logs/login.php' || $_POST['location']==''){
                header("Location:/govpost");
            }else{
                //header('location:'.str_replace(PHP_EOL, '', $_POST['location']));
                header('location:'.$_POST['location']);
            }
            

        }else{
            echo '<script type="text/javascript">';
            echo 'alert("Invalid NIC num or password")';
            echo '</script>';
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login page</title>
        <link rel="stylesheet" href="/css_codes/style.css">
    </head>

    <body style="background-color: #dedede">
        <div style="height:100px">
        </div>
        <div class="div1">
            <center>
            <h2 class="h2_tag">Login Here</h2>

            </center>

            <form class="form_box" action="/logs/login.php" method="post">
                <label class="label">NIC number </label><br>
                <input name = "nic_num" type="text" class="input_box" placeholder="Enter your NIC number" required/><br>
                <label class="label">Password </label><br>
                <input name="password" type="password" class="input_box" placeholder="Enter your password" required/><br>
                <input name="login_button" type="submit" class="login_button" value="Login"/><br>
                <a href="https://www.google.com">Don't have an account yet</a>
                <input type='hidden' name='location' value='<?php echo isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:''; ?>'>
            </form>
        </div>
    </body>
</html>
