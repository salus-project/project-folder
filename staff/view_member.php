<?php  
    require $_SERVER['DOCUMENT_ROOT']."/staff/header.php";
?>

<title>view event</title>
<link rel="stylesheet" href="/staff/css_codes/view_member.css">

<script>
    btnPress(2);
</script>

<?php
    $query="select * from civilian_detail where NIC_num ='". $_GET['nic']."'";
    $result=($con->query($query))->fetch_assoc();
    $name=$result['first_name']." ".$result['last_name'];
    $gender=$result['gender'];
    $district=$result['district'];
    $village=$result['village'];
    $street=$result['street']; 
    $address=$result['address'];
    $Occupation=$result['Occupation'];
    $email=$result['email'];
    $phone_num=$result['phone_num'];
?>

<div id=event_header>
    <div id=title_box>
        <?php echo $name; ?>
    </div>
    <div class='back_btn_div'>
        <?php
            echo "<form action=/staff/delete_member.php method=GET>";
            echo "<input type='hidden' name='nic' value='". $_GET['nic']."'>";
            echo    "<button type='submit' class='back_button' ><i class='fa fa-trash' style='font-size:20px;color:black;' aria-hidden='true'>Delete</i>
            </button>";
            echo "</form>";
        ?>
    </div>
</div>
<div class="detail">
    <table class="detail_table" style="width:100%">
        <tr>
            <th class="mem_det_head" colspan=2>Staff Detail</th>
        </tr>
        <tr>
            <td><?php echo "Full name" ?></td>
            <td><?php echo $name; ?></td>
        </tr>
        <tr>
            <td><?php echo "Gender" ?></td>
            <td><?php echo $gender; ?></td>
        </tr>
        <tr>
            <td><?php echo "District" ?></td>
            <td><?php echo $district; ?></td>
        </tr>
        <tr>
            <td><?php echo "Village" ?></td>
            <td><?php echo $village; ?></td>
        </tr>
        <tr>
            <td><?php echo "Street" ?></td>
            <td><?php echo $street; ?></td>
        </tr>
        <tr>
            <td><?php echo "Address" ?></td>
            <td><?php echo $address; ?></td>
        </tr>
        <tr>
            <td><?php echo "Occupation" ?></td>
            <td><?php echo $Occupation; ?></td>
        </tr>
        <tr>
            <td><?php echo "Phone number" ?></td>
            <td><?php echo $phone_num; ?></td>
        </tr>
        <tr>
            <td><?php echo "Email" ?></td>
            <td><?php echo $email; ?></td>
        </tr>
        
    </table>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/staff/footer.php" ?>
