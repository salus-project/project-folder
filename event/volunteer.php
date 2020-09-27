<?php
    require $_SERVER['DOCUMENT_ROOT']."/event/event_header.php";
    $event_id=$_GET['event_id'];
    $nic=$_GET['nic'];
    $query="select * from event_".$event_id."_volunteers where NIC_num='".$nic."';
    select first_name, last_name from civilian_detail where NIC_num='".$nic."';
    select * from event_".$event_id."_abilities where donor='".$nic."';";

    if(mysqli_multi_query($con,$query)){
        $result=mysqli_store_result($con);
        $volunteer_detail=mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        mysqli_next_result($con);
        $result=mysqli_store_result($con);
        $civilian_detail=mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        mysqli_next_result($con);
        $result=mysqli_store_result($con);
        $abilities=mysqli_fetch_all($result,MYSQLI_ASSOC);
        mysqli_free_result($result);

        $content='';
        foreach($abilities as $row){
            $content.=$row['item']." : ".$row['amount']."<br>";
        }
    }
    $name=$civilian_detail['first_name']." ".$civilian_detail['last_name'];
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel='stylesheet'href='/css_codes/volunteer.css'>
    </head>
    <body>
        <script>
            btnPress(4);
        </script>
            <div class='main_container'>
                <div class='volunteer_head'>
                    <b>Volunteer Details of <?php echo "<a class='name_anchor' href='/view_profile.php?id=".$volunteer_detail['NIC_num']."'>".
                                    $name."</a>"; ?></b>
                </div>
                <div class='voluteer_table_div'>
                    <table class="volunteer_detail_table">
                        <tr>
                            <td class='volun_col1'>Service districts:</td>
                            <td class='volun_col2'><?php echo $volunteer_detail['service_district']; ?></td>
                        </tr>
                        <tr>
                            <td class='volun_col1'>Type:</td>
                            <td class='volun_col2'><?php echo $volunteer_detail['type']; ?></td>
                        </tr>
                        <tr>
                            <td class='volun_col1'>Abilities:</td>
                            <td class='volun_col2'><?php echo $content; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
    </body>
</html>

<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>