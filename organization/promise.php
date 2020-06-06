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
		<tr><td>Name</td><td>Address</td><td>Requirements</td><td>Other promises</td><td>Your promise</td><td>Note</td></tr>
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
					
					$request = explode(",", $row['requests']);
					echo"<td>";
					foreach($request as $res){
					  echo "$res <br>";
					}
					echo"</td>";
					
					echo "<td>";
					
					$query4="select * from event_2_pro_don where to_person='$idd' ORDER BY by_org";
					$result4=$con->query($query4);
					if($result4->num_rows>0){
						while($rows=$result4->fetch_assoc()){
							if ($rows['by_org']==""){
								$iddd=$rows['by_person'];
								$query2="select * from civilian_detail where NIC_num='$iddd'";
								$result2=($con->query($query2))->fetch_assoc();
								echo "<b>".$result2['first_name']." ".$result2['last_name']."</b>";
								echo "<br>";
								$string1 = explode (",", $rows['content']); 
									foreach($string1 as $str) {
										$string2 = explode (":", $str); 
										echo "\t".$string2[0]." ".$string2[1];
										echo "<br>";
									}
							}
							else{
								$o_id=$rows['by_org'];
								$query3="select * from organizations where org_id=".$o_id;
								$result3=($con->query($query3))->fetch_assoc();
								echo "<b>".$result3['org_name']."</b>";
								echo "<br>";
								$string1 = explode (",", $rows['content']); 
									foreach($string1 as $str) {
										$string2 = explode (":", $str); 
										echo "\t".$string2[0]." ".$string2[1];
										echo "<br>";
									}
							}
						echo "<br>";
						}
					}else{
						echo "<b>No Promises<b>";
					}
							
						
					echo "</td>";
					
					echo "<td>";
					?>
					
					<div class="input_container">
						<div class="input_sub_container">
							<input type="text" class="text_input">
							<input type="text" class="text_input">
							<button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>
						</div>
					</div>
					
					<?php
					echo "</td>";
					echo "<td>";
						echo "<input type=text name=note id=note>";
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
function add_input(element){
        var parent = element.parentElement.parentElement;
        if(element.parentElement.children[0].value!=='' || element.parentElement.children[1].value!=='') {
            for (var ele of parent.children) {
                ele.children[0].setAttribute("value", ele.children[0].value);
                ele.children[1].setAttribute("value", ele.children[1].value);
                ele.children[2].outerHTML = "<button type='button' onclick='remove_input(this)' class='add_rem_btn'>Remove</button>"
            }
            parent.innerHTML += '<div class="input_sub_container">\n' +
                '        <input type="text" class="text_input">\n' +
                '        <input type="text" class="text_input">\n' +
                '        <button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>\n' +
                '    </div>';
        }
    }
    function remove_input(element){
        element.parentElement.outerHTML='';
    }
</script>
</body>
</html>