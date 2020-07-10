<?php
require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
$id=$_SESSION['user_nic'];
$query="select p.*,f.*,f.id AS  fundraising_pro_donid from fundraising_pro_don f inner join fundraisings p on f.for_fund = p.id where by_person='".$id."';
select * from fundraising_pro_don_content inner join fundraising_pro_don on fundraising_pro_don.id = fundraising_pro_don_content.don_id where by_person='".$id."';";
if(mysqli_multi_query($con,$query)){
    $result=mysqli_store_result($con);
    $fundraising_detail=[];
    if(mysqli_num_rows($result)>0){
        $fundraising_detail=mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    
    $content_detail=[];
    mysqli_next_result($con);
    $result = mysqli_store_result($con);
    $content_detail = mysqli_fetch_all($result,MYSQLI_ASSOC);
    mysqli_free_result($result);
}
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
        <th colspan=1>Fundraising name </th>
        <th colspan=1>Promises</th>
        <th colspan=1>Note</th>
        </thead>

        <?php
            foreach($fundraising_detail as $row_req){
                $item_amount="";
                $name=$row_req['name'];
                $note=$row_req['note'];
                foreach($content_detail as $row_req1){
                    if ($row_req1['don_id']==$row_req['id']){
                        $item_amount=$item_amount.$row_req1['item'].":".$row_req1['amount']."<br>";
                        }
                }
                echo "<tr>
            <td>".$name."</td><td>".$item_amount."</td><td>".$note."</td>
            </tr>";
            }
            
        ?>
    </table>
</div>
</body>

</html>