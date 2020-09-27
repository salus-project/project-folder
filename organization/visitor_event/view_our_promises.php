<?php require $_SERVER['DOCUMENT_ROOT']."/organization/visitor_event/visitor_event_header.php" ;

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
		<title>view  promises</title>
		<link rel="stylesheet" href='/css_codes/view_my_event_individual_promise.css'>
        <link rel="stylesheet" href='/css_codes/view_our_promises.css'>
    </head>
    <body>
		<script>
            btnPress(6);
		</script>
		<div class='our_promise_body'>
			<table class='our_promise_table'>
				<tr class="first_head">
					<th colspan=3>Our Promises</th>
				</tr>
				<tr class="second_head">
					<th colspan=1>Person name</th>
                    <th colspan=1>Promises</th>
					<th colspan=1>Note</th>
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
                    
                    <td>".$name[$key]."</td><td>".$data."</td><td>".$note[$key]."</td>
                    
                    </tr>";
                }
                ?>    
            </table>
        </div>
    </body>
	
	<?php require $_SERVER['DOCUMENT_ROOT']."/organization/org_footer.php"; ?>