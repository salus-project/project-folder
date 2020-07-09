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
                    <a href="/home_page.php"> <button type="submit" class="menubar_buttons" id='menu_bar_btn_1'>Home</button> </a>
                    <a href="/govermentpost.php"> <button type="submit" class="menubar_buttons" id='menu_bar_btn_2'>Goverment posts</button> </a>
                    <a href="/publicpost"><button class="menubar_buttons" id='menu_bar_btn_3'>Public posts</button></a>
                    <div class='menubar_button_container'><button class="menubar_buttons" id='menu_bar_btn_4' onclick='showevent(this)'>Events</button><div id=event_container></div></div>
                    <div class='menubar_button_container'><button class="menubar_buttons" id='menu_bar_btn_5' onclick="show_notification(this)">Notifications</button><div id=notification_container></div></div>
                    <div class='menubar_button_container'><button type="submit" class="menubar_buttons" name='menubar_buttons' id='menu_bar_btn_6' value=6 onclick='show_org(this)'>Organizations</button><div id=menubar_org_container></div></div>
                    <a href="/fundraising"><button class="menubar_buttons" id=menu_bar_btn_7>Fundraisings</button></a>
                    <a href=""> <button type="submit" class="menubar_buttons" id='menu_bar_btn_8'>About</button> </a>
                </div>
            </div>

        <script src="/js/header.js"></script>
        <div id='main_body'>
	        <div id='sub_body'>