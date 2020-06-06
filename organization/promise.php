<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    echo $_GET['selected'];
	$my_promises='';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Promise help</title>
        <link rel="stylesheet" href='promise.css'>
    </head>
    <body>
	<div id="full_body">
		<h2>Promise your help</h2>
		<table id='main_table'>
		<tr><td>Name</td><td>Address</td><td>Requirements</td><td>Other promises</td><td>Your promise</td></tr>
		<?php
			$string = $_GET['selected'];
			$str_arr = explode (",", $string);  
			//foreach($str_arr as $NIC) {
			//   print($NIC);
			//}
			$query="select * from event_2_help_requested ";
            $result=$con->query($query);
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
				$idd=$row['NIC_num'];
				if (in_array($idd, $str_arr)) {
					echo "<tr>";
					$query1="select * from civilian_detail where NIC_num='$idd'";
					$result1=($con->query($query1))->fetch_assoc();
					echo"<td>".$result1['first_name']." ".$result1['last_name']."</td>";
					echo"<td>".$row['street']." ".$row['village']." ".$row['district']."</td>";
					
					if ($row['help_type']=="money and good"){
						echo"<td>"."Money ".$row['money_discription']."<br>".$row['good_discription']."</td>";
					}
					else if ($row['help_type']=="money"){
						echo"<td>"."Money ".$row['money_discription']."</td>";
					}
					else if ($row['help_type']=="good"){
						echo"<td>".$row['good_discription']."</td>";
					}
					echo "<td>";
					$i_promises = $row['individual_promises'];
					if ($i_promises!=""){
						$i_promise = explode (";", $i_promises ); 
							foreach($i_promise as $promise){
								$string1 = explode ("-", $promise); 
								$iddd=$string1[0];
								$query2="select * from civilian_detail where NIC_num='$iddd'";
								$result2=($con->query($query2))->fetch_assoc();
								echo "<b>".$result2['first_name']." ".$result2['last_name']."</b>";
								echo "<br>";
								$string2 = explode (",", $string1[1]); 
									foreach($string2 as $str) {
										$string3 = explode (":", $str); 
										echo "\t".$string3[0]." ".$string3[1];
										echo "<br>";
									}
							}
						echo "<br>";
					}
					
					$o_promises = $row['org_promises'];
					if ($o_promises!=""){
						$o_promise = explode (";", $o_promises ); 
							foreach($o_promise as $promise_o){
								$string5 = explode ("-", $promise_o); 
								$o_id=$string5[0];
								$query3="select * from organizations where org_id=".$o_id;
								$result3=($con->query($query3))->fetch_assoc();
								echo "<b>".$result3['org_name']."</b>";
								echo "<br>";
								$string6 = explode (",", $string5[1]); 
									foreach($string6 as $str_o) {
										$string7= explode (":", $str_o); 
										echo "\t".$string7[0]." ".$string7[1];
										echo "<br>";
									}
								
								
							}
					}
					if (($o_promises=="")and ($i_promises=="")){
						echo "<b>No Promises<b>";
					}
						
					echo "</td>";
					
					echo "<td>";
					echo "<div id=add_".$idd.">";
						echo "<input type=text name=1 id=new_member>";
						echo "<input type=text name=2 id=new_member>";
						echo "<button type=button onclick=add(".$idd.")>Add item</button>";
					echo "</div> ";
					
					
					echo "</td>";
					echo"</tr>"	;
					}
				}
			}	
		?>
		<tr>
		<td colspan='5'>
		<input type='button' name='submit' id='submit' value='submit'/>
		</td>
		</tr>
		</table>
	</div>
	<input type='hidden' id='hidden' name='hidden'>
	
<script>                                                                                                                                                             
	                                                                              
	function add(iid){
		var str='';
		
		str+="<br><input type=text name=jsinput1 id=new_member><input type=text name=jsinput2 id=new_member>";
		document.getElementById('add_'+iid).innerHTML += str;

	}
</script>
</body>
</html>