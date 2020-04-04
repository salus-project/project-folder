<!DOCTYPE html>
<html>
    <head>
        <title>Home Page</title>
        <link rel="stylesheet" href="css_codes/header.css">

    </head>

    <body>
        
        <div class="titlebar">
            <div class="logo_box">
                <div class="logo"><img src="logo.jpg" alt="logo" class="logo"></div>
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
        <div class="menubar">
            <a href="home_page.php"> <button type="submit" class="menubar_buttons" name='menubar_buttons' id='menu_bar_btn_1' value=1>Home</button> </a>
            <a href="govermentpost.php"> <button type="submit" class="menubar_buttons" name='menubar_buttons' id='menu_bar_btn_2' value=2>Goverment posts</button> </a>
            <a href="publicpost.php"><button type="submit" class="menubar_buttons" name='menubar_buttons' id='menu_bar_btn_3' value=3>Public posts</button></a>
            <a href='events.php'><button type="submit" class="menubar_buttons" name='menubar_buttons' id='menu_bar_btn_4' value=4>Events</button></a>
            <a href=""> <button type="submit" class="menubar_buttons" name='menubar_buttons' id='menu_bar_btn_5' value=5>Notifications</button> </a>
            <a href="organizations.php"><button type="submit" class="menubar_buttons" name='menubar_buttons' id='menu_bar_btn_6' value=6>Organizations</button></a>
            <a href=""> <button type="submit" class="menubar_buttons" name='menubar_buttons' id='menu_bar_btn_7' value=7>About</button> </a>
        </div>

        <script>
            function btnPress(btn){
                var button = document.getElementById('menu_bar_btn_'.concat(btn));
                button.style.backgroundColor = 'white';
                button.style.color = 'rgb(15, 73, 160)';
                button.style.border = '2px solid rgb(16, 134, 163)';
            }
        </script>
        
        <?php
            if(isset($_POST['logout'])){
                echo 'logout';
                session_unset();
                session_destroy();
                
                header('location:login.php');
            }
        ?>
        <div>

    </body>

</html>