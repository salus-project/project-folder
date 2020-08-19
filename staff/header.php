<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify_staff.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/staff/css_codes/header.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <div class="titlebar">
            <div class="web_name">
                DCA
            </div>
            <div class="logout">
                <div class ="person_name">
                    <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?>
                </div>
                <div><img src="Profiles/login_img.png" alt="Avatar" class="avatar"></div>
                <div  class="logout_anchor" ><a href="login.php"><i class="fa fa-sign-out" style="font-size:18px;color:white;" aria-hidden="true"> Log out</i></a></div>
            </div>  
        </div>
        <div class="topnav">
            <a href="/staff/homepage.php">HOME</a>
            <a href="/staff/member.php">MEMBER</a>
            <a href="/staff/event">EVENT</a>
            <a href="/staff/post">POST</a>
            <a href="/staff/about.php">ABOUT</a>
            </div>
        <div>
    </body>

</html>