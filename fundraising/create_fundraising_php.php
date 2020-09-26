<?php
    $nameErr =$purpErr=$noSelEveErr="";
    if($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['submitBtn'])){
    $fundraising_name=filt_inp($_POST['fundraising_name']);
    $for_event=$_POST['for_event']?$_POST['for_event']:'NULL';
    $for_any=$_POST['other_purpose']?$_POST['other_purpose']:'NULL';
    $item = array_filter($_POST['item']);
    $amount = $_POST['amount'];
    $description=filt_inp($_POST['description']);
    $org=$_POST['organization']?$_POST['organization']:"";
    $for_opt=$_POST['purp'];
    $by=$_SESSION['user_nic'];
  
    if (isset($_POST['district'])){
        $district=$_POST['district'];
    }else{
        $district=[];
    }
    for($x=0 ; $x < count($district) ; $x++){
        filt_inp($district[$x]);
    }
    $district= implode(",", $district);
 
    if($org==""){
        $org_id= "NULL"; 
    }
    else{ 
        $org_id=$_POST['organization'];
    }
    $isOk=1;
    if(empty($_POST['fundraising_name'])){
        $nameErr = "Name required";
        $isOk=0;
    }else{
        $validate_name_query="select * from fundraisings where name='$fundraising_name'";
        $query_run=mysqli_query($con,$validate_name_query);
        if(mysqli_num_rows($query_run)>0){
            $nameErr="Name already exists";
            echo '<script type="text/javascript">alert("fundraising name already exits...")</script>';
            $isOk=0;
        }
    }
    if(!preg_match("/^[a-zA-Z0-9 ]*$/",$fundraising_name)){
        $nameErr='Only letters and white space allowed';
        $isOk=0;
    } 
    if ($for_event=='NULL' && $for_any=='NULL'){
        $isOk=0;
        $noSelEveErr="Select an event";
    }
    if($for_opt==1){
        $for_any='NULL';
    }
    elseif ($for_opt==2){
        $for_event='NULL';   
    }

    if($isOk==1){

        $query1="INSERT INTO `fundraisings` (`name`, `by_civilian`, `by_org`, `for_event`, `for_any`, `service_area`, `description`) VALUES ('$fundraising_name', '$by',$org_id, $for_event, '$for_any', '$district','$description')";
        $query_run1=mysqli_query($con,$query1);
        $last_id2=$con->insert_id;

        $querry_arr=array();
        $query2="";
        for($x=0 ; $x < count($item) ; $x++){
            if(!empty($item[$x])){
                $item1=filt_inp(ready_input($item[$x]));
                $amount1=filt_inp($amount[$x]);
                if(empty($amount[$x])){
                        $amount1=0; 
                        
                }
                array_push($querry_arr, "('$last_id2','".$item1."','$amount1')");
            }
        }
        $query2.= "INSERT INTO `fundraisings_expects`(`fund_id`, `item`, `amount`) VALUES ". implode(",", $querry_arr).";";
        
        $query_run2=mysqli_multi_query($con,$query2);

        copy($_SERVER['DOCUMENT_ROOT'] . '/common/documents/Fundraising/default.jpg', $_SERVER['DOCUMENT_ROOT'] . '/common/documents/Fundraising/'.$last_id2.'.jpg');
        copy($_SERVER['DOCUMENT_ROOT'] . '/common/documents/Fundraising/resized/default.jpg', $_SERVER['DOCUMENT_ROOT'] . '/common/documents/Fundraising/resized/'.$last_id2.'.jpg');

        if($query_run1){

            echo '<script type="text/javascript">alert("Successfully created")</script>';
            header("Location:/fundraising/view_fundraising.php?view_fun=".$last_id2);

        }else{
            echo '<script type="text/javascript">alert("Error")</script>';
        }
    }

    else{
        echo "try again";
    }

   
    }
?>