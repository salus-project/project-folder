<?php
    require $_SERVER['DOCUMENT_ROOT']."/staff/header.php";
?>

<!DOCTYPE html>
<html> 
    <head>
        <title>Home Page</title>
        <link rel="stylesheet" href="/staff/css_codes/homepage.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
    <script>
        btnPress(1);
    </script>    

        <div class="detail">
            <table class="detail_table" style="width:100%">
                <tr>
                    <td colspan=2>Staff Detail</td>
                </tr>
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