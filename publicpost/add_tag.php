<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";

    if($_SERVER['REQUEST_METHOD']=="POST"){
        if($_POST['topic']=='event'){
            $query="select event_id, name from disaster_events order by event_id desc";
            $result=$con->query($query);
            if($result){
                echo "<select class='post_select inner' name='tag_content'>";
                while($row = $result->fetch_assoc()){
                    echo "<option data-link='/event?event_id=".$row['event_id']."' value='".$row['name']."'>".$row['name']."</option>";
                }
                echo "</select>";
            }
        }else if($_POST['topic'] == 'organization'){
            $query="select org_id, org_name from organizations order by org_id asc";
            $result=$con->query($query);
            if($result){
                echo "<input list='tag_data_list' name='tag_content' class='post_select inner'>";
                echo "<datalist id='tag_data_list'>";
                while($row = $result->fetch_assoc()){
                    echo "<option data-link='/organization?selected_org=".$row['org_id']."' value='".$row['org_name']."'>".$row['org_name']."</option>";
                }
                echo "</dataList>";
            }
        }else if($_POST['topic'] == 'fundraising'){
            $query="select id, name from fundraisings order by name asc";
            $result=$con->query($query);
            if($result){
                echo "<input list='tag_data_list' name='tag_content' class='post_select inner'>";
                echo "<datalist id='tag_data_list'>";
                while($row = $result->fetch_assoc()){
                    echo "<option data-link='/fundraising/view_fundraising?view_fun=".$row['id']."' value='".$row['name']."'>".$row['name']."</option>";
                }
                echo "</dataList>";
            }
        }else if($_POST['topic'] == 'person'){
            $query="select NIC_num, first_name, last_name from civilian_detail order by first_name, last_name asc";
            $result=$con->query($query);
            if($result){
                echo "<input list='tag_data_list' name='tag_content' class='post_select inner'>";
                echo "<datalist id='tag_data_list'>";
                while($row = $result->fetch_assoc()){
                    echo "<option data-link='/view_profile?id=".$row['NIC_num']."' value='".$row['first_name']." ".$row['last_name']."'>".$row['first_name']." ".$row['last_name']."</option>";
                }
                echo "</dataList>";
            }
        }
    }