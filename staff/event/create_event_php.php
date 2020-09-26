
<?php
    $name=$type=$start_date=$detail="";
    $values=[];
    $nameErr="";
    if (isset($_POST['submit_button'])){
        $check=true;
        $name=filt_inp($_POST['name']);
        $type =filt_inp( $_POST['type']);
        $affected_districts="not_selected";
        $start_date = filt_inp($_POST['start_date']);
        $status ="active";
        $detail = filt_inp($_POST['detail']);

        $name_check='SELECT name FROM `disaster_events` WHERE name="'.$name.'"';
        $result_=$con->query($name_check);
        if (mysqli_num_rows($result_) > 0){
            $nameErr="Name already exist";
            $check=false;
        }
        
        if(! empty($_POST['district'])){
            $values=array_filter($_POST['district'],"filt_inp");
            $affected_districts = implode(",", $values);
        }
        
        if ($check){
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
            mysqli_multi_query($con, $sub_query);
            copy($_SERVER['DOCUMENT_ROOT'] . '/common/documents/Event/default.jpg', $_SERVER['DOCUMENT_ROOT'] . '/common/documents/Event/'.$id.'.jpg');
            copy($_SERVER['DOCUMENT_ROOT'] . '/common/documents/Event/resized/default.jpg', $_SERVER['DOCUMENT_ROOT'] . '/common/documents/Event/resized/'.$id.'.jpg');
            
            header('location:/staff/event/area?event_id='.$id);
        }
    }
?>