<?php
    session_start();
    require 'dbconfi/confi.php';
    /*echo $_GET['event_id']."<br>";
    echo $_GET['method'];

    if( $_GET['method']=='request'){
        request_help();
    }
    elseif( $_GET['method']=='option'){
        request_help();
    }elseif( $_GET['method']=='cancel'){
        cancel_request();
    }*/

 
    if(isset($_POST['submit_button'])){
        $event_id=$_POST['event_id'];
       $user_nic=$_SESSION['user_nic'];
       $district=$_POST['district'];
       $money_description=$_POST['money_description']??'';
       $good_description=$_POST['good_description']??'';
       $type_arr=(array)$_POST["type"]??[];
       $help_type="";
       
       if(count($type_arr)==2){
           $help_type="money and good"; 
       }elseif(count($type_arr)==1){
           if($type_arr[0]=="money"){
               $help_type="money";
           }elseif($type_arr[0]=="good"){
               $help_type="good";
           }
       }
        $data="SELECT * from event_".$event_id."_help_requested where NIC_num='".$_SESSION['user_nic']."'";
        $result=$con->query($data);
        $query_run = $query_now_run = false;
        if($result->num_rows>0){
            $query_now="UPDATE `event_".$event_id."_help_requested` SET `district` = '$district', `now` = 'yes', `help_type` = '$help_type', `money_discription` = '$money_description', `good_discription` = '$good_description' WHERE `event_".$event_id."_help_requested`.`NIC_num` = '$user_nic'";
            $query_now_run= mysqli_query($con,$query_now);
        }
        else{
            $query="INSERT INTO event_".$event_id."_help_requested (NIC_num, district, help_type, money_discription, good_discription) VALUES ('$user_nic', '$district', '$help_type', '$money_description', '$good_description')";
            $query_run= mysqli_query($con,$query);
        }
        if($query_run || $query_now_run){

           $data="SELECT * from disaster_events where event_id='$event_id'";
           $result=($con->query($data))->fetch_assoc();
           $status=explode(" ",$result['user_'.$_SESSION['user_nic']]);

           $status[1]='requested';
           $data1=join(" ",$status);
           $query1="UPDATE `disaster_events` SET `user_".$_SESSION['user_nic']."` = '".$data1."' WHERE `disaster_events`.`event_id` = $event_id";
           $query_run1= mysqli_query($con,$query1);

           if($query_run1){
                echo 'success';
           }else{
               echo 'unsucessful';
           }
        }
        else{
           echo 'unsucessful';

       }
    }
      
    if(isset($_POST['update_button'])){
        $event_id=$_POST['event_id'];
        $user_nic=$_SESSION['user_nic'];
        $district=$_POST['district'];
        $money_description=$_POST['money_description'];
        $good_description=$_POST['good_description'];
        $type_arr=$_POST["type"];
        $help_type="";
        
        if(count($type_arr)==2){
            $help_type="money and good"; 
        }elseif(count($type_arr)==1){
            if($type_arr[0]=="money"){
                $help_type="money";
            }elseif($type_arr[0]=="good"){
                $help_type="good";
            }
        }
        
        $query_edit="UPDATE `event_".$event_id."_help_requested` SET `district` = '$district', `help_type` = '$help_type', `money_discription` = '$money_description', `good_discription` = '$good_description' WHERE `event_".$event_id."_help_requested`.`NIC_num` = '$user_nic'";
        $query_run= mysqli_query($con,$query_edit);
 
        if($query_run){
            header('location:view_event.php?event_id='.$event_id);
        }else{
            echo '<script type="text/javascript"> alert ("Not edited") </script>';
        }
    }
    if(isset($_POST['cancel_button'])){
    
        $event_id=$_POST['event_id'];
        $data1="SELECT * from disaster_events where event_id='$event_id'";
        $result1=($con->query($data1))->fetch_assoc();
        $status=explode(" ",$result1['user_'.$_SESSION['user_nic']]);
        
        $status[1]='not_requested';
        $data2=join(" ",$status);
        $query1="UPDATE `disaster_events` SET `user_".$_SESSION['user_nic']."` = '".$data2."' WHERE `disaster_events`.`event_id` = $event_id";
        $query_run1= mysqli_query($con,$query1);

        if($query_run1){
            $query_now="UPDATE `event_".$event_id."_help_requested` SET `now` = 'no' WHERE `event_".$event_id."_help_requested`.`NIC_num` = '".$_SESSION['user_nic']."'";
            $query_now_run= mysqli_query($con,$query_now);

            if($query_now_run){
                echo 'cancelled';
            }else{
                echo '<script type="text/javascript"> alert ("No updated") </script>';
            }
        }else{
        echo '<script type="text/javascript"> alert ("Not requested updated") </script>';
        }
        
    }
