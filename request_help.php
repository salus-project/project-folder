<?php
    session_start();
    require 'dbconfi/confi.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Help request</title>
        <link rel="stylesheet" href="css_codes/help_request.css">
    </head>

    <body style="background-color: #dedede">

    <script> btnPress(1) </script>

        <center>
            <h1> Request for help </h1>
            
            <div class="div1">
            <form  class="form_box" action="request_help.php" method="POST">

               <label class="label">NIC number </label><br>
                <input name = "NIC_num" type="text" class="input_box" value="<?php echo $_SESSION['user_nic']; ?>" required/><br>
                <label class="label"> District (current) </label><br>
                    <select name="district" class="input_box">
                        <option value='all island'>All island</option>
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
                <input type="checkbox" name="type[]" value="money"> Money<br>
                <input type="checkbox" name="type[]" value="good"> Good<br>
                
                <label class="label">Money description</label><br>
                <textarea cols="30" rows="4"  class="input_box" name="money_description" ></textarea><br>
                <label class="label">Good description</label><br>
                <textarea cols="30" rows="4"  class="input_box" name="good_description"></textarea><br>

                <input name="submit_button" type="submit"  value="Submit"  class="submit_button"><br>
                
                
            </form>

            
            </div>
        <center>
    </body>
</html>

<?php
    $con = mysqli_connect("remotemysql.com","kfm2yvoF5R","4vkzHfeBh6") or die("Unable to connect");
    mysqli_select_db($con,"kfm2yvoF5R");

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $event_id="2";
        $user_nic=$_POST['NIC_num'];
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
        

        $query="INSERT INTO event_".$event_id."_help_requested (NIC_num, district, help_type, money_discription, good_discription) VALUES ('$user_nic', '$district', '$help_type', '$money_description', '$good_description')";
        $query_run= mysqli_query($con,$query);

        if($query_run){
            header('location:events.php');
            echo '<script type="text/javascript"> alert ("Submited!") </script>';
        }
        else{
            echo '<script type="text/javascript"> alert ("Not Submited") </script>';

        }
    }
?>