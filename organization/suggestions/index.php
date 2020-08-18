<?php
require $_SERVER['DOCUMENT_ROOT'].'/organization/view_org_header.php';
$nic=$_SESSION['user_nic'];
$name=$_SESSION['first_name'].' '.$_SESSION['last_name'].' (suggestion)';

date_default_timezone_set("Asia/Colombo");
$time= date("H:i:s");
$date= date("Y-m-d");

?>
<div class=sugg_cont>
    <div class=sugg_msg>
    </div>
    <div class=sugg_type>
        <input type="text" class="sugg_text" autocomplete="off" spellcheck="false"  onkeypress="enterKey(event)" placeholder="Type suggestions here" />
        <button class="sugg_btn" type="button" onclick=sendMsg()>Send</button>
    </div>
</div>
<script>
    function enterKey(e){
        if(e.keyCode==13){
            sendMsg();
        }
    }
            
    function sendMsg(){
        var msg=document.getElementsByClassName('sugg_text')[0].value;
        document.getElementsByClassName('sugg_text')[0].value="";
        document.getElementsByClassName('sugg_msg')[0].innerHTML += "<p class='sugg_messages'>"+msg+"</P>";

        var nic="<?php echo $nic;?>";
        var date="<?php echo $date;?>";
        var time="<?php echo $time;?>";
        var name="<?php echo $name;?>";
        var org_id="<?php echo $org_id;?>";

        var sql="INSERT INTO org_"+org_id+" ( `NIC_num`, `sender`, `message`, `date`, `time`) VALUES ('"+ nic+"','"+ name+"','"+ msg+"','"+ date+"','"+ time+"');";
        var xhttp = new XMLHttpRequest();
        // xhttp.onreadystatechange = function() {
        //     if (this.readyState == 4 && this.status == 200) {
        //         console.log(this.responseText);
        //     }
        // };
        xhttp.open("POST", "/organization/suggestions/post_ajax.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("sql="+sql);
        
    }
</script>
