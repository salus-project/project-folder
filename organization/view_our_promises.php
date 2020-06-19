<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
	$org_id= $_GET['org_id'];
	$event_id= $_GET['event_id'];	
    $event_name="event_".$event_id."_pro_don";
	$query="select * from $event_name where by_org='$org_id'";
    $result=$con->query($query);
	
	$id_array = array(); 
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
			while($row=$result->fetch_assoc()){
                $id_num=$row['to_person'];
                $sql="select * from civilian_detail where NIC_num='$id_num'";
                $result1=($con->query($sql))->fetch_assoc();
                $name=$result1['first_name']." ".$result1['last_name'];

                $ability=explode(",",$row['content']);
                $count_arr = count($ability);
                $data="";
                for ($x = 0; $x <$count_arr; $x++) {
                    $data=$data.$ability[$x]."<br>";
                }
				$row_id=$row['id'];
                echo "<tr onclick='select(this.firstElementChild.firstElementChild)'>
				<td><input type='checkbox' class='select_me' data-id='".$row_id."' id='edit_box' onclick='' ></td>
                <td>".$name."</td><td>".$data."</td><td>".$row['note']."</td>
				<td><form id='edit_me_form".$row_id."' class='edit_me' action='edit_me.php' method=post>
				<input type='hidden' name='datas' ><br>
				<input type='hidden' name='org_id' value= $event_id > 
				<input type='hidden' name='event_id' value= $event_id > 
				<input type='submit' name='submit_button'  value='Edit'>
			</form></td>
                </tr>";
				array_push($id_array, $row_id);
            }
            ?>    
			<tr>
			<td>
			<button type="button" onclick="select_all()" >select all</button>
			<form id="edit_form" action="edit_our_promise.php" method=get>
				<input type="hidden" name="id_list" id="id_list"><br>
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
		var jArray = <?php echo json_encode($id_array); ?>;
		var arr= new Array() ;  
		function select_me(element){
			var idn=element.getAttribute("data-id");
			if(element.checked==true){
				arr.push(idn);
			}else{
				for( var i = 0; i < arr.length; i++){ if ( arr[i] === idn) { arr.splice(i, 1); }}
			}
			document.getElementById('id_list').value=arr.join(",");
			
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
			document.getElementById('id_list').value=arr.join(",");
		}
	</script>


</html>