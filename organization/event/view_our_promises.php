<?php
    require $_SERVER['DOCUMENT_ROOT']."/organization/event/org_event_header.php";
	$org_id= $_GET['org_id'];
	$event_id= $_GET['event_id'];	
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
	$note=[];
	$name=[];
	$query="SELECT a.to_person AS person, a.note AS note, b.item AS item, b.amount AS amount, c.first_name AS first, c.last_name AS last FROM $event_name1 AS a INNER JOIN $event_name2 AS b ON (a.id = b.don_id) INNER JOIN civilian_detail AS c ON (a.to_person = c.NIC_num) WHERE a.by_org = $org_id";
	$result=$con->query($query);
	if($result->num_rows>0){
		while($row=$result->fetch_assoc()){
			if (in_array($row['person'], $persons)) {
				$key = array_search($row['person'], $persons); 
				$promises[$key]=$promises[$key].",".$row['item'].":".$row['amount'];
			}else{
				array_push( $persons,$row['person']);
				array_push( $promises,$row['item'].":".$row['amount']);
				array_push( $note,$row['note']);
				array_push( $name,$row['first']." ".$row['last']);
			}
		}
	}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>view our my promises</title>
        <link rel="stylesheet" href='/css_codes/view_my_event_individual_promise.css'>
    </head>
    <body>
		<script>
            btnPress(6);
		</script>

		<div class='our_promise_body'>
            <table class='our_promise_table'>
			<tr class="first_head">
                    <th colspan=5>Our Promises</th>
                </tr>
				<tr class="second_head">
                    <th colspan=2>Person name</th>
                    <th colspan=1>Promises</th>
                    <th colspan=1>Note</th>
                    <th colspan=1></th>
                </tr>


                <?php
                
                foreach($persons as $person){
                    $key = array_search($person, $persons); 

                    $ability=explode(",",$promises[$key]);
                    $count_arr = count($ability);
                    $data="";
                    for ($x = 0; $x <$count_arr; $x++) {
                        $data=$data.$ability[$x]."<br>";
                    }
                    $link_='/event/help/help/?event_id='.$event_id.'&to='.$person.'&by='.$org_id.'';

                    echo "<tr onclick='select(this.firstElementChild.firstElementChild)'>
                    
                    <td><input type='checkbox' class='select_me' data-id='".$persons[$key]."' id='edit_box' onclick='select_me(this)' ></td>
                    <td>".$name[$key]."</td><td>".$data."</td><td>".$note[$key]."</td>
                    <td>
                    <a href=$link_><button class= 'our_pro_btn edit_pro'  type='button' ><i class='fas fa-edit'> Edit</i></button></a>
                    </td>
                    </tr>";
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
		</div>
		
    </body>
	<script>


		var jArray = <?php echo json_encode($persons); ?>;
		var arr= new Array() ;  
		function select_me(element){
			var idn=element.getAttribute("data-id");
			if(element.checked==true){
				arr.push(idn);
			}else{
				for( var i = 0; i < arr.length; i++){ if ( arr[i] === idn) { arr.splice(i, 1); }}
			}
			document.getElementById('selected').value=arr.join(",");
			
			console.log(arr);
		}
		function select(element){
			if(event.target.type !== 'checkbox'){
				if(element.checked==true){
					element.checked=false;
				}else{
					element.checked=true;
				}
				select_me(element);
			}
		}	

		function select_all(){
			var element=document.getElementsByClassName('select_me');
			var checked=true;
			for(var td of element){
				if (td.checked ==false){
					checked=false;
				}
			}
			if (checked==true){
				arr =[];
				for(var td of element){
					td.checked =false;
				}
			}else{
				arr=jArray;
				for(var td of element){
					td.checked =true;
				}
				console.log(jArray);
			}
			document.getElementById('selected').value=arr.join(",");
		}
	</script>
	<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>
</html>