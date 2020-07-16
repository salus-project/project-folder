<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";

    $event_id=$_GET['event_id'];
    $nic=$_GET['nic'];
    $query="select * from event_".$event_id."_help_requested where NIC_num='".$nic."';
    select first_name, last_name from civilian_detail where NIC_num='".$nic."';
    select * from event_".$event_id."_requests where requester='".$nic."';";

    if(mysqli_multi_query($con,$query)){
        $result=mysqli_store_result($con);
        $requester_detail=mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        mysqli_next_result($con);
        $result=mysqli_store_result($con);
        $civilian_detail=mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        mysqli_next_result($con);
        $result=mysqli_store_result($con);
        $requests=mysqli_fetch_all($result,MYSQLI_ASSOC);
        mysqli_free_result($result);

        $content='';
        foreach($requests as $row){
            $content.=$row['item']." : ".$row['amount']."<br>";
        }
    }
    $name=$civilian_detail['first_name']." ".$civilian_detail['last_name'];
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel='stylesheet'href='/css_codes/requester.css'>
    </head>
    <body>
        <script>
            btnPress(4);
        </script>
        <div id='requester_div'>
            <table id='requester_tab'>
                <tr><td colspan='2' id='requester_head'><b>Request Details of <?php echo "<a href='/view_profile.php?id=".$requester_detail['NIC_num']."'>".
                                    $name."</a>"; ?></b></td></tr>
                <tr><td class='request_col1'>District(current):</td><td class='request_col2'><?php echo $requester_detail['district']; ?></td></tr>
                <tr><td class='request_col1'>Village:</td><td class='request_col2'><?php echo $requester_detail['village']; ?></td></tr>
                <tr><td class='request_col1'>Street:</td><td class='request_col2'><?php echo $requester_detail['street']; ?></td></tr>
                <tr><td class='request_col1'>Requests:</td><td class='request_col2'><?php echo $content; ?></td></tr>
            </table>
        </div>
    </body>
</html>