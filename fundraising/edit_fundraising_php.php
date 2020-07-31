<?php
    if($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['submitBtn'])){
    $fund_id=$_POST['fund_id'];
    $_GET['edit_btn']=$fund_id;
    $for_event=$_POST['for_event']?$_POST['for_event']:'NULL';
    $for_any=$_POST['other_purpose']?$_POST['other_purpose']:'NULL';
    $item = array_filter($_POST['item']);
    $amount = $_POST['amount'];
    $description=$_POST['description'];
    $by=$_SESSION['user_nic']; 

    /*$district=$_POST['district']?$_POST['district']:[];
    for($x=0 ; $x < count($district) ; $x++){
        filt_inp($district[$x]);
    }
    $district= implode(",", $district);*/
    $district="";

    if($_POST['organization']==""){
        $org_id= "NULL";
    } 
    else{
        $org_id=$_POST['organization'];
    }
    $isOk=1;
    if(empty($_POST['fundraising_name'])){
        $nameErr="Name required";
        $isOk=0;
    }else{
        $fundraising_name=filt_inp($_POST['fundraising_name']);            
        $validate_name_query="select * from fundraisings where name='$fundraising_name'";
        $query_run=mysqli_query($con,$validate_name_query);
        if(mysqli_num_rows($query_run)>1){
            $nameErr='Fundraising name already exists';
            echo '<script type="text/javascript">alert("Fundraising name already exits...")</script>';
            $isOk=0;
        }
        if(!preg_match("/^[a-zA-Z0-9 ]*$/",$fundraising_name)){
            $nameErr='Only letters and white space allowed';
            $isOk=0;
        } 
    }
    echo $fundraising_name;
    $for_opt=$_POST['purp'];
    if ($for_event==0){
        $isOk=0;
        $noSelEveErr="Select an event";
    }
    if($for_opt==1){
        $for_any='NULL';
    }
    elseif ($for_opt==2){
        $for_event='NULL';   
    }
    $item = array_filter($_POST['item']);
    $amount = $_POST['amount'];
    $update_id=$_POST['update_id'];
    $pri_query = '';
    $del_detail = array_filter(explode(',', $_POST['del_details']));
    echo $isOk;
    if($isOk==1){
        foreach( $del_detail as $row_del){
            $pri_query.= "delete from fundraisings_expects where id=".$row_del.";";
        }
        for($x=0 ; $x < count($item) ; $x++){
            if(!empty($item[$x])){
                if(empty($amount[$x])){
                    $amount[$x]=0;
                }
                
                if($update_id[$x]=='0'){
                    $pri_query .= "INSERT INTO fundraisings_expects (`fund_id`, `item`, `amount`) VALUES ('$fund_id', '".ready_input(filt_inp($item[$x]))."', '".filt_inp($amount[$x])."');";
                
                }else{
                    $pri_query .= "UPDATE `fundraisings_expects` SET `item` = '".ready_input(filt_inp($item[$x]))."', `amount` = '".filt_inp($amount[$x])."' WHERE `fundraisings_expects`.`id` = '".$update_id[$x]."';";
                }
            }
        }
        $pri_query .="update `fundraisings` SET name='".$fundraising_name."', by_civilian='".$by."', by_org=".$org_id.", for_event=".$for_event.", for_any='".$for_any."', service_area='".$district."', description='".$description."' WHERE id=".$fund_id.";";
        
        $query_run=mysqli_multi_query($con,$pri_query);

        if($query_run){
            header('location:/fundraising/view_fundraising.php?view_fun='.$fund_id);
            echo '<script type="text/javascript">alert("Successfully updated")</script>';

        }else{
            echo '<script type="text/javascript">alert("Error")</script>';
        }
    }

    else{
        echo "try again";
    }
}
?>