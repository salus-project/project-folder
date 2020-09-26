<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    date_default_timezone_set("Asia/Colombo");
    $civilian_query = "select first_name, last_name, NIC_num, last_seen from civilian_detail order by last_seen DESC";
    $civilian = $con->query($civilian_query);
    while($row=$civilian->fetch_assoc()){
        if($row['NIC_num']!=$_SESSION['user_nic']){
            
            $profile_path = "/common/documents/Profiles/resized/" . $row['NIC_num'] . ".jpg";

            echo    "<tr class='user_row'>
                        <td class='user_name'>
                            <a class='side_nav_a' href='/view_profile.php?id=".$row['NIC_num']."'>".
                                "<img src='".$profile_path."' alt='oops' class='side_nav_profile'>".
                                $row['first_name']." ".$row['last_name']."
                            </a>
                        </td>
                        <td class='last_seen_data'>
                            <span class='last_seen'>".findLast($row['last_seen'])."</span>
                        </td>
                    </tr>";
        }
    }
    $query = "update civilian_detail SET last_seen='".date("Y-m-d H:i:s")."' where NIC_num='{$_SESSION['user_nic']}'";
    $con->query($query);

    function findLast($date){
        $date = new DateTime($date);
        $now = new DateTime();
        $diff=explode(',',$date->diff($now)->format("%y,%m,%d,%h,%i,%s"));
        if ((int)$diff[0]>=1){
            return $diff[0]." years";
        }elseif ((int)$diff[1]>=1){
            return $diff[1]." months";
        }elseif ((int)$diff[2]>=1){
            return $diff[2]." days";
        }elseif ((int)$diff[3]>=1){
            return $diff[3]." hrs";
        }elseif((int)$diff[4]>=1){
            return $diff[4]." mins";
        }elseif((int)$diff[5]>0){
            return "online";
        }else{
            return "long ago";
        }
    }
?>