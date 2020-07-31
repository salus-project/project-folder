<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/confi/db_confi.php";
if($_SERVER['REQUEST_METHOD']=='GET' && $_GET['get']=='all'){
    $query =    "select name as showname, concat('http://d-c-a.000webhostapp.com/Event/resized/',event_id,'.jpg') as img_src, concat('/event/?event_id=',event_id) as link from disaster_events;
                select concat(first_name, ' ', last_name) as showname, concat('http://d-c-a.000webhostapp.com/Profiles/resized/',NIC_num,'.jpg') as img_src, concat('/view_profile.php?id=',NIC_num) as link from civilian_detail;
                select org_name as showname, concat('http://d-c-a.000webhostapp.com/Organization/resized/',org_id,'.jpg') as img_src, concat('/organization/?selected_org=',org_id) as link from organizations;
                select name as showname, concat('http://d-c-a.000webhostapp.com/Fundraising/resized/',id,'.jpg') as img_src, concat('/fundraising/view_fundraising.php?view_fun=',id) as link from fundraisings;";
    $result_arr = array();
    if ($con->multi_query($query)) {
        do {
            // Store first result set
            if ($result = $con->store_result()) {
                $result_arr = array_merge($result_arr, $result->fetch_all(MYSQLI_ASSOC));
                $result->free_result();
            }
            //Prepare next result set
        } while ($con->next_result());
    }
    echo json_encode($result_arr);
}
elseif($_SERVER['REQUEST_METHOD']=='GET' && $_GET['get']=='users'){
    $query =    "select concat(first_name, ' ', last_name) as showname, concat('http://d-c-a.000webhostapp.com/Profiles/resized/',NIC_num,'.jpg') as img_src, concat('/view_profile.php?id=',NIC_num) as link from civilian_detail;";
    $result_arr = array();
    if ($con->multi_query($query)) {
        do {
            // Store first result set
            if ($result = $con->store_result()) {
                $result_arr = array_merge($result_arr, $result->fetch_all(MYSQLI_ASSOC));
                $result->free_result();
            }
            //Prepare next result set
        } while ($con->next_result());
    }
    echo json_encode($result_arr);
}
elseif($_SERVER['REQUEST_METHOD']=='GET' && $_GET['get']=='orgs'){
    $query =    "select name as showname, concat('http://d-c-a.000webhostapp.com/Event/resized/',event_id,'.jpg') as img_src, concat('/event/?event_id=',event_id) as link from disaster_events;";
    $result_arr = array();
    if ($con->multi_query($query)) {
        do {
            // Store first result set
            if ($result = $con->store_result()) {
                $result_arr = array_merge($result_arr, $result->fetch_all(MYSQLI_ASSOC));
                $result->free_result();
            }
            //Prepare next result set
        } while ($con->next_result());
    }
    echo json_encode($result_arr);
}