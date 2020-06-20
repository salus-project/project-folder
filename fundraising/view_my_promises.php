<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    $id=$_SESSION['user_nic'];
    $query="SELECT * FROM fundraising_pro_don INNER JOIN fundraisings ON fundraising_pro_don.for_fund = fundraisings.id where by_person='$id'";
    $result=$con->query($query);
?>


<!DOCTYPE html>
<html>
    <head>
        <title>view my promises</title>
        <link rel="stylesheet" href='/css_codes/view_my_promise.css'>
    </head>
    <body>
		<script>
        btnPress(7);
		</script>
        <div id="title">
            <?php echo "My Promises" ?>
        </div>
        
        <div id='promise_body'>
            <table id='promise_table'>
            <thead>
                <th colspan=1>Fundraising name</th>
                <th colspan=1>Promises</th>
                <th colspan=1>Note</th>
            </thead>

            <?php
            while($row=$result->fetch_assoc()){
                $name=$row['name'];
                $ability=explode(",",$row['content']);
                $count_arr = count($ability);
                $data="";
                for ($x = 0; $x <$count_arr; $x++) {
                    $data=$data.$ability[$x]."<br>";
                }

                echo "<tr class='my_promises_tr' onclick='mypromise_click(this)'>
                <td>".$name."</td><td>".$data."</td><td>".$row['note']."</td>
                </tr>";
            }
            ?>    
            </table>
        </div>

        <?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>

    </body>
    <script>
    </script>

</html>