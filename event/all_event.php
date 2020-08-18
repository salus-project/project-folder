<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>
<link rel="stylesheet" href="/css_codes/all_event.css">
<div id="event_body">   
    <div class='event_search'>
        <div>Search for: </div><div class='search'><input placeholder='Event name' class='search_input' type=text></div>
    </div>
    <table id="table">
        <?php
            $event_detail=$con->query('select name,event_id,detail from disaster_events ORDER BY event_id DESC');
            $result=$event_detail->fetch_all(MYSQLI_ASSOC);
            
            foreach($result as $row_dis){
                echo "<tr><td class='table_td event_list'>
                <div class='event_main'>
                    <div class='event_logo_container'>";
                        $event_profile_path =" http://d-c-a.000webhostapp.com/Event/Profiles/" . $row_dis['event_id'] . ".jpg";
                        echo '<img src="<?php echo $event_profile_path;?>" alt="Opps..." class="event_logo_pic">
                    </div>
                    <div class="event_name_des">
                        <a href="/event/index.php?event_id='.$row_dis['event_id'].'"><button class="event_list_name" type="button" name="event_id" value="'.$row_dis['event_id'].'"><div class="name_only">'.ucfirst($row_dis['name']).'</div><div class="desc_only">'.$row_dis['detail'].'</div></button></a>
                    </div>
                </div>
                </td>
                </tr>';
            }               
        ?>
    </table>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>