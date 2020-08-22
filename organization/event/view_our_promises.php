<?php
    require $_SERVER['DOCUMENT_ROOT']."/organization/event/org_event_header.php";
	$org_id= $_GET['org_id'];
	$event_id= $_GET['event_id'];	
	$person_name=$_SESSION['first_name']." ".$_SESSION['last_name'];
	$event_name1="event_".$event_id."_pro_don";
	$event_name2="event_".$event_id."_pro_don_content";

	function console_log($data) {
		$output = $data;
		if (is_array($output))
			$output = implode(',', $output);
	
		echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
	}
	
	$persons=[];
	$promises=[];
	$status=[];
	$id_arr=[];
	$note=[];
	$name=[];

	$don_promises=[];
	$don_note=[];
	$don_name=[];
	$query="SELECT a.to_person AS person, a.note AS note, b.item AS item, b.amount AS amount,b.pro_don AS pro_don,b.id AS d_id, c.first_name AS first, c.last_name AS last FROM $event_name1 AS a INNER JOIN $event_name2 AS b ON (a.id = b.don_id) INNER JOIN civilian_detail AS c ON (a.to_person = c.NIC_num) WHERE a.by_org = $org_id";
	$result=$con->query($query);
	if($result->num_rows>0){
		while($row=$result->fetch_assoc()){
			if($row['pro_don']!='donated'){
				if (in_array($row['person'], $persons)) {
					$key = array_search($row['person'], $persons); 
					$promises[$key]=$promises[$key].",".$row['item'].":".$row['amount'];
					$status[$key]=$status[$key].",".$row['pro_don'];
					$id_arr[$key]=$id_arr[$key].",".$row['d_id'];
				}else{
					array_push( $persons,$row['person']);
					array_push( $promises,$row['item'].":".$row['amount']);
					array_push( $note,$row['note']);
					array_push( $name,$row['first']." ".$row['last']);
					array_push( $status,$row['pro_don'] );
					array_push( $id_arr,$row['d_id'] );
				}
			}else{
				if (in_array($row['first']." ".$row['last'], $don_name)) {
					$key = array_search($row['first']." ".$row['last'], $don_name); 
					$don_promises[$key]=$don_promises[$key].",".$row['item'].":".$row['amount'];
				}else{
					array_push( $don_name,$row['first']." ".$row['last']);
					array_push( $don_promises,$row['item'].":".$row['amount']);
					array_push( $don_note,$row['note']);
				}
			}
		}
	}
	// print_r($id_arr);
	// echo "<br>";
	// print_r($don_promises);
	// echo "<br>";
	// print_r($don_note);
	// echo "<br>";
	// print_r($don_name);
?>


