<?php
    if($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['submitBtn'])){
    $fund_id=$_POST['fund_id'];
    $_GET['edit_btn']=$fund_id;
    $for_event=$_POST['for_event']? filt_inp($_POST['for_event']):'';
    $for_any=$_POST['other_purpose']? filt_inp($_POST['other_purpose']):'';
    $item = array_filter(array_filter($_POST['item']),"filt_inp");
    $amount =array_filter(array_filter($_POST['amount']),"filt_inp");
    $description=filt_inp($_POST['description']);
    $for_opt=filt_inp($_POST['purp']);
    $by=$_SESSION['user_nic']; 

    $district=isset($_POST['district'])?$_POST['district']:[];
    
    for($x=0 ; $x < count($district) ; $x++){
        filt_inp($district[$x]);
    }
    $district= implode(",", $district);

    if($_POST['organization']==""){
        $org_id= "NULL";
    } 
    else{
        $org_id=filt_inp($_POST['organization']);
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

        if(in_array(substr($fundraising_name,0,1), ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']) ){
            $nameErr="Name should start with a letter";
            echo '<script type="text/javascript">alert("Name should start with a letter")</script>';
            $isOk=0;
        }
        
        if(!preg_match("/^[a-zA-Z0-9 ]*$/",$fundraising_name)){
            $nameErr='Only letters and white space allowed';
            $isOk=0;
        } 
    }
    if ($for_event=='' && $for_any==''){
        $isOk=0;
        $noSelEveErr="Select an event";
    }
    if($for_opt==1){
        $for_any='NULL';
        if ($for_event==''){
            $isOk=0;   
            $noSelEveErr="Select an event";
            $for_any='';
        }
    }
    elseif ($for_opt==2){
        $for_event='NULL'; 
        if ($for_any==''){
            $isOk=0;   
            $noPurpEveErr="Give a purpose";
            $for_event='';
        }
    }
    
   
    $update_id=array_filter($_POST['update_id'],"filt_inp");
    $pri_query = '';
    $del_detail = array_filter(explode(',', filt_inp($_POST['del_details'])));
    if($isOk==1){
        foreach( $del_detail as $row_del){
            $pri_query.= "delete from fundraisings_expects where id=".$row_del.";";
        }
        for($x=0 ; $x < count($item) ; $x++){
            if(!empty($item[$x])){
                if(empty($amount[$x])){
                    $amount[$x]=0;
                }
                
                if(count($update_id) <= $x){
                    $pri_query .= "INSERT INTO fundraisings_expects (`fund_id`, `item`, `amount`) VALUES ('$fund_id', '".ready_input(filt_inp($item[$x]))."', '".filt_inp($amount[$x])."');";
                
                }else{
                    $pri_query .= "UPDATE `fundraisings_expects` SET `item` = '".ready_input(filt_inp($item[$x]))."', `amount` = '".filt_inp($amount[$x])."' WHERE `fundraisings_expects`.`id` = '".$update_id[$x]."';";
                }
            }
        }
        $pri_query .="update `fundraisings` SET name='".$fundraising_name."', by_civilian='".$by."', by_org=".$org_id.", for_event=".$for_event.", for_any='".$for_any."', service_area='".$district."', description='".$description."' WHERE id=".$fund_id.";";
        
        $query_run=mysqli_multi_query($con,$pri_query);
        echo $pri_query;
        if($query_run){
            header('location:/fundraising/view_fundraising.php?view_fun='.$fund_id);
            echo '<script type="text/javascript">alert("Successfully updated")</script>';

        }else{
            echo '<script type="text/javascript">alert("Error")</script>';
        }
    }

    else{
        echo "<div class='try_again'>Try again</div>";
    }
}
?>