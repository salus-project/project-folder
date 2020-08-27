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
                $_SESSION['role']='civilian';
            }
            $self=explode("/",$_POST['location'])[1];
            if($_POST['location']=='http://localhost/logs/login.php' || $_POST['location']=='' || $self=='anonymous'){
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
        
        <link rel="shortcut icon" href="/common/logo.jpg" type="image/x-icon" /> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        <meta name="description" content="Free Web tutorials">
        <meta name="keywords" content="HTML,CSS,XML,JavaScript">
        <meta name="author" content="John Doe">
        <script src='/js/font_awesome.js' defer></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <link rel="stylesheet" href="/css_codes/ano_header.css">
    </head>

    <body>
            <div id="titlebar">
                <div class="logo_box">
                    <div class="logo"><img src="/common/logo.jpg" alt="logo" class="logo"></div>
                </div>
            </div>

        <div>
            <div id="menubar">
                <div class="please_login">
                    <?php
                    if( isset($_GET['location'])){
                        echo 'Please log in';
                    }
                    ?>
                </div>
                <div class="font_aws" >
                   
                    <a href="/govpost" class="menubar_buttons_cont"> <div type="submit" class="menubar_buttons"><div class="menu_icon_tooltip"><i class='fas fa-university menu_icon menu_bar_btn_2'></i><span class="menu_icon_tooltiptext">Goverment post</span></div></div> </a>
                    <div class='menubar_button_container menubar_buttons_cont'><div class="menubar_buttons" onclick='showevent(this)'><div class="menu_icon_tooltip"><i class='far fa-calendar-alt menu_icon menu_bar_btn_4'></i><span class="menu_icon_tooltiptext">Events</span></div></div><div id=event_container></div></div>
                    <div class='menubar_button_container menubar_buttons_cont'><div type="submit" class="menubar_buttons" name='menubar_buttons'  value=6 onclick='show_org(this)'><div class="menu_icon_tooltip"><i class='fas fa-users menu_icon menu_bar_btn_6'></i><span class="menu_icon_tooltiptext">Organization</span></div></div><div id=menubar_org_container></div></div>
                </div>
                <div class="log_in">
                    <form class="ano_form_box" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <div class="enter_nic">
                            <input name = "nic_num" type="text" class="ano_input_box" placeholder="Enter your NIC number" required/>
                        </div>
                        <div class="enter_password">
                        <input name="password" type="password" class="ano_input_box" placeholder="Enter your password" required/> 
                        </div>
                        <input name="ano_login_button" type="submit" class="ano_login_button" value="Login"/>
                        <!-- <a href="https://www.google.com">Don't have an account yet</a> -->
                        <input type='hidden' name='location' value='<?php echo isset($_GET["location"])?$_GET["location"]:''; ?>'>
                    </form>
                </div>
            </div>
        </div>

        <script src="/js/ano_header.js"></script>
        <script>
            
        </script>
        <div id='main_body'>
            <div id='sub_body' class='sub_body'>