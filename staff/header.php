<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify_staff.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/staff/css_codes/header.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="shortcut icon" href="/common/logo.png" type="image/x-icon" /> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        <meta name="description" content="Disaster And Crisis Assistance">
        <meta name="keywords" content="disaster,srilanka,help,emergency,volunteer,flood,strom">
        <meta name="author" content="Salus Team">
        <script src='/js/font_awesome.js' defer></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src='/common/autocomplete/auto_complete.js'></script>
        <link rel='stylesheet' type='text/css' href='/common/autocomplete/auto.css'>
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
                <div><img src="/staff/Profiles/login_img.jpg" alt="Avatar" class="avatar"></div>
                <div  class="logout_anchor" >
                <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"> 
                    <button class="logbtn" name="logout" value=1><i class="fa fa-sign-out" style="font-size:18px;color:white;" aria-hidden="true"> Log out</i></button>
                </form>
            </div>
            </div>  
        </div>
        <div class="topnav">
            <a class='menu_bar_btn menu_bar_btn_1'  href="/staff/">HOME</a>
            <a class='menu_bar_btn menu_bar_btn_2'  href="/staff/member.php">MEMBER</a>
            <a class='menu_bar_btn menu_bar_btn_3'  href="/staff/event">EVENT</a>
            <a class='menu_bar_btn menu_bar_btn_4'  href="/staff/post">POST</a>
        </div>
        <div class='main_body'>
            <div class='sub_body'>
        <?php
            if(isset($_POST['logout'])){ 
                session_unset();
                session_destroy();
                header('location:/staff/login.php');
            }
        ?>
<script>
    var btn_num;

    function btnPress(btn) {
        btn_num = btn;
        var tdd = document.getElementsByClassName('menu_bar_btn');
        for (var item of tdd) {
            item.classList.remove('active');
        }
        document.getElementsByClassName('menu_bar_btn_'.concat(btn))[0].classList.add('active');
    }
</script>
