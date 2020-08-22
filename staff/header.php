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
                <div><img src="/staff/Profiles/login_img.png" alt="Avatar" class="avatar"></div>
                <div  class="logout_anchor" ><a href="login.php"><i class="fa fa-sign-out" style="font-size:18px;color:white;" aria-hidden="true"> Log out</i></a></div>
            </div>  
        </div>
        <div class="topnav">
            <a class='menu_bar_btn menu_bar_btn_1'  href="/staff/">HOME</a>
            <a class='menu_bar_btn menu_bar_btn_2'  href="/staff/member.php">MEMBER</a>
            <a class='menu_bar_btn menu_bar_btn_3'  href="/staff/event">EVENT</a>
            <a class='menu_bar_btn menu_bar_btn_4'  href="/staff/post">POST</a>
            <a class='menu_bar_btn menu_bar_btn_5'  href="/staff/about.php">ABOUT</a>
        </div>
    </body>

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
</html>