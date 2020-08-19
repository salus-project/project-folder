<?php
    session_start();
    require 'dbconfi/confi.php';
    require "header.php";
    $query="select * from civilian_detail";
    $result=($con->query($query))->fetch_assoc();
    $result=$con->query($query);
    ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Member</title>
        <link rel="stylesheet" href="css_codes/member.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
<body>

    <div class="new_member"><a class="tag" href="create_civilian_acc.php"><i class="fa fa-user-plus" aria-hidden="true" style="font-size:25px;color:black;">  Add new member</i></a></div>
    <div>
    
    <form action='view_member.php' method='get'>
    <div class="civi_detail">
    <table class="civilian_table">
        <tr>
            <th> Full name</th>
            <th> NIC number</th>
        </tr>
        <?php
            while($row=$result->fetch_assoc()){
                echo "<tr><td><button type=submit class=civilian_name name=nic value=". $row['NIC_num'] .">" . $row['first_name']." " .$row['last_name'] ."</button></td><td>" . $row['NIC_num'] . "</td></tr>";
            }
        ?>
    </table>
    </div>
    </form>
</body>
</html>
