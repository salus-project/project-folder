<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify_admin.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Home Page</title>
        <link rel="stylesheet" href="css_codes/header.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div class="titlebar">
            <div class="web_name">
                DCA admin
            </div>
            <div class="logout">
                <div class ="person_name">
                    <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?>
                </div>
                <div  class="logout_anchor" >
                <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"> 
                <button class="log_btn" name='logout' value=1 ><i class="fa fa-sign-out" style="font-size:18px;color:white;" aria-hidden="true"> Log out</i></button>
                </form>
            </div>
            </div>  
        </div>
        <div class="topnav">
            <a class='menu_bar_btn menu_bar_btn_1'  href="index.php">HOME</a>
            <a class='menu_bar_btn menu_bar_btn_2'  href="staff.php">STAFF</a>
        </div>
        <?php
            if(isset($_POST['logout'])){ 
                session_unset();
                session_destroy();
                header('location:/admin/login.php');
            }
        ?>
    <div id='main_body'>
        <div id='sub_body' class='sub_body'> 

