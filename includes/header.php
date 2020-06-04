<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    if(isset($_POST['logout'])){
        echo 'logout';
        session_unset();
        session_destroy();
        
        header('location:'.$_SERVER['DOCUMENT_ROOT'].'/login.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/css_codes/header.css">
        <link rel='stylesheet' type='text/css' href='/css_codes/events.css'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    
                    <form action="header.php" method="post">
                        <input name="logout" type="submit" class="logout_btn" value="logout"/>
                    </form>
                </div>
                
            </div>
            <div>
                <div id="menubar">
                    <a href="home_page.php"> <button type="submit" class="menubar_buttons" id='menu_bar_btn_1'>Home</button> </a>
                    <a href="govermentpost.php"> <button type="submit" class="menubar_buttons" id='menu_bar_btn_2'>Goverment posts</button> </a>
                    <a href="/publicpost"><button class="menubar_buttons" id='menu_bar_btn_3'>Public posts</button></a>
                    <div class='menubar_button_container'><button type="submit" class="menubar_buttons" name='menubar_buttons' id='menu_bar_btn_4' value=4 onclick='showevent(this)'>Events</button><div id=event_container></div></div>
                    <a href=""> <button type="submit" class="menubar_buttons" name='menubar_buttons' id='menu_bar_btn_5' value=5>Notifications</button> </a>
                    <div class='menubar_button_container'><button type="submit" class="menubar_buttons" name='menubar_buttons' id='menu_bar_btn_6' value=6 onclick='show_org(this)'>Organizations</button><div id=menubar_org_container></div></div>
                    <a href="/fundraising"><button class="menubar_buttons" id=menu_bar_btn_7>Fundraisings</button></a>
                    <a href=""> <button type="submit" class="menubar_buttons" id='menu_bar_btn_8'>About</button> </a>
                </div>
            </div>

        <script>
            var header = document.getElementById("menubar").parentElement;
            var body = document.getElementsByTagName('body')[0];
            var sticky = header.offsetTop;
            window.onscroll = function(){
                if (window.pageYOffset > sticky) {
                    header.classList.add("sticky");
                    body.style.paddingTop = header.clientHeight+'px';
                } else {
                    header.classList.remove("sticky");
                    body.style.paddingTop = '0'
                }
            }
            var btn_num;
            function btnPress(btn){
                btn_num =btn;
                var buttons = document.getElementsByClassName('menubar_buttons');
                for(var item of buttons){
                    item.classList.remove('active');
                }
                var button = document.getElementById('menu_bar_btn_'.concat(btn));
                button.classList.toggle('active');
            };
            function showevent(element){
                var buttons = document.getElementsByClassName('menubar_buttons');
                for(var item of buttons){
                    item.classList.remove('active');
                }
                var button = document.getElementById('menu_bar_btn_4');
                button.classList.toggle('active');
                getDoc(document.querySelector('#event_container'),'/event/event_list.php');
            }
            function show_org(element){
                var buttons = document.getElementsByClassName('menubar_buttons');
                for(var item of buttons){
                    item.classList.remove('active');
                }
                var button = document.getElementById('menu_bar_btn_6');
                button.classList.toggle('active');
                getDoc(document.querySelector('#menubar_org_container'),'/organization/org_list.php');
            }
            function getDoc(container,url){
                const request = new XMLHttpRequest();
                request.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        container.innerHTML=request.responseText;
                        //container.style.display='block';
                    }if(this.readyState == 1){
                        container.innerHTML="<div class='loader'></div>";
                        container.style.display='inline-block';
                    }
                }
                request.open('GET',url,true);
                request.send();
            };
            function remove(element){
                element.parentElement.innerHTML='';
                btnPress(btn_num);
            }
        </script>
        

    </body>

</html>