<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
	$org_id= $_GET['org_id'];
	$event_id= $_GET['event_id'];	
    $event_name="event_".$event_id."_pro_don";
	$query="select * from $event_name where by_org='$org_id'";
    $result=$con->query($query);
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
                <th colspan=1>Person name</th>
                <th colspan=1>Promises</th>
                <th colspan=1>Note</th>
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

                echo "<tr>
                <td>".$name."</td><td>".$data."</td><td>".$row['note']."</td>
                </tr>";
            }
            ?>    
            </table>
        </div>
    </body>

</html>