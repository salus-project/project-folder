<?php
    require $_SERVER['DOCUMENT_ROOT']."/anonymous/ano_header.php";
?>

<link rel="stylesheet" href="/css_codes/organizations.css">
<div id="org_body">
    <form method='get' action='/organization'>
        <div class='org_search'>
            <div>Search for: </div><div class='search'><input placeholder='Event name' class='search_input' type=text></div>
        </div>
        <table id="table">
            <?php
                $event_detail=$con->query('select name,event_id,detail from disaster_events ORDER BY event_id DESC');

                $result=$event_detail->fetch_all(MYSQLI_ASSOC);
               // echo $event_detail;
               // $events = array_unique(array_column($result,'LOWER(district)'));
                
                foreach($result as $row_dis){
                    echo "<tr><td class='table_td org_list'>
                    <div class='org_main'>
                        <div class='org_logo_container'>";
                            $org_profile_path =" /common/documents/Organization/Profiles/" . $org[1] . ".jpg";
                            echo '<img src="<?php echo $org_profile_path;?>" alt="Opps..." class="org_logo_pic">
                        </div>
                        <div class="org_name_des">
                            <a href="/anonymous/event.php?event_id='.$row_dis['event_id'].'"><button class="org_name" type="button" name="event_id" value="'.$row_dis['event_id'].'"><div class="name_only">'.ucfirst($row_dis['name']).'</div><div class="desc_only">'.$row_dis['detail'].'</div></button></a>
                        </div>
                        </td>
                    </tr>';
                   /* echo '<tr><td class="table_td"><div class="org_name_des">
                        <a href="/event/index.php?event_id='.$row_dis['event_id'].'"><button class="org_name" type="button" name="event_id" value="'.$row_dis['event_id'].'">'.ucfirst($row_dis['name']).'<br>'.$row_dis['LOWER(affected_districts)'].'</button>
                    </div></td></tr>';*/
                }

               /* function innerOrg($dis,$result){
                    $org_array = array_filter(array_map(function($item) use($dis) {return org_filter($item,$dis);},$result));
                    $orgs = array_map(function($item){return array(($item['org_name']),$item['org_id'],$item['discription']);},$org_array);
                    foreach($orgs as $org){
                        echo "<tr><td class='table_td org_list'>
                            <div class='org_main'>
                                <div class='org_logo_container'>";
                                    $org_profile_path =" /common/documents/Organization/Profiles/" . $org[1] . ".jpg";
                                    echo '<img src="<?php echo $org_profile_path;?>" alt="Opps..." class="org_logo_pic">
                                </div>
                                <div class="org_name_des">
                                    <button class="org_name" type="submit" name="selected_org" value="'.$org[1].'">'.ucfirst($org[0]).'<br>'.$org[2].'</button>
                                </div>
                                </td>
                            </tr>';
                    }
                }
                function org_filter($row,$org){
                    if($row['LOWER(district)'] == $org){
                        return $row;
                    }
                }
                function countOrg($dis,$result){
                    $org_array = array_filter(array_map(function($item) use($dis) {return org_filter($item,$dis);},$result));
                    $orgs = array_map(function($item){return array(($item['org_name']),$item['org_id']);},$org_array);
                    return count($orgs)+1;
                }*/
                 
            ?>
        </table>
    </form>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/staff/footer.php" ?>