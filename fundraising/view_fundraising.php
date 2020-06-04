<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
	$query="select * from fundraisings where id=".$_GET['view_fun'];
    $result=($con->query($query))->fetch_assoc();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>view fundraising event</title>
        <link rel="stylesheet" href='/css_codes/view_fundraising.css'>
    </head>
    <body>
		
		<script>
        btnPress(7);
		</script>
		
		<div id="title">
        <?php echo $result['name'] ?>
		</div>
		<div id='fund_body'>
        <?php
			if($result['by_civilian']==$_SESSION['user_nic']){
				echo "<div id=fund_edit_btn_container >";
					echo "<form action='/fundraising/edit_fundraising.php' method=get>";
						echo "<button id=edit_btn type='submit' name=edit_btn value=".$_GET['view_fun'].">Edit</button>";
					echo "</form>";
				echo"</div>";
			}
		?>
        
            <table id='fund_table'>
                <tr>
                    <td>Fundraising id </td>
                    <td><?php echo $result['id'] ?></td>
                </tr>
                
				<?php
				
				$idd= filter($result['by_civilian']);
				
				$query3="select * from civilian_detail where NIC_num='$idd' ";
				$result3=($con->query($query3))->fetch_assoc();
				echo '<tr><td id=column1> Created by </td><td id=column2>' . $result3['first_name'] ." ". $result3['last_name']. '</td></tr>';
					
				
				if($result['by_org']!=NULL){
					$query1="select * from organizations where org_id=". $result['by_org'];
					$result1=($con->query($query1))->fetch_assoc();
					echo '<tr><td id=column1> Org name</td><td id=column2>' . $result1['org_name'] . '</td></tr>';
				}
				if($result['for_event']==NULL){
				echo '<tr><td id=column1> Purpose</td><td id=column2>' . $result['for_any'] . '</td></tr>';
				}else{
					$query2="select * from disaster_events where event_id=". $result['for_event'];
					$result2=($con->query($query2))->fetch_assoc();
					echo '<tr><td id=column1>Purpose</td><td id=column2>' . $result2['name'] . '</td></tr>';
				}
				
				echo '<tr><td id=column1> Request</td><td id=column2>' . $result['type'] . '</td></tr>';
				
				if($result['type']=="money only"){
				echo '<tr><td id=column1> Ammount in rs</td><td id=column2>' . $result['expecting_money'] . '</td></tr>';
				}elseif($result['type']=="things only"){
				echo '<tr><td id=column1> Requested things </td><td id=column2>' . $result['expecting_things'] . '</td></tr>';
				}else{
				echo '<tr><td id=column1> Ammount in rs</td><td id=column2>' . $result['expecting_money'] . '</td></tr>';
				echo '<tr><td id=column1> Requested things </td><td id=column2>' . $result['expecting_things'] . '</td></tr>';
				}
				function filter($input){
					return(htmlspecialchars(stripslashes(trim($input))));
					}
				?>
				
				<tr>
                    <td>Service area </td>
                    <td><?php echo $result['service_area'] ?></td>
                </tr>
				<tr>
                    <td>description </td>
                    <td><?php echo $result['description'] ?></td>
                </tr>
                
            </table>
        </div>
    </body>

</html>