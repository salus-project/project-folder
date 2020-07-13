<?php
require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    $query="select * from fundraisings where id=".$_GET['view_fun'].";
    select * from civilian_detail where NIC_num=(
        select by_civilian from fundraisings where id=".$_GET['view_fun']."
    );
    select org_name from organizations where org_id=(
        select by_org from fundraisings where id=".$_GET['view_fun']."); 
    select name from disaster_events where event_id=(
        select for_event from fundraisings where id=".$_GET['view_fun'].");
    select * from fundraisings_expects where fund_id=".$_GET['view_fun'].";";
    if(mysqli_multi_query($con,$query)){
        $result = mysqli_store_result($con);
        $fundraising = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        mysqli_next_result($con);
        $result = mysqli_store_result($con);
        $civi_detail = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        mysqli_next_result($con);
        $result = mysqli_store_result($con);
        $org_name_result=mysqli_fetch_assoc($result);
        $org_name_fundraising = (isset($org_name_result['org_name']))?$org_name_result['org_name']:'';
        mysqli_free_result($result);

        mysqli_next_result($con);
        $result = mysqli_store_result($con);
        $event_name_result=mysqli_fetch_assoc($result);
        $event_name_fundraising = (isset($event_name_result['name']))?$event_name_result['name']:'';
        mysqli_free_result($result);

           
        mysqli_next_result($con);
        $result = mysqli_store_result($con);
        $fund_expect = mysqli_fetch_all($result,MYSQLI_ASSOC);
        mysqli_free_result($result);
        $expect="";
        foreach($fund_expect as $row_req){
            $expect.=$row_req['item']." : ".$row_req['amount']."<br>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>view fundraising event</title>
        <link rel="stylesheet" href='/css_codes/view_fundraising.css'>
    </head>
    <body>

        <script>
            btnPress(7);
        </script>
        <div id="title">
            <?php echo '<center>'.$fundraising['name'].'</center>' ?>
        </div>
        <div id='fund_body'>
            <?php
                if($fundraising['by_civilian']==$_SESSION['user_nic']){
                    echo "<div id=fund_edit_btn_container >";
                    echo "<form action='/fundraising/edit_fundraising.php' method=get>";
                    echo "<button id=edit_btn type='submit' name=edit_btn value=".$_GET['view_fun'].">Edit</button>";
                    echo "</form>";
                    echo"</div>";
                }
            ?>

            <table id='fund_table'>
                <?php
                    echo '<tr><td id=column1> Created by </td><td id=column2>' . $civi_detail['first_name'] ." ". $civi_detail['last_name']. '</td></tr>';


                if($fundraising['by_org']!=NULL){
                    echo '<tr><td id=column1> Org name</td><td id=column2>' . $org_name_fundraising . '</td></tr>';
                }
                if($fundraising['for_event']==NULL){
                    echo '<tr><td id=column1> Purpose</td><td id=column2>' . $fundraising['for_any'] . '</td></tr>';
                }else{
                    echo '<tr><td id=column1>Purpose</td><td id=column2>' . $event_name_fundraising . '</td></tr>';
                }
                    echo '<tr><td id=column1> Expectations </td><td id=column2>' . $expect . '</td></tr>';

                ?>

                <tr>
                    <td>Service area </td>
                    <td><?php echo $fundraising['service_area'] ?></td>
                </tr>
                <tr>
                    <td>description </td>
                    <td><?php echo $fundraising['description'] ?></td>
                </tr>

            </table>
        </div>

        <?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>

    </body>

</html>