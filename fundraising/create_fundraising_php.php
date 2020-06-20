<?php
require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";

$string1= $_POST["list"];
$string2 = explode ("++", $string1);


$isOk=1;
if(empty($string2[0])){
    echo '<script type="text/javascript">alert("Fundraising event name is required")</script>';
    $isOk=0;
}else{
    $fundraising_name=filter($string2[0]);
    $validate_name_query="select * from fundraisings where name='$fundraising_name'";
    $query_run=mysqli_query($con,$validate_name_query);
    if(mysqli_num_rows($query_run)>0){
        echo '<script type="text/javascript">alert("fundraising name already exits...")</script>';
        $isOk=0;
    }
}
if($string2[1]==""){
    $org_name= "NULL";
}
else{
    $org_name=$string2[1];
}

$for_event=$string2[2];
$for_any=$string2[3];

$for_opt=$string2[4];
$purpose='';
if($for_opt=="00"){
    echo '<script type="text/javascript">alert("fill purpose field")</script>';
    $isOk=0;
}
elseif($for_opt=="1"){
    $for_any=NULL;
    $query2="select * from disaster_events where event_id=". $for_event;
    $result2=($con->query($query2))->fetch_assoc();
    $purpose=$result2['name'];
}
else{
    $for_event="NULL";
    $purpose=$for_any;
    if(empty($for_any)){
        echo '<script type="text/javascript">alert("purpose is required")</script>';
        $isOk=0;
    }
}
$mon=$string2[5];
$thin=$string2[6];


if(($mon=="0") and ($thin=="0")){
    echo '<script type="text/javascript">alert("select your requests")</script>';
    $isOk=0;
}
elseif(($mon=="1") and ($thin=="1")){
    $type="money and things";
    $money=$string2[7];
    $things=$string2[8];

    if((empty($money)) or (empty($things))){
        echo '<script type="text/javascript">alert("fill your request")</script>';
        $isOk=0;
    }

}
elseif( $mon=="1"){
    $type="money only";
    $money=$string2[7];
    $things=NULL;
    if(empty($money)){
        echo '<script type="text/javascript">alert("ammount is required")</script>';
        $isOk=0;
    }
}
elseif($thin=="1"){
    $type="things only";
    $money="NULL";
    $things=$string2[8];

    if(empty($things)){
        echo '<script type="text/javascript">alert("things required")</script>';
        $isOk=0;
    }
}

$service_area=$string2[9];
$description=$string2[10];
$by=filter($_SESSION['user_nic']);

// echo $fundraising_name.' '.$by.''.$org_name.' '.$type.' '. $for_event.' '.$for_any.' '. $money.' '.$things.' '.$service_area.' '.$description.' '.$last_id;
if($isOk==1){
    $query1="INSERT INTO public_posts (`author`, `org`, `date`) VALUES ('$by',$org_name,NOW())";
    $con->query($query1);
    $last_id=$con->insert_id;

    $query="INSERT INTO `fundraisings` (`id`, `name`, `by_civilian`, `by_org`, `type`, `for_event`, `for_any`, `expecting_money`, `expecting_things`, `service_area`, `description`,`post_id`) VALUES (NULL, '$fundraising_name', '$by',$org_name, '$type', $for_event, '$for_any', $money, '$things','$service_area','$description',$last_id)";
    $query_run=mysqli_query($con,$query);
    $last_id2=$con->insert_id;


    $query2="UPDATE public_posts set fund='$last_id2'   WHERE post_index=".$last_id;
    $query_run2=mysqli_query($con,$query2);

    if($query_run){

        echo '<script type="text/javascript">alert("Successfully created")</script>';

    }else{
        echo '<script type="text/javascript">alert("Error")</script>';
    }
}
else{
    echo "try again";
}

header("Location:fundraising.php");

function filter($input){
    return(htmlspecialchars(stripslashes(trim($input))));
}
?>