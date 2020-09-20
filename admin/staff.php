<?php
    require "header.php";
    $query="select * from staff_detail";
    $result=($con->query($query))->fetch_assoc();
    $result=$con->query($query);
?>

<head>
    <title> Staff</title>
    <link rel="stylesheet" href="css_codes/staff.css">
</head>
</body>
    <div class="new_staff">
    <a class="tag" href="add_staff.php">
        <i class="fa fa-user-plus" aria-hidden="true" style="font-size:25px;color:black;">  Add new staff</i>
    </a>
    </div>

    <div class="staff_detail">
        <table class="staff_table">
            <tr>
                <th> Full name</th>
                <th> NIC number</th>
                <th> </th>
            </tr>
            <?php 
                while($row=$result->fetch_assoc()){
                    echo "<tr><td>" . $row['first_name']." " .$row['last_name'] ."</td><td class='nic_row'>" . $row['NIC_num'] . "</td><td><a href='/admin/delete_staff.php?nic=".$row['NIC_num']."'><i class='fa fa-trash' style='font-size:16px;color:#6b7c93;' aria-hidden='true'>  Delete</i></a></td></tr>";
                }
            ?>
        </table> 
    </div>            
<?php include $_SERVER['DOCUMENT_ROOT']."/admin/footer.php" ?>

