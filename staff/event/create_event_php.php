<?php  
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify_staff.php";
?>

<?php
    if (isset($_POST['submit_button'])){
        $name=$_POST['name'];
        $type = $_POST['type'];
        $affected_districts="not_selected";
        if( ! empty( $_POST['district'] )){
            $values = $_POST['district'];
            $affected_districts = implode(",", $values);
        }
        $start_date = $_POST['start_date'];
        $status = $_POST['status'];
        $detail = $_POST['detail'];
        
        $query="INSERT INTO disaster_events(name, type, affected_districts, start_date, status, detail) VALUES ('$name','$type','$affected_districts','$start_date','active','$detail')";     
        $query_run= mysqli_query($con,$query);
        $id = mysqli_insert_id($con);
        $sub_query="";
        if($query_run ){
            $sub_query.="CREATE TABLE `event_".$id."_volunteers`(NIC_num varchar(12),now varchar(5) NOT NULL DEFAULT 'yes',service_district varchar(100),type varchar(20),PRIMARY KEY (NIC_num));"; 
            $sub_query.="CREATE TABLE `event_".$id."_help_requested`(NIC_num varchar(12),now varchar(5) NOT NULL DEFAULT 'yes',district varchar(20),village varchar(100),street varchar(100),PRIMARY KEY (NIC_num));"; 
            $sub_query.="CREATE TABLE `event_".$id."_pro_don`(id int(10) NOT NULL AUTO_INCREMENT,by_org int(5),by_person varchar(12),to_person varchar(12) NOT NULL ,note text,PRIMARY KEY (id));"; 
            $sub_query.="CREATE TABLE `event_".$id."_locations`(id int(10) NOT NULL AUTO_INCREMENT,type varchar(20),latitude double,longitude double,radius int(10),geojson text,by_org int(11),by_person varchar(12),detail text,PRIMARY KEY (id));"; 
            $sub_query.="CREATE TABLE `event_".$id."_abilities`(id int(11) NOT NULL AUTO_INCREMENT,donor varchar(12) NOT NULL,item varchar(20),amount varchar(20),PRIMARY KEY (id),FOREIGN KEY(donor) REFERENCES event_".$id."_volunteers(NIC_num));"; 
            $sub_query.="CREATE TABLE `event_".$id."_requests`(id int(11) NOT NULL AUTO_INCREMENT,requester varchar(12) NOT NULL,item varchar(20),amount varchar(20),PRIMARY KEY (id),FOREIGN KEY(requester) REFERENCES event_".$id."_help_requested(NIC_num));"; 
            $sub_query.="CREATE TABLE `event_".$id."_pro_don_content`(id int(11) NOT NULL AUTO_INCREMENT,don_id int(10) NOT NULL,item varchar(20),amount varchar(20),pro_don varchar(10),PRIMARY KEY (id),FOREIGN KEY(don_id) REFERENCES event_".$id."_pro_don(id));"; 
        }
        if(mysqli_multi_query($con, $sub_query)){
            echo '<script type="text/javascript"> alert ("Data Uploaded") </script>';
        }else{
            echo '<script type="text/javascript"> alert ("Data not Uploaded") </script>';
        }
        header('location:/staff/event/view_event.php?event_id='.$id);
    }
?>