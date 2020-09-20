<?php
    require "header.php";
?>

<title>Home Page</title>
<link rel="stylesheet" href="css_codes/home.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class="admin_detail">
    <table class="admin_detail_table">
        <tr>
            <th class="admin_det_head" colspan=2>Admin Detail</th>
        </tr>
        <tr>
            <td class="admin_det_data"><?php echo "NAME:" ?> </td>
            <td class="admin_det_data"><?php echo $_SESSION['first_name']. " ".$_SESSION['last_name']; ?> </td>
        </tr>
        <tr>
            <td class="admin_det_data"><?php echo "NIC NUM:" ?> </td>
            <td class="admin_det_data"><?php echo $_SESSION['nic_num']; ?> </td>
        </tr>
    </table>
</div>   
<?php include $_SERVER['DOCUMENT_ROOT']."/admin/footer.php" ?>