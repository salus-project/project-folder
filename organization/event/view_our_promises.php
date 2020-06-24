<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
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
	

	console_log($persons);
	console_log($promises);
	console_log($note);
	console_log($name);
?>


<!DOCTYPE html>
<html>
    <head>
        <title>view our my promises</title>
        <link rel="stylesheet" href='view_our_promises.css'>
    </head>
    <body>
		<script>
        btnPress(6);
		</script>
		
		<div id="title">
            <?php echo "Our Promises" ?>
        </div>
        
		<div id='promise_body'>
            <table id='promise_table'>
            <thead>
				<th colspan=1></th>
                <th colspan=1>Person name</th>
                <th colspan=1>Promises</th>
                <th colspan=1>Note</th>
				<th colspan=1></th>
             </thead>

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
				
				<td><input type='checkbox' class='select_me' data-id='".$persons[$key]."' id='edit_box' ></td>
                <td>".$name[$key]."</td><td>".$data."</td><td>".$note[$key]."</td>
				<td>
				<a href=$link_><button type='button' >Edit</button></a>
				</td>
                </tr>";
            }
            ?>    
			<tr>
			<td>
			<button type="button" onclick="select_all()" >select all</button>
			<form id="edit_form" action="edit_our_promise.php" method=get>
				<input type="hidden" name="selected" id="selected"><br>
				<input type="hidden" name="org_id" value=<?php echo $org_id ; ?> >
				<input type="hidden" name="event_id" value=<?php echo $event_id ; ?> >
				<input type='submit' name='submit_button' id='submitBtn' value='Edit'>
			</form>
			</td><td></td><td></td><td></td><td></td>
			</tr>
            </table>
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
			if(element.checked==true){
				element.checked=false;
			}else{
				element.checked=true;
			}
			select_me(element);
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
			}
			document.getElementById('selected').value=arr.join(",");
		}
	</script>


</html>