<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
?>

<title>Login page</title>
<link rel="stylesheet" href="css_codes/login.css">
<script src='/js/font_awesome.js' defer></script>
<div class='form_div'>
    <form class="login_form" action="/staff/login.php" method="post">
        <div class="login_form_head">
            Staff Login
        </div>
        
        <div class="container">
            <i class="fa fa-user" aria-hidden="true"></i><label >USERNAME </label>
            <input name = "username" type="text" class="login_form_input" placeholder="USER NAME" required/>
                
            <i class="fa fa-lock" aria-hidden="true"></i><label >PASSWORD </label>
            <input name="password" type="password" class="login_form_input" placeholder="PASSWORD" required/>     
            <button name="login" type="submit" class="login_form_submit_btn" value="LOGIN"/>LOGIN</button>
        </div>
    </form>
</div>

<?php
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username=$_POST['username'];
        $password=$_POST['password'];
        $query="select * from staff_detail where user_name='$username' AND password='$password'";
    
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
                $_SESSION['role']='staff';
            }
                header('location:/staff');
            
        }else{
            echo '<script type="text/javascript">';
            echo 'alert("Invalid Username or password")';
            echo '</script>';
        }
    }
?>  
