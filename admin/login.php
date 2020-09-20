<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    session_start();
?>
<html>
<title>Login page</title>
<link rel="stylesheet" href="css_codes/login.css">
<script src='/js/font_awesome.js' defer></script>
<div class='form_div'>
    <form class="login_form" action="login.php" method="post">
        <div class="login_form_head">
            Admin Login
        </div>
        
        <div class="container">
            <i class="fa fa-user" aria-hidden="true"></i><label >USERNAME </label>
            <input name="emp_id" type="text" class="login_form_input" placeholder="USER NAME" required/>
                
            <i class="fa fa-lock" aria-hidden="true"></i><label >PASSWORD </label>
            <input name="password" type="password" class="login_form_input" placeholder="PASSWORD" required/>     
            <button name="submit" type="submit" class="login_form_submit_btn" value="LOGIN"/>LOGIN</button>
        </div>
    </form>
</div>
<?php
    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        $emp_id=$_POST['emp_id'];
        $password=$_POST['password'];
        $query="select * from admin_detail where emp_id='$emp_id' AND password='$password'";
        $result=$con->query($query);
        if ($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $_SESSION['emp_id']=$row["emp_id"];
                $_SESSION['first_name']=$row["first_name"];
                $_SESSION['last_name']=$row["last_name"];
                $_SESSION['nic_num']=$row["nic_num"];
                $_SESSION['role']="admin";
                
            }
            header('location:/admin');
        }else{
            echo '<script type="text/javascript">';
            echo 'alert("Invalid emp id or password")';
            echo '</script>';
        }
    }
?>
