<?php
$notification_DB=NotificationDb::getConnection();
$sql="SELECT * FROM user_message_".$_SESSION['user_nic']." WHERE id IN ( SELECT MAX(id) FROM user_message_".$_SESSION['user_nic']." GROUP BY _from,_to);";
$result=array_reverse($notification_DB->query($sql)->fetch_all(MYSQLI_ASSOC));
//echo $sql;
$nic_arr=[];
$detail=[];
for ($x = 0; $x < sizeof($result); $x++) {
    if (! in_array($result[$x]['_from'].$result[$x]['_to'], $nic_arr)) {
        array_push($nic_arr,$result[$x]['_from'].$result[$x]['_to']);
        array_push($detail,$result[$x]);
    }
    }
//echo var_dump($detail);
$nic_ar=array_map(function($ver){return "'".$ver."'";},$nic_arr);
$sql="SELECT NIC_num,first_name,last_name,last_seen FROM civilian_detail WHERE NIC_num in (".(implode(",",$nic_ar)?:"''").");";
$result=array_reverse($con->query($sql)->fetch_all(MYSQLI_ASSOC));
//print_r ($result);
$result_nic=array_column($result,"NIC_num");
echo "<div class='Msg_page_container' >";
echo "<div class='Msg_nav_container' >";
echo "<div id='Msg_search_container' class='Msg_search_container' >
        <input id='message_inp' type='text' placeholder='Search here'>";
echo "</div>";
echo "<div class='msg_nav_s_cont'>";
for ($x = 0; $x < sizeof($nic_arr); $x++) {
    $index=array_search($nic_arr[$x],$result_nic);
    $name_=$result[$index]["first_name"];
    $last_msg=$detail[$x]["content"];
    $icon="";
    if($detail[$x]["_to"] !=""){
        if ($detail[$x]["status"]){
            $icon="<i class='fa fa-check seen nav_icon'></i>";
        }else{
            $icon="<i class='fa fa-check unseen nav_icon'></i>";
        }
    }else{
        if ((! $detail[$x]["status"]) && ($to_person != $nic_arr[$x]) ){
            $icon="<i class='fa fa-circle nav_icon'></i>";
        }
    }

?>
    <a class='<?php echo $nic_arr[$x] ?>' href='/message/?to_person=<?php echo $nic_arr[$x] ?>' >
    <div class='Msg_nav' >
        <div class='Msg_nav_image' >
            <img src="http://d-c-a.000webhostapp.com/Profiles/resized/<?php echo $nic_arr[$x] ?>.jpg">
        </div>
        <div class='Msg_nav_detail' >
            <div class='Msg_nav_name' > <?php echo $name_?></div>
            <div class='Msg_nav_last' >
                <div class='Msg_nav_last_msg' ><?php echo $last_msg ?> </div>
                <?php echo $icon ?>
            </div>
        </div>
    </div>
    </a>
<?php    
}
echo "</div>";
echo "</div>";

?> 
<script>
        autocomplete_ready(document.getElementById("message_inp"), 'users', 'ready', '/message/?to_person=');
</script>