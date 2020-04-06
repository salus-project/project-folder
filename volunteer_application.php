<?php
    session_start();
    require 'dbconfi/confi.php';
    require 'header.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <title> Update Help</title>
        <link rel="stylesheet" href="css_codes/style.css">
    </head>

    <body style="background-color: #dedede">

    <script> btnPress(4) </script>
    <center>
            <h1> Update my Help </h1>
            
            <div class="div1">
            <form  class="form_box" action="volunteer_application.php" method="POST">

                <label class="label"  style="font-weight:bolder;">Type </label><br>
                    from_home<input type="checkbox" name="type[]" value="from_home"><br/>
                    on_the_spot<input type="checkbox" name="type[]" value="on_the_spot"><br/><br/>
                
                    <label class="label"  style="font-weight:bolder;">District/Districts </label><br>
                    AllDistricts  <input type="checkbox" name="district[]" value='AllDistricts'>
                    Ampara  <input type="checkbox" name="district[]" value='Ampara'>
                    Anurashapura  <input type="checkbox" name="district[]" value='Anurashapura'><br/>
                    Badulla   <input type="checkbox" name="district[]" value='Badulla'>
                    Batticaloa  <input type="checkbox" name="district[]" value='Batticaloa'>
                    Colombo <input type="checkbox" name="district[]" value='Colombo'><br/>
                    Galle  <input type="checkbox" name="district[]" value='Galle'>
                    Gampha <input type="checkbox" name="district[]" value='Gampha'>
                    Hambantota  <input type="checkbox" name="district[]" value='Hambatota'><br/>
                    Jaffna   <input type="checkbox" name="district[]" value='Jaffna'>
                    Kaltura  <input type="checkbox" name="district[]" value='Kaltura'>
                    Kandy  <input type="checkbox" name="district[]" value='Kandy'><br/>
                    Kegalle <input type="checkbox" name="district[]" value='Kegalle'>
                    Kilinochchi  <input type="checkbox" name="district[]" value='Kilinochchi'>
                    Kurunegala <input type="checkbox" name="district[]"  value='Kurunegala'><br/>
                    Mannar  <input type="checkbox" name="district[]"  value='Mannar'>
                    Matale <input type="checkbox" name="district[]"  value='Matale'>
                    Mathara  <input type="checkbox" name="district[]"  value='Mathara'><br/>
                    Moneragala <input type="checkbox" name="district[]"  value='Moneragala'>
                    Mullaitivu  <input type="checkbox" name="district[]"  value='Mullaitivu'>
                    Nuwara-Eliya <input type="checkbox" name="district[]"  value='Nuwara-Eliya'><br/>
                    Polonnaruwa    <input type="checkbox" name="district[]"  value='Polonnaruwa'>
                    Puttalam  <input type="checkbox" name="district[]"  value='Puttalam'>
                    Ratnapura   <input type="checkbox" name="district[]"  value='Ratnapura'><br/>
                    Tricomalee  <input type="checkbox" name="district[]"  value='Tricomalee'>
                    Vavuniya   <input type="checkbox" name="district[]"  value='Vavuniya'><br/><br/>
                
                <label class="label"  style="font-weight:bolder;">Money or Goods </label><br>

                Money<input type="checkbox" name="moneygoods[]" value="money"  onclick="OnChangeCheckbox (this,'amount')"id ="money"/>
                <input type="textbox" id="amount" style="display:none" name="t1"/>                <br/>

                Goods<input type="checkbox" name="moneygoods[]" value="goods"  onclick="OnChangeCheckbox (this,'things')" id="goods"/>
                <input type="textbox" id="things" style="display:none" name="t2"/>
                <br/>
                <br/>

                <input name="update_button" type="submit"  value="Submit"  class="login_button"><br>   

                <script>
                    function OnChangeCheckbox (checkbox,text_box) {
                        if (checkbox.checked) {
                            document.getElementById(text_box).style.display="block"; 
                        }
                        else {
                            document.getElementById(text_box).style.display="none"; 
                        }
                    }
                </script>
                
                
            </form>

            
            </div>
        <center>
    </body>
</html>


<?php
    $con = mysqli_connect("remotemysql.com","kfm2yvoF5R","4vkzHfeBh6") or die("Unable to connect");
    mysqli_select_db($con,"kfm2yvoF5R");

    $nic=$_SESSION['user_nic'];
    $value1="not_selected";
    $value2="not_selected";
    
    $counts1=0;
    $counts2=0;

    if (isset($_POST['update_button'])){

        if( ! empty( $_POST['type'] )){
        $counts1 = count($_POST['type']);}
        if ($counts1==1){
            if ($_POST['type'][0]=="from_home"){
                $value1="from_home";
            }elseif($_POST['type'][0]=="on_the_spot"){
                $value1="on_the_spot";
            }
        }elseif ($counts1==2){
            $value1="both";
        }

        if( ! empty( $_POST['moneygoods'] )){
            $counts2 = count($_POST['moneygoods']);}
            if ($counts2==1){
                if ($_POST['moneygoods'][0]=="money"){
                    $value2="money";
                }elseif($_POST['moneygoods'][0]=="goods"){
                    $value2="goods";
                }
            }elseif ($counts2==2){
                $value2="both";
            }
        
        $districts="not_selected";
        if( ! empty( $_POST['district'] )){
        $values = $_POST['district'];
        $districts = implode(",", $values);}

        $t1=0;
        $t2="null";
        if( ! empty( $_POST['t1'] )){
            $t1=$_POST['t1'];}
        $t2=$_POST['t2'];
        
        $query= "INSERT INTO `event_2_volunteers` (`NIC_num`,`service_district`, `type`, `money_or_goods`, `amount`, `things`) VALUES ('$nic','$districts', '$value1', '$value2', '$t1', '$t2')";
        $query_run= mysqli_query($con,$query);
        
        
        // code to update status---------------------------
        $sql="select * from disaster_events where event_id=2" ;
        $result=($con->query($sql))->fetch_assoc();  
        $status=explode(" ",$result[$_SESSION['user_nic']]);
        $status[2]="applied";
        $my=join(" ",$status);
        $nic_num=$_SESSION['user_nic'];
        $sql1="UPDATE civilian_status SET nic_num='$my'";
        $query_run1= mysqli_query($con,$sql1);
        //---------------------------------------------

        
        if($query_run){
            echo '<script type="text/javascript"> alert ("Data Uploaded") </script>';
        }
        else{
            echo '<script type="text/javascript"> alert ("Data not Uploaded") </script>';
    }
}

?>