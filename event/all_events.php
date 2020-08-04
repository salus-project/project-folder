<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
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
                            $org_profile_path =" http://d-c-a.000webhostapp.com/Organization/Profiles/" . $org[1] . ".jpg";
                            echo '<img src="<?php echo $org_profile_path;?>" alt="Opps..." class="org_logo_pic">
                        </div>
                        <div class="org_name_des">
                            <a href="/event/index.php?event_id='.$row_dis['event_id'].'"><button class="org_name" type="button" name="event_id" value="'.$row_dis['event_id'].'"><div class="name_only">'.ucfirst($row_dis['name']).'</div><div class="desc_only">'.$row_dis['detail'].'</div></button></a>
                        </div>
                        </td>
                    </tr>';
                }

               
                 
            ?>
        </table>
    </form>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>