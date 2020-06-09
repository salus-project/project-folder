<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    $id=$_SESSION['user_nic'];  
    $event_id = $_GET['event_id'];
    $query="SELECT * FROM event_".$event_id."_pro_don INNER JOIN civilian_detail ON civilian_detail.NIC_num = event_".$event_id."_pro_don.to_person where by_person='$id'"; 
    $result=$con->query($query);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>view my promises</title>
        <link rel="stylesheet" href='/css_codes/view_my_event_individual_promise.css'>
    </head>
    <body>
		<script>
            btnPress(4);
		</script>
		
		<div id="title">
            <?php echo "My Promises" ?>
        </div>
        
		<div id='promise_body'>
            <table id='promise_table'>
                <thead>
                    <th colspan=1>Full name </th>
                    <th colspan=1>Promises</th>
                    <th colspan=1>Note</th>
                </thead>

                <?php
			        while($row=$result->fetch_assoc()){
                        $name=$row['first_name']." ".$row['last_name'];
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
