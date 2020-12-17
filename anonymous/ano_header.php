<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $nic_num=$_POST['nic_num'];
        $password=$_POST['password'];
        $query="select * from civilian_detail where NIC_num='$nic_num' ";
        //$query_run = mysqli_query($con,$query);
        $result=$con->query($query);
        if($result->num_rows ==1){
            $row=$result->fetch_assoc();
            if ((md5($password)==$row["password"]) ){
            //if ( True ){
                require_once $_SERVER['DOCUMENT_ROOT']."/common/documents/check_imgs.php";
                //$_SESSION['']=$row[''];
                $_SESSION['user_nic'] = $row["NIC_num"];
                $_SESSION['first_name']=$row["first_name"];
                $_SESSION['last_name']=$row['last_name'];
                $_SESSION['side_nav']=1;
                $_SESSION['role']='civilian';
            
                $self=explode("/",$_POST['location'])[1];
                if($_POST['location']=='http://localhost/logs/login.php' || $_POST['location']=='' || $self=='anonymous'){
                    header("Location:/govpost");
                }else{
                    //header('location:'.str_replace(PHP_EOL, '', $_POST['location']));
                    header('location:'.$_POST['location']);
                }
            }else{
                echo '<script type="text/javascript">';
                echo 'alert("Wromg password")';
                echo '</script>';
            }
        }else{
            echo '<script type="text/javascript">';
            echo 'alert("Invalid NIC num")';
            echo '</script>';
        }
    }

?>
<!DOCTYPE html>
<html>

    <head>
        <link rel="shortcut icon" href="/common/logo.png" type="image/x-icon" /> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        <meta name="description" content="Disaster And Crisis Assistance">
        <meta name="keywords" content="disaster,srilanka,help,emergency,volunteer,flood,strom">
        <meta name="author" content="Salus Team">
        <script src='/common/autocomplete/auto_complete.js'></script>
        <link rel='stylesheet' type='text/css' href='/common/autocomplete/auto.css'>
        <script src='/js/font_awesome.js' defer></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <link rel="stylesheet" href="/css_codes/ano_header.css">
    </head>

    <body>
        <div id="wrapper_container">
            <div class="wrapper">
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="shadow"></div>
                <div class="shadow"></div>
                <div class="shadow"></div>
                <span>Loading</span>
            </div>
        </div>
        <div id="titlebar">
            <span id="dcaname">Disaster and Crisis Assistance</span>
        </div>

        <div>
            <div class="logo_box">
                <div class="logo"><img src="/common/logo.png" alt="logo" class="logo"></div>
            </div>
            <div id="menubar">
                <div class="please_login">
                    
                </div>
                <div class="font_aws" >
                   
                    <a href="/govpost" class="menubar_buttons_cont"> <div type="submit" class="menubar_buttons"><div class="menu_icon_tooltip"><i class='fas fa-university menu_icon menu_bar_btn_2'></i><span class="menu_icon_tooltiptext">Goverment post</span></div></div> </a>
                    <div class='menubar_button_container menubar_buttons_cont'><div class="menubar_buttons" onclick='showevent(this)'><div class="menu_icon_tooltip"><i class='far fa-calendar-alt menu_icon menu_bar_btn_4'></i><span class="menu_icon_tooltiptext">Events</span></div></div><div id=event_container></div></div>
                    <div class='menubar_button_container menubar_buttons_cont'><div type="submit" class="menubar_buttons" name='menubar_buttons'  value=6 onclick='show_org(this)'><div class="menu_icon_tooltip"><i class='fas fa-users menu_icon menu_bar_btn_6'></i><span class="menu_icon_tooltiptext">Organization</span></div></div><div id=menubar_org_container></div></div>
                </div>
                <button class='ano_login_button' onclick="document.getElementById('id01').style.display='block'">Login</button> 
            </div>
        </div>

        <div id="id01" class="modal"> 
            <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"> 
                <div class="imgcontainer"> 
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">×</span> 
                    <!-- <img src= 
            "https://media.geeksforgeeks.org/wp-content/cdn-uploads/20190710102234/download3.png" alt="Avatar" class="avatar">  -->
                </div> 

                <div class="pop_container"> 
                    <label><b>Username</b></label> 
                    <input type="text" class="login_username" placeholder="Enter Username" name="nic_num" required> 

                    <label><b>Password</b></label> 
                    <input type="password" class="login_password" placeholder="Enter Password" name="password" required> 

                    <button class="popup_btn" type="submit">Login</button> 
                </div> 

                <div class="pop_container"> 
                    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn popup_btn">Cancel</button> 
                    <span class="psw"><a href="/anonymous/forgot_password/forgot_password.php">Forgot password?</a></span> 
                </div> 
            </form> 
        </div> 
        <?php
            if( isset($_GET['location'])){
                echo "<script>document.getElementById('id01').style.display='block'</script>";
            }
        ?>

        <script src="/js/ano_header.js"></script>
        <script>
            var modal = document.getElementById('id01'); 
            window.onclick = function(event) { 
                if (event.target == modal) { 
                    modal.style.display = "none"; 
                } 
            }
            window.addEventListener('load',function(){
                document.getElementById('wrapper_container').outerHTML='';
            },false);
        </script>
        <div id='main_body'>
            <div id='sub_body' class='sub_body'>
