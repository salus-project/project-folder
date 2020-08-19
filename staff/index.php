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
                    <th class="staff_det_head" colspan=2>Staff Detail</th>
                </tr>
                <tr>
                    <td class="staff_det_data"><?php echo "User id" ?></td>
                    <td class="staff_det_data"><?php echo $_SESSION['username']; ?></td>
                </tr>
                <tr>
                    <td class="staff_det_data"><?php echo "Full name" ?></td>
                    <td class="staff_det_data"><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></td>
                </tr>
                <tr>
                    <td class="staff_det_data"><?php echo "Gender" ?></td>
                    <td class="staff_det_data"><?php echo $_SESSION['gender']; ?></td>
                </tr>
                <tr>
                    <td class="staff_det_data"><?php echo "District" ?></td>
                    <td class="staff_det_data"><?php echo $_SESSION['district']; ?></td>
                </tr>
             
                <tr>
                    <td class="staff_det_data"><?php echo "Address" ?></td>
                    <td class="staff_det_data"><?php echo $_SESSION['address']; ?></td>
                </tr>
            </table>
        </div>
        

    </body>

</html>