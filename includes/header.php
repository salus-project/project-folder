<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/css_codes/header.css">
        <link rel='stylesheet' type='text/css' href='/css_codes/events.css'>
        <link rel='stylesheet' type='text/css' href='/css_codes/side_nav.css'>
        <link rel="shortcut icon" href="/common/logo.jpg" type="image/x-icon" /> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        <meta name="description" content="Free Web tutorials">
        <meta name="keywords" content="HTML,CSS,XML,JavaScript">
        <meta name="author" content="John Doe">
        <script src='/js/font_awesome.js' defer></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>

    <body>
            <div id="titlebar">
                <div class="logo_box">
                    <div class="logo"><img src="/common/logo.jpg" alt="logo" class="logo"></div>
                </div>
                <div class="username">
                    <label>
                        <?php 
                        echo  $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
                        
                        ?>
                    </label>
                </div>
                <div class="logout">
                    
                    <form action="/logs/logout.php" method="post">
                        <input name="logout" type="submit" class="logout_btn" value="logout"/>
                    </form>
                </div>
                
            </div>
            <div>
                <div id="menubar">
                    <!-- <a href="/home_page.php"> <div class="menubar_buttons" id='menu_bar_btn_1'>Home</div> </a> -->
                    <a href="/govermentpost.php" class="menubar_buttons_cont"> <div type="submit" class="menubar_buttons"><div class="menu_icon_tooltip"><i class='fas fa-university menu_icon menu_bar_btn_2'></i><span class="menu_icon_tooltiptext">Goverment post</span></div></div> </a>
                    <a href="/publicpost" class="menubar_buttons_cont"><div class="menubar_buttons" ><div class="menu_icon_tooltip"><i class='fas fa-book-reader menu_icon menu_bar_btn_3'></i><span class="menu_icon_tooltiptext">Public post</span></div></div></a>
                    <div class='menubar_button_container menubar_buttons_cont'><div class="menubar_buttons" onclick='showevent(this)'><div class="menu_icon_tooltip"><i class='far fa-calendar-alt menu_icon menu_bar_btn_4'></i><span class="menu_icon_tooltiptext">Events</span></div></div><div id=event_container></div></div>
                    <div class='menubar_button_container menubar_buttons_cont'><div type="submit" class="menubar_buttons" name='menubar_buttons'  value=6 onclick='show_org(this)'><div class="menu_icon_tooltip"><i class='fas fa-users menu_icon menu_bar_btn_6'></i><span class="menu_icon_tooltiptext">Organization</span></div></div><div id=menubar_org_container></div></div>
                    <a href="/fundraising" class="menubar_buttons_cont"><div class="menubar_buttons" ><div class="menu_icon_tooltip"><i class='fas fa-hand-holding-heart menu_icon menu_bar_btn_7'></i><span class="menu_icon_tooltiptext">Fundraising</span></div></div></a>
                    <a href="/chat.php" class="menubar_buttons_cont"> <div type="submit" class="menubar_buttons" ><div class="menu_icon_tooltip"><i class='fas fa-comments menu_icon menu_bar_btn_8'></i><span class="menu_icon_tooltiptext">Chat</span></div></div> </a>
                    <div class='menubar_button_container menubar_buttons_cont' ><div class="menubar_buttons"  onclick="show_notification(this)"><div class="menu_icon_tooltip"><i class='fas fa-bell menu_icon menu_bar_btn_5'></i><span class="menu_icon_tooltiptext">Notification</span></div></div><div id=notification_container></div></div>
                    <div class='menubar_button_container dropdown_cont'><div  class="menubar_buttons dropdown_btn" onclick='show_dropdown(this)'><div class="menu_icon_tooltip">
                        <i class="fa fa-caret-down" style="font-size:30px"></i>
                    <span class="menu_icon_tooltiptext">More</span></div></div>
                    <div id=dropdown_container class='dropdown_container'> 
                        <a class="header_drop_down" href='Apple'>Apple</a>
                        <a class="header_drop_down" href="Banana">Orane</a>
                        <a class="header_drop_down" href='Orange'>Banana</a>
                    </div></div>
                    <!-- <a href=""> <button type="submit" class="menubar_buttons" id='menu_bar_btn_8'>About</button> </a> -->
                </div>
            </div>

        <script src="/js/header.js"></script>
        <div id='main_body'>
	        <div id='sub_body'>