/*function request_help(){ 
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title> Help request</title>
            <link rel="stylesheet" href="css_codes/help_request.css">
        </head>

        <body style="background-color: #dedede">
        <?php require 'header.php' ?>
        <script> btnPress(4) </script>
            <center>
                <h1> My request</h1>
                
                <div class="div1">
                <form  class="form_box" action="request_help.php" method="POST">
                    <input type=hidden name=event_id value=<?php echo $_GET['event_id'] ?>>
                    <label class="label"> District (current) </label><br>
                        <select name="district" class="input_box">
                            <option value='Ampara'>Ampara</option>
                            <option value='Anurashapura'>Anurashapura</option>
                            <option value='Badulla'>Badulla</option>
                            <option value='Batticaloa'>Batticaloa</option>
                            <option value='Colombo'>Colombo</option>
                            <option value='Galle'>Galle</option>
                            <option value='Gampha'>Gampha</option>
                            <option value='Hambatota'>Hambantota</option>
                            <option value='Jaffna'>Jaffna</option>
                            <option value='Kaltura'>Kaltura</option>
                            <option value='Kandy'>Kandy</option>
                            <option value='Kegalle'>Kegalle</option>
                            <option value='Kilinochchi'>Kilinochchi</option>
                            <option value='Kurunegala'>Kurunegala</option>
                            <option value='Mannar'>Mannar</option>
                            <option value='Matale'>Matale</option>
                            <option value='Mathara'>Mathara</option>
                            <option value='Moneragala'>Moneragala</option>
                            <option value='Mullaitivu'></option>
                            <option value='Nuwara-Eliya'>Nuwara-Eliya</option>
                            <option value='Polonnaruwa'>Polonnaruwa</option>
                            <option value='Puttalam'>Puttalam</option>
                            <option value='Ratnapura'>Ratnapura</option>
                            <option value='Tricomalee'>Tricomalee</option>
                            <option value='Vavuniya'>Vavuniya</option>
                        </select></br>
                        <label class="label">Help Type </label><br>
                        <input type="checkbox" name="type[]" value="money" onclick="OnChangeCheckbox (this,'money_des_con')" id ="money"> Money<br>
                        <input type="checkbox" name="type[]" value="good" onclick="OnChangeCheckbox (this,'goods_des_con')" id ="good"> Good<br>
                        
                        <div id=money_des_con style="display:none">
                            <label class="label">Money description</label><br>
                            <textarea cols="30" rows="4"  class="input_box" name="money_description" id="money_des"></textarea><br>
                        </div>
                        <div id=goods_des_con style="display:none">
                            <label class="label">Good description</label><br>
                            <textarea cols="30" rows="4"  class="input_box" name="good_description" id="good_des"></textarea><br>
                        </div>

                    <input name="submit_button" type="submit"  value="Submit"  class="submit_button"><br>
            
            
                </form>

        
                </div>
            <center>
        <script>
            var district_in_nic = '<?php echo $_SESSION['district'] ?>';
            var allOptions = document.getElementsByTagName('option');
            var results = [];
            for(var x=0; x<allOptions.length; x++){
                if(allOptions[x].value == district_in_nic){
                    allOptions[x].defaultSelected = true;
                }
            }
            function OnChangeCheckbox (checkbox,textbox) {
                if (checkbox.checked) {
                    document.getElementById(textbox).style.display="block"; 
                }
                else {
                    document.getElementById(textbox).style.display="none"; 
                }
            }
        </script>    
        </body>
    </html>
<?php }*/
?>