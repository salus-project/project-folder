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
            <a href="home_page.php"> <button type="button" class="menubar_buttons">Home</button> </a>
            <a href="govermentpost.php"> <button type="button" class="menubar_buttons">Goverment posts</button> </a>
            <a href="publicpost.php"><button type="button" class="menubar_buttons">Public posts</button></a>
            <button type="button" class="menubar_buttons">Events</button>
            <a href=""> <button type="button" class="menubar_buttons">Notifications</button> </a>
            <a href="organizations.php"><button type="button" class="menubar_buttons">Organizations</button></a>
            <a href=""> <button type="button" class="menubar_buttons">About</button> </a>
        </div>
        
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