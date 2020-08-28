<style>
.find_match_table_div{
    width: 100%;
    overflow: auto;
}
.find_match_table{
    border-collapse: collapse;
    margin: 0;
}

.find_match_table th,.find_match_table td{
    font-family: "Open Sans",sans-serif;
    height: 37px;
    padding: 5px;
    margin: 0;
    vertical-align: middle;
    font-weight: 600;
    
    line-height: 1.8;
}
.find_match_table th{
    text-align: center;
    font-size: 16px;
}
.find_match_table td{
    text-align: left;
    font-size: 14px;
}

.find_first_head{
    background: #4c5fd7;
    color: white;
}
.find_second_head{
    background-color: #0c7dff47;
}
			
tbody:hover,
tr.hover,
th.hover,
td.hover,
tr.hoverable:hover {
    background-color: #f5f5f5;
    cursor:pointer;
}
</style>


<?php 
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
$nic=$_SESSION['user_nic'];
$event_id=$_GET['event_id'];
$type=$_GET['type'];

?>
    <div class='find_match_table_div'>
        <table class='find_match_table'>
        
<?php

    if ($type==1){
        $sql1="SELECT lower(item) FROM `event_".$event_id."_requests` where requester='".$nic."';";
        $result1=array_column($con->query($sql1)->fetch_all(),0);
        $sql2="SELECT a.donor,concat(b.first_name,' ',b.last_name) as full_name,a.item FROM `event_".$event_id."_abilities` as a inner join civilian_detail as b on a.donor=b.NIC_num where lower(a.item) in ('".implode('\',\'',$result1)."') order BY a.donor DESC;";
        $result2=$con->query($sql2)->fetch_all();
        $nic_arr=array_column($result2,0);

        echo "<tr>";
            echo "<th class='find_first_head' colspan=3>Volunteer Detail</th>";
        echo "</tr>";
        echo "<tr>";
            echo "<th class='find_second_head' colspan=2>Person name</th>";
            echo "<th class='find_second_head' colspan=1>Ablities</th>";
        echo "</tr>";

    }elseif($type==2){
        $sql1="SELECT lower(item) FROM `event_".$event_id."_abilities` where donor='".$nic."';";
        $result1=array_column($con->query($sql1)->fetch_all(),0);
        $sql2="SELECT a.requester,concat(b.first_name,' ',b.last_name) as full_name,a.item FROM `event_".$event_id."_requests` as a inner join civilian_detail as b on a.requester=b.NIC_num where lower(a.item) in ('".implode('\',\'',$result1)."') order BY a.requester DESC;";
        $result2=$con->query($sql2)->fetch_all();
        $nic_arr=array_column($result2,0);

        echo "<tr class='find_first_head'>";
            echo "<th colspan=3>Request details</th>";
        echo "</tr>";
        echo "<tr class='find_second_head'>";
            echo "<th colspan=2>Person name</th>";
            echo "<th colspan=1>Requests</th>";
        echo "</tr>";

    }

            $dis_arr=[];
            echo "<tbody>";
            foreach($nic_arr as $key =>$n_id){
                if(in_array($n_id,$dis_arr)){
                    echo "<tr><td >".$result2[$key][2]."</td></tr>";
                }else{
                    array_push($dis_arr,$n_id);
                    echo "</tbody><tbody><tr><td colspan=2 rowspan=".array_count_values($nic_arr)[$n_id].">".$result2[$key][1]."</td><td>".$result2[$key][2]."</td></tr>";
                }
                
            }
            echo "</tbody>";
        ?>
        </table>
    </div>