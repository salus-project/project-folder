<?php
    session_start();
?>

<!DOCTYPE html>
<html> 
    <head>
        <title>Home Page</title>
        <link rel="stylesheet" href="css_codes/homepage.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        
        <?php require "header.php" ?>

        <div class="detail">
            <table class="detail_table" style="width:100%">
                <tr>
                    <td><?php echo "User id" ?></td>
                    <td><?php echo $_SESSION['username']; ?></td>
                </tr>
                <tr>
                    <td><?php echo "Full name" ?></td>
                    <td><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></td>
                </tr>
                <tr>
                    <td><?php echo "Gender" ?></td>
                    <td><?php echo $_SESSION['gender']; ?></td>
                </tr>
                <tr>
                    <td><?php echo "District" ?></td>
                    <td><?php echo $_SESSION['district']; ?></td>
                </tr>
             
                <tr>
                    <td><?php echo "Address" ?></td>
                    <td><?php echo $_SESSION['address']; ?></td>
                </tr>
            </table>
        </div>
        

    </body>

</html>