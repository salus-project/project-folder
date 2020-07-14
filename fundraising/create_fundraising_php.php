<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";

    $fundraising_name=filt_inp($_POST['fundraising_name']);
    $for_event=$_POST['for_event']?$_POST['for_event']:'NULL';
    $for_any=$_POST['other_purpose']?$_POST['other_purpose']:'NULL';
    $item = array_filter($_POST['item']);
    $amount = $_POST['amount'];
    $service_area=$_POST['service_area'];
    $description=$_POST['description'];
    $by=$_SESSION['user_nic'];
    if($_POST['organization']==""){
        $org_id= "NULL";
    }
    else{
        $org_id=$_POST['organization'];
    }
    $isOk=1;
    if(empty($_POST['fundraising_name'])){
        echo '<script type="text/javascript">alert("Fundraising event name is required")</script>';
        $isOk=0;
    }else{
        $validate_name_query="select * from fundraisings where name='$fundraising_name'";
        $query_run=mysqli_query($con,$validate_name_query);
        if(mysqli_num_rows($query_run)>0){
            echo '<script type="text/javascript">alert("fundraising name already exits...")</script>';
            $isOk=0;
        }
    }
    
    $for_opt=$_POST['purp'];
    if($for_opt=="00"){
        echo '<script type="text/javascript">alert("fill purpose field")</script>';
        $isOk=0;
    }
    elseif($for_opt=="1"){
        $for_any='NULL';
    }
    else{
        $for_event='NULL';   
    }

    if($isOk==1){
        $query="INSERT INTO public_posts (`author`, `org`, `date`) VALUES ('$by',$org_id,NOW())";
        $con->query($query);
        $last_id=$con->insert_id;

        $query1="INSERT INTO `fundraisings` (`name`, `by_civilian`, `by_org`, `for_event`, `for_any`, `service_area`, `description`,`post_id`) VALUES ('$fundraising_name', '$by',$org_id, $for_event, '$for_any', '$service_area','$description',$last_id)";
        $query_run1=mysqli_query($con,$query1);
        $last_id2=$con->insert_id;

        $querry_arr=array();
        $query2="UPDATE public_posts set fund='$last_id2' WHERE post_index=".$last_id.";";
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

        if($query_run && $query_run1 && $query_run2){

            echo '<script type="text/javascript">alert("Successfully created")</script>';

        }else{
            echo '<script type="text/javascript">alert("Error")</script>';
        }
    }
    else{
        echo "try again";
    }

   // header("Location:/fundraising");

?>