<!DOCTYPE html>
<html>
    <head>
        <title>view our my promises</title>
        <link rel="stylesheet" href='/css_codes/view_my_event_individual_promise.css'>
		<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
		<link href="/css_codes/bootstrap-toggle.css" rel="stylesheet">
    </head>
    <body>
		<script>
            btnPress(6);
		</script>

		<div class='our_promise_body'>
            <table class='our_promise_table'>
			<tr class="first_head">
                    <th colspan=6>Our Promises</th>
                </tr>
				<tr class="second_head">
                    <th colspan=2>Person name</th>
                    <th colspan=1>Promises</th>
					<th colspan=1>Status</th>
                    <th colspan=1>Note</th>
                    <th colspan=1></th>
                </tr>


                <?php
                
                foreach($persons as $person){
                    $key = array_search($person, $persons); 
					
					$ability=explode(",",$promises[$key]);
					$state=explode(",",$status[$key]);
					$data_id=explode(",",$id_arr[$key]);
					$count_arr = count($ability);
					$data="";
					

					$link_='/event/help/?event_id='.$event_id.'&to='.$person.'&by='.$org_id;
                    for ($x = 0; $x <$count_arr; $x++) {
						$data=$data.$ability[$x]."<br>";
						if ($x==0){
							$check_box="<td rowspan=".$count_arr."><label class='check_cont'>
																		<input disabled class='".$person."' type='checkbox' >
																		<span class='checkmark'></span>
																		</label></td>";
							$name_data_row="<td rowspan=".$count_arr.">".$name[$key]."</td>";
							if($note[$key]==''){
								$row_note="No notes";
							}else{
								$row_note=$note[$key];
							}
							$note_data_row="<td rowspan=".$count_arr.">".$row_note."</td>";
							$edit_btn="<td rowspan=".$count_arr.">
							<a href=".$link_."><button class= 'our_pro_btn edit_pro'  type='button' ><i class='fas fa-edit'> Edit</i></button></a>
							</td>";
						}
                        else{
                            $name_data_row=$note_data_row=$check_box=$edit_btn="";
						}
						if($state[$x]=='pending'){
                            $checked="checked='checked'";
                        }
                        else{
                            $checked="";
                        }
                    echo "<tr onclick='select(\"".$person."\")'>".$check_box.
                    $name_data_row."<td>".$ability[$x]."</td><td class='not_click'>
					<input type='checkbox'".$checked."data-toggle='toggle' data-on='Helped' data-off='Not helped' data-width='100' data-height='15' data-offstyle='warning' data-onstyle='success' onchange='toggleFn(this,".$data_id[$x].",\"".$person."\")'>
					</td>".$note_data_row.$edit_btn."
					</tr>";
					}
                }
                ?>    
			</table>
				<div class="our_pro_btn_div">
                        <button class= "our_pro_btn edit_pro_btn" type="button" onclick="select_all()" >Select all</button>
                        <form id="edit_form" action="promise.php" method=get>
                            <input type="hidden" name="selected" id="selected"><br>
                            <input type="hidden" name="org_id" value=<?php echo $org_id ; ?> >
                            <input type="hidden" name="event_id" value=<?php echo $event_id ; ?> >
                            <input type="hidden" name="type" value="2" >
                            <button class= "our_pro_btn edit_pro_btn" type='submit' name='submit_button' id='submitBtn'>Edit selected</button>
                        </form>
			</div>

			<table class='our_promise_table'>
			<tr class="first_head">
                    <th colspan=3>Donations</th>
                </tr>
				<tr class="second_head">
                    <th colspan=1>Person name</th>
                    <th colspan=1>Donations</th>
                    <th colspan=1>Note</th>
                </tr>


                <?php
                
                foreach($don_name as $person_namee){
                    $key = array_search($person_namee, $don_name); 
					
					$ability=explode(",",$don_promises[$key]);
                    $count_arr = count($ability);
					

					$link_='/event/help/help/?event_id='.$event_id.'&to='.$person.'&by='.$org_id.'';
                    for ($x = 0; $x <$count_arr; $x++) {
						if ($x==0){
							$name_data_row="<td rowspan=".$count_arr.">".$person_namee."</td>";
							$note_data_row="<td rowspan=".$count_arr.">".$don_note[$key]."</td>";
						}
                        else{
                            $name_data_row=$note_data_row="";
						}
						
                    echo "<tr >".$name_data_row."<td>".$ability[$x]."</td>".$note_data_row."
					</tr>";
					}
                }
                ?>    
			</table>
		</div>
		

    </body>
	<script>


		var jArray =<?php echo json_encode($persons); ?>;
		var idArray= new Array() ;  
		console.log(jArray);	
		function select(id_){
			if(!((event.target.className.includes('btn')) || (event.target.className.includes('not_click')))){
				if(idArray.includes(id_)){
					document.getElementsByClassName(String(id_))[0].outerHTML="<input disabled class='"+id_+"' type='checkbox' >";
					for( var i = 0; i < idArray.length; i++){ if ( idArray[i] === id_) { idArray.splice(i, 1); }}
				}else{
					document.getElementsByClassName(String(id_))[0].outerHTML="<input disabled class='"+id_+"' type='checkbox' checked >";
					idArray.push(id_);
				}
			}
			document.getElementById('selected').value=idArray.join(",");
			console.log(idArray);
		}	

		function select_all(){
			if (idArray.length < jArray.length){
				idArray=[];
				for(var x=0;x<jArray.length;x++){
					document.getElementsByClassName(jArray[x])[0].outerHTML="<input disabled class='"+jArray[x]+"' type='checkbox' checked >";
					idArray.push(jArray[x]);
				}
			}else{
				idArray=[];
				for(var x=0;x<jArray.length;x++){
					document.getElementsByClassName(jArray[x])[0].outerHTML="<input disabled class='"+jArray[x]+"' type='checkbox' >";
				}
			}
			console.log(idArray);
			document.getElementById('selected').value=idArray.join(",");
		}
		

		function toggleFn(ele,id,id_n){
			var person="<?php echo $person_name ; ?>";
			var org_id="<?php echo $org_id ; ?>";
			var event_id="<?php echo $event_id ; ?>";
			var org="<?php echo $org_detail['org_name'] ; ?>";
			var event="<?php echo $event_name ; ?>";
			
			if (ele.checked){
			var c_status='pending';
			}else{
			var c_status='promise';
			}
			var sql="UPDATE `event_"+event_id+"_pro_don_content` SET `pro_don` = '"+c_status+"' WHERE `id` = "+id+";";
			var xhttp = new XMLHttpRequest();
			// xhttp.onreadystatechange = function() {
			// 	if (this.readyState == 4 && this.status == 200) {
			// 		console.log(this.responseText);
			// 	}
			// };
			xhttp.open("POST", "/common/postajax/post_ajax.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("sql="+sql+"&person="+person+"&event="+event+"&event_id="+event_id+"&org="+org+"&status="+c_status+"&id_n="+id_n+"&type="+5);
    	}
	</script>
	<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>
</